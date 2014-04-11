<?php
namespace Server\ACM;
class Factory extends \Server\Factory{
    public static function getServerName($name){
    	$server_name = 'Authority';
        switch ($type) {
            case 'authority':
                $server_name = 'Authority';
                break;
        }
        return self::getRealName('ACM',$server_name);
    }
}
?>