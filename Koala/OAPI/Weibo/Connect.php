<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Weibo;
use Koala\OAPI\Base;

/**
 */
abstract class Connect extends Base {
	/**
	 * 获取回调url
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getCodeRedirectUri($str = '');
	/**
	 * 获取appid
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppKey($str = '');
	/**
	 * 获取appkey
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppSecret($str = '');
	/**
	 * 获取code
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAuthCode($str = '');
	/**
	 * 获取openid
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getOpenid($str = '');
	/**
	 * 获取Token值
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAccessToken($str = '');
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
			//获取accesstoken的时候老是出现“miss client id or secret”错误。
			//该方法说是只能通过post请求传递，但是参数又必须放到url里面，是get/post混搭使用的，实际上post的内容为空，参数都是拼在url中。
			if (in_array($name, array('get_access_token', 'get_token_info'))) {
				curl_setopt($ch, CURLOPT_URL, $this->cfg[$name]['url'] . '?' . http_build_query($params));
				$params = array();
			} else {

				curl_setopt($ch, CURLOPT_URL, $this->cfg[$name]['url']);
			}
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