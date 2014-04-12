<?php
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
//运行时目录//写数据目录
define('RUNTIME_PATH',ENTRANCE_PATH.'Runtime'.DIRECTORY_SEPARATOR);
//日志目录
define('LOG_PATH',RUNTIME_PATH.'Storage'.DIRECTORY_SEPARATOR);
//框架核心版本
define("FRAME_VERSION",'1.0');
//框架发布时间
define('FRAME_RELEASE','20140323');
//默认应用插件路径
!defined('APP_ADDONS_PATH') and define('APP_ADDONS_PATH',APP_PATH.'Addons'.DS);
!defined('APP_PLUGIN_PATH') and define("APP_PLUGIN_PATH",APP_ADDONS_PATH.'Plugin'.DS);

include(__DIR__.'/Initial.php');
class KoalaCore extends Initial{
    //执行应用
    public static function execute(){
        //判断运行模式
        if(RUNCLI){
            //使用命令行解析器
            Task::factory(KoalaCLI::options())->execute();
        }else{
            //分发
            Dispatcher::factory('mvc')->execute(URL::Parser());
        }
       
    }
}

//初始化类库
include(__DIR__.'/ClassLoader.php');
//内核初始化进程
KoalaCore::initialize(function(){
    ClassLoader::initialize(function($instance){
    //注册_autoload函数
    $instance->register();
    $instance->registerNamespaces(array(
        'Func' => FRAME_PATH.'Core',
        'Helper' => FRAME_PATH,
        'Base' => FRAME_PATH.'Core',
        'Core' => FRAME_PATH,
        'Server' => FRAME_PATH,
        'Plugin' => array(FRAME_PATH.'Addons',APP_ADDONS_PATH),
        'Minion' => FRAME_PATH.'Addons',
        'Resource'=>FRAME_PATH.'Addons',
        ));
    $instance->registerDirs(array(
        FRAME_PATH.'Core',
        FRAME_PATH.'Tests',
        FRAME_PATH.'Server',
        FRAME_PATH.'Addons/Compatible',
        ));
    //系统内置函数库
    $instance->LoadFunc('Func','Common,Special');
    });
    //检查环境
    require_once(FRAME_PATH.'Initialise/checkEnv.php');
    //加载常量
    include(FRAME_PATH.'Initialise/Constant'.APPENGINE.'.php');
    //composer第三方库加载支持
    require FRAME_PATH.'Addons/vendor/autoload.php';
    //++++++++++++++++++++++++系统调试及错误设置++++++++++++++++++++++++++++
    $log = Log::factory('monolog');
    ErrorHandler::register('monolog',array($log),function()use($log){
        switch (C('DEBUGLEVEL',1)) {
            case 2://调试模式
                ini_set("display_errors","On");
                break;
            case 1://默认模式
            default:
                //关掉错误提示
                error_reporting(0);
                ini_set("display_errors","Off");
                break;
        }
        $log->pushHandler(new AEStreamHandler('Log/'.date('Y-m-d')."/ERROR.log", Log::ERROR));
        $log->pushHandler(new AEStreamHandler('Log/'.date('Y-m-d')."/WARN.log", Log::WARNING));
    });
    //加载云服务类支持(如BAE类库)
    (APPENGINE!="LAE") AND include(FRAME_PATH.'Initialise/Class'.APPENGINE.".php");
    //配置初始化
    Config::initialize(function($instance){
        //默认文件
        $instance->loadConfig(FRAME_PATH.'Config'.DIRECTORY_SEPARATOR.'Global.default.php');
    });
    //插件支持
    Plugin::loadPlugin();
});