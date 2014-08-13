<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI;
/**
 * 工厂类
 * 
 * @package  Koala
 * @subpackage  Server\OAPI
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory extends \Koala\Server\Factory{
	public static function getServerName($name){
		if(empty($name)){
			$server_name = 'Tencent\Connect';
		}else{
			$server_name = $name;
		}
		return self::getRealName($server_name);
	}
	/**
	* 组装完整服务类名
	*
	*  @param  string $server_name 服务驱动名
	* @param  string $prex  类名前缀
	* @access protected
	* @static
	* @return string              完整服务驱动类名
	*/
	protected static function getRealName($server_name,$prex='Koala'){
		return $prex.'\OAPI\\'.$server_name;
	}
}