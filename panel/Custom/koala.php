<?php

//应用自定义初始化
koala::initialize(function(){
    ClassLoader::initialize(function($instance){
        //注册_autoload函数
        $instance->register();
        //注册_autoload函数
    $instance->register();
    $instance->registerNamespaces(array(
        'Controller' => APP_PATH,
        'Custom' => APP_PATH,
        'Engine' => ROOT_PATH.'Koala/Addons',
        'Tag' => ROOT_PATH.'Koala/Extension',
        ));
    //More Coding
    $instance->loadFunc('Custom','Func');
    //加载模块
    $instance->registerNamespaces(array(
        'UFM' => ROOT_PATH.'Koala/Addons/Module',
        'UUM' => ROOT_PATH.'Koala/Addons/Module',
        ));
    });
    //配置初始化
    Config::initialize(function($instance){
        //配置
        $instance->loadConfig(Config::getPath('Config/LAEGlobal.user.php'));
        //应用配置
        $instance->loadConfig(Config::getPath('Config/app.php'));
    });
    define('STYLENAME', 'default');
    //视图初始化
    View::initialize(function($instance){
        $type = C('Template_Engine:DEFAULT','Tengine');
        $instance->setEngine($type,C('Template_Engine:'.$type));
    });
});
class koala extends KoalaCore{
    public static function execute(){
        //分发
        Dispatcher::factory('mvc')->execute(URL::Parser());
    }
}