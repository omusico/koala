<?php
//目录分隔符
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

//框架核心版本
define("FRAME_VERSION", '1.0');

//框架发布时间
define('FRAME_RELEASE', '20140323');

//核心初始化需求

//加载单例实现
include (__DIR__ . '/Singleton.php');

/**
 * CLI方式核心初始化实现类
 */
class KoalaCore extends Singleton {
	/**
	 * 需延迟执行的closure;
	 */
	static $closure = null;
	/**
	 * 执行应用
	 * 若应用没有实现子类execute,则使用该默认方法
	 * @static
	 * @access public
	 */
	public static function execute() {
		//使用命令行解析器
		Koala\Core\Minion\Task::factory(Koala\CLI\KoalaCLI::options())->execute();
	}
	/**
	 * 部分延迟执行的代码,用于延迟搜集可由应用自定义的参数，常量等代码
	 * @static
	 * @access public
	 */
	public static function lazyInitialize(Closure $initializer, $options = array()) {
		self::$closure[] = array(
			'closure' => $initializer,
			'params' => array(self::getInstance(get_called_class()), $options)
		);
	}
	/**
	 * 执行 延迟执行的代码
	 * @static
	 * @access public
	 */
	public static function executeLazy() {
		if (count(self::$closure) > 0) {
			foreach (self::$closure as $key => $value) {
				call_user_func_array($value['closure'], $value['params']);
			}
		}
	}
}

//加载类加载器
include (__DIR__ . '/ClassLoader.php');

////核心初始化开始
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
			'Base' => FRAME_PATH . 'Core',
			'Core' => FRAME_PATH,
			'Server' => FRAME_PATH,
			'Plugin' => array(FRAME_PATH . 'Addons'),
			'Minion' => FRAME_PATH . 'Addons',
			'Resource' => FRAME_PATH . 'Addons',
			'Koala' => dirname(FRAME_PATH),
		));
		$instance->registerDirs(array(
			FRAME_PATH . 'Core',
			FRAME_PATH . 'Tests',
			FRAME_PATH . 'Server',
			FRAME_PATH . 'Addons/Compatible',
		));
		//框架内置函数库
		$instance->LoadFunc('Func', 'Common,Special');
	});
	//默认文件
	\Config::loadFile(FRAME_PATH . 'Config/Global.default.php');
	//核心AOP切面路径
	define('ADVICE_PATH', FRAME_PATH . 'Core/AOP/Advice/');
	//检查环境
	require_once (ENTRANCE_PATH . 'Initialise/checkEnv.php');
	//composer第三方库加载支持
	is_file(FRAME_PATH . 'External/autoload.php') AND require FRAME_PATH . 'External/autoload.php';
	//++++++++++++++++++++++++调试及错误设置++++++++++++++++++++++++++++
	$log = Log::factory('monolog');
	ErrorHandler::register('monolog', array($log), function () use ($log) {
		switch (C('DEBUGLEVEL', defined('DEBUGLEVEL') ? DEBUGLEVEL : 1)) {
			case 4://development//线下开发环境
				ini_set("display_errors", "On");
				$log->pushHandler(new Monolog\Handler\ChromePHPHandler(Log::ERROR));
				break;
			case 3://test//线上测试环境
				ini_set("display_errors", "Off");
				$log->pushHandler(new Monolog\Handler\ChromePHPHandler(Log::ERROR));
				$log->pushHandler(new Monolog\Handler\ChromePHPHandler(Log::INFO));
				$log->pushHandler(new Monolog\Handler\ChromePHPHandler(Log::WARNING));
				break;
			case 2://production//线上生产环境
			case 1://默认模式
			default:
				//关掉错误提示
				error_reporting(0);
				ini_set("display_errors", "Off");
				break;
		}
		$log->pushHandler(new AEStreamHandler('Log/' . date('Y-m-d') . "/ERROR.log", Log::ERROR));
		$log->pushHandler(new AEStreamHandler('Log/' . date('Y-m-d') . "/WARN.log", Log::WARNING));
	});
	//加载云服务类支持(如BAE类库)
	(RUN_ENGINE != "LAE") AND include (ENTRANCE_PATH . 'Initialise/Class' . RUN_ENGINE . ".php");

	//插件支持
	Plugin::loadPlugin(FRAME_PATH . 'Addons/');
});

/**
 * 需要延迟初始化的部分
 */
KoalaCore::lazyInitialize(function () {
	//所有可在应用中自定义的常量

	//优先加载文件中自定义的常量
	include (ENTRANCE_PATH . 'Initialise/Constant' . RUN_ENGINE . '.php');

	//控制器路径
	defined('CONTRLLER_PATH') or define('CONTRLLER_PATH', APP_PATH . 'Controller/');
	//模型路径
	defined('MODEL_PATH') or define('MODEL_PATH', APP_PATH . 'Model/');
	//语言包路径
	defined('LANG_PATH') or define('LANG_PATH', APP_PATH . 'Language/');
	//模板路径
	defined('VIEW_PATH') or define('VIEW_PATH', APP_PATH . 'View/');
	//读数据路径
	defined('DATA_PATH') or define('DATA_PATH', FRAME_PATH . 'Data/');
	//编译路径
	defined('COMPILE_PATH') or define('COMPILE_PATH', RUNTIME_PATH . 'Compile/');
	//缓存路径
	defined('CACHE_PATH') or define('CACHE_PATH', RUNTIME_PATH . 'Cache/');
	//静态资源路径
	defined('ASSETS_URL') or define('ASSETS_URL', APP_URL . 'Source/');
	//存储路径
	defined('STOR_PATH') or define('STOR_PATH', RUNTIME_PATH . 'Storage/');
	//存储访问路径
	defined('STOR_URL') or define('STOR_URL', APP_RELATIVE_URL . 'Runtime/Storage/');
	//widget路径
	defined('WIDGET_PATH') or define('WIDGET_PATH', APP_PATH . 'Addons/Source/Widget/');
	//widget访问路径
	defined('WIDGET_URL') or define('WIDGET_URL', APP_RELATIVE_URL . 'Addons/Source/Widget/');

	//默认应用路径
	defined('APP_PATH') or define('APP_PATH', ENTRANCE_PATH . 'App/');
	//默认应用插件路径
	defined('APP_ADDONS_PATH') or define('APP_ADDONS_PATH', APP_PATH . 'Addons/');
	defined('APP_PLUGIN_PATH') or define("APP_PLUGIN_PATH", APP_ADDONS_PATH . 'Plugin/');

	//设置应用默认加载方案
	ClassLoader::initialize(function ($instance) {
		$instance->register();
		$instance->registerNamespace('Plugin', array(APP_ADDONS_PATH));
	});

	//composer第三方库加载支持
	is_file(APP_PATH . 'External/autoload.php') AND require APP_PATH . 'External/autoload.php';

	//设定时区
	date_default_timezone_set(C('time_zone', 'PRC'));
	//设置本地化环境
	setlocale(LC_ALL, "chs");
	//不输出可替代字符
	mb_substitute_character('none');
});

////核心初始化结束