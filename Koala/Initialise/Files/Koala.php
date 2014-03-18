<?php

//应用自定义初始化
Koala::initialize(function(){
    ClassLoader::initialize(function($instance){

    //用户自定义函数库
    //注册_autoload函数
    $instance->register();

    //注意:loadClass语句不能在下面代码之后,否则将导致某些问题(例如无法获取正确常量值等,原因未明)
    $instance->loadClass('Custom_Func');

    $instance->registerNamespaces(array(
        'AppCache' => ROOT_PATH.'Koala/Addons',
        'Engine' => ROOT_PATH.'Koala/Addons',
        'Controller' => APP_PATH,
        'Custom' => APP_PATH,
        ));
    $instance->registerDirs(array(
        ROOT_PATH.'Koala/Addons/Vendor/Everzet',
        ));
    //加载模块
    $instance->registerNamespaces(array(
        'UUM' => ROOT_PATH.'Koala/Addons/Module',
        'UPM' => ROOT_PATH.'Koala/Addons/Module',
        'USM' => ROOT_PATH.'Koala/Addons/Module',
        'UFM' => ROOT_PATH.'Koala/Addons/Module',
        ));
	});
    Config::initialize(function($instance){
        //用户文件
        $file = APPENGINE.'Global.user.php';
        $file_path = Config::getPath('Config/'.$file);
        if(file_exists($file_path)){
            $instance->loadConfig($file_path);
        }
    });
    !defined('STYLENAME')&&define('STYLENAME',Config::getItem('style_name',"default"));
    !defined('SKINNAME')&&define('SKINNAME',Config::getItem('skin_name'),"default");
	//视图初始化
    View::initialize(function($instance){
        $option = array(
            array(
                'TemplateDir'=>VIEW_PATH.STYLENAME.DS.GROUP_NAME.DS,
                'CompileDir'=>COMPILE_PATH.STYLENAME.DS.GROUP_NAME.DS.MODULE_NAME.DS,
                'PluginDir'=>ADDONS_PATH.'Smarty/plugin'.DS,
                'ConfigDir'=>ROOT_PATH.'Config'.DS,
                'debugging'=>false,
                //'cache_lifetime'=>3600,
                'left_delimiter'=>'{%',
                'right_delimiter' =>'%}',
                'compile_locking'=>false,
                'plugins'=>array(
                    'function'=>array('L'=>'L','U'=>'U','PU'=>'PU','cats'=>'cats'),
                    ),
                )
            );
        $instance->setEngine(Config::getItem('Template.Engine'),$option);
        });
    //皮肤相关
    define('CSS_URL',str_replace('\\','/',SOURCE_URL."css".DS));
    define('JS_URL',str_replace('\\','/',SOURCE_URL."js".DS));
    define('IMG_URL',str_replace('\\','/',SOURCE_URL."img".DS));
});
class Koala extends KoalaCore{}