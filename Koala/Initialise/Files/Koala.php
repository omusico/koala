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
    //More Coding
    $instance->loadFunc('Custom','Func');
    //加载模块
    $instance->registerNamespaces(array(
        'UFM' => FRAME_PATH.'Addons/Module',
        'UUM' => FRAME_PATH.'Addons/Module',
        ));
    });
    //配置初始化
    Config::initialize(function($instance){
        //用户文件
        $instance->loadConfig(Config::getPath('Config/LAEGlobal.user.php'));
    });
    Session::register(C('Session:default','file'));
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