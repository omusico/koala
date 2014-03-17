<?php
defined('IN_Koala') or exit();
class Server{
	public static function getInstance($serverName){
		$class = self::initForConf($serverName);

		if(stripos($class,APPENGINE)!==false){
	        $class = 'Drive_'.$class;
	    }else{
	        $class = 'Drive_'.$class;
	        if(!class_exists($class)){
	            $class = $class;
	        }
	    }
        if(class_exists($class)){
            $instance = new $class();
        } 
        else
            return null;
        
        return $instance;
    }
    public static function initForConf($serverName){
    	$name = APPENGINE;
	    $file = 'server.xml';
    	$xml = simplexml_load_file(dirname(__FILE__).'/'.$file);
		foreach($xml->children() as $appengine){
			if($appengine->getName()==$name){
				$Server = $appengine->children();
				break;
			}
		}
		switch ($Server->$serverName->attributes()->item) {
			case 'class':
				if(class_exists($Server->$serverName->attributes()->key)
					==intval($Server->$serverName->attributes()->value)){
					$class = $Server->$serverName;
				}
				break;
			case 'getenv':
				$check = getenv($Server->$serverName->attributes()->key);
				if(isset($check)
					==intval($Server->$serverName->attributes()->value)){
					$class = $Server->$serverName;
				}
			break;
			default:
				break;
		}
		return $class;
    }
}
?>