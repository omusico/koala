<?php
class Server_KVDB_Factory{
    protected static $cache_type = 'KVDB';
	public static function getInstance($type='KVDB',$option=array()){
            Server_KVDB_Factory::setCacheType($type);
            $class = 'Server\KVDB\Drive\\'.self::$cache_type;
            if(class_exists($class)){
                return new $class($option);
            } 
            else
                return null;
    }
    public static function setCacheType($cacheType='KVDB'){
        self::$cache_type=strtolower($cacheType);
        switch(self::$cache_type){
            case 'KVDB':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAEKVDB')) self::$cache_type = 'SAEKVDB' ;
                    else trigger_error('未发现 SAE Memcache 支持!');
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeKVDB')) self::$cache_type = 'BaeKVDB' ;
                    else trigger_error('未发现 BAE Memcache 支持!');
                }else{
                    if (class_exists('KVDB')) self::$cache_type = 'LAEKVDB' ;
                    else trigger_error('未发现 KVDB 支持!');
                }
            break;
        }
    }
}
?>