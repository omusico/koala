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
 * 微信公众平台 API
 *
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class WeixinPF extends Base {
	public function first_verify_token() {
		if ($this->checkSignature()) {
			exit($this->_getEchostr());
		} else {
			exit(0);
		}
	}
	public function getContent() {
		return file_get_contents('php://input', 'r');
	}
	public function checkSignature() {
		$tmpArr = array($this->_getToken(), $this->_getTimestamp(), $this->_getNonce());
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode($tmpArr);
		$tmpStr = sha1($tmpStr);
		if ($tmpStr == $this->_getSignature()) {
			return true;
		} else {
			return false;
		}
	}
	protected function _getTimestamp($string = 'timestamp') {
		return $_GET[$string];
	}
	protected function _getNonce($string = 'nonce') {
		return $_GET[$string];
	}
	protected function _getSignature($string = 'signature') {
		return $_GET[$string];
	}
	abstract protected function _getToken($string);
}