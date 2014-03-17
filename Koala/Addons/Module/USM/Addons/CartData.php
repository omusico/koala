<?php
/**
 * 购物数据逻辑
 */
class USM_Addons_CartData extends Base_Addons{
	
	public function before(){
		//查询购物车数据
		$sid = $_SESSION[GROUP_NAME]['cartsid'];
		$list=array();
		if(isset($sid))
        $list = \USM_Logic_Cart::getItems($sid);
        if(!empty($list)){
        	$amount=0;
        	$num=0;
        	//计算总价
            foreach ($list as $key => $value){
                $p[$value['type']][$value['pid']]['num'] += $value['num'];
                $p[$value['type']][$value['pid']]['amount'] += (double)$value['amount'];
                $amount += (double)$value['amount'];
                $num++;
            }
            return array('code'=>1,'msg'=>'购物数据获取成功','ext'=>array('cart'=>$list,'amount'=>$amount,'num'=>$num,'sale'=>$p));
        }
		else
			return array('code'=>0,'msg'=>'购物数据获取失败');
	}
	public function after(){
		return array('code'=>1);
	}
}