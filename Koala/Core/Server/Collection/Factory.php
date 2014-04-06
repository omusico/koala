<?php
namespace Server\Collection;
class Factory extends \Server\Factory{
    public static function getServerName($type){
        $server_name = 'Collection';
        switch($type){
            case 'collection':
               $server_name = 'Collection';
               break;
            case 'route':
               $server_name = 'RouteCollection';
               break;
            break;
        }
        return self::getRealName('Collection',$server_name);
    }
}
?>