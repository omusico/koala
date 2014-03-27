<?php
class Server_Payment_Factory{
	public static function getInstance($type,$option=array()){
        $class = self::getAdapterClass($type);
        $instance = new $class();
        $instance->setConfig($option);
        return $instance;
    }
     //获得适配器类
    private static function getAdapterClass($type){
        if(empty($type)){
            return null;
        }
        return 'Server_Payment_Adapter_'.$type;
    }
}
?>