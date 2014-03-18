<?php
class Server_Counter_Factory{
    protected static $cache_type = 'Counter';
	public static function getInstance($type='Counter',$option=array()){
            Server_Counter_Factory::setCacheType($type);
            $class = 'Server\Counter\Drive\\'.self::$cache_type;
            if(class_exists($class)){
                return new $class($option);
            } 
            else
                return null;
    }
    public static function setCacheType($cacheType='Counter'){
        self::$cache_type=strtolower($cacheType);
        switch(self::$cache_type){
            case 'Counter':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAECounter')) self::$cache_type = 'SAECounter' ;
                    else trigger_error('未发现 SAE Memcache 支持!');
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeCounter')) self::$cache_type = 'BaeCounter' ;
                    else trigger_error('未发现 BAE Memcache 支持!');
                }else{
                    if (class_exists('Counter')) self::$cache_type = 'LAECounter' ;
                    else trigger_error('未发现 Counter 支持!');
                }
            break;
        }
    }
}
?>