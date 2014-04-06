<?php
abstract class Base_AOP{
	//被代理类
	static $_proxy;
	//附加业务
	static $_addons=array();
	//返回结果
	static $_ret=array();
	//错误状态
	static $_iserror = false;
	//设置被代理对象
	public function getProxy($instance){
		self::$_proxy = $instance;
		return new static();
	}
	//加入附加业务
	//addAddons('UFM\InputFilter')
	//addAddons('UUM_UserIdentity',array(),1,2)
	//addAddons(array('UFM\InputFilter',array(),1,2))
	public function addAddons(){
		$tmpargs = func_get_args();
		if(count($tmpargs)==1&&is_array($tmpargs[0])){//array(array(class,$option,$type,$flag))
			$tmpargs = $tmpargs[0];
		}//else //array(class,$option,$type,$flag)
		$args = array(
			'class'=>$tmpargs['0'],
			'option'=>!isset($tmpargs['1'])?array():$tmpargs['1'],
			'type'=>!isset($tmpargs['2'])?1:$tmpargs['2'],
			'flag'=>!isset($tmpargs['3'])?1:$tmpargs['3']
			);
		switch ($tmpargs['2']) {//1-before,2-after,3-before-after
			case 2:
				self::$_addons[2][] = $args;//after
				break;
			case 3:
				self::$_addons[2][] = $args;//after
			case 1:
				self::$_addons[1][] = $args;//before
				break;
			default:
				self::$_addons[1][] = $args;//before
				break;
		}
		return $this;
	}
	//加入附加业务列表
	//addAddonsList(array('UFM\InputFilter'),array('UUM_UserIdentity',array(),1,2),...)
	public function addAddonsList(){
		$tmpargs = func_get_args();
		foreach ($tmpargs as $param) {
			call_user_func_array('self::addAddons',$param);
		}
		return $this;
	}
	//获得返回结果
	public function getRets(){
		self::$_iserror = false;//状态复原;
		self::$_addons = array();
		return self::$_ret;
	}
	public function getRet($key){
		return self::$_ret[$key];
    }
	//执行前置操作
	protected function before(){
		self::_exec('before',1);
		if(self::$_iserror){
			return 0;
		}
		return 1;
	}
	//执行后置操作
	protected function after(){
		self::_exec('after',2);
		if(self::$_iserror){
			return 0;
		}
		return 1;
	}
	//执行操作
	protected function _exec($method,$pos){
		if(!empty(self::$_addons[$pos])){
			foreach (self::$_addons[$pos] as $key => $callback_arr) {
				//call(array($object,method),param);
				/*
				$ret = array(
				'code'=>1,//0,1,.....
				'msg'=>'',
				'ext'=>array(...);
				)
				*/
				if(is_object($callback_arr['class']))
					$ret = call_user_func_array(array($callback_arr['class'],$method),$callback_arr['option']);
				else
					$ret = call_user_func_array(array(new $callback_arr['class'](),$method),$callback_arr['option']);
				
				if(is_object($callback_arr['class']))
					$current = get_class($callback_arr['class']);
				else
					$current = $callback_arr['class'];
				if(isset($ret)){//如果设置了返回值
					self::$_ret[$current.'->'.$method]=$ret;
				}
				if($callback_arr['flag']==2){//是先验条件，意味着失败则不继续任务.
					if(!(isset($ret['code'])&&$ret['code']==1)){
						break;
					}
				}
				//必须清理
				unset(self::$_addons[$pos][$key]);
			}
		}
	}
}