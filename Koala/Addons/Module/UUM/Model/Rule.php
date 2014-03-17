<?php
/**
 * UUM之权限规则
 */
class UUM_Model_Rule extends Base_Model{
	//主表
    static $table_name = 'auth_rule';
    //获取所有
    public function getAll($fileds,$where=''){
        $objlist=UUM_Model_Rule::find('all',
            array(
                "conditions" => $where,
                'select' => $fileds
            ));
        return self::conv2arr($objlist);
    }
}
?>