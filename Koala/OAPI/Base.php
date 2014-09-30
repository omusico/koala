<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI;
/**
 * 基类
 *
 * @package  Koala
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Base {
	/**
	 * api配置
	 * @var array
	 */
	protected $cfg = array();
	/**
	 * 额外的参数
	 * @var array
	 */
	protected $params = array();
	/**
	 * api名
	 * @var string
	 */
	protected $name = '';
	/**
	 * header,cookie  separator
	 * @var array
	 */
	protected $separator = array('header' => ':', 'cookie' => '=');
	/**
	 * 构造函数
	 *
	 * 目录变量初始化
	 */
	public function __construct() {
		list($class, $org) = array_reverse(explode('\\', get_called_class()));
		$this->cfg = include (__DIR__ . '/' . $org . '/Api/' . $class . '.php');
	}
	/**
	 * 从URL侧获取数据
	 * @param  string $name api名
	 * @return mixed     	数据结果
	 */
	public function apply($name, $params = array()) {
		$this->name = $name = strtolower($name);
		$this->params = $params;
		if (isset($this->cfg[$name])) {
			if (isset($this->cfg[$name]['url'])) {
				if (isset($this->cfg[$name]['redirect'])) {
					$this->_redirectUrl($name, $this->_parseParams($name), array_shift(explode('/', $this->cfg[$name]['method'])));
				} else {

					return $this->_fetchUrl($name, $this->_parseParams($name), array_shift(explode('/', $this->cfg[$name]['method'])));
				}
			} else {
				return null;
			}
		} else {
			return null;
		}
	}
	/**
	 * 从配置中解析出header,cookie参数
	 * @param  string $name api名
	 * @return [type]       [description]
	 */
	protected function _parseHC($name) {
		$params = array();
		foreach ($this->separator as $type => $separator) {
			$paramCFG = $this->cfg[$name][$type];
			foreach ($paramCFG as $key => $value) {
				$params = array_merge($params, array(key($this->_parseStr($value)) . $separator . current($this->_parseStr($value))));
			}
			$this->cfg[$name][$type] = $params;
			$params = array();
		}
	}
	/**
	 * 从配置中解析出参数
	 * @param  string $name api名
	 * @return array     	结果
	 */
	protected function _parseParams($name) {
		isset($this->cfg[$name]['header']) || ($this->cfg[$name]['header'] = array());
		isset($this->cfg[$name]['cookie']) || ($this->cfg[$name]['cookie'] = array());
		isset($this->cfg[$name]['commonParam']) || ($this->cfg[$name]['commonParam'] = array());

		$this->_parseHC($name);
		$params = array();
		$paramCFG = array_merge($this->cfg[$name]['commonParam'], $this->cfg[$name]['requestParam']);
		foreach ($paramCFG as $key => $value) {
			$params = array_merge($params, $this->_parseStr($value));
		}
		return ($this->cfg[$name]['params'] = array_merge($params, $this->params));
	}
	/**
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
	protected function _fetchUrl($name, $params = array(), $method = 'get') {
		//去除空值字段
		$params = array_filter($params);
		//有文件字段时，值必须是@开头的绝对路径
		//初始化
		$ch = curl_init();
		//证书验证
		//0,1,2
		if (isset($this->cfg[$name]['cacert_type'])) {
			//SSL证书认证
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, (bool) $this->cfg[$name]['cacert_type']);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, $this->cfg[$name]['cacert_type']);
			if ((bool) $this->cfg[$name]['cacert_type']) {
				curl_setopt($curl, CURLOPT_CAINFO, $params['cacert']);//证书地址
			}
			unset($params['cacert']);
		}
		//
		curl_setopt($ch, CURLOPT_HTTPHEADER, $this->cfg[$name]['header']);

		if (strtolower($method) == 'post') {
			curl_setopt($ch, CURLOPT_URL, $this->cfg[$name]['url']);
			// post方式
			curl_setopt($ch, CURLOPT_POST, 1);
			// post的变量
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		} else {
			curl_setopt($ch, CURLOPT_URL, $this->cfg[$name]['url'] . '?' . http_build_query($params));
		}

		$cookie_jar = TMP_PATH . 'cookie12hdfgyu78df6ghy';
		//提交cookie
		curl_setopt($ch, CURLOPT_COOKIE, implode(';', $this->cfg[$name]['cookie']));
		curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);

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
	protected function _redirectUrl($name, $params = array()) {
		header('Location:' . $this->cfg[$name]['url'] . '?' . http_build_query($params));
	}
}