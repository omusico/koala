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
class Commission {
	/**
	 * 用户上线佣金处理逻辑
	 * @param  string $uid   用户id
	 * @return [type]        [description]
	 */
	public function dealCommission($profit, $uid, $maxdepth = 5, $floor = 1) {
		//获得用户的上级用户
		$invitor = \Koala\Module\Invitation\Logic\Invite::getList('id,invitor', array('invited=?', $uid));
		//当前提成深度
		if ($maxdepth > 0 && !empty($invitor)) {
			//对多个用户进行处理
			foreach ($invitor as $key => $user) {
				//查询上级用户的余额
				$tuser = \UUM_Logic_User::getOne('id,money', array('id=? and state=?', $user['invitor'], '正常'));
				//计算订单产生的利润的佣金
				$unsettle = \getUnsettle($profit, $floor);
				//更新上级用户的数据
				\UUM_Logic_User::update(array(
						'id'    => $user['invitor'],
						'money' => $tuser['money']+$unsettle,
					));
				//资金流入库
				$da['fid']     = 0;
				$da['tid']     = $user['invitor'];
				$da['amount']  = $unsettle;
				$da['purpose'] = '返现支付';
				$da['channel'] = '消费星级返现';
				$da['paytype'] = '返现';
				$da['payment'] = '返现';
				$da['addtime'] = gmdate("Y-n-j H:i:s", time()+8 * 3600);
				//资金状态//已付款
				$da['state'] = \FundState::HAVEDEDUCT;
				$da['oid']   = 0;
				$da['note']  = '返现金额:' . $unsettle . ',用户层级:' . $floor;
				$status      = \USM_Logic_Fundrecord::add($da);

				//递归处理
				$this->dealCommission($profit, $user['invitor'], $maxdepth - 1, $floor + 1);
			}
		}
	}
	/**
	 * 用户业绩处理逻辑
	 * @param  string $uid   用户id
	 * @return [type]        [description]
	 */
	public function dealPerformance($amount, $uid, $maxdepth = 5) {
		//获得用户的上级用户
		$invitor = \Koala\Module\Invitation\Logic\Invite::getList('id,invitor', array('invited=?', $uid));
		//当前提成深度
		if ($maxdepth > 0 && !empty($invitor)) {
			//对多个用户进行处理
			foreach ($invitor as $key => $user) {
				//查询上级用户的业绩
				$data = \UUM_Logic_User::getList('id,performance', array('id=? and state=?', $user['invitor'], '正常'));
				//更新上级用户的业绩
				\UUM_Logic_User::update(array(
						'id'          => $data[0]['id'],
						'performance' => $data[0]['performance']+$amount,
					));
				//递归处理
				$this->dealPerformance($amount, $user['invitor'], $maxdepth - 1);
			}
		}
	}
}