<?php
class USM_Logic_Conf extends Base_Logic{
	//是否存在
	public static function isExist($where){
		$obj = USM_Model_Conf::count(
			array('conditions' =>$where)
    		);
		if($obj){
        	return array('code'=>1,'msg'=>'存在');
        }
        return array('code'=>0,'msg'=>'不存在');
	}
	//产品入库
	public static function addConf($data){
		if(is_array($data)){
			$obj = new USM_Model_Conf();
			if($obj->add($data)){
				return array('code'=>1,'msg'=>'添加成功');
			}
		}
		return array('code'=>0,'msg'=>'添加失败');
	}
}