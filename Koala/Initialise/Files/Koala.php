<?php
//应用自定义初始化
koala::initialize(function(){
    ClassLoader::initialize(function($instance){
    //注册_autoload函数
    $instance->register();
    //注册_autoload函数
    $instance->register();
    $instance->registerNamespaces(array(
        'Custom' => APP_PATH,
        'Engine' => FRAME_PATH.'Addons',
        'Tag' => FRAME_PATH.'Extension',
        ));
    $instance->registerDirs(array(
        APP_PATH.'Custom'
        ));
    //More Coding
    $instance->loadFunc('Custom','Func');
    //加载模块
    $instance->registerNamespaces(array(
        'UUM' => APP_PATH.'Addons/Module',
        'UPM' => APP_PATH.'Addons/Module',
        'USM' => APP_PATH.'Addons/Module',
        'UFM' => APP_PATH.'Addons/Module',
        ));
    });
    //composer第三方库加载支持
    is_file(APP_PATH.'Addons/vendor/autoload.php') AND require APP_PATH.'Addons/vendor/autoload.php';
    //配置初始化
    Config::initialize(function($instance){
        //用户文件
        $instance->loadConfig(Config::getPath('Config/LAEGlobal.user.php'));
    });
    //控制器加载
    Controller::register();
    define('STYLENAME', 'default');
    //视图初始化
    View::initialize(function($instance){
        $type = C('Template_Engine:DEFAULT','Tengine');
        $instance->setEngine($type,C('Template_Engine:'.$type));
    });
});
class koala extends KoalaCore{
    public static function execute(){
        Dispatcher::factory('mvc')->execute(URL::Parser());
    }
}