<?php
namespace Koala\Server\ACM;
class Factory extends \Koala\Server\Factory {
	public static function getServerName($name, $prex = '') {
		$server_name = 'Authority';
		switch ($type) {
			case 'authority':
				$server_name = 'Authority';
				break;
		}
		return self::getApiName('ACM', $server_name);
	}
}
?>