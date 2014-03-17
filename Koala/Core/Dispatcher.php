<?php
defined('IN_Koala') or exit();
//调度器
class Dispatcher extends Initial{
	//执行应用
    public static function execute($options){
    	$action = array_pop($options['paths']);
        $ins = self::loadController($options['paths']);
        //调用控制器
        $controller = Controller::getProxy($ins)->addAddonsList(
            array(new UFM\InputFilter(),array(),1,1)
            );
        try{
            if(!preg_match('/^[_A-Za-z](\w)*$/',$action)){
                // 非法操作
                throw new ReflectionException();
            }
            $controller->{$action}();
            $status = $controller->getRets();
        } catch (ReflectionException $e) { 
            // 方法调用发生异常后
            echo '方法异常';
        }
    }
    protected static function loadController($options){
    	$class_m = implode("\\",$options);
    	$filename = str_replace("\\",DIRECTORY_SEPARATOR,$class_m);
        $file = CONTRLLER_PATH.$filename.'.php';
        $class = 'Controller\\'.$class_m;
        if (file_exists($file)) {
            include $file;
            return new $class();
        } else {
            exit('控制器不存在.');
        }
    }
}
?>