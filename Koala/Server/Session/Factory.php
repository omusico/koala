<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Session;
class Factory extends \Koala\Server\Factory{
    public static function getServerName($name, $prex=''){
        $server_name = 'PDOStream';
        switch($name){
            case 'memcache':
                $server_name = 'MemcacheStream';
                break;
            case 'pdo':
            default:
                $server_name = 'PDOStream';
            break;
        }
        return self::getApiName('Session',$server_name);
    }
   /**
     * 组装完整服务类名
     *
     * @param  string $server_name 服务驱动名
     * @param  string $prex  类名前缀
     * @access protected
     * @static
     * @return string              完整服务驱动类名
     */
    protected static function getApiName($name, $server_name, $prex = 'Koala') {
        return $prex . '\Server\\' . ucwords($name) . '\Stream\\' . $server_name;
    }
}