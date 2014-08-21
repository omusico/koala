<?php
/**
* Koala - A PHP Framework For Web
*
* @package  Koala
* @author   LunnLew <lunnlew@gmail.com>
*/
namespace Koala\Module\Invitation\Logic;
use Base_Logic;
use Module\Invitation\Model\Invitation;
/**
* 邀请模块逻辑
* @author 20140415
*/
class Invite extends Base_Logic{
	/**
	 * 获得模型类
	 * @return [type] [description]
	 */
	public static function getModel(){
		return str_replace('Logic\Invite', 'Model\Invitation',get_called_class());
	}
	/**
	* 是否存在记录
	* @param  array  $where 查询条件
	* @return boolean       true/false
	*/
	public static function isExist($where){
		$obj = Invitation::count(
			array('conditions' =>$where)
		);
		if($obj){
			return array('code'=>1,'msg'=>'存在');
		}
		return array('code'=>0,'msg'=>'不存在');
	}
	/**
	* 查询记录列表
	* @param  string  $fileds 字段
	* @param  string  $where  条件
	* @param  string  $order  排序
	* @param  integer $start  偏移
	* @param  integer $limit  条数
	* @return array          索引结果
	*/
	public static function getList($fileds='*',$where='',$order='id desc',$start=0,$limit=1){
		$obj = new Invitation();
		return $obj->getList($fileds,$where,$limit,$start,$order);
	}
	//更新
	public static function update($data){
		$user = new Invitation();
		if($user->update($data)){
			return array('code'=>1,'msg'=>'更新信息成功');
		}
		return array('code'=>1,'msg'=>'更新信息失败');
	}
}