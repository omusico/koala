<?php
namespace Server\Payment;
class Factory extends \Server\Factory{
    public static function getServerName($name){
    	$server_name = 'Alipay';
        switch($name){
            case 'alipay':
                $server_name = 'Alipay' ;
            break;
        }
        return 'Server_Payment_Adapter_'.$type;
    }
}