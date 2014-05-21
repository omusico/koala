<?php
namespace Koala\Server\Collection;
class Factory extends \Koala\Server\Factory{
    public static function getServerName($name){
        $server_name = 'DataCollection';
        switch($name){
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
            case 'front':
               $server_name = 'FrontDataCollection';
               break;
            default:
              $server_name = 'DataCollection';
              break;
        }
        return self::getRealName('Collection',$server_name);
    }
}
?>