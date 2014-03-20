<?php
class UUM_Logic_Group extends Base_Logic{
	//初始化管理员的权限
    public static function initAdminAuth($gid){
        $obj = new UUM_Model_Rule();
        $list = $obj->getAll('id,name');
        $ids = '';
        foreach ($list as $key => $item) {
            if(empty($ids)){
                $ids = $item['id'];
            }else{
                $ids .= ','.$item['id'];
            }
        }
        $obj = UUM_Model_Group::find($gid,
            array(
                'select' => '*'
            ));
        $obj->rules = $ids;
        if($obj->save()){
        	return array('code'=>1,'msg'=>'管理员组权限初始化成功');
        }
        return array('code'=>0,'msg'=>'管理员组权限初始化失败');
    }
    //获取组权限
    public static function getGroupAuth($gid){
    	$obj = new UUM_Model_Group();
    	$res = $obj->getById($gid);
    	return $res;
    }
}