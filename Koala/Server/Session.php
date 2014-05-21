<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Koala\Server;
/**
 * Session服务类
 * 
 * @package  Koala
 * @subpackage  Server
 * @author    Lunnlew <Lunnlew@gmail.com>
 */
class Session{
    /**
    * 服务驱动实例数组
    * @var array
    * @static
    * @access protected
    */
    protected static $instances = array();
    /**
     * 服务实例化函数
     * 
     * @param  string $stream_name    session通道名
     * @param  array  $options 驱动构造参数
     * @param  boolean $new    是否初始化新实例 默认false
     * @static 
     * @return object          驱动实例
     */
    public static function register($stream_name,$options=array(),$new=false){
        if(empty($stream_name)||!is_string($stream_name)){
            $stream_name = C('Session:DEFAULT','file');
        }
        if($new || !isset(self::$instances[$stream_name])){
            $c_options = C('Session:'.$stream_name);
            if(empty($c_options)){
                $c_options = array();
            }
            $options = array_merge($c_options,$options);
            self::$instances[$stream_name] = Session\Factory::getInstance($stream_name,$options);
        }
        $sess = self::$instances[$stream_name];
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
        return self::$instances[$stream_name];
    }
}