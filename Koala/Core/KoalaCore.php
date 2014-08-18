<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

//目录分隔符
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

//框架核心版本
define("FRAME_VERSION",'1.0');

//框架发布时间
define('FRAME_RELEASE','20140323');

//核心初始化需求

//加载单例实现
include(__DIR__.'/Singleton.php');

/**
 * WEB方式核心初始化实现类
 */
class KoalaCore extends Singleton{
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
    public static function execute(){
        $dispatcher = \Core\AOP\AOP::getInstance(\Koala\Server\Dispatcher::factory('mvc'));
        $options = \Plugin::trigger('registerRequest','','',true);
        //视图文件
        View::setTemplateOptions($options['path']);
        //控制器分发
        $dispatcher->execute(\Plugin::trigger('registerController',$options,'',true),array_pop($options['path']));
    }
    /**
     * Closure 初始化支持
     * @param  Closure $initializer Closure
     * @param  array   $options      选项
     */
    public static function initialize(Closure $initializer,$options=array()){
        $object = self::getInstance(get_called_class());
        self::setInstance(get_class($object),$object);
        $initializer($object,$options);
    }
}

//加载类加载器
include(__DIR__.'/ClassLoader.php');

////核心初始化开始

/**
 * 内核初始化进程
 */
KoalaCore::initialize(function(){
    //写数据路径
    defined('RUNTIME_PATH') or define('RUNTIME_PATH',APP_PATH.'Runtime/');
    //日志路径
    defined('LOG_PATH') or define('LOG_PATH',RUNTIME_PATH.'Storage/');
    //框架类库加载方案
    ClassLoader::initialize(function($instance){
    $instance->register();
    $instance->registerNamespaces(array(
        'Advice' => FRAME_PATH.'Addons',
        'Func' => FRAME_PATH.'Core',
        'Helper' => FRAME_PATH,
        'Addons' => FRAME_PATH,
        'Base' => FRAME_PATH.'Core',
        'Core' => FRAME_PATH,
        'Server' => FRAME_PATH,
        'Plugin' => array(FRAME_PATH.'Addons'),
        'Minion' => FRAME_PATH.'Addons',
        'Resource'=>FRAME_PATH.'Addons',
        'Koala'=>dirname(FRAME_PATH),
        'Controller' => APP_PATH,
         'Addons' => APP_PATH,
        ));
    $instance->registerDirs(array(
        FRAME_PATH.'Core',
        FRAME_PATH.'Tests',
        FRAME_PATH.'Server',
        FRAME_PATH.'Addons/Compatible',
        ));
    //框架内置函数库
    $instance->LoadFunc('Func','Common,Special');
    });
    //配置初始化
    Config::initialize(function($instance){
        //默认文件
        $instance->loadConfig(FRAME_PATH.'Config/Global.default.php');
    });
    //核心AOP切面路径
    define('ADVICE_PATH', FRAME_PATH.'Core/AOP/Advice/');
    //检查环境
    require_once(FRAME_PATH.'Initialise/checkEnv.php');
    //composer第三方库加载支持
    is_file(FRAME_PATH.'External/autoload.php') AND require FRAME_PATH.'External/autoload.php';
    //++++++++++++++++++++++++调试及错误设置++++++++++++++++++++++++++++
    $log = Koala\Server\Log::factory('monolog');
    Koala\Server\ErrorHandler::register('monolog',array($log),function()use($log){
        switch (C('DEBUGLEVEL',defined('DEBUGLEVEL')?DEBUGLEVEL:1)) {
            case 4://development//线下开发环境
                ini_set("display_errors","On");
                break;
            case 3://test//线上测试环境
                ini_set("display_errors","Off");
                $log->pushHandler(new Monolog\Handler\ChromePHPHandler(Koala\Server\Log::INFO));
                break;
            case 2://production//线上生产环境
            case 1://默认模式
            default:
                //关掉错误提示
                error_reporting(0);
                ini_set("display_errors","Off");
                break;
        }
        $log->pushHandler(new AEStreamHandler('Log/'.date('Y-m-d')."/ERROR.log", Koala\Server\Log::ERROR));
        $log->pushHandler(new AEStreamHandler('Log/'.date('Y-m-d')."/WARN.log", Koala\Server\Log::WARNING));
    });
    //加载云服务类支持(如BAE类库)
    (APPENGINE!="LAE") AND include(FRAME_PATH.'Initialise/Class'.APPENGINE.".php");
    
    //插件支持
    Plugin::loadPlugin(FRAME_PATH.'Addons');
    Plugin::loadPlugin(APP_PATH.'Addons','');
});
////核心初始化结束