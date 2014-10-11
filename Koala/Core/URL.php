<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

class URL {
	/**
	 * URL组装
	 * @param string $url URL表达式，格式：'[分组/模块/操作]?param1=val1&?param2=val2|param3/val3'
	 * @param string|array $vars 传入的参数，支持数组和字符串
	 * @param string $suffix 伪静态后缀，默认为true表示获取配置值
	 * @param boolean $redirect 是否跳转，如果设置为true则表示跳转到该URL地址
	 * @param boolean $overwite 是否用默认值覆写
	 * @return string
	 */
	public function Assembler($url = '', $vars = '', $suffix = true, $redirect = false, $domain = false, $overwite = false) {
		$url_params = array();
		if ($suffix) {
			$url_suffix = C('URL_HTML_SUFFIX', '.html');
		} else {

			$url_suffix = '';
		}
		$url = str_replace('/', C('URL_PATHINFO_DEPR', '/'), $url);
		$baseurl = rtrim(APP_RELATIVE_URL, '/') . '/';
		if (C('MULTIPLE_ENTRY', 0)) {
			$baseurl .= basename($_SERVER["SCRIPT_NAME"]);
		}
		switch (C('URLMODE', 3)) {
			case 1://使用普通url组装器//index.php?group=admin&module=index
				list($url_params[C('VAR_GROUP', 'g')], $url_params[C('VAR_MODULE', 'm')], $url_params[C('VAR_ACTION', 'a')]) = $url_paths;
				$url = $baseurl . '?' . http_build_query(array_reverse($url_params));
				break;

			case 2:
				//默认使用PATHINFO组装器模式
				//允许多入口
				//index.php/admin/index
				//other.php/admin/index
				//
				$depr = C('URL_PATHINFO_DEPR', '/');
				$url = $baseurl . $url;
				foreach ($url_params as $var => $val) {
					$url .= $depr . $var . $depr . urlencode($val);
				}
				$url .= $url_suffix;
				break;
			case 3://兼容模式//index.php?s=Admin-Index-index-id-1.html
			default:
				$depr = C('URL_PATHINFO_DEPR', '/');
				$url = $baseurl . '?' . C('URL_VAR', 's') . '=' . $url;
				foreach ($url_params as $var => $val) {
					$url .= $depr . $var . $depr . urlencode($val);
				}
				$url .= $url_suffix;
		}
		if ($domain) {
			return 'http://' . $_SERVER['HTTP_HOST'] . $url;
		}
		//组装
		return $url;
	}
}