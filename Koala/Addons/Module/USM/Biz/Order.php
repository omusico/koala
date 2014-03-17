<?php
//订单主业务逻辑
class USM_Biz_Order{
	//添加订单
	public function add(){
		//查询用户余额
        $userobj = (Object)$_SESSION[GROUP_NAME]['user'];
        $user = \UUM_Logic_User::getList('id,money,blockfund',array('id=?',$userobj->id));
        $data = USM_Biz::getRet('USM_Addons_CartData->before');
        if($data['ext']['amount']>=$user[0]['money']){
        	return array('code'=>0,'msg'=>'用户余额不足');
        }
        $amount = $data['ext']['amount'];
        $num = $data['ext']['num'];
        $cart = $data['ext']['cart'];

        $user = $user[0];
        $user['money'] -= $amount;
        $user['blockfund'] += $amount;
        $status = \UUM_Logic_User::update($user);
        unset($data);
        if($status['code']){
        	//将信息加入订单表
            //订单序列号
            $data['serial']= createShortGuid('order');
            //订单总价
            $data['amount'] = $amount;
            //下单用户
            $data['uid'] = $userobj->id;
            $data['username'] = $userobj->username;
            //订单状态
            $data['state'] = '0';
            //订单时间
            $data['addtime'] = date('Y-m-d H:m:s',time());
            $status = \USM_Logic_Order::add($data);

            $data['id'] = $status['ext']['id'];
            //供次义务使用数据
            USM_Biz::$_ret['USM_Biz_Order->add'] = array('code'=>$status['code'],'msg'=>$status['msg'],'ext'=>array('data'=>$data));
        }
        
        return array('code'=>$status['code'],'msg'=>$status['msg'],'ext'=>array('id'=>$status['ext']['id']));
	}
    public function dealOrder(){
        $loginusr = (Object)$_SESSION[GROUP_NAME]['user'];
        $data =\USM_Biz::getRet('USM_Addons_OrderData->before');
        $data = $data['ext']['data'];
        $data["state"] = 2;
        $data["operid"] = $loginusr->id;
        $data["opername"] = $loginusr->username;
        $data["confirmtime"] = date("Y-m-d H:i:s");
        $status = \USM_Logic_Order::update($data);
        return array('code'=>$status['code'],'msg'=>$status['msg'],'ext'=>array('data'=>$data));
    }
}