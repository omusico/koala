<?php
/**
 * 提成业务逻辑
 */
class USM_Addons_Reward extends Base_Addons{
	
	public function before(){
		return array('code'=>1);
	}
	public function after(){
		$data = USM_Biz::getRet('USM_Addons_OrderData->before');
		$order = $data['ext']['order'];
    	//下订单人
    	$user = \UUM_Logic_User::getList('*',array('id=?',$order[0]['uid']));
    	//上级业务员
    	$manager = \UUM_Logic_User::getList('*',array('id=?',$user[0]['pid']));
    	//上级经销商
    	$dealer = \UUM_Logic_User::getList('*',array('id=?',$manager[0]['pid']));
    	// 经销商、业务员提成
        $conf = \USM_Logic_Conf::getList('*',array('code=?','discount'));
        $discount = (double)$conf[0]["value"];
        $money = $order[0]["amount"] * $discount/100;
        $money1 = $money * $manager[0]["discount"] / 100;
        $money2 = $money - $money1;
        $loginusr = (Object)$_SESSION[GROUP_NAME]['user'];
        if($money1>0&&isset($manager[0]["id"])){
	        $data = array(
            "uid"=>$manager[0]["id"],
            "username"=>$manager[0]["username"],
            "amount"=>$money1,
            "operid"=>$loginusr->id,
            "opername"=>$loginusr->username,
            "note"=>"业务员订单提成");
	        $status = \USM_Logic_Reward::add($data);
	    }
	    if($money2>0&&isset($dealer[0]["id"])){
	    	$data = array(
            "uid"=>$dealer[0]["id"],
            "username"=>$dealer[0]["username"],
            "amount"=>$money2,
            "operid"=>$loginusr->id,
            "opername"=>$loginusr->username,
            "note"=>"经销商订单提成");
	        $status = \USM_Logic_Reward::add($data);
	    }
        $user[0]["blockfund"] -= $order[0]["amount"];
    	$manager[0]["money"] += $money1;
    	$dealer[0]["money"] += $money2;

    	\UUM_Logic_User::update($user[0]);
    	if(isset($manager[0]["id"]))
    	\UUM_Logic_User::update($manager[0]);
    	if(isset($dealer[0]["id"]))
    	\UUM_Logic_User::update($dealer[0]);

		return array('code'=>1,'msg'=>'完成提成计算');
	}
}