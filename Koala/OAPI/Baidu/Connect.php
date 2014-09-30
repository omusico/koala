<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Baidu;
use Koala\OAPI\Base;
include (__DIR__ . '/Lib/func.php');

/**
 * BAIDU OAUTH API
 *
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Connect extends Base {
	/**
	 * 获取回调url
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getRedirectUri($str = '');
	/**
	 * 获取appid
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppKey($str = '');
	/**
	 * 获取appkey
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppSecret($str = '');

	/**
	 * 获取code
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAuthCode($str = '');
	/**
	 * 获取openid
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getOpenid($str = '');
	/**
	 * 获取Token值
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAccessToken($str = '');
}