<?php
/**
 * 数据逻辑
 */
class USM_Addons_OrderData extends Base_Addons{
	
	public function before(){
		//查询订单数据
		$id = intval(!empty($_POST["id"])?$_POST["id"]:(!empty($_GET["id"])?$_GET["id"]:"0"));
        $status =\USM_Logic_Order::isExist(array('id=? and state=?',$id,0));
        $order =array();
        if($status['code']){
            $order = \USM_Logic_Order::getList('*',array('id=? and state=?',$id,0));
            return array('code'=>1,'msg'=>'数据获取成功','ext'=>array('data'=>$order[0]));
        }
		else
			return array('code'=>0,'msg'=>'数据获取失败');
	}
	public function after(){
		return array('code'=>1);
	}
}