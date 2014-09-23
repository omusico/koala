<?php
namespace Koala\Server\Payment;
class Factory extends \Koala\Server\Factory{
    public static function getServerName($name, $prex=''){
    	$server_name = 'Alipay';
        switch($name){
            case 'alipay':
                $server_name = 'Alipay' ;
            break;
        }
        return 'Server_Payment_Adapter_'.$type;
    }
}