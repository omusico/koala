<?php
namespace Koala\Server\Session;
class Factory extends \Koala\Server\Factory{
    public static function getServerName($name){
        $server_name = 'FileStream';
        switch($name){
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