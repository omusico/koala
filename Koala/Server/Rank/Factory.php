<?php
namespace Koala\Server\Rank;
class Factory extends \Koala\Server\Factory {
	public static function getServerName($name, $prex='') {
		$server_name = 'LAERank';
		switch ($name) {
			case 'rank':
				if (APP_ENGINE == 'SAE') {
					if (function_exists('SAERank')) {self::$cache_type = 'SAERank';
					}
				} elseif (APP_ENGINE == 'BAE') {
					if (class_exists('BaeRank')) {self::$cache_type = 'BaeRank';
					}
				} else {
					if (class_exists('Rank')) {self::$cache_type = 'LAERank';
					}
				}

				break;
		}
		return self::getRealName('Rank', $server_name);
	}
}