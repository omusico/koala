<?php

session_start();

define('DS',DIRECTORY_SEPARATOR);
//配置路径
define("CONFIG_PATH", FRAME_PATH.'Config'.DS);
//运行时目录//写数据目录
define('RUNTIME_PATH',ROOT_PATH.'Runtime'.DS);
//日志目录
define('LOG_PATH',RUNTIME_PATH.'Storage'.DS);
//初始化类库
//set_include_path(get_include_path() . PATH_SEPARATOR . implode(PATH_SEPARATOR,array(FRAME_PATH.'Core')));
include_once(__DIR__.'/ClassLoader.php');
//内核初始化进程
KoalaCore::initialize(function(){
    ClassLoader::initialize(function($instance){
    //注册_autoload函数
    $instance->register();
    $instance->registerNamespaces(array(
        'Func' => ROOT_PATH.'Koala/Core',
        'Helper' => ROOT_PATH.'Koala',
        'Base' => ROOT_PATH.'Koala/Core',
        'Interface' => ROOT_PATH.'Koala/Core',
        'Factory' => ROOT_PATH.'Koala/Core',
        'Core' => ROOT_PATH.'Koala',
        'Server' => ROOT_PATH.'Koala/Core',
        'Minion' => ROOT_PATH.'Koala/Addons',
        'Psr' => ROOT_PATH.'Koala/Addons/Vendor',
        'Monolog' => ROOT_PATH.'Koala/Addons/Vendor'
        ));
    $instance->registerDirs(array(
        ROOT_PATH.'Koala/Core',
        ROOT_PATH.'Koala/Core/Server',
        ROOT_PATH.'Koala/Addons/Compatible',
        ));
    //-----------加载系统函数库-----------
    //系统内置函数库
    $instance->loadClass('Func_Common');
    $instance->loadClass('Func_Special');

    //加载差异函数库
    defined('APPENGINE')&&(APPENGINE!=='LAE')&&$instance->loadClass('Func_'.APPENGINE);
    });
    //++++++++++++++++++++++++系统调试及错误设置++++++++++++++++++++++++++++
    $log = Log::factory();
    ErrorHandler::register($log);
    $log->pushHandler(new AEStreamHandler('Log/'.date('Y-m-d')."/ERROR.log", Log::ERROR));
    $log->pushHandler(new AEStreamHandler('Log/'.date('Y-m-d')."/WARN.log", Log::WARNING));
    //检查环境
    require_once(FRAME_PATH.'Initialise/checkEnv.php');
    if(!file_exists(ROOT_PATH.'App')){
        //编译设置
        require_once(FRAME_PATH.'Initialise/BuildItems/build.php');
    }
    //应用路径
    define('APP_PATH',realpath(ROOT_PATH.'App').DIRECTORY_SEPARATOR);
    //配置初始化
    Config::initialize(function($instance){
        //默认文件
        $default_file = 'Global.default.php';
        $default_file_path = CONFIG_PATH.$default_file;
        $instance->loadConfig($default_file_path);
        //用户文件
        $file = APPENGINE.'Global.user.php';
        $file_path = APP_PATH.'Config/'.$file;
        if(!file_exists($file_path)){
            $instance->loadConfig($file_path);
        }
    });
    //加载常量
    file_exists(FRAME_PATH.'Initialise/Constant'.APPENGINE.'.php')&&require_once(FRAME_PATH.'Initialise/Constant'.APPENGINE.'.php');
    //加载云服务类支持(如BAE类库)
    file_exists(FRAME_PATH.'Initialise/Class'.APPENGINE.".php")&&require_once(FRAME_PATH.'Initialise/Class'.APPENGINE.".php");
    //加载常量
    require_once(FRAME_PATH.'Initialise/Constant.php');
    //针对云环境的数据目录搬移等操作
    require_once(FRAME_PATH.'Initialise/adaptEnv.php');//如何分离仅使用一次的代码呢
    Request::standard();
    Request::UrlParser();
    //调度器初始化
    Dispatcher::initialize(function($instance){});
    View::initialize(function($instance){});
});
class Initial{
    static $instance=array();
    /**
     * 配置初始化
     * @param  Closure $initializer 匿名函数
     */
    public static function initialize(Closure $initializer,$option=array()){
        $initializer(self::getInstance(),$option);
    }
    /**
     * 获得实例
     * @return object        对象实例
     */
    public static function getInstance(){
        $class = get_called_class();
        $md5_class = MD5($class);
        if(!isset(static::$instance[$md5_class])){
            static::$instance[$md5_class] = new static();
        }
        return static::$instance[$md5_class];
    }
}
class KoalaCore extends Initial{
    //执行应用
    public static function execute(){
        //判断运行模式
        if(RUNCLI){
            //使用命令行解析器
            Task::factory(KoalaCLI::options())->execute();
        }else{
            //分发
            Dispatcher::execute(Request::options());
        }
       
    }
}
