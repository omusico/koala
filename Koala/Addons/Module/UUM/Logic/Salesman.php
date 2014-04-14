<?php
class UUM_Logic_Salesman extends Base_Logic{
	//代理商是否存在
	public static function isExist($where){
		$obj = UUM_Model_User::count(
			array('conditions' =>$where)
    		);
		if($obj){
        	return array('code'=>1,'msg'=>'存在');
        }
        return array('code'=>0,'msg'=>'不存在');
	}
	public static function getList($fileds='*',$where='',$order='id desc',$start=0,$limit=1){
        $obj = new UUM_Model_User();
       return $obj->getList($fileds,$where,$limit,$start,$order);
    }
    //更新
    public static function update($data){
    	$user = new UUM_Model_User();
    	if($user->update($data)){
    		return array('code'=>1,'msg'=>'更新信息成功');
    	}
    	return array('code'=>1,'msg'=>'更新信息失败');
    }
    //分页数据
    public static function getData($pagesize=20,$pageid=1,$fileds='*',$where='',$style='Badoo'){
		$page = new Helper_Pagination(UUM_Model_User::count(array('conditions' =>$where)),$pagesize,$pageid);
		//获取数据
		$page->setSourceCall('UUM_Model_User::getPagin',array($fileds,$where));
		//设置分页样式
		$page->setTemplate($style);
		return $page;
	}

}