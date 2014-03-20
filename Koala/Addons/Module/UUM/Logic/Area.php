<?php
//地区
class UUM_Logic_Area{
    //获取省,城市,地区列表
    public static function getList($type,$fileds='*',$where='',$order='id DESC',$start=0,$limit=500){
        $model = 'UUM_Model_'.ucwords(strtolower($type));
        $obj = new $model();
        return $obj->getList($fileds,$where,$num,$start,$order);
    }
    //地址串
    public static function getAddress($location1,$location2,$location3){
    	$address = '';
    	$province = \UUM_Logic_Area::getList('Province','province',array('provinceid = ?',$location1));
        $address .= $province[0]["province"];
        $city = \UUM_Logic_Area::getList('city','city',array('cityid = ?',$location2));
        $address .= $city[0]["city"];
        $area = \UUM_Logic_Area::getList('Area','area',array('areaid = ?',$location3));
        $address .= $area[0]["area"];
        return $address;
    }
    //地址冲突检测
    public static function isConfict($type,$location1,$location2,$location3){
        if($location1=="0"){
            return array('code'=>1,'msg'=>'没有选择地址');
        }
        else if($location2=="0"){
            if(UUM_Model_User::count(array('conditions' =>array("type = ? and location1=?",$type,$location1)))){
                return array('code'=>1,'msg'=>'存在地址冲突');
            }
        }
        else if($location3=="0"){

            if(UUM_Model_User::count(array('conditions' =>array("type=? and ((location1=? and location2=0) or (location2=?))",$type,$location1,$location2)))){
                 return array('code'=>1,'msg'=>'存在地址冲突');
            }
        }
        else{
            if(UUM_Model_User::count(array('conditions' =>array("type=? and ((location1=? and location2=0) or (location2=? and location3=0) or (location3=?))",$type,$location1,$location2,$location3)))){
                 return array('code'=>1,'msg'=>'存在地址冲突');
            }
        }
        return array('code'=>0,'msg'=>'不存在地址冲突');
    }
      
}