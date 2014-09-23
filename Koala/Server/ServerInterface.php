<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server;
/**
 * 服务工厂接口
 *
 * @package  Koala
 * @subpackage  Server
 * @author    LunnLew <lunnlew@gmail.com>
 */
interface ServerInterface {
	/**
	 * 获取服务类名
	 * @param  string $name 服务名(小写)
	 * @static
	 * @return string       服务驱动类名
	 */
	public static function getServerName($name, $prex = '');
}