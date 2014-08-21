<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Module
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Module;
/**
 *用户上线佣金处理逻辑
 */
class Commission{
	/**
	 * 用户上线佣金处理逻辑
	 * @param  string $uid   用户id
	 * @param  float $money 消费金额
	 * @return [type]        [description]
	 */
	public function dealCommission($uid,$money=0.00){
		while(true){
			//查询当前用户的上级
			$invitor = \Koala\Module\Invitation\Logic\Invite::getOne('id,invitor',array('invited=?',$uid));
			//不存在上级用户时
			if(empty($invitor))break;
			//计算佣金
			$unsettle = $this->getUnsettle($money);
			//查询是否存在佣金记录
			$res = \Koala\Module\Invitation\Logic\Commission::isExist(array(
	    				'uid=?',$invitor['invitor']
	    				));
			if(!$res['code']){
				//没有佣金记录
				$data = array(
					'uid'=>$invitor['invitor'],
					'unsettle'=>$unsettle,
					);
				//添加佣金记录
				\Koala\Module\Invitation\Logic\Commission::add($data);
			}else{
				//有佣金记录
				//查询上级用户的佣金
		    		$data = \Koala\Module\Invitation\Logic\Commission::getOne('id,unsettle',array(
	    				'uid=?',$invitor['invitor']
	    				));
	    			//更新数据
				\Koala\Module\Invitation\Logic\Commission::update(array(
	    				'id'=>$data['id'],
					'uid'=>$invitor['invitor'],
					'unsettle'=>floatval($data['unsettle'])+$unsettle,
					));
			}
			//上级用户作为下一次循环用户
			$uid = $invitor['invitor'];
		}
		return true;
	}
	public function getUnsettle($money){
		exit($money);
	}
	public function deal($topuid,$uid,$maxdepth=5,&$amount=false,$flag=false){
		while ( $maxdepth>0) {
			//查询下级用户列表
			$invitored = \Koala\Module\Invitation\Logic\Invite::getList('id,invited',array('invitor=?',$uid));
			foreach ($invitored as $key => $user) {
				//查询用户消费记录
				//
				//计算当前下级用户消费产生的佣金
				$unsettle = $this->getUnsettle($money);
				//更新topuid的佣金
		    		//查询是否存在佣金记录
		    		if(!$flag){
					$res = \Koala\Module\Invitation\Logic\Commission::isExist(array(
			    				'uid=?',$topuid
			    				));
				}else{
					$res['code'] = 1;
				}
				if(!$res['code']){
					//没有佣金记录
					$data = array(
						'uid'=>$topuid,
						'unsettle'=>$unsettle,
						);
					//添加佣金记录
					\Koala\Module\Invitation\Logic\Commission::add($data);
				}else{
					//有佣金记录
					
					if($amount===false){
						//查询用户的佣金
				    		$data = \Koala\Module\Invitation\Logic\Commission::getOne('id,unsettle',array(
			    				'uid=?',$topuid
			    				));
				    		$amount = floatval($data['unsettle']);
				    	}
				    	$amount+=$unsettle;
		    			//更新数据
					\Koala\Module\Invitation\Logic\Commission::update(array(
		    				'id'=>$data['id'],
						'uid'=>$topuid,
						'unsettle'=>$amount,
						));
				}
				//递归处理
				$this->deal($topuid,$user['id'],$maxdepth-1,$amount,true);
			}
		}
	}
}