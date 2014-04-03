<?php
namespace Server;
class Payment\Factory extends Factory{
    public static function getServerName($type){
        switch($type){
            case 'alipay':
                $server_name = 'Alipay' ;
            break;
        }
        return 'Server_Payment_Adapter_'.$type;
    }
}