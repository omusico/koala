<?php
class UUM_Logic_Test extends Base_Logic{
	public static function getList($fileds='*',$where='',$order='id desc',$start=0,$limit=1){
        $obj = new UUM_Model_User();
        return $obj->getList($fileds,$where,$limit,$start,$order);
    }
}