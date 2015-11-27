<?php
namespace Koala\Server\Segment;
class Factory extends \Koala\Server\Factory {
	public static function getServerName($name, $prex='') {
		$server_name = 'LAESegment';
		switch ($name) {
			case 'segment':
				if (RUN_ENGINE == 'SAE') {
					if (function_exists('SAESegment')) {$server_name = 'SAESegment';
					}
				} elseif (RUN_ENGINE == 'BAE') {
					if (class_exists('BaeSegment')) {$server_name = 'BaeSegment';
					}
				} else {
					if (class_exists('Segment')) {$server_name = 'LAESegment';
					}
				}

				break;
		}
		return self::getApiName('Segment', $server_name);
	}
}