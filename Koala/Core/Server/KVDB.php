<?php
defined('IN_Koala') or exit();
/**
 * 
 *对不同云计算平台的KVDB服务API支持
 *
 */
class KVDB{
	static $object = null;
	public static function __callStatic($method,$args){
		if(self::$object==''){
			self::$object = Server::getInstance('KVDB');
		}
		if(method_exists(self::$object, $method)){
			$res = call_user_func_array(array(self::$object,$method),$args);
			return $res;
		}
		return null;
	}
}
/*
if(KVDB::write('xhprof','test.txt','SaeWriteTest')!==false){echo '写入文件成功!';}
if(($content = KVDB::read('xhprof','test.txt'))!==false){
	echo '读取内容:'.$content;
}
 */
?>