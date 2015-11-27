<?php
/**
 * KoalaCMS - A PHP CMS System In Koala FrameWork
 *
 * @package  KoalaCMS
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Image;
/**
 * Image Factory
 */
class Factory extends \Koala\Server\Factory {
	public static function getServerName($name, $prex = '') {
		$server_name = 'LAEImage';
		switch ($name) {
			case 'saeimage':
				$server_name = 'SAEImage';
				break;
			case 'gdimage':
				$server_name = 'LAEGDImage';
				break;
			case 'image':
			case 'laeimage':
				$server_name = 'LAEImage';
				break;
		}
		return self::getApiName('Image', $server_name);
	}
}