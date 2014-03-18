<?php
class Server_Log_Factory{
    protected static $cache_type = 'Log';
	public static function getInstance($type='Log',$option=array()){
            Server_Log_Factory::setCacheType($type);
            $class = 'Server\Log\Drive\\'.self::$cache_type;
            if(class_exists($class)){
                return new $class($option);
            } 
            else
                return null;
    }
    public static function setCacheType($cacheType='Log'){
        self::$cache_type=strtolower($cacheType);
        switch(self::$cache_type){
            case 'Log':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAELog')) self::$cache_type = 'SAELog' ;
                    else trigger_error('未发现 SAE Memcache 支持!');
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeLog')) self::$cache_type = 'BaeLog' ;
                    else trigger_error('未发现 BAE Memcache 支持!');
                }else{
                    if (class_exists('Log')) self::$cache_type = 'LAELog' ;
                    else trigger_error('未发现 Log 支持!');
                }
            break;
        }
    }
}
?>