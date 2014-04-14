<?php
/**
 * 
 *--
 *-- 表的结构 `candy_session`
 *--
 *
 *CREATE TABLE IF NOT EXISTS `candy_session` (
 *  `id` int(10) NOT NULL AUTO_INCREMENT,
 *  `PHPSESSID` varchar(32) NOT NULL,
 *  `update_time` int(12) NOT NULL,
 *  `client_ip` varchar(20) NOT NULL,
 *  `data` varchar(500) NOT NULL,
 *  PRIMARY KEY (`id`)
 *) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;
 */
class SessionToDB{
    private static $_path         = null;
    private static $_name         = null;
    private static $db          = null;
    private static $_ip           = null;
    private static $_maxLifeTime  = 0;
    private static $table = '';
    public function __construct($db){
        if(get_class($db)!='Drive_LAEPDO'){
            writeLine('目前只支持Drive_LAEPDO类');exit;
        }
        self::$db   = $db->oobj;
        self::$table = C('DB_PREFIX').'session';
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
    
    static public function open($path,$name)
    {
        return true;    
    }
    
    static public function close()
    {
        return true;
    }
    
    static public function read($id)
    {
        $sql = 'SELECT * FROM '.self::$table.' where PHPSESSID = ?';
        $stmt = self::$db->prepare($sql);
        $stmt->execute(array($id));
        if (!$result = $stmt->fetch(PDO::FETCH_ASSOC)) {
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
    
    static public function write($id,$data)
    {
        $sql = 'SELECT * FROM '.self::$table.' where PHPSESSID = ?';
        $stmt = self::$db->prepare($sql);
        $stmt->execute(array($id));
        
        if ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($result['data'] != $data) {
                $sql = 'UPDATE '.self::$table.' SET update_time =? , data = ? WHERE PHPSESSID = ?';
                
                $stmt = self::$db->prepare($sql);
                $time = time();
                $stmt->execute(array($time, $data, $id));
            }
        } else {
            if (!empty($data)) {
                $sql = 'INSERT INTO '.self::$table.' (PHPSESSID, update_time, client_ip, data) VALUES (?,?,?,?)';
                $stmt = self::$db->prepare($sql);
                $time = time();//
                $stmt->execute(array($id, $time, self::$_ip, $data));
            }
        }
        
        return true;
    }
    
    static public function destroy($id)
    {
        $sql = 'DELETE FROM '.self::$table.' WHERE PHPSESSID = ?';
        $stmt = self::$db->prepare($sql);
        $stmt->execute(array($id));
        
        return true;        
    }
    
    static public function gc($maxLifeTime)
    {
        $sql = 'DELETE FROM '.self::$table.' WHERE update_time < ?';
        $stmt = self::$db->prepare($sql);
        $time = time();
        $stmt->execute(array($time - $maxLifeTime));
        
        return true;
    }
}