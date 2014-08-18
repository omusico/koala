<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Addons\Initialize;
use Plugin;
/**
* Initialize
*/
class Action{
    /**
    * 供插件管理器主动加载的入口
    * @param string $plugin 插件管理器
    */
    function __construct(){
        //你想自动挂接的钩子列表
        Plugin::only('appInitialize', array(&$this,'appInitialize'));
        Plugin::only('appLazyInitialize', array(&$this,'appLazyInitialize'));
        Plugin::only('coreLazyInitialize', array(&$this,'coreLazyInitialize'));
    }
    /**
     *
     * @param  array  $options [description]
     * @return [type]          [description]
     */
    public function appInitialize($options=array()){
    /**
     * 应用类库加载方案
     */
    \ClassLoader::initialize(function($instance){
        $instance->register();
        $instance->registerNamespaces(array(
            'Controller' => dirname(CONTRLLER_PATH),
            'Model' => dirname(MODEL_PATH),
            'Logic' => dirname(MODEL_PATH),
            'Library'=>APP_PATH,
            'Custom' => APP_PATH,
            'Addons' => APP_PATH,
            'Tag' => FRAME_PATH.'Extension',
            ));
        $instance->registerDirs(array(
            APP_PATH.'Custom'
            ));
        $instance->loadFunc('Custom','Func');
    });

    /**
     * 应用的第三方库composer加载支持
     */
    is_file(APP_PATH.'Vendor/autoload.php') AND require APP_PATH.'Vendor/autoload.php';
    /**
     * 应用配置文件
     */
    \Config::initialize(function($instance){
        $instance->loadConfig(\Config::getPath('Config/LAEGlobal.user.php'));
    });
    /**
     * 应用的初始化过程
     */
    \Plugin::trigger('appLazyInitialize','','',true);
    }
    public function appLazyInitialize(){
        /**
         * 视图加载方案
         */
        //视图风格名
        define('THEME_NAME',C('THEME_NAME',"page"));
        //静态资源URL
        define('CSS_URL',str_replace('\\','/',SOURCE_URL."css".DS));
        define('JS_URL',str_replace('\\','/',SOURCE_URL."js".DS));
        define('IMG_URL',str_replace('\\','/',SOURCE_URL."img".DS));
        //视图初始化
        \View::initialize(function($instance){
            \View::$engine = \Koala\Server\Engine::factory(C('Engine:default'));
        });
    }
    public function coreLazyInitialize(){
        
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
    defined('APP_PATH') or define('APP_PATH',ENTRANCE_PATH.'MyApp/');
    //默认应用插件路径
    defined('APP_ADDONS_PATH') or define('APP_ADDONS_PATH',APP_PATH.'Addons/');
    defined('APP_PLUGIN_PATH') or define("APP_PLUGIN_PATH",APP_ADDONS_PATH.'Plugin/');
    //请求开始时间
    defined('START_TIME') or define('START_TIME', $_SERVER['REQUEST_TIME_FLOAT']);
    //定义应用标识码
    //对多个相同应用情况下的缓存服务提供前缀防止缓存段共用问题;
    defined('APP_UUID') or define('APP_UUID',substr(md5(APP_PATH),0,6));

    //设置应用插件默认加载方案
    \ClassLoader::initialize(function($instance){
        $instance->register();
        $instance->registerNamespace('Plugin',array(APP_ADDONS_PATH));
    });

    //composer第三方库加载支持
    is_file(APP_PATH.'External/autoload.php') AND require APP_PATH.'External/autoload.php';

    //设定时区
    date_default_timezone_set(C('time_zone','Asia/Hong_Kong'));
    //设置本地化环境
    setlocale(LC_ALL,"chs");
    //不输出可替代字符
    mb_substitute_character('none');
    }
}