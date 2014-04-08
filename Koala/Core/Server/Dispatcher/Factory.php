<?php
namespace Server\Dispatcher;
class Factory extends \Server\Factory{
    public static function getServerName($type){
        $server_name = 'Dispatcher';
        switch($type){
            case 'rest':
                $server_name = 'RESTDispatcher';
                break;
            case 'mvc':
            default:
                $server_name = 'Dispatcher';
            break;
        }
         return self::getRealName('Dispatcher',$server_name);
    }
}