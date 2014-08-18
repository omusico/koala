<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Addons\Initialize;
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
            'Custom' => APP_PATH,
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
    \Plugin::trigger('coreLazyInitialize','','',true);
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
}