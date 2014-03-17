<?php
defined('IN_Koala') or exit();
include_once(ROOT_PATH.'Library/Vendor/Utils/pscws4/PSCWS4.php');
/**
 * 
 *本地分词服务
 *
 */
class Drive_LAESegment extends Base_Segment{
	var $object = '';
	public function __construct(){
	}
	public function start($str){}
	public function init(){
		set_time_limit(0);
		$word = array();
		$file = fopen(DATA_PATH.'word/1.txt',"r");
		while(! feof($file)){
			$lstr = iconv('gbk','utf-8',fgets($file));
			$lstr = preg_replace("/[^\x{4E00}-\x{9FAF}]+/u", '',$lstr);
		  	$arr = str_split($lstr,3);
			$word = array_merge($word,array_flip(array_flip($arr)));
			$word=array_flip(array_flip($word));
		  }
		$content='';
		Storage::write('chinesewords.txt',implode($word,','));
		//self::wordToMMC($word);
	}
	public function wordToMMC($data = array()){
		$mmc = Factory_Cache::getInstance('memcache','word');
		foreach ($data as $key => $value) {
			$mmc->set(hash('md4',$value),$value);
		}

	}
}
?>