<?php
class Server_Channel_Factory{
    protected static $cache_type = 'Channel';
	public static function getInstance($type='Channel',$option=array()){
            Server_Channel_Factory::setCacheType($type);
            $class = 'Server\Channel\Drive\\'.self::$cache_type;
            if(class_exists($class)){
                return new $class($option);
            } 
            else
                return null;
    }
    public static function setCacheType($cacheType='Channel'){
        self::$cache_type=strtolower($cacheType);
        switch(self::$cache_type){
            case 'Channel':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAEChannel')) self::$cache_type = 'SAEChannel' ;
                    else trigger_error('未发现 SAE Memcache 支持!');
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeChannel')) self::$cache_type = 'BaeChannel' ;
                    else trigger_error('未发现 BAE Memcache 支持!');
                }else{
                    if (class_exists('Channel')) self::$cache_type = 'LAEChannel' ;
                    else trigger_error('未发现 Channel 支持!');
                }
            break;
        }
    }
}
?>