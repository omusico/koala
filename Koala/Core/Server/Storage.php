<?php
defined('IN_Koala') or exit();
/**
 * 
 *对不同云计算平台的Storage服务API支持
 *
 */
class Storage{
	static $object = null;
	public static function __callStatic($method,$args){
		if(self::$object==''){
			self::$object = Server::getInstance('Storage');
		}
		if(method_exists(self::$object, $method)){
			$res = call_user_func_array(array(self::$object,$method),$args);
			return $res;
		}
		return null;
	}
	//-------------一下是为了处理 5.2以下版本对 __callStatic 的间接支持(for BAE)
  	//向文件写入内容
	public static function write(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
	//从文件读取内容
	public static function read(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
	//上传某个文件
	public static function upload(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
	//复制某个文件
	public static function copy(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
	//删除某个文件
	public static function delete(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
	//移除某个路径
	public static function remove(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
	//获得某个路径文件列表
	public static function getList(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
	//获得某个文件的url
	public static function getUrl(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
	//获得某个文件的属性
	public static function getFileAttr(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
	//检查某个文件是否存在
	public static function fileExists(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
	//建立一个目录
	public static function mkdir(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
	//重命名一个文件
	public static function rename(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
	//从文件读取内容到数组
	public static function read2Arr(){
    	$m = explode('::',__METHOD__);
    	$p = func_get_args();
    	return self::__callStatic($m[1],$p);
  	}
  //import文件
  public static function import(){
      $m = explode('::',__METHOD__);
      $p = func_get_args();
      return self::__callStatic($m[1],$p);
    }
  public static function getListByPath(){
      $m = explode('::',__METHOD__);
      $p = func_get_args();
      return self::__callStatic($m[1],$p);
    }
  public static function setArea(){
      $m = explode('::',__METHOD__);
      $p = func_get_args();
      return self::__callStatic($m[1],$p);
    }
}
/*
if(Storage::write('xhprof','test.txt','SaeWriteTest')!==false){echo '写入文件成功!';}
if(($content = Storage::read('xhprof','test.txt'))!==false){
	echo '读取内容:'.$content;
}
 */
?>