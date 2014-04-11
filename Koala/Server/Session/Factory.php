<?php
namespace Server\Session;
class Factory extends \Server\Factory{
    public static function getServerName($type){
        $server_name = 'FileStream';
        switch($type){
            case 'file':
            default:
                $server_name = 'FileStream';
            break;
        }
        return self::getRealName('Session',$server_name);
    }
    protected static function getRealName($type,$server_name){
        return 'Server\\'.ucwords($type).'\Stream\\'.$server_name;
    }
}