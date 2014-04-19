<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Advice;
/**
 * 参数签名类
 */
class Sign{
	/**
	 * 获取签名后的参数  包含签名字段sign
	 * @param  array  $params     需签名的参数不含sign参数
	 * @param  string $secret    签名密匙
	 * @param  string $sign_type 签名方式
	 * @return array             签名成功返回含sign参数数组,签名失败返回false
	 */
	function getSignParams($params=array(),$secret='',$sign_type='md5'){
		//签名方法
		$sign_method = 'getFrom'.ucwords($sign_type);
		//不存在方法时，返回false
		if(!is_callable(array($this,$sign_method)))
			return false;
		//签名结果
		$sign = $this->{$sign_method}($param,$secret);
		return array_merge($params,array('sign'=>$sign));
	}
	/**
	  * 签名生成算法
	  * @param  array  $params 请求参数集合的关联数组,不包含sign参数
	  * @param  string $secret 签名的密钥
	  * @return string 返回参数签名值
	  */
	function getFromMd5($params=array(),$secret=''){
		$str = '';  //待签名字符串
	    //先将参数以其参数名的字典序升序进行排序
	    ksort($params);
	    //遍历排序后的参数数组中的每一个key/value对
	    foreach ($params as $k => $v) {
	        //为key/value对生成一个key=value格式的字符串，并拼接到待签名字符串后面
	        $str .= "$k=$v";
	    }
	    //将签名密钥拼接到签名字符串最后面
	    $str .= $secret;
	    //通过md5算法为签名字符串生成一个md5签名，该签名就是我们要追加的sign参数值
	    return md5($str);
	}
}