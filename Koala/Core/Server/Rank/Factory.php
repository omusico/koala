<?php
class Server_Rank_Factory{
    protected static $cache_type = 'Rank';
	public static function getInstance($type='Rank',$option=array()){
            Server_Rank_Factory::setCacheType($type);
            $class = 'Server\Rank\Drive\\'.self::$cache_type;
            if(class_exists($class)){
                return new $class($option);
            } 
            else
                return null;
    }
    public static function setCacheType($cacheType='Rank'){
        self::$cache_type=strtolower($cacheType);
        switch(self::$cache_type){
            case 'Rank':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAERank')) self::$cache_type = 'SAERank' ;
                    else trigger_error('未发现SAERank支持!');
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeRank')) self::$cache_type = 'BaeRank' ;
                    else trigger_error('未发现BaeRank支持!');
                }else{
                    if (class_exists('Rank')) self::$cache_type = 'LAERank' ;
                    else trigger_error('未发现LAERank支持!');
                }
            break;
        }
    }
}
?>