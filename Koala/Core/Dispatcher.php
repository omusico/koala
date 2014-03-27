<?php
//调度器
class Dispatcher extends Initial{
    static $options = array();
	//执行应用
    public static function execute($options){
        self::$options = $options;
    	$action = array_pop($options['paths']);
        $ins = self::loadController();
        //调用控制器
        $controller = Controller::getProxy($ins);
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
    protected static function loadController(){
        $paths = self::$options['paths'];
        //去除action
        array_pop($paths);
    	$class_m = implode("\\",$paths);
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