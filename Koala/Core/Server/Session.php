<?php
/**
 * 
 *SESSION
 *
 */
class Session{
    /**
    * 操作句柄数组
    * @var array
    */
    static protected $handlers = array();
    public static function register($stream_type,$options=array(),$new=false){
        if(empty($stream_type)||!is_string($stream_type)){
            $stream_type = C('Session:DEFAULT','file');
        }
        if($new || !isset(self::$handlers[$stream_type])){
            $c_options = C('Session:'.$stream_type);
            if(empty($c_options)){
                $c_options = array();
            }
            $options = array_merge($c_options,$options);
            self::$handlers[$stream_type] = Server\Session\Factory::getInstance($stream_type,$options);
        }
        $sess = self::$handlers[$stream_type];
        session_write_close();
        session_set_save_handler(
            array(&$sess,"open"),
            array(&$sess,"close"),
            array(&$sess,"read"),
            array(&$sess,"write"),
            array(&$sess,"destroy"),
            array(&$sess,"gc"));
        register_shutdown_function('session_write_close');
        session_start();
        return self::$handlers[$stream_type];
    }
}