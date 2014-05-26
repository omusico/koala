<?php
//应用版本
define('APP_VERSION','1');
/**
 * 需要延迟初始化的部分
 */
Koala::lazyInitialize(function(){
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
    View::initialize(function($instance){
        \View::$engine = Koala\Server\Engine::factory(C('Engine:default'));
    });
});
/**
 * 应用的初始化过程
 */
koala::initialize(function(){
    /**
     * 应用类库加载方案
     */
    ClassLoader::initialize(function($instance){
        $instance->register();
        $instance->registerNamespaces(array(
            'Custom' => APP_PATH,
            'Engine' => FRAME_PATH.'Addons',
            'Tag' => FRAME_PATH.'Extension',
            ));
        $instance->registerDirs(array(
            APP_PATH.'Custom'
            ));
        $instance->loadFunc('Custom','Func');
        $instance->registerNamespaces(array(
            'UFM' => FRAME_PATH.'Addons/Module',
            'UUM' => FRAME_PATH.'Addons/Module',
            ));
    });
    /**
     * 应用的第三方库composer加载支持
     */
    is_file(APP_PATH.'Addons/vendor/autoload.php') AND require APP_PATH.'Addons/vendor/autoload.php';
    /**
     * 应用配置文件
     */
    Config::initialize(function($instance){
        $instance->loadConfig(Config::getPath('Config/LAEGlobal.user.php'));
    });
    /**
     * 环境方案设置
     */
    Koala\Server\Session::register(C('Session:default','pdo'));
    /**
     * 控制器加载方案
     */
    Koala\Server\Controller::register(function(){
        define("CONTRLLER_PATH",APP_PATH.'Application/');
        ClassLoader::initialize(function($instance){
            $instance->register();
            $instance->registerNamespaces(array(
                'Admin' =>CONTRLLER_PATH,
                'Install' =>CONTRLLER_PATH
                ));
        });
    });
});
/**
 * 应用执行实现
 */
class koala extends KoalaCore{
    /**
     * 应用分发实现并执行
     */
    public static function execute(){
        $dispatcher = \Core\AOP\Aop::getInstance(Koala\Server\Dispatcher::factory('mvc'));
        $u = \Core\AOP\Aop::getInstance('URL');
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
}