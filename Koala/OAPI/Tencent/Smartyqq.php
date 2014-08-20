<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Tencent;
use Koala\OAPI\Base;
include(__DIR__.'/Lib/func.php');
/**
 * SMARTYQQ 协议 api
 */
class Smartyqq extends Base{
	/**
	 * 构造函数
	 */
	final public function __construct(){
		parent::__construct();
		$this->cfg = include(__DIR__.'/Api/smartyqq.php');
	}
	/**
	 * 魔术方法
	 * @param  string $method 方法名
	 * @param  array $args   方法参数
	 * @return mixed         返回值
	 */
	public function __call($method,$args){}
	/**
	 * 获取qq号码
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getUin($str='');
	/**
	 * 获取随机数
	 * 随机18位  0.后面+随机16位数
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getRandnum($str='');
	/**
	 * pass
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getPass($str='');
	/**
	 * verifycode
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getVerifycode($str=''){
		return  $this->params['verifycode'];
	}
	/**
	 * smarty qq 新版登陆加密函数
	 * 
	 * @access public
	 * @param string $p  密码
	 * @return string
	 */
	protected function _getEncodePass($p){
		$h =strtoupper(md5(\hexchar2bin(md5($this->_getPass())).\uin2hex($this->_getUin())));
		return strtoupper(md5($h.strtoupper($this->_getVerifycode())));
	}
	/**
	 * encodestr
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getEncodeStr($str=''){
		return $this->params['encodestr'];
	}
	/**
	 * getcookie
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getCookie($str=''){
		$cookie_jar = '/tmp/cookie12hdfgyu78df6ghy';
		preg_match_all('/(.*)	(.*)	(.*)	(.*)	(.*)	(.*)	(.*)/i', file_get_contents($cookie_jar), $matches);
		if(false!==($key=array_search($str, $matches[6])))
			return $matches[7][$key];
		else
			return '';
	}
	/**
	 * hash
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getHash($str=''){
		return \qqhash($this->_getUin(),$this->_getCookie('ptwebqq'));
	}
	/**
	 * 从url侧获取数据的核心方法
	 * 
	 * @param  string $name   api名
	 * @param  array  $params 请求参数
	 * @param  string $method 请求方法
	 * @return string         结果
	 */
	protected function _fetchUrl($name,$params=array(),$method='get'){
		//去除空值字段
		$params = array_filter($params);
		if(isset($params['url'])){
			$this->cfg[$name]['url'] = $params['url'];
			unset($params['url']);
		}
		unset($params['encodestr']);
		//有文件字段时，值必须是@开头的绝对路径
		//初始化
		$ch = curl_init();
		//echo $this->cfg[$name]['url'].'?'.http_build_query($params);exit;
		if(strtolower($method)=='post'){
			curl_setopt($ch, CURLOPT_URL, $this->cfg[$name]['url']);
		}else{
			curl_setopt($ch, CURLOPT_URL, $this->cfg[$name]['url'].'?'.http_build_query($params));
		}
		//以返回值方式
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		//curl_setopt($ch,  CURLOPT_FOLLOWLOCATION, 1); // 302 redirect

		if(strtolower($method)=='post'){
			// post方式
			curl_setopt($ch, CURLOPT_POST, 1);
			if($this->cfg[$name]['form-urlencode']){
				curl_setopt($ch, CURLOPT_POSTFIELDS, 'r='.$params['r']);
			}else
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		}else{
			curl_setopt($ch, CURLOPT_HEADER, 0);
		}
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $this->cfg[$name]['header']); 

		$cookie_jar = '/tmp/cookie12hdfgyu78df6ghy';
		//提交cookie
		curl_setopt($ch, CURLOPT_COOKIE,implode(';', $this->cfg[$name]['cookie']));
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);

		//保存cookie
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);
		//执行并获取HTML文档内容
		$output = curl_exec($ch);

		//释放curl句柄
		curl_close($ch);
		return $output;
	}
}