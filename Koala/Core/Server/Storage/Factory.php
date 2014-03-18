<?php
class Server_Storage_Factory{
    protected static $cache_type = 'Storage';
	public static function getInstance($type='Storage',$option=array()){
            Server_Storage_Factory::setCacheType($type);
            $class = 'Server\Storage\Drive\\'.self::$cache_type;
            if(class_exists($class)){
                return new $class($option);
            } 
            else
                return null;
    }
    public static function setCacheType($cacheType='Storage'){
        self::$cache_type=strtolower($cacheType);
        switch(self::$cache_type){
            case 'Storage':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAEStorage')) self::$cache_type = 'SAEStorage' ;
                    else trigger_error('未发现SAEStorage支持!');
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeStorage')) self::$cache_type = 'BaeStorage' ;
                    else trigger_error('未发现BaeStorage支持!');
                }else{
                    if (class_exists('Storage')) self::$cache_type = 'LAEStorage' ;
                    else trigger_error('未发现LAEStorage支持!');
                }
            break;
        }
    }
}
?>