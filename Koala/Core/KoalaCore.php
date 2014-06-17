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
        $u = \Core\AOP\AOP::getInstance('URL');
        $test_url = rtrim(APP_RELATIVE_URL,'/');
        if(!empty($test_url))
            $url = str_replace(APP_RELATIVE_URL,'',$_SERVER['REQUEST_URI']);
        else
            $url = $_SERVER['REQUEST_URI'];
        //请求选项
        $options = $u->requestOption($url,1);
        //视图文件
        View::setTemplateOptions($options['path']);
        //控制器分发
        $dispatcher->execute(
            //获取控制器类
            function()use($options){
                if(C('MULTIPLE_GROUP')){
                    list($group,$module,$action) = $options['path'];
                    !defined('GROUP_NAME') AND define('GROUP_NAME',$group);
                    $class = $group.'\Controller\\'.$module;
                }
                else{
                    list($module,$action) = $options['path'];
                    $class = 'Controller\\'.$module;
                }
                !defined('MODULE_NAME') AND define('MODULE_NAME',ucwords($module));
                !defined('ACTION_NAME') AND define('ACTION_NAME',$action);
                return $class;
            },
            //获取控制器方法
            function()use($options){return array_pop($options['path']);}
        );
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
        //执行 核心的延迟代码片段
        if($object instanceof Koala){
            KoalaCore::executeLazy();
            //如果没有使用过session_start()
            //if(''===($id=session_id()))
            //Koala\Server\Session::register(C('Session:default','pdo'));
        }
    }
    /**
     * 部分延迟执行的代码,用于延迟搜集可由应用自定义的参数，常量等代码
     * @static
     * @access public
     */
    public static function lazyInitialize(Closure $initializer,$options=array()){
        self::$closure[] = array(
            'closure'=>$initializer,
            'params'=>array(self::getInstance(get_called_class()),$options)
            );
    }
    /**
     * 执行 延迟执行的代码
     * @static
     * @access public
     */
    public static function executeLazy(){
        if(count(self::$closure)>0){
            foreach (self::$closure as $key => $value) {
                call_user_func_array($value['closure'],$value['params']);
            }
        }
    }
}

//加载类加载器
include(__DIR__.'/ClassLoader.php');

////核心初始化开始

/**
 * 需要延迟初始化的部分
 */
KoalaCore::lazyInitialize(function(){
    //所有可在应用中自定义的常量

    //优先加载文件中自定义的常量
    include(FRAME_PATH.'Initialise/Constant'.APPENGINE.'.php');

    //控制器路径
    defined('CONTRLLER_PATH') or define('CONTRLLER_PATH',APP_PATH.'Controller/');
    //模型路径
    defined('MODEL_PATH') or define('MODEL_PATH',APP_PATH.'Model/');
    //语言包路径
    defined('LANG_PATH') or define('LANG_PATH',APP_PATH.'Language/');
    //模板路径
    defined('VIEW_PATH') or define('VIEW_PATH',APP_PATH.'View/');
    //读数据路径
    defined('DATA_PATH') or define('DATA_PATH',FRAME_PATH.'Data/');
    //编译路径
    defined('COMPILE_PATH') or define('COMPILE_PATH',RUNTIME_PATH.'Compile/');
    //缓存路径
    defined('CACHE_PATH') or define('CACHE_PATH',RUNTIME_PATH.'Cache/');
    //静态资源URL
    defined('SOURCE_URL') or define('SOURCE_URL', APP_URL.'Source/');
    //存储路径
    defined('STOR_PATH') or define('STOR_PATH',RUNTIME_PATH.'Storage/');
    //存储访问URL
    defined('STOR_URL') or define('STOR_URL',APP_RELATIVE_URL.'Runtime/Storage/');
    //widget路径
    defined('WIDGET_PATH') or define('WIDGET_PATH',APP_PATH.'Addons/Source/Widget/');
    //widget访问URL
    defined('WIDGET_URL') or define('WIDGET_URL',APP_RELATIVE_URL.'Addons/Source/Widget/');
    //文件后缀
    defined('EXT') or define('EXT', '.php');
    //默认应用路径
    defined('APP_PATH') or define('APP_PATH',ENTRANCE_PATH.'App/');
    //默认应用插件路径
    defined('APP_ADDONS_PATH') or define('APP_ADDONS_PATH',APP_PATH.'Addons/');
    defined('APP_PLUGIN_PATH') or define("APP_PLUGIN_PATH",APP_ADDONS_PATH.'Plugin/');
    //请求开始时间
    defined('START_TIME') or define('START_TIME', $_SERVER['REQUEST_TIME_FLOAT']);
    //定义应用标识码
    //对多个相同应用情况下的缓存服务提供前缀防止缓存段共用问题;
    defined('APP_UUID') or define('APP_UUID',substr(md5(APP_PATH),0,6));
    //设置应用默认加载方案
    ClassLoader::initialize(function($instance){
        $instance->register();
        $instance->registerNamespace('Plugin',array(APP_ADDONS_PATH));
    });

    //composer第三方库加载支持
    is_file(APP_PATH.'External/autoload.php') AND require APP_PATH.'External/autoload.php';

    //设定时区
    date_default_timezone_set(C('time_zone','PRC'));
    //设置本地化环境
    setlocale(LC_ALL,"chs");
    //不输出可替代字符
    mb_substitute_character('none');
});

/**
 * 内核初始化进程
 */
KoalaCore::initialize(function(){
    //写数据路径
    defined('RUNTIME_PATH') or define('RUNTIME_PATH',ENTRANCE_PATH.'Runtime/');
    //日志路径
    defined('LOG_PATH') or define('LOG_PATH',RUNTIME_PATH.'Storage/');
    //框架类库加载方案
    ClassLoader::initialize(function($instance){
    $instance->register();
    $instance->registerNamespaces(array(
        'Advice' => FRAME_PATH.'Addons',
        'Func' => FRAME_PATH.'Core',
        'Helper' => FRAME_PATH,
        'Base' => FRAME_PATH.'Core',
        'Core' => FRAME_PATH,
        'Server' => FRAME_PATH,
        'Plugin' => array(FRAME_PATH.'Addons'),
        'Minion' => FRAME_PATH.'Addons',
        'Resource'=>FRAME_PATH.'Addons',
        'Koala'=>dirname(FRAME_PATH),
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
    Plugin::loadPlugin();
});
////核心初始化结束