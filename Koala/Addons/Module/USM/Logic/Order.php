<?php
class USM_Logic_Order extends Base_Logic{
	//是否存在
	public static function isExist($where){
		$obj = USM_Model_Order::count(
			array('conditions' =>$where)
    		);
		if($obj){
        	return array('code'=>1,'msg'=>'存在');
        }
        return array('code'=>0,'msg'=>'不存在');
	}
}