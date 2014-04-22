<?php
namespace Server\Dispatcher\Drive;
use Core\AOP\AdviceContainer;
class Dispatcher{
	protected $options = array();
	//执行应用
    public function execute($options=array(),AdviceContainer $Container){
        $this->options = $options;
        if(C('MULTIPLE_GROUP')){
            list($group,$module,$action) = $options['path'];
            !defined('GROUP_NAME') AND define('GROUP_NAME',$group);
        }
        else
            list($module,$action) = $options['path'];
        array_pop($options['path']);
        !defined('MODULE_NAME') AND define('MODULE_NAME',ucwords($module));
        !defined('ACTION_NAME') AND define('ACTION_NAME',$action);
        $class = 'Controller\\'.implode("\\",$options['path']);
        $controller = \Core\AOP\Aop::getInstance($class);
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