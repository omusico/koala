<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Tencent;
use Koala\OAPI\Base;

/**
 * 腾讯微博开放平台 API
 * http://wiki.open.t.qq.com/index.php/%E9%A6%96%E9%A1%B5
 *
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Weibo extends Base {
	/**
	 * 获取已保存的code RedirectUri
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getCodeRedirectUri($str = '');
	/**
	 * 获取已保存的appid
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppKey($str = '');
	/**
	 * 获取已保存的appkey
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppSecret($str = '');
	/**
	 * 获取已保存的openid
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getOpenid($str = '');
	/**
	 * 获取已保存的Token值
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAccessToken($str = '');
	/**
	 * 获取已保存的Refresh Token值
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getRefreshToken($str = '');
	/**
	 * 获取 客户端ip
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getClientip($str = '') {
		return '0.0.0.0';
	}
}