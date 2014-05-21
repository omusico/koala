<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Koala\Server;
/**
 * 服务工厂接口
 * 
 * @package  Koala
 * @subpackage  Server
 * @author    Lunnlew <Lunnlew@gmail.com>
 */
interface Interf{
	/**
	 * 获取服务类名
	 * @param  string $name 服务名(小写)
	 * @static
	 * @return string       服务驱动类名
	 */
    public static function getServerName($name);
}