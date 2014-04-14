<?php
namespace Server\ErrorHandler;
class Factory extends \Server\Factory{
    public static function getServerName($name){
        $server_name = 'ErrorHandler';
        switch($name){
            case 'monolog':
                $server_name = 'MonologErrorHandler';
            break;
            default :
                $server_name = 'ErrorHandler';
            break;
        }
        return self::getRealName('ErrorHandler',$server_name);
    }
}