<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Core\Request;

class BaseV2{
	//api名称
	var $api_name;
	//api参数设置
	var $api_params=array();
	//访问参数
	var $access_params=array();

	public function __construct() {
		//获得当前的的实例化类名
		$class = get_called_class();
		//分为文件名及组织分类名
		list($filename, $org) = array_reverse(explode('\\', $class));
		//加载参数设置
		$this->api_params = include (FRAME_PATH.'OAPI' . '/' . $org . '/Api/' . $filename . '.php');

	}
	/**
	 * 从URL侧获取数据
	 * @param  string $name api名
	 * @return mixed     	数据结果
	 */
	public function apply($name, $params = array()) {
		$this->api_name = strtolower($name);
		$this->access_params = $params;
		if (isset($this->api_params[$this->api_name])) {
			if (isset($this->api_params[$this->api_name]['url'])) {
				//获取请求方法
				$methods = explode('/', strtoupper($this->api_params[$this->api_name]['method']));
				//判断是否使用跳转方式//只对GET方式
				if (in_array('GET',$methods,true)&&isset($this->api_params[$this->api_name]['jump'])) {
					$this->_jumpUrl($this->api_name, $this->_parseParams(), array_shift($methods));
				} else {
					//获取数据
					return $this->_fetchUrl($this->api_name, $this->_parseParams(), array_shift($methods));
				}
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
	/**
	 * 从配置中解析出参数
	 * @return array     	结果
	 */
	protected function _parseParams() {
		$this->access_params = array_merge_recursive($this->api_params[$this->api_name]['request_params'],$this->api_params[$this->api_name]['public_params'],$this->access_params);
		$access_params = array('uri'=>array(),'header'=>array(),'body'=>array());
		foreach ($this->access_params as $postype => $arr) {
			if(is_array($arr)){
				$this->access_params[$postype]=array_unique($arr);
				foreach ($this->access_params[$postype] as $str) {
					$access_params[$postype] = array_merge($access_params[$postype],$this->_parseStr($str));
				}
			}
		}
		unset($this->access_params);
		return $access_params;
		//print_r($this->access_params);exit;
	}
	/*
	 * 从字符中解析出参数名与参数值
	 * @param  string $name api名
	 * @return array     	结果
	 */
	protected function _parseStr($str = '') {
		$parts = explode('|', $str);
		$result[$name] = $name = array_shift($parts);
		$pos = false;
		if (count($parts) > 0) {
			//循环处理
			foreach ($parts as $key => $callable) {
				if (stripos($callable, 'fetch') === 0 || stripos($callable, 'get') === 0) {
					//将上一次的结果作为新参数
					$result[$name] = $this->{'_' . $callable}($result[$name]);
				} elseif (stripos($callable, 'make') === 0) {
					$result[$name] = $this->{'_makeFrom'}($result[$name]);
				} else {
					if (($pos = stripos($callable, '@')) === 0) {
						$result[$name] = substr($callable, $pos + 1);
						$pos = false;
					} else {
						$result[$name] = $callable;
					}
				}
			}
		} else {
			$result[$name] = '';
		}
		//返回本次字串的结果
		return $result;
	}
	/*
	 * 组装
	 * @param  arr
	 * @return array     	结果
	 */
	protected function _makeBody($arr) {
		switch (strtoupper($this->api_params[$this->api_name]['body_type'])) {
			case 'JSON':
				return json_encode($arr);
				break;
			case 'XML':
			exit('MAKE XML BODY!');
				return xml_encode($arr);
				break;
			default:
				# code...
				break;
		}
	}
	/**
	 * 从url侧获取数据的核心方法
	 *
	 * 该方法以multipart/form-data方式编码数据
	 *
	 * @param  string $name   api名
	 * @param  array  $params 请求参数
	 * @param  string $method 请求方法
	 * @return string         结果
	 */
	protected function _fetchUrl($name, $params = array(), $method = 'GET') {
		//去除空值字段
		foreach ($params as $key => $value) {
			$params[$key] = array_filter($value);
		}

		//body消息格式
		$params['body'] = $this->_makeBody($params['body']);
		
		//有文件字段时，值必须是@开头的绝对路径
		//初始化
		$ch = curl_init();
		//证书验证
		//0,1,2
		if (isset($this->api_params[$name]['cacert_type'])) {
			//SSL证书认证
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, (bool) $this->api_params[$name]['cacert_type']);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $this->api_params[$name]['cacert_type']);
			if ((bool) $this->api_params[$name]['cacert_type']) {
				curl_setopt($curl, CURLOPT_CAINFO, $this->api_params[$name]['cacert_path']);//证书地址
			}
		}
		print_r($params['body']);exit;
		//
		if(isset($params['header']['cookie']))
		$cookies = $params['header']['cookie'];unset($params['header']['cookie']);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $params['header']);

		if (strtolower($method) == 'POST') {
			curl_setopt($ch, CURLOPT_URL, $this->api_params[$name]['url'] . '?' . http_build_query($params['uri']));
			// post方式
			curl_setopt($ch, CURLOPT_POST, 1);
			// post的变量
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params['body']);
		} else {
			exit($this->api_params[$name]['url'] . '?' . http_build_query($params['uri']));
			curl_setopt($ch, CURLOPT_URL, $this->api_params[$name]['url'] . '?' . http_build_query($params['uri']));
		}

		if(!empty($cookies)){
			$cookie_jar = TMP_PATH . 'cookie12hdfgyu78df6ghy';
			//提交cookie
			curl_setopt($ch, CURLOPT_COOKIE, implode(';',$cookies));
			curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
		}
		//以返回值方式
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// 过滤HTTP头
		curl_setopt($ch, CURLOPT_HEADER, 0);

		//保存cookie
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);

		//执行并获取HTML文档内容
		$output = curl_exec($ch);
		//释放curl句柄
		curl_close($ch);
		return $output;
	}
	/**
	 * url跳转
	 * @param  string $name   api名
	 * @param  array  $params url参数
	 */
	protected function _jumpUrl($name, $params = array()) {
		//去除空值字段
		foreach ($params as $key => $value) {
			$params[$key] = array_filter($value);
		}
		header('Location:' . $this->api_params[$name]['url'] . '?' . http_build_query($params['uri']));
	}
	function __call($method,$args){
		return rand();
	}
}