<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Session\Stream;
use Koala\Server\Session\Base;
/*
 * 
 *--
 *-- 表的结构 `koala_session`
 *--
 *
 CREATE TABLE IF NOT EXISTS `koala_session` (
   `id` int(10) NOT NULL AUTO_INCREMENT,
   `PHPSESSID` varchar(32) NOT NULL,
   `update_time` int(12) NOT NULL,
   `client_ip` varchar(20) NOT NULL,
   `data` varchar(500) NOT NULL,
   PRIMARY KEY (`id`)
 ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
 */
/**
 * PDO驱动数据库session支持
 * @author   LunnLew <lunnlew@gmail.com>
 * @final
 */
final class PDOStream extends Base{
    private static $_path         = null;
    private static $_name         = null;
    private static $_db          = null;
    private static $_ip           = null;
    private static $_maxLifeTime  = 0;
    private static $_table = '';
    /**
     * 构造函数
     * @param array $options 参数项
     */
    public function __construct($options=array()){
    	//PDO连接
        $str = C('DB_TYPE').":host=".C('DB_HOST_M').";port=".C('DB_PORT').";dbname=".C('DB_NAME');
        self::$_db = new \PDO($str, C('DB_USER'), C('DB_PWD'));
    	self::$_db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        self::$_table = C('DB_PREFIX').'session';
        //表是否存在
        $sql = "SHOW TABLES LIKE '".self::$_table."'";
        $stmt = self::$_db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        if(empty($result)){
        	throw new \Exception('table '.self::$_table.' not exists!', 1);
        }
        //方法注册
        self::$_maxLifeTime = ini_get('session.gc_maxlifetime');
        self::$_ip    = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;

        session_module_name('user');
        session_set_save_handler(
            array(__CLASS__, 'open'),
            array(__CLASS__, 'close'),
            array(__CLASS__, 'read'),
            array(__CLASS__, 'write'),
            array(__CLASS__, 'destroy'),
            array(__CLASS__, 'gc')
        );
        session_start();
    }
    /**
     * session_read
     * @param mixed $id session id
     */
    public static function read($id){
        $sql = 'SELECT * FROM '.self::$_table.' where PHPSESSID = ?';
        $stmt = self::$_db->prepare($sql);
        $stmt->execute(array($id));
        if (!$result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return null;
        } elseif (self::$_ip != $result['client_ip']) {
            return null;
        } elseif ($result['update_time']+self::$_maxLifeTime < time()){
            self::destroy($id);
            return null;
        } else {
            return $result['data'];    
        }
    }
    /**
     * session_write
     * @param mixed $id session id
     * @param mixed $data session data
     */
    public static function write($id,$data){
        $sql = 'SELECT * FROM '.self::$_table.' where PHPSESSID = ?';
        $stmt = self::$_db->prepare($sql);
        $stmt->execute(array($id));
        
        if ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            if ($result['data'] != $data) {
                $sql = 'UPDATE '.self::$_table.' SET update_time =? , data = ? WHERE PHPSESSID = ?';
                
                $stmt = self::$_db->prepare($sql);
                $time = time();
                $stmt->execute(array($time, $data, $id));
            }
        } else {
            if (!empty($data)) {
                $sql = 'INSERT INTO '.self::$_table.' (PHPSESSID, update_time, client_ip, data) VALUES (?,?,?,?)';
                $stmt = self::$_db->prepare($sql);
                $time = time();//
                $stmt->execute(array($id, $time, self::$_ip, $data));
            }
        }
        
        return true;
    }
    /**
     * session_destroy
     * @param mixed $id session id
     */
    public static function destroy($id){
        $sql = 'DELETE FROM '.self::$_table.' WHERE PHPSESSID = ?';
        $stmt = self::$_db->prepare($sql);
        $stmt->execute(array($id));
        
        return true;        
    }
    /**
     * session_gc
     * @param int $maxLifeTime session最大生存时间
     */
    public static function gc($maxLifeTime='3600'){
        $sql = 'DELETE FROM '.self::$_table.' WHERE update_time < ?';
        $stmt = self::$_db->prepare($sql);
        $time = time();
        $stmt->execute(array($time - $maxLifeTime));
        
        return true;
    }
}