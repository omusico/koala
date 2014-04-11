<?php
namespace Server\Dispatcher\Drive;
class Dispatcher{
	protected $options = array();
	//执行应用
    public function execute($options){
        $this->options = $options;
        $action = array_pop($options['paths']);
        $class = 'Controller\\'.implode("\\",$options['paths']);
        $options['c_instance']  = new $class();
        //调用控制器
        $controller = \Controller::factory('',$options);
        $custom['const'] = get_defined_constants();
        \View::assign('Koala',$custom);
        try{
            if(!preg_match('/^[_A-Za-z](\w)*$/',$action)){
                // 非法操作
                throw new \ReflectionException();
            }
            $controller->{$action}();
        } catch (\ReflectionException $e) { 
            // 方法调用发生异常后
            echo '方法异常';
        }
    }
    public function getOptions(){
    	return $this->options;
    }
}