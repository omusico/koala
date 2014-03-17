<?php
defined('IN_Koala') or exit();
class Factory_Log{
	protected static $instance = null;
    protected $_type = 'auto';
	public static function getInstance($type='auto'){
        if (!isset(self::$instance)){
            self::$instance = new Factory_Storage();
            self::$instance->setType($type);
            if(stripos(self::$instance->_type,APPENGINE)!==false){
		        $class = 'Drive_'.self::$instance->_type;
		    }else{
		        $class = 'Drive_'.self::$instance->_type;
		        if(!class_exists($class)){
		            $class = self::$instance->_type;
		        }
		    }
            if(class_exists($class)){
                self::$instance = new $class();
            } 
            else
                return null;
        } 
        return self::$instance;
    }
    public function setType($Type='auto'){
        $this->_type=strtolower($Type);
        switch($this->_type){
            case 'auto'://try to auto select a  system
                if (class_exists('BaeLog'))$this->_type = 'BaeLog';
                else $this->_type = 'Log';
            break;
            default://not any  selected or wrong one selected
                if (isset($Type)) $msg='未识别的Log类型<b>'.$Type.'</b>';
                else $msg='没有提供Log类型设置';
                trigger_error($msg);     
            break;
        }
    }
}
?>