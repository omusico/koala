<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Baidu;
use Koala\OAPI\Base;
include(__DIR__.'/Lib/func.php');
/**
 * BAIDU OAUTH API
 * 
 * TODO
 */
class Connect extends Base{
	/**
	 * 构造函数
	 */
	final public function __construct(){
		
		$this->cfg = include(__DIR__.'/Api/baiduOauth.php');
	}
	/**
	 * 魔术方法
	 * @param  string $method 方法名
	 * @param  array $args   方法参数
	 * @return mixed         返回值
	 */
	public function __call($method,$args){}
	/**
	 * 获取回调url
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getCallbackUrl($str='');
	/**
	 * 获取appid
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppKey($str='');
	/**
	 * 获取appkey
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppSecret($str='');

	/**
	 * 获取code
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAuthCode($str='');
	/**
	 * 获取openid
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getOpenid($str='');
	/**
	 * 获取Token值
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getToken($str='');
}