<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Org;
use Koala\OAPI\Base;

/**
 * 国家气象局提供的天气预报接口
 * 接口地址：
 * http://www.weather.com.cn/data/sk/101010100.html
 * http://www.weather.com.cn/data/cityinfo/101010100.html
 * http://m.weather.com.cn/data/101010100.html
 *
 * $o = \Koala\OAPI::factory('weather');
 * echo $o->apply('get_weather_info',array('cityid'=>'101010100'));
 *
 */

class Weather extends Base {
	/**
	 * 魔术方法
	 * @param  string $method 方法名
	 * @param  array $args   方法参数
	 * @return mixed         返回值
	 */
	public function __call($method, $args) {}
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
		foreach ($params as $key => $value) {
			$this->cfg[$name]['urltpl'] = str_replace('{' . $key . '}', $value, $this->cfg[$name]['urltpl']);
		}
		unset($params);
		//有文件字段时，值必须是@开头的绝对路径
		//初始化
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->cfg[$name]['url'] . $this->cfg[$name]['urltpl']);
		//以返回值方式
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		//执行并获取HTML文档内容
		$output = curl_exec($ch);
		//释放curl句柄
		curl_close($ch);
		return $output;
	}
}