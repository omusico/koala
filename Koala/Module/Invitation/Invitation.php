<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Module
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Module;
/**
 * 邀请实现类
 */
class Invitation{
	/**
	 * 生成邀请链接
	 * @param string baseurl  参数
	 * @param array param  参数
	 * @return [type] [description]
	 */
	public function makeInvitationUrl($baseurl,$param=array()){
		return U($baseurl,$param,true,false,true);
	}
	/**
	 * 解析邀请链接
	 * @param string url
	 * @return [type] [description]
	 */
	public function parseInvitationUrl($url=''){
		$options = \Plugin::trigger('invitationUrl',$url,'',true);
		return $options;
	}
	/**
	 * 新增邀请关系
	 */
	public function addNewRelation($data=array()){
		return \Koala\Module\Invitation\Logic\Invite::add($data);
	}
	/**
	 * 获取用户的邀请关系
	 * @param string $user    登录用户(被邀请者)
	 * @return [type] [description]
	 */
	public function getInvitationInfo($user){}
	/**
	 * 获取用户的已邀请用户数
	 * @return [type] [description]
	 */
	public function getInvitedNum($uid){
		return \Koala\Module\Invitation\Model\Invitation::count(
			array('conditions' => array('invitor=?',$uid))
			);
	}
	/**
	 * 检查邀请码是否有效
	 */
	public function checkCode(){}
}