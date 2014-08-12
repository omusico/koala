<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Baidu;
use Koala\OAPI\Base;
/**
 * BAIDU OAUTH API
 * 
 * TODO
 */
final class Connect extends Base{
	/**
	 * 构造函数
	 */
	final public function __construct(){
		parent::__construct();
		$this->cfg = include(__DIR__.'/Api/baiduOauth.php');
	}
	/**
	 * 魔术方法
	 * @param  string $method 方法名
	 * @param  array $args   方法参数
	 * @return mixed         返回值
	 */
	final public function __call($method,$args){
		//print_r(func_get_args());
		return '';
	}
	/**
	 * 获取回调url
	 * @param  string $str [description]
	 * @return mixed
	 */
	final protected function _getCallbackUrl($str=''){
		return  $this->cfg[$this->name]['callbackUrl'];
	}
	/**
	 * 获取appid
	 * @param  string $str [description]
	 * @return mixed
	 */
	final protected function _getAppKey($str=''){
		exit('[TODO]'.__METHOD__);
		return  '';
	}
	/**
	 * 获取appkey
	 * @param  string $str [description]
	 * @return mixed
	 */
	final protected function _getAppSecret($str=''){
		exit('[TODO]'.__METHOD__);
		return  '';
	}

	/**
	 * 获取code
	 * @param  string $str [description]
	 * @return mixed
	 */
	final protected function _getAuthCode($str=''){
		exit('[TODO]'.__METHOD__);
		return  '';
	}
	/**
	 * 获取openid
	 * @param  string $str [description]
	 * @return mixed
	 */
	final protected function _getOpenid($str=''){
		exit('[TODO]'.__METHOD__);
		return  '';
	}
	/**
	 * 获取Token值
	 * @param  string $str [description]
	 * @return mixed
	 */
	final protected function _getToken($str=''){
		exit('[TODO]'.__METHOD__);
		return  '';
	}
}