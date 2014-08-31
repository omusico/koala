<?php
namespace Koala\Server\Segment;
class Factory extends \Koala\Server\Factory {
	public static function getServerName($name) {
		$server_name = 'LAESegment';
		switch ($name) {
			case 'segment':
				if (APP_ENGINE == 'SAE') {
					if (function_exists('SAESegment')) {$server_name = 'SAESegment';
					}
				} elseif (APP_ENGINE == 'BAE') {
					if (class_exists('BaeSegment')) {$server_name = 'BaeSegment';
					}
				} else {
					if (class_exists('Segment')) {$server_name = 'LAESegment';
					}
				}

				break;
		}
		return self::getRealName('Segment', $server_name);
	}
}