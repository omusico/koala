<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Org;
use Core\Request\BaseV1 as RequestBase;

/**
 *https://www.youdaye.com/docs.htm
 */
class youdaye extends RequestBase {
	/**
	 * 获取appUser
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppUser($str='');
	/**
	 * 获取appKey
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppKey($str='');
	/**
	 * 获取Sender
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getSender($str='');
}