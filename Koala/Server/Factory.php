<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
/**
 * 服务工厂类
 * 
 * @package  Koala
 * @subpackage  Server
 * @author    Lunnlew <Lunnlew@gmail.com>
 */
namespace Server;
class Factory implements interf{
    /**
     * 获得服务驱动实例
     * 
     * @param  string $name 服务驱动名
     * @param  array  $option 配置数组
     * @final
     * @static
     * @return object  实例
     */
	final public static function getInstance($name,$option=array()){
		$class = static::getServerName(strtolower($name));
		if(class_exists($class)){
            return new $class($option);
        } 
        else
            return null;
	}
	/**
	 * 组装完整服务类名
     * 
	 * @param  string $server_name 服务驱动名
     * @access protected
     * @static
	 * @return string              完整服务驱动类名
	 */
    protected static function getRealName($name,$server_name){
    	return 'Server\\'.ucwords($name).'\Drive\\'.$server_name;
    }
}