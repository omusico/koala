<?php
class Controller extends Base_AOP{
	public function __call($method,$args){
		//控制器调用前置操作
		if(!$this->before()){
           //print_r($this->getRet());
        }
		//执行主逻辑
		$result = $this->execMain($method,$args);
        
		//控制器调用后置操作
		if(!$this->after()){
            //
        }
		return $result;
	}
	protected function execMain($method,$args){
		$controller = self::$_proxy;
		//执行当前操作
        $objmethod =   new ReflectionMethod($controller,$method);
        if($objmethod->isPublic()) {
            $class  =   new ReflectionClass($controller);
            //控制器内部方法前置操作
            if($class->hasMethod('_before_'.$method)) {
                $before =   $class->getMethod('_before_'.$method);
                if($before->isPublic()) {
                    $before->invoke($controller);
                }
            }
            // URL参数绑定检测
            if(C('URL_PARAMS_BIND') && $objmethod->getNumberOfParameters()>0){
                switch($_SERVER['REQUEST_METHOD']) {
                    case 'POST':
                        $vars    =  array_merge($_GET,$_POST);
                        break;
                    case 'PUT':
                        parse_str(file_get_contents('php://input'), $vars);
                        break;
                    default:
                        $vars  =  $_GET;
                }
                $params =  $objmethod->getParameters();
                foreach ($params as $param){
                    $name = $param->getName();
                    if(isset($vars[$name])) {
                        $args[] =  $vars[$name];
                    }elseif($param->isDefaultValueAvailable()){
                        $args[] = $param->getDefaultValue();
                    }else{
                        throw_exception(L('_PARAM_ERROR_').':'.$name);
                    }
                }
                $objmethod->invokeArgs($controller,$args);
            }else{
                $objmethod->invoke($controller);
            }
            //控制器内部方法后置操作
            if($class->hasMethod('_after_'.$method)) {
                $after =   $class->getMethod('_after_'.$method);
                if($after->isPublic()) {
                    $after->invoke($controller);
                }
            }
        }else{
            // 操作方法不是Public 抛出异常
            throw new ReflectionException();
        }
	}
}