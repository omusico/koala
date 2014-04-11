<?php
namespace Server\Payment;
class Factory extends \Server\Factory{
    public static function getServerName($type){
    	$server_name = 'Alipay';
        switch($type){
            case 'alipay':
                $server_name = 'Alipay' ;
            break;
        }
        return 'Server_Payment_Adapter_'.$type;
    }
}