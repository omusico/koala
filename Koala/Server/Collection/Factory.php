<?php
namespace Server\Collection;
class Factory extends \Server\Factory{
    public static function getServerName($type){
        $server_name = 'DataCollection';
        switch($type){
            case 'route':
               $server_name = 'RouteCollection';
                break;
            case 'header':
               $server_name = 'HeaderDataCollection';
               break;
            case 'server':
               $server_name = 'ServerDataCollection';
               break;
            case 'response':
               $server_name = 'ResponseCookieDataCollection';
               break;
            default:
              $server_name = 'DataCollection';
              break;
        }
        return self::getRealName('Collection',$server_name);
    }
}
?>