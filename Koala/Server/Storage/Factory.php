<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Storage;
/**
 * 工厂类
 *
 * @package  Koala
 * @subpackage  Server\Storage
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory extends \Koala\Server\Factory {
	public static function getServerName($name, $prex = '') {
		return self::getApiName('Storage', $name);
	}
}