<?php
namespace Server;
abstract class Factory implements interf{
    /**
     * 获得服务驱动实例
     * @param  string $type 服务类型
     * @param  array  $option 配置数组
     * @return object  实例
     */
	public static function getInstance($type,$option=array()){
		$class = static::getServerName(strtolower($type));
		if(class_exists($class)){
            return new $class($option);
        } 
        else
            return null;
	}
	/**
	 * 组装完整服务类名
	 * @param  string $server_name 服务驱动名
	 * @return string              完整服务驱动类名
	 */
    protected static function getRealName($type,$server_name){
    	return 'Server\\'.ucwords($type).'\Drive\\'.$server_name;
    }
}