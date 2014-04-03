<?php
namespace Server;
class ACM\Factory extends Factory{
    public static function getServerName($type){
        switch ($type) {
            case 'authority':
                $server_name = 'Authority';
                break;
        }
        return self::getRealName('ACM',$server_name);
    }
}
?>