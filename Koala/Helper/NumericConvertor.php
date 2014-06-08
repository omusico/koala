<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Helper;
/**
 * 中文数字大小写与阿拉伯数字的字符形式的转换
 * 
 * 仅支持人民币转换
 * 
 *	$s = new NumericConvertor('壹亿壹仟伍佰贰拾伍万零伍拾壹');
 *	echo '壹亿壹仟伍佰贰拾伍万零伍拾壹','<br>=>',$s->convChineseToNumeric();
 *	echo '<br>';
 *	$s->setStr('壹仟贰佰亿零伍佰零伍万零壹佰贰拾');
 *	echo '壹仟贰佰亿零伍佰零伍万零壹佰贰拾','<br>=>',$s->convChineseToNumeric();
 *	echo '<br>';
 *	$s->setStr('壹仟贰佰亿零伍佰零伍万零壹佰贰拾伍元贰角壹分柒厘');
 *	echo '壹仟贰佰亿零伍佰零伍万零壹佰贰拾伍元贰角壹分柒厘','<br>=>',$s->convChineseToNumeric();
 *	echo '<br>';
 *	//130002200
 *	$s->setStr('一亿三千万二千二百',true);
 *	echo '一亿三千万二千二百','<br>=>',$s->convChineseToNumeric();
 *	echo '<br>';
 *	$s->setStr('一亿三千万零二千二百八角五分九厘',true);
 *	echo '一亿三千万零二千二百八角五分九厘','<br>=>',$s->convChineseToNumeric();
 *	echo '<br>';
 *	$s->setStr('一百亿三千万零二千二百零三',true);
 *	echo '一百亿三千万零二千二百零三','<br>=>',$s->convChineseToNumeric();
 *
 * @author   LunnLew <email:lunnlew@gmail.com> <qq:759169920>
 */
class NumericConvertor{
	/**
	 * 中文的分割正则
	 * @var string
	 */
	var $split_pattern = '//u';
	/**
	 * 中文数字处理正则
	 * @var string
	 */
	var $upperpattern = '/(.*?)([亿萬万仟佰拾元角分厘]*)/u';
	/**
	 * 中文数字大写
	 * @var array
	 */
	var $upperWords = array(
		'零','壹','贰','叁','肆','伍','陆','柒','捌','玖'
		);

	/**
	* 进位数
	* @var array
	*/
	var $uppercarrys = array(
		'厘'=>-3,'分'=>-2,'角'=>-1,'元'=>0,
		'拾'=>1,'佰'=>2,'仟'=>3,'万'=>4,'亿'=>8,'兆'=>12,
		);
	/**
	 * 中文小写数字处理正则
	 * @var string
	 */
	var $lowerpattern = '/(.*?)([亿万千百十元角分厘]*)/u';
	/**
	* 中文数字小写
	* @var array
	*/
	var $lowerWords = array(
		'零','一','二','三','四','五','六','七','八','九'
		);
	/**
	* 进位数
	* @var array
	*/
	var $lowercarrys = array(
		'厘'=>-3,'分'=>-2,'角'=>-1,'元'=>0,
		'十'=>1,'百'=>2,'千'=>3,'万'=>4,'亿'=>8,'兆'=>12
		);
	/**
	 * 处理类型
	 * 0,为中文大写转换为阿拉伯数字 默认
	 * 1,为中文小写转换为阿拉伯数字
	 * @var integer
	 */
	var $type = 0;
	/**
	* 要处理的字符串
	* @var string
	*/
	var $prep_str = '';
	/**
	 * 当前段基础进位
	 */
	var $carryNumberBase = 0;
	/**
	* 字符串的预处理结果
	* @var array
	*/
	var $prep_result = array();
	/**
	 * 小数点位置
	 * @var integer
	 */
	var $pos = null;
	/**
	 * 是否有小数位
	 */
	var $float = false;
	/**
	 * 构造函数
	 * @param  string  $str  要处理的中文数字字符串
	 * @param  integer $type 要处理的中文数字类型
	 */
	public function __construct($str='',$type=0){
		$this->setStr($str,$type);
	}
	/**
	 * @param  string  $str  要处理的中文数字字符串
	 * @param  integer $type 要处理的中文数字类型
	 */
	public function setStr($str='',$type=0){
		$this->carryNumberBase=0;
		$this->float =false;
		$this->pos = null;
		$this->prep_str = rtrim(str_replace('圆', '元',$str),'元整');
		$this->type = $type;
	}

	/*
	 * 转换中文数字到阿拉伯数字
	 * @return string
	 */
	public function convChineseToNumeric(){
		if($this->type==0){
			if(!preg_match_all($this->upperpattern,$this->prep_str,$this->prep_result)){
				return ;
			}
		}else{
			if(!preg_match_all($this->lowerpattern,$this->prep_str,$this->prep_result)){
				return ;
			}
		}
		//反转结果
		$this->prep_result[1] = array_reverse($this->prep_result[1]);
		$this->prep_result[2] = array_reverse($this->prep_result[2]);
		//结果串
		$str = '';
		//临时串
		$temp_str='';
		//进位数
		$carryNumberSum=0;
		//处理区
		foreach($this->prep_result[1] as $key=>$digital){
			//如果不为空
			if(!empty($digital)){
				//如果当前数字为零
				if($digital=='零'){
					//echo '[1]','<br>';
					//三万零二千
					//下一个单位的进位数
					$carryNumberSum = $this->carryNumber($this->prep_result[2][$key+2]);
					//补零
					$str = strrev(str_pad(strrev($str).$this->getNumeric($digital),$carryNumberSum,'0'));
				}else{//如果除了‘零’外
					//如果接下来的数字位不是是零且数字单位不存在
					if($this->prep_result[1][$key+2]!='零'&&empty($this->prep_result[2][$key])){
						//echo '[2]','<br>';
						//'三万二';
						//取得下一个单位的进位数值
						$carryNumberSum = $this->carryNumber($this->prep_result[2][$key+2]);
						//补零
						$str = str_pad($str.$this->getNumeric($digital),$carryNumberSum,'0');
					}else{
						//下一个不为零的数有单位时且单位不相邻
						if(!empty($this->prep_result[2][$key+2])&&!$this->isAdjoin($this->prep_result[2][$key],$this->prep_result[2][$key+2])){
							//echo '[3]','<br>';
							//'三千万二千';
							//下一个单位的进位数
							$carryNumberSum = $this->carryNumber($this->prep_result[2][$key+2]);
							//补零
							$str = strrev(str_pad(strrev($str).$this->getNumeric($digital),$carryNumberSum,'0'));
						}else{
							//echo '[4]','<br>';
							//三万零二千，'三万二千';
							//取得当前单位的进位数值
							$carryNumberSum = $this->carryNumber($this->prep_result[2][$key]);
							//补零
							$str = str_pad($this->getNumeric($digital).$str,$carryNumberSum+1,'0');
						}
					}
				}
				//小数部分处理
				if($this->float&&$this->pos===null){
					$this->pos = $carryNumberSum;
				}
				//echo $carryNumberSum.'|'.$digital.'|'.$this->prep_result[2][$key].'|'.$str.'<br>';
			}
		}
		//去除多余前置0,返回结果
		if($this->float&&$this->pos<0)
			return ltrim(substr_replace($str,'.'.mb_substr($str,$this->pos),$this->pos));
		else
			return ltrim($str,'0');
	}
	/**
	 * 单位的进位数值
	 * @param  string 单位
	 * @param  integer $next
	 * @return integer
	 */
	private function carryNumber($str){
		$ars = $this->getWords($str);
		if($this->type==0){
			$number =  $this->uppercarrys[array_shift($ars)];
			foreach ($ars as $key => $value) {
				$sum[] = $this->uppercarrys[$value];
			}
		}else{
			$number =  $this->lowercarrys[array_shift($ars)];
			foreach ($ars as $key => $value) {
				$sum[] = $this->lowercarrys[$value];
			}
		}
		//关键段的识别点
		if(in_array($str,array('亿','万'))){
			//有小数时的小数位数 （-$this->pos）
			return ($this->carryNumberBase = ($number-$this->pos));
		}else{//在某一段中
			$num = array_sum($sum);
			//有小数时的小数位数 （-$this->pos）
			$this->carryNumberBase = $num-$this->pos;
			//进位数小于零时有小数位
			if($number+$num<0){
				//接下来需要处理小数
				$this->float=true;
			}
			return $number+$this->carryNumberBase;
		}
		
	}
	/**
	 * 获取单字的字符数字
	 * @param  string $word
	 * @return char
	 */
	private function getNumeric($word){
		if($this->type==0){
			return strval(array_shift(array_keys($this->upperWords,$word)));
		}else{
			return strval(array_shift(array_keys($this->lowerWords,$word)));
		}
	}
	/**
	 * 是否相邻
	 * @param  string 一个较小单位
	 * @param  string 一个较大单位
	 * @return integer
	 */
	private function isAdjoin($str,$str1){
		if($this->type==0){
			$keys = array_keys($this->uppercarrys);
		}else{
			$keys = array_keys($this->lowercarrys);
		}
		$key = array_shift(array_keys($keys,$str));
		if(isset($keys[$key+1])&&$keys[$key+1]==$str1){
			return true;
		}
		return false;
	}
	/**
	 * 获取字符分割数组
	 * @param  string $str
	 * @return array
	 */
	private function getWords($str){
		return array_filter(preg_split($this->split_pattern,$str));
	}
}