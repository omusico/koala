<?php
namespace Server\ACM;
class Factory{
    protected static $cache_type = 'Authority';
	public static function getInstance($type='Authority',$option=array()){
            Factory::setCacheType($type);
            $class = 'Server\ACM\Drive\\'.self::$cache_type;
            if(class_exists($class)){
                return new $class($option);
            } 
            else
                return null;
    }
    public static function setCacheType($cacheType='Authority'){
        self::$cache_type=$cacheType;
    }
}
?>