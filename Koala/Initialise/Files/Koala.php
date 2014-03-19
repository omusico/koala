<?php

//应用自定义初始化
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
    $instance->loadFunc('Custom','Func');
    });
    //配置初始化
     Config::initialize(function($instance){
        //用户文件
        $file = APPENGINE.'Global.user.php';
        $file_path = Config::getPath('Config/'.$file);
        if(file_exists($file_path)){
            $instance->loadConfig($file_path);
        }
    });
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
    define('STYLENAME',Config::getItem('style_name',"default"));
    define('SKINNAME',Config::getItem('skin_name'),"default");
    define('CSS_URL',str_replace('\\','/',SOURCE_URL."css".DS));
    define('JS_URL',str_replace('\\','/',SOURCE_URL."js".DS));
    define('IMG_URL',str_replace('\\','/',SOURCE_URL."img".DS));
});
class Koala extends KoalaCore{}