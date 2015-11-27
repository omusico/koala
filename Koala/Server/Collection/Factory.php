<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Collection;
/**
 * Collection工厂类
 *
 * @package  Koala
 * @subpackage  Server\Collection
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory extends \Koala\Server\Factory {
	public static function getServerName($name, $prex = '') {
		$server_name = 'DataCollection';
		switch ($name) {
			case 'route':
				$server_name = 'RouteCollection';
				break;
			case 'header':
				$server_name = 'HeaderDataCollection';
				break;
			case 'server':
				$server_name = 'ServerDataCollection';
				break;
			case 'response':
				$server_name = 'ResponseCookieDataCollection';
				break;
			case 'front':
				$server_name = 'FrontDataCollection';
				break;
			default:
				$server_name = 'DataCollection';
				break;
		}
		return self::getApiName('Collection', $server_name);
	}
}
?>