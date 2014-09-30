<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Qiniu;
use Koala\OAPI\Base;

/**
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Img extends Base {
	/**
	 * [setPutPolicy description]
	 * @param [type] $name      [description]
	 * @param array  $putPolicy [description]
	 */
	public function setPutPolicy($name, $putPolicy = array()) {
		$this->_parsePutPolicy($name, $putPolicy);
	}
	/**
	 * 从配置中解析出header参数
	 * @param  string $name api名
	 * @return array     	结果
	 */
	protected function _parsePutPolicy($name, $putPolicy = array()) {
		$params = array();
		$paramCFG = $this->cfg[$name]['putPolicy'];
		foreach ($paramCFG as $key => $value) {
			$params = array_merge($params, $this->_parseStr($value));
		}
		$this->cfg[$name]['putPolicy'] = array_merge(array_filter($params), $putPolicy);
	}
	/**
	 * [_getAccessKey description]
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	abstract protected function _getAccessKey($str);
	/**
	 * [_getSecertKey description]
	 * @param  [type] $str [description]
	 * @return [type]      [description]
	 */
	abstract protected function _getSecertKey($str);
	/**
	 *
	 * @param  array  $putPolicy [description]
	 * @return [type]            [description]
	 */
	protected function _getAccessToken($str) {
		$encodedPutPolicy = \urlsafe_base64_encode(json_encode($this->cfg[$this->name]['putPolicy']));
		return $this->_getAccessKey('AccessKey')
		. ':' . \urlsafe_base64_encode(hash_hmac("sha1", $encodedPutPolicy, $this->_getSecertKey('SecertKey'), true))
		. ':' . $encodedPutPolicy;
	}
}