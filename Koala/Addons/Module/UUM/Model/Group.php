<?php
/**
 * UUM之用户组管理
 */
class UUM_Model_Group extends Base_Model{
	//主表
    static $table_name = 'auth_group';
    //获取所有
    public function getAll($fileds){
        $objlist = UUM_Model_Group::all(array('select'=>$fileds));
        return self::conv2arr($objlist);
    }
       
}
?>