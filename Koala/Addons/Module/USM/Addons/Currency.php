<?php
/**
 * 流通数据逻辑
 */
class USM_Addons_Currency extends Base_Addons{
	
	public function before(){
		return array('code'=>1);
	}
	public function after(){
        $userobj = (Object)$_SESSION[GROUP_NAME]['user'];
        $sid = $_SESSION[GROUP_NAME]['cartsid'];
        $data = USM_Biz::getRet('USM_Addons_CartData->before');
        $amount = $data['ext']['amount'];
        $num = $data['ext']['num'];
        $cart = $data['ext']['cart'];
        $data = USM_Biz::getRet('USM_Biz_Order->add');
        //将资金流通数据入库
        $da['fid'] = $userobj->id;
        $da['tid'] = $cart[0]['fid'];
        $da['amount'] =  $amount;
        $da['purpose'] = '订单支付';
        $da['channel'] = '产品订单';
        $da['paytype'] = '交易';
        $da['payment'] = '余额支付';
        $da['state']=0;
        $da['oid'] = $data['ext']['data']['id'];
        $da['note'] = '订单号:'.$data['ext']['data']['serial'];
        $status = \USM_Logic_Fund::add($da);
        //将信息加入流通记录表
        foreach ($cart as $key => $value){
            unset($cart[$key]['sid']);
            unset($cart[$key]['type']);
            unset($cart[$key]['id']);
            $cart[$key]['oid']=$data['ext']['data']['serial'];
            if($value['type']=='product'){
                $status = \USM_Logic_OrderProduct::add($cart[$key]);
            }else{
                $status = \USM_Logic_OrderBaseliquor::add($cart[$key]);
            }
        }
        $status = \USM_Logic_Cart::clear($sid);
        return $status;
	}
}