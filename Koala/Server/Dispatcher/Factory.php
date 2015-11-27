<?php
namespace Koala\Server\Dispatcher;
class Factory extends \Koala\Server\Factory {
	public static function getServerName($name, $prex = '') {
		$server_name = 'Dispatcher';
		switch ($name) {
			case 'rest':
				$server_name = 'RESTDispatcher';
				break;
			case 'mvc':
			default:
				$server_name = 'Dispatcher';
				break;
		}
		return self::getApiName('Dispatcher', $server_name);
	}
}