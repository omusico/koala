<?php
/**
 * 用户应用自定义初始化加载
 *
 * 根据实际情况书写加载的模块等
 */
KoalaTest::initialize(function(){
    ClassLoader::initialize(function($instance){
        //注册_autoload函数
        $instance->register();
        //More Coding
        $instance->loadFunc('Custom','Func');
         $instance->registerDirs(array(
            APP_PATH.'Tests',
        ));
    });
});
class KoalaTest extends KoalaCore{
    public static function execute(){}
}