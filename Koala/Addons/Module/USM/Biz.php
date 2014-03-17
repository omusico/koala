<?php
//业务AOP
class USM_Biz extends Base_AOP{
    //主业务结果
    static $result = '';
	public function __call($method,$args){
        //控制器调用前置操作
        if(!$this->before()){
           //print_r($this->getRet());
        }
        //执行主逻辑
        $status = $this->execMain($method,$args);
        //保存主逻辑结果
        self::$result=$status['ext'];
        //控制器调用后置操作
        if($status['code']&&!$this->after()){
            //
        }
        return $status;
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
            $result = call_user_func_array(array($controller,$method),$args);
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
        return $result;
	}

}