<?php
session_start();
/**
 * 用户应用自定义初始化加载
 *
 * 根据实际情况书写加载的模块等
 */
Koala::initialize(function(){
    ClassLoader::initialize(function($instance){
    //注册_autoload函数
    $instance->register();
    $instance->registerNamespaces(array(
        'Controller' => APP_PATH,
        'Custom' => APP_PATH,
        'AppCache' => ROOT_PATH.'Koala/Addons',
        'Engine' => ROOT_PATH.'Koala/Addons',
        ));
    //More Coding
    $instance->loadFunc('Custom','Func');
    //加载模块
    $instance->registerNamespaces(array(
        'UFM' => ROOT_PATH.'Koala/Addons/Module',
        ));
    });
    //配置初始化
    Config::initialize(function($instance){
        //用户文件
       $instance->loadConfig(Config::getPath('Config/'.APPENGINE.'Global.user.php'));
    });
    define('STYLENAME', 'default');
    //视图初始化
    View::initialize(function($instance){
        $type = C('Template_Engine:DEFAULT','Tengine');
        $instance->setEngine($type,C('Template_Engine:'.$type));
    });

    //请求处理
    Request::standard();
    Router::UrlParser();
    //More Coding
    //
});
class Koala extends KoalaCore{}