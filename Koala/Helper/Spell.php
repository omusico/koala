<?php
/**
 * 中文拼音
 * 目前仅支持可以以GBK编码的20902个汉字提取拼音首字母
 * $py = new Spell();
 * $r = $py->getInitial($str,'utf-8','utf-8');
 */
class Helper_Spell{
	//当前字符
	protected $word='';
	//资源
	protected $source = array();
	protected $pos = array();
	//运行期间数据
	protected $temp = array();
	//数据暂存标识//在运行期间多次使用时有明显效果
	protected $flag = true;
	//输入输出字符集
	protected $charset = array('in'=>'gbk','out'=>'utf-8');
	//例外处理//当没有拼音首字母other===false的情况下，返回原字串否则设置为该值
	protected $other = '!';//other=false;
	public function __construct($flag=true){
		$this->flag = $flag;
		//加载资源
		$this->source['gk221']=file_get_contents(DATA_PATH.'word/gk2-2-1.txt');
		$this->source['gk31']=file_get_contents(DATA_PATH.'word/gk3-1.txt');
		$this->source['gk41']=file_get_contents(DATA_PATH.'word/gk4-1.txt');
		$this->pos=json_decode(file_get_contents(DATA_PATH.'word/pos.txt'),true);
	}
	/**
	 * 获得拼音首字母
	 * @param  string/arr $data 数据，可以是字符串和数组
	 * @param  string $in   数据的编码
	 * @param  string $out  输出的编码
	 * @return arr       返回数组
	 */
	public function getInitial($data,$in='gbk',$out='utf-8'){
		if(is_string($data)){
			return self::getInitialByStr($data,$in,$out);
		}elseif(is_array($data)){
			return self::getInitialByArr($data,$in,$out);
		}
	}
	/**
	 * 获得拼音首字母
	 * @param  string $data 字符串数据
	 * @param  string $in   数据的编码
	 * @param  string $out  输出的编码
	 * @return arr       返回数组
	 */
	public function getInitialByStr($str,$in='gbk',$out='utf-8'){
		$this->charset['in'] = strtolower($in);
		$this->charset['out'] = strtolower($out);
		if($this->flag!=true){
			$this->temp['fws']= array();
		}
		switch ($this->charset['in']) {
			case 'gbk':
				return self::_getInitialInGBK($str);
				break;
			case 'utf-8':
				return self::_getInitialInUTF8($str);
				break;
			default:
				# code...
				break;
		}
		//历史数据
		if($this->flag!=true){
			unset($this->temp['fws']);
		}
	}
	/**
	 * 获得拼音首字母
	 * @param  array $data 	数组数据
	 * @param  string $in   数据的编码
	 * @param  string $out  输出的编码
	 * @return arr       返回数组
	 */
	public function getInitialByArr($arr,$in='gbk',$out='utf-8'){
		$this->charset['in'] = strtolower($in);
		$this->charset['out'] = strtolower($out);
		if($this->flag!=true){
			$this->temp['fws']= array();
		}
		switch ($this->charset['in']) {
			case 'gbk':
				return self::_getInitialInGBKArr($arr);
				break;
			case 'utf-8':
				return self::_getInitialInUTF8Arr($arr);
				break;
			default:
				# code...
				break;
		}
		//历史数据
		if($this->flag!=true){
			unset($this->temp['fws']);
		}
	}
	/**
	 * 处理gbk编码字符串的首字母
	 * @param  string $str 字符串
	 * @return array      数组
	 */
	protected function _getInitialInGBK($str){
		//存放字符串拼音
		$w = array();
		$i = 0;
		$str_length = strlen($str); //字符串的字节数
	    while ($i<$str_length){
	    	//得到字符串中第$i位字符的ASCII码
	    	$ascnum = ord($str[$i]);
	    	if($ascnum >= 0x81){//gbk区域
	    		$nstr = substr($str, $i, 2);
	    		$i = $i + 2;
	    	}else{
	    		$nstr = substr($str, $i, 1);
	    		$i = $i + 1;
	    	}
	    	$this->word = iconv('gbk','utf-8',$nstr);
	    	if(isset($this->temp['fws'][$nstr])){
				$w[] = $this->temp['fws'][$nstr];
			}else{
		    	$w[] = self::_preGetInitial($nstr);
		    }
	    }
		
		return $w;
	}
	/**
	 * 处理gbk编码数组的首字母
	 * @param  array $arr 字符串单字数组
	 * @return array      数组
	 */
	protected function _getInitialInGBKArr($arr){
		//存放字符串拼音
		$w = array();
		foreach ($arr as $key => $word) {
			$this->word = iconv('gbk','utf-8',$word);
			if(isset($this->temp['fws'][$word])){
				$w[] = $this->temp['fws'][$word];
			}else{
		    	$w[] = self::_preGetInitial($word);
		    }
		}
		return $w;
	}
	/**
	 * 处理utf-8编码字符串的首字母
	 * @param  string $str 字符串
	 * @return array      数组
	 */
	protected function _getInitialInUTF8($str){
		//存放字符串拼音
		$w = array();
		$nstr = '';
	    $i = 0;
	    $str_length = strlen($str); //字符串的字节数
	    while ($i<$str_length){
		    $ascnum = ord($str[$i]); //得到字符串中第$i位字符的ASCII码
		    if ( $ascnum >= 252){//如果ASCII位高与252
			    $nstr = substr($str, $i, 6); //根据UTF-8编码规范，将6个连续的字符计为单个字符
			    $i = $i + 6; //实际Byte计为6
		    }elseif ( $ascnum >= 248 ){//如果ASCII位高与248
			    $nstr = substr($str, $i, 5); //根据UTF-8编码规范，将5个连续的字符计为单个字符
			    $i = $i + 5; //实际Byte计为5
		    }elseif ( $ascnum >= 240 ){//如果ASCII位高与240
			    $nstr = substr($str, $i, 4); //根据UTF-8编码规范，将4个连续的字符计为单个字符
			    $i = $i + 4; //实际Byte计为4
		    }elseif ( $ascnum >= 224 ){//如果ASCII位高与224
			    $nstr = substr($str, $i, 3); //根据UTF-8编码规范，将3个连续的字符计为单个字符
			    $i = $i + 3 ; //实际Byte计为3
		    }elseif ( $ascnum >= 192 ){//如果ASCII位高与192
			    $nstr = substr($str, $i, 2); //根据UTF-8编码规范，将2个连续的字符计为单个字符
			    $i = $i + 2; //实际Byte计为2
		    }else{//其他情况下，包括大写字母,小写字母和半角标点符号,%,&,@,m,w等 
			    $nstr = substr($str, $i, 1);
			    $i = $i + 1; //实际的Byte数计1个
		    }
		    $this->word = $nstr;
		    //编码转换至GBK
		    $nstr = iconv('utf-8','gbk',$nstr);
		    if(isset($this->temp['fws'][$nstr])){
				$w[] = $this->temp['fws'][$nstr];
			}else{
		    	$w[] = self::_preGetInitial($nstr);
		    }
		}
		return $w;
	}
	/**
	 * 处理utf-8编码数组的首字母
	 * @param  array $arr 字符串单字数组
	 * @return array      数组
	 */
	protected function _getInitialInUTF8Arr($arr){
		//存放字符串拼音
		$w = array();
		foreach ($arr as $key => $word) {
			$this->word = $word;
			$nword = iconv('utf-8','GBK',$word);
			if(isset($this->temp['fws'][$nword])){
				$w[] = $this->temp['fws'][$nword];
			}else{
		    	$w[] = self::_preGetInitial($nword);
		    }
		}
		return $w;
	}
	/**
	 * 对单字预处理
	 * @param  string $word 单字,gbk编码
	 * @return string      拼音首字母,编码视$this->charset['out']
	 */
	protected function _preGetInitial($word){
		$fw = self::_getInitial($word);//返回的utf-8编码数据首字母
		if($fw!==false){
			$nstr=$this->temp['fws'][$word]=iconv('utf-8',$this->charset['out'],$fw);
		}else{
			$nstr=$this->temp['fws'][$word]=iconv('gbk',$this->charset['out'],$word);
		}
		return $nstr;
	}
	/**
	 * 获得汉字拼音首字母的核心函数
	 * @param  string $word 单字,gbk编码
	 * @return string       首字母,utf-8编码
	 */
	protected function _getInitial($word){
		$high = ord($word{0});
		$low = ord($word{1});
		//对20902个汉字支持拼音首字母提取
		$hexc = $high * 256 + $low;
		//GBK/2:gb2312汉字表(拼音排序),低位a0开始
		if($hexc >= 0xB0A1 and $hexc <= 0xD7F9 and $low>=0xA0){
			//共3755个字
			return self::_getInGBK21($hexc);
		}
		//GBK/2:gb2312汉字表,低位a0开始
		if($hexc >= 0xD8A1 and $hexc <= 0xF7FE and $low>=0xA0){
			//共3008个字
			return self::_getInGBK('gk221');
		}
		//GBK/3:扩充汉字表(UCS 代码大小排列)
		if($hexc >= 0x8140 and $hexc <= 0xA0FE){
			//共6080个字
			return self::_getInGBK('gk31');
		}
		//GBK/4:扩充汉字表(按康熙字典的页码/字位排列)
		//低位00开始
		if($hexc >= 0xAA40 and $hexc <= 0xFEA0){
			//共8059个字
			return self::_getInGBK('gk41');
		}
		//都没有
		return $this->other;
	}
	/**
	 * 获取首字母
	 * GBK/2:gb2312汉字表(拼音序)
	 * 共3755个字
	 * @param  int $hexc 单字GBK编码值
	 * @return string      首字母,utf-8编码
	 */
	protected function _getInGBK21($hexc){
		//无i,u,v开始的拼音
		$char = array("",//填充位置
			"A","B","C","D","E","F",
			"G","H","J","K","L","M",
			"N","O","P","Q","R","S",
			"T","W","X","Y","Z"
			);
		$hcs = array(
			0xB0A1,0xb0c5,0xb2c1,0xb4ee,0xb6ea,0xb7a2,
			0xb8c1,0xb9fe,0xbbf7,0xbfa6,0xc0ac,0xc2e8,
			0xc4c3,0xc5b6,0xc5be,0xc6da,0xc8bb,0xc8f6,
			0xcbfa,0xcdda,0xcef4,0xd1b9,0xd4d1
			);
		if($key=array_search($hexc,$hcs)){
			return $char[$key];
		}else{
			$hcs[] = $hexc;
			sort($hcs);
			return $char[array_search($hexc,$hcs)];
		}
	}
	/**
	 * 获取首字母
	 * @param  string $type 单字所属GBK区域类型
	 * @return string      首字母,utf-8编码
	 */
	protected function _getInGBK($type){
		//无i,u,v开始的拼音
		$char = array("",//填充位置
			"A","B","C","D","E","F",
			"G","H","J","K","L","M",
			"N","O","P","Q","R","S",
			"T","W","X","Y","Z"
			);
		$str = str_replace("\r\n",'',$this->source[$type]);
		$p = stripos($str,$this->word)+3;//居右//stripos($str,$word),居左
		$str = '';
		if($key=array_search($p,$this->pos[$type])){
			return $char[$key];
		}else{
			$pos = $this->pos[$type];
			$pos[] = $p;
			sort($pos);
			return $char[array_search($p,$pos)];
		}
	}
}
?>