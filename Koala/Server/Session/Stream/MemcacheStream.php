<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Session\Stream;
use Koala\Server\Session\Base;
/**
 * session的Memcache支持
 * @author   LunnLew <lunnlew@gmail.com>
 * @final
 */
final class MemcacheStream extends Base{
	public static $mem;
	public static $maxtime;
	/**
	 * 构造函数
	 * @param array $options 行为参数
	 */
	function __construct($options=array()){
		self::$mem = \Koala\Server\Cache::factory('memcache');
		//设置前缀
		self::$mem->setCachePrex('session');
		
		self::$maxtime = ini_get('session.gc_maxlifetime');

		session_module_name('user');//session文件保存方式，这个是必须的！除非在Php.ini文件中设置了

		session_set_save_handler(
			array(__CLASS__,'open'),//在运行session_start()时执行
			array(__CLASS__,'close'),//在脚本执行完成或调用session_write_close() 或 session_destroy()时被执行,即在所有session操作完后被执行
			array(__CLASS__,'read'),//在运行session_start()时执行,因为在session_start时,会去read当前session数据
			array(__CLASS__,'write'),//此方法在脚本结束和使用session_write_close()强制提交SESSION数据时执行
			array(__CLASS__,'destroy'),//在运行session_destroy()时执行
			array(__CLASS__,'gc')//执行概率由session.gc_probability 和 session.gc_divisor的值决定,时机是在open,read之后,session_start会相继执行open,read和gc
		);
        //sae-error 
        session_start();
	}
    /**
     * session_read
     * @param mixed $id session id
     */
	public static function read($sid){
		return self::$mem->get($sid);
	}
    /**
     * session_write
     * @param mixed $id session id
     * @param mixed $data session data
     */
	public static function write($sid,$data){
		return self::$mem->set($sid,$data,MEMCACHE_COMPRESSED,self::$maxtime); 
	}
    /**
     * session_destroy
     * @param mixed $id session id
     */
	public static function destroy($id){
		return self::$mem->delete($id);
	}
    /**
     * session_gc
     * @param int $maxLifeTime session最大生存时间
     */
	public static function gc($maxLifeTime='3600'){
		return true;
	}
}