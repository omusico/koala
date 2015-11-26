<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
class Request {
	//请求映射路径
	static $map_paths = array();
	//请求参数
	static $params = array();
	//请求参数分析
	public static function parse() {
		$info_paths = $paths = array();
		if (C("SUBDOMAIN", false)) {
			if (preg_match('/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\/', $_SERVER['HTTP_HOST']) == false || $_SERVER['HTTP_HOST'] != 'localhost') {
				$paths = array_reverse(array_slice(explode('.', $_SERVER['HTTP_HOST']), 0, -2));
			}
		}
		//$paths = array_reverse(array_slice(explode('.', 'sub1.www.baidu.com'), 0, -2));
		switch (C('URLMODE', 3)) {
			case 1://普通模式
				parse_str($_SERVER['QUERY_STRING'], $params);
				break;
			case 2://PATHINFO模式
				if (false !== ($pos = stripos($_SERVER['PATH_INFO'], C('URL_HTML_SUFFIX', '.html')))) {
					$pathinfo = substr($_SERVER['PATH_INFO'], 0, $pos);
				} else {
					$pathinfo = $_SERVER['PATH_INFO'];
				}
				parse_str($_SERVER['QUERY_STRING'], $params);
				$info_paths = array_filter(explode(C('URL_PATHINFO_DEPR', '/'), trim($pathinfo, C('URL_PATHINFO_DEPR', '/'))));
				break;
			case 3://兼容模式
				if (false !== ($pos = stripos($_SERVER['QUERY_STRING'], C('URL_HTML_SUFFIX', '.html')))) {
					$_SERVER['QUERY_STRING'] = substr($_SERVER['QUERY_STRING'], 0, $pos);
				}
				parse_str($_SERVER['QUERY_STRING'], $params);
				!isset($params[C('URL_VAR', 's')]) and ($params[C('URL_VAR', 's')] = '');
				$info_paths = array_filter(explode(C('URL_PATHINFO_DEPR', '/'), trim($params[C('URL_VAR', 's')], C('URL_PATHINFO_DEPR', '/'))));
			default:
				break;
		}
		//插入子域名部署模式下的path
		array_splice($info_paths, 0, 0, $paths);
		//解析出映射路径和参数
		static::$map_paths = self::parsePaths($info_paths);
		$info_paths = array_values($info_paths);
		$keys = $vals = array();
		while (list($key, $val) = each($info_paths)) {
			if ($key % 2 == 0) {
				$keys[] = $val;
			} else {
				$vals[] = $val;
			}
		}
		if(!empty($keys))
			static::$params = array_unique(array_merge($params, array_combine($keys, $vals)));
		else
			static::$params = array_unique($params);
		
		$_GET = array_merge($_GET, static::$params);
		$_REQUEST = array_merge($_REQUEST, static::$params);
	}
	//获得请求映射路径
	public static function getMapPaths() {
		return static::$map_paths;
	}
	//获得请求参数
	public static function getParams() {
		return static::$params;
	}
	private static function parsePaths(&$paths = array(), $params = array(), $overwite = true) {
		//处理计数
		$num = 0;
		//是否启用了多应用模式//默认单应用
		if (C('MULTIPLE_APP', 0)) {
			//如果不在已有的应用列表中
			if (!isset($paths[$num]) || !in_array(strtoupper($paths[$num]), C('APP:list', array('APP')))) {
				//是否用默认值
				if ($overwite) {
					$options[C('VAR_APP', 'app')] = strtoupper(C('APP:default', 'APP'));
				}
			} else {
				$options[C('VAR_APP', 'app')] = strtoupper($paths[$num]);
				unset($paths[$num]);
				++$num;
			}
		}
		//是否启用了多分组//默认多分组
		if (C('MULTIPLE_GROUP', 1)) {
			//如果不在已有的分组列表中
			if (!isset($paths[$num]) || !in_array(ucwords($paths[$num]), C('GROUP:list', array('Home')))) {
				//是否用默认值
				if ($overwite) {
					$options[C('VAR_GROUP', 'g')] = ucwords(C('GROUP:default', 'Home'));
				}
			} else {
				$options[C('VAR_GROUP', 'g')] = ucwords($paths[$num]);
				unset($paths[$num]);
				++$num;
			}
		}
		//模块
		if (!isset($paths[$num])) {
			//是否用默认值
			if ($overwite) {
				$options[C('VAR_MODULE', 'm')] = ucwords(C('MODULE:default', 'Home'));
			}
		} else {
			$options[C('VAR_MODULE', 'm')] = ucwords($paths[$num]);
			unset($paths[$num]);
			++$num;
		}
		//方法
		if (!isset($paths[$num])) {
			//是否用默认值
			if ($overwite) {
				$options[C('VAR_ACTION', 'a')] = C('ACTION:default', 'index');
			}
		} else {
			$options[C('VAR_ACTION', 'a')] = $paths[$num];
			unset($paths[$num]);
			++$num;
		}
		return $options;
	}
}