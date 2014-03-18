<?php
class Server_Segment_Factory{
    protected static $cache_type = 'Segment';
	public static function getInstance($type='Segment',$option=array()){
            Server_Segment_Factory::setCacheType($type);
            $class = 'Server\Segment\Drive\\'.self::$cache_type;
            if(class_exists($class)){
                return new $class($option);
            } 
            else
                return null;
    }
    public static function setCacheType($cacheType='Segment'){
        self::$cache_type=strtolower($cacheType);
        switch(self::$cache_type){
            case 'Segment':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAESegment')) self::$cache_type = 'SAESegment' ;
                    else trigger_error('未发现SAESegment支持!');
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeSegment')) self::$cache_type = 'BaeSegment' ;
                    else trigger_error('未发现BaeSegment支持!');
                }else{
                    if (class_exists('Segment')) self::$cache_type = 'LAESegment' ;
                    else trigger_error('未发现LAESegment支持!');
                }
            break;
        }
    }
}
?>