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
        return self::getRealName('Session',$server_name);
    }
    protected static function getRealName($type,$server_name){
        return 'Koala\\Server\\'.ucwords($type).'\Stream\\'.$server_name;
    }
}