<?php
/**
 * KoalaCMS - A PHP CMS System In Koala FrameWork
 *
 * @package  KoalaCMS
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Controller;
use Koala\Server\Controller\Base as ControllerBase;

class Oapi extends ControllerBase {
	public function qqLogin() {
		$o = \Koala\OAPI::factory('Tencent\QQConnect', array(), 'Library');
		$o->apply('get_auth_code', array('state' => time()));
		exit;
	}
	public function qqCode() {
		$o = \Koala\OAPI::factory('Tencent\QQConnect', array(), 'Library');
		parse_str($o->apply('get_access_token', array()), $param);
		$openid = json_decode(str_replace(array(' ', ');'), '', substr($o->apply('get_openid', $param), 9)), true);
		$mysql = new \SaeMysql();
		$sql = "SELECT * FROM `ouser` where openid = '" . $mysql->escape($openid['openid']) . "' LIMIT 10";
		$data = $mysql->getData($sql);
		if (empty($data)) {
			$user = json_decode($o->apply('get_user_info', array('openid' => $openid['openid'], 'access_token' => $param['access_token'])), true);
			$sql = "INSERT  INTO `ouser` ( `username`, `openid`, `access_token`, `refresh_token`) VALUES ('" . $mysql->escape($user['nickname']) . "','" . $mysql->escape($openid['openid']) . "' ,'" . $mysql->escape($param['access_token']) . "' , '" . $mysql->escape($param['refresh_token']) . "' ) ";
			$mysql->runSql($sql);
		}
		exit('login success!');
	}
	public function weiboLogin() {
		$o = \Koala\OAPI::factory('Weibo\Connect', array(), 'Library');
		$o->apply('get_auth_code', array('state' => time()));
		exit;
	}
	public function weiboCode() {
		$o = \Koala\OAPI::factory('Weibo\Connect', array(), 'Library');
		$param = json_decode($o->apply('get_access_token', array()), true);
		$mysql = new \SaeMysql();
		$sql = "SELECT * FROM `ouser` where openid = '" . $mysql->escape($param['uid']) . "' LIMIT 10";
		$data = $mysql->getData($sql);
		if (empty($data)) {
			$user = json_decode($o->apply('users_show', $param), true);
			$sql = "INSERT  INTO `ouser` ( `username`, `openid`, `access_token`, `refresh_token`) VALUES ('" . $mysql->escape($user['screen_name']) . "','" . $mysql->escape($param['uid']) . "' ,'" . $mysql->escape($param['access_token']) . "' , '' ) ";
			$mysql->runSql($sql);
		}
		exit('login success!');
	}
	public function txweiboLogin() {
		$o = \Koala\OAPI::factory('Tencent\Weibo', array(), 'Library');
		$o->apply('get_auth_code', array('state' => time()));
		exit;
	}
	public function txweiboCode() {
		$o = \Koala\OAPI::factory('Tencent\Weibo', array(), 'Library');
		parse_str($o->apply('get_access_token', array()), $param);
		$mysql = new \SaeMysql();
		$sql = "SELECT * FROM `ouser` where openid = '" . $mysql->escape($param['openid']) . "' LIMIT 10";
		$data = $mysql->getData($sql);
		if (empty($data)) {
			$sql = "INSERT  INTO `ouser` ( `username`, `openid`, `access_token`, `refresh_token`) VALUES ('" . $mysql->escape($param['nick']) . "','" . $mysql->escape($param['openid']) . "' ,'" . $mysql->escape($param['access_token']) . "' , '" . $mysql->escape($param['refresh_token']) . "' ) ";
			$mysql->runSql($sql);
		}
		exit('login success!');
	}
	public function test() {
		$o = \Koala\OAPI::factory('Alipay\Connect', array());
		echo $o->apply('get_auth_code_login');
		exit;
	}
}