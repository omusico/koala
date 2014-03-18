<?php
class Server{
	static $objects = null;
	static $type = '';
	public function __construct(){}
	//工厂化实例
	public static function factory($type){
		$name = str_replace(APPENGINE,'',$type);
		if(empty($type)||!is_string($type)){
			$type = C($name.':DEFAULT',$name);
		}
		if(!isset(self::$objects[$type])){
			$factory_class = 'Server_'.ucfirst($name).'_Factory';
			self::$objects[$type] = $factory_class::getInstance($type,C($name.':'.$type));
		}
		returnself::$objects[$type];
	}
	/**
	 * 获取服务类名
	 *
	 * @deprecated 不推荐使用该方法
	 * @param  string $serverName 服务名
	 * @return string            服务类名
	 */
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