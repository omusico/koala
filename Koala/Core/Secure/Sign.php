<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Core\Secure;
/**
 * 参数签名类
 */
class Sign{
	/**
	 * 获取签名后的参数
	 * @param  array  $params     需签名的参数,不含sign参数
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
		$sign = $this->{$sign_method}($params,$secret);
		return array_merge($params,array('sign'=>$sign));
	}
	/**
	 * 获取签名验证结果
	 * @param  array  $params    需校验签名的参数,必须包含sign参数
	 * @param  string $secret    签名密匙
	 * @param  string $sign_type 签名方式
	 * @return bool              相等返回true,不相等返回false
	 */
	function getVerify($params=array(),$secret='',$sign_type='md5'){
		//签名验证方法
		$verify_method = 'verifyFrom'.ucwords($sign_type);
		//不存在方法时，返回false
		if(!is_callable(array($this,$verify_method)))
			return false;
		return $this->{$verify_method}($params,$secret);
	}
	/**
	  * 签名生成算法 md5方式
	  * @param  array  $params 请求参数集合的关联数组,不包含sign参数
	  * @param  string $secret 签名的密钥
	  * @access protected
	  * @return string 返回参数签名值
	  */
	protected function getFromMd5($params=array(),$secret=''){
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
	/**
	 * 签名验证算法 md5方式
	 * @param  array  $params 需校验签名的参数,必须包含sign参数
	 * @param  string $secret 签名的密钥
	 * @access protected
	 * @return bool            相等返回true,不相等返回false
	 */
	protected function verifyFromMd5($params=array(),$secret=''){
		$str = '';  //待签名字符串
		$old_sign = $params['sign'];unset($params['sign']);//保存原始签名并移除参数sign
		//生成签名
	    $sign = $this->getFromMd5($params,$secret);
	    //比较结果
	    return 0===strcmp($sign,$old_sign);
	}
}