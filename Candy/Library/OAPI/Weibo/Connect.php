<?php
/**
 * @package  Library
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Library\OAPI\Weibo;
/**
 */
class Connect extends \Koala\OAPI\Weibo\Connect {

	/**
	 * 获取已保存的code RedirectUri
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getCodeRedirectUri($str = '') {
		$mysql = new \SaeMysql();
		$sql = "SELECT * FROM `oapp` where app_name='weibo' LIMIT 10";
		$data = $mysql->getData($sql);
		return $data[0]['redirect_uri'];
	}
	/**
	 * 获取已保存的appid
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getAppKey($str = '') {
		$mysql = new \SaeMysql();
		$sql = "SELECT * FROM `oapp` where app_name='weibo' LIMIT 10";
		$data = $mysql->getData($sql);
		return $data[0]['app_key'];
	}
	/**
	 * 获取已保存的appkey
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getAppSecret($str = '') {
		$mysql = new \SaeMysql();
		$sql = "SELECT * FROM `oapp` where app_name='weibo' LIMIT 10";
		$data = $mysql->getData($sql);
		return $data[0]['app_secret'];
	}
	/**
	 * 获取code
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getAuthCode($str = '') {
		return $_GET['code'];
	}
	/**
	 * 获取已保存的openid
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getOpenid($str = '') {
		$mysql = new \SaeMysql();
		$sql = "SELECT * FROM `ouser` LIMIT 10";
		$data = $mysql->getData($sql);
		return $data[0]['openid'];
	}
	/**
	 * 获取已保存的Token值
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getAccessToken($str = '') {
		$mysql = new \SaeMysql();
		$sql = "SELECT * FROM `ouser` LIMIT 10";
		$data = $mysql->getData($sql);
		return $data[0]['access_token'];
	}
}