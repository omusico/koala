<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
//框架核心版本
define("FRAME_VERSION", '1.1');
//框架发布时间
define('FRAME_RELEASE', '20140323');
//加载单例实现
include (__DIR__ . '/Singleton.php');
//加载类加载器
include (__DIR__ . '/ClassLoader.php');
/**
 * WEB方式核心初始化实现类
 */
class KoalaCore extends Singleton {
	/**
	 * 执行应用
	 * 若应用没有实现子类execute,则使用该默认方法
	 * @static
	 * @access public
	 */
	public static function execute() {
		//控制器分发
		$dispatcher = \Koala\Server\Dispatcher::factory('mvc');
		$dispatcher->execute(
			hookTrigger('getControllerClass', array(Request::$map_paths), '', true),
			Request::$map_paths[C('VAR_ACTION', 'a')]
		);
		$Front = new Core\Front\Advice\FrontAdvice;
		$Front->output();
	}
}
use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;
/**
 * 内核初始化进程
 */
KoalaCore::initialize(function () {
	//框架类库加载方案
	ClassLoader::initialize(function ($instance) {
		$instance->register();
		$instance->registerNamespaces(array(
			'Advice' => FRAME_PATH . 'Addons',
			'Func' => FRAME_PATH . 'Core',
			'Helper' => FRAME_PATH,
			'Addons' => FRAME_PATH,
			'Base' => FRAME_PATH . 'Core',
			'Core' => FRAME_PATH,
			'Server' => FRAME_PATH,
			'Koala' => dirname(FRAME_PATH),
			'Controller' => APP_PATH,
			'Addons' => APP_PATH
		));
		$instance->registerDirs(array(
			FRAME_PATH . 'Core',
			FRAME_PATH . 'Tests',
			FRAME_PATH . 'Server',
		));
		//框架内置函数库
		$instance->LoadFunc('Func', 'Common,Special');
	});
	//默认文件
	\Config::loadFile(FRAME_PATH . 'Config/Global.default.php');
	//定义应用标识码
	//对多个相同应用情况下的缓存服务提供前缀防止缓存段共用问题;
	define('APP_UUID', strtolower(substr(md5(APP_PATH), 0, 6)));
	//定义应用引擎常量
	define('APP_ENGINE', env::$items['APP_ENGINE']);
	//composer第三方库加载支持
	is_file(FRAME_PATH . 'External/autoload.php') AND require FRAME_PATH . 'External/autoload.php';
	//调试及错误设置
	if (C('DEBUGLEVEL', defined('DEBUGLEVEL') ? DEBUGLEVEL : 1)) {
			$run = new Run;
			$run->pushHandler(new PrettyPageHandler);
			$run->register();
		} else {
		ini_set("display_errors", "Off");
		$log = Koala\Server\Log::factory('monolog');
		Koala\Server\ErrorHandler::register('monolog', array($log), function () use ($log) {
			$log->pushHandler(new Monolog\Handler\ChromePHPHandler(Koala\Server\Log::INFO));
			$log->pushHandler(new AEStreamHandler('Log/' . date('Y-m-d') . "/ERROR.log", Koala\Server\Log::ERROR));
			$log->pushHandler(new AEStreamHandler('Log/' . date('Y-m-d') . "/WARN.log", Koala\Server\Log::WARNING));
		});
	}
	//插件支持
	\Core\Plugin\Manager::loadPlugin(FRAME_PATH . 'Addons');
	\Core\Plugin\Manager::loadPlugin(APP_PATH . 'Addons', '');
});
////核心初始化结束