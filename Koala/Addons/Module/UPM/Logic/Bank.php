<?php
/**
 * 银行
 */
class UPM_Logic_Bank{
	public static function getList($fileds='*',$where='',$order='',$start=0,$limit=1){
        $obj = new UPM_Model_Banktype();
        return $obj->getList($fileds,$where,$num,$start,$order);
    }
}
?>