<?php
/**
 * 购物车
 * 
 * @author  lunnlew <lunnlew@qq.com>
 * @copyright 20130809 lunnlew
 * 
 */
class USM_Logic_Cart extends Base_Logic{
	static $sid;
	//默认配置
    static $_config = array(
        'namespace' => 'cart'
    );
	/**
	 * 生成购物车序列号
	 */
	public static function makeSid(){
		self::$sid = createShortGuid(self::$_config['namespace']);
		return self::$sid;
	}
	/**
	 * 加入购物数据
	 */
	public static function addItem($data,$sid=null){
		if(!empty($sid)){
			self::$sid = $sid;
		}
		if(USM_Model_Cart::add($data)){
			return  array('code'=>1,'msg'=>'加入购物车成功');
		}
		return array('code'=>0,'msg'=>'加入购物车失败');
	}
	public static function getItems($sid=null){
		if(!empty($sid)){
			self::$sid = $sid;
		}
		return USM_Model_Cart::getList('*',array('sid=?',self::$sid),'id desc',0,50);
	}
	/**
	 * 更新购物车数据
	 */
	public static function updateItem($data,$sid=null){
		if(!empty($sid)){
			self::$sid = $sid;
		}
		if(USM_Model_Cart::update($data)){
			return  array('code'=>1,'msg'=>'更新购物车成功');
		}
		return array('code'=>0,'msg'=>'更新购物车失败');
	}
	/**
	 * 清空购物车数据
	 * @param  string $sid 购物车id
	 * @return boll
	 */
	public static function clear($sid=null){
		if(!empty($sid)){
			self::$sid = $sid;
		}
		if(USM_Model_Cart::delete_all(array('conditions' =>array('sid=?',self::$sid)))){
			return  array('code'=>1,'msg'=>'清空购物数据成功');
		}
		return  array('code'=>0,'msg'=>'清空购物数据失败');
	}
}
?>