<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Sendcloud;
use Koala\OAPI\Base;

/**
 * 邮件发送
 * http://sendcloud.sohu.com/api-doc/web-api-ref
 * $o = \Koala\OAPI::factory('Sendcloud\Mail', array(), 'Library');
 * echo $o->apply('send_mail', array());
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Mail extends Base {
	/**
	 * 获取已保存的Key
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getKey($str = '');
	/**
	 * 获取已保存的User
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getUser($str = '');
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
		if (strtolower($method) == 'post') {
			curl_setopt($ch, CURLOPT_URL, $this->cfg[$name]['url']);
		} else {
			curl_setopt($ch, CURLOPT_URL, $this->cfg[$name]['url'] . '?' . http_build_query($params));
		}

		//以返回值方式
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		if (strtolower($method) == 'post') {
			// post方式
			curl_setopt($ch, CURLOPT_POST, 1);
			// post的变量
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		} else {
			curl_setopt($ch, CURLOPT_HEADER, 0);
		}
		//执行并获取HTML文档内容
		$output = curl_exec($ch);
		//释放curl句柄
		curl_close($ch);
		return $output;
	}
}