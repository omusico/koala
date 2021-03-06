<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Tencent;
use Core\Request\BaseV1 as RequestBase;

/**
 * 微信 OAUTH API
 *
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class WeixinConnect extends RequestBase {
	/**
	 * 获取回调url
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getRedirectUri($str = '') {
		return $this->cfg[$this->name]['callbackUrl'];
	}
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