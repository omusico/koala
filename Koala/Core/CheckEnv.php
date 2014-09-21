<?php
ini_set("display_errors", "On");
//+++++++++++++运行模式及环境检查++++++++++++
//php版本最低需求
env::reg('MIN_PHP_VERSION', function ($key) {return "5.3";});
//应用引擎环境
env::reg('APP_ENGINE', function ($key) {
	if (defined('SAE_ACCESSKEY')) {
		return 'SAE';
	} elseif (isset($_SERVER['HTTP_BAE_ENV_APPID'])) {
		return 'BAE';
	} else {
		return 'LAE';
	}
});
env::reg('IS_CGI', function ($key) {
	return (0 === strpos(PHP_SAPI, 'cgi') || false !== strpos(PHP_SAPI, 'fcgi')) ? true : false;
});
env::reg('IS_WIN', function ($key) {
	return strstr(PHP_OS, 'WIN') ? true : false;
});
env::reg('IS_CLI', function ($key) {
	return PHP_SAPI == 'cli' ? true : false;
});
env::reg("PHP_OS", function ($key) {
	return PHP_OS;
});
env::check("PHP_VERSION", function ($key) {
	$result = array(
		'require' => env::get("MIN_" . $key),
		'current' => PHP_VERSION
	);
	if (version_compare(PHP_VERSION, env::get("MIN_" . $key), "<")) {
		$result['msg'] = '当前PHP运行版本[' . PHP_VERSION . "]低于最低需求版本[" . env::get("MIN_" . $key) . "]";
		$result['state'] = 'error';
	} else {
		$result['msg'] = "";
		$result['state'] = 'success';
	}
	if (version_compare(PHP_VERSION, "4.2.3", "<=")) {
		//register_globals设置关闭
		env::check("register_globals", function ($key) {
			ini_set($key, 0);
		});
	}
	return $result;
});
//应用相对URL路径
env::reg('APP_RELATIVE_URL', function ($key) {
	$data = array_intersect(explode('/', $_SERVER["REQUEST_URI"]), explode('/', $_SERVER["SCRIPT_NAME"]));
	$test_path = '';
	//在/app/index.php/param/1类似情况下 为/app
	if (($pos = array_search(basename($_SERVER["SCRIPT_NAME"]), $data)) !== false) {
		$test_path = implode('/', array_slice($data, 0, $pos));
	} else {
		//在/app/param/1类似情况下 为/app
		$num = count($data);
		for ($i = 2; $i < $num; $i++) {
			$test_path = implode('/', array_slice($data, 0, $i));
			if (strpos($_SERVER["REQUEST_URI"], $test_path) === 0 && strpos($_SERVER["SCRIPT_NAME"], $test_path) === 0) {
				break;
			}
		}
	}
	$test_path = $test_path . '/';
	$pathname = str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '', str_replace('\\', '/', ENTRANCE_PATH));
	//BAE
	if (env::$items['APP_ENGINE'] == 'BAE') {//BAE $_SERVER['DOCUMENT_ROOT'] 与 ENTRANCE_PATH 不在同一路径分支。
		$pathname = basename($pathname) . DIRECTORY_SEPARATOR;
	}
	if ($pathname != $test_path) {
		$test_path = $pathname;
	}
	return $test_path;
});
env::check("PHP_UPLOADSIZE", function ($key) {
	return array(
		'require' => '不限',
		'current' => ini_get('upload_max_filesize'),
	);
});
env::check("PHP_MAXTIME", function ($key) {
	return array(
		'require' => '不限',
		'current' => ini_get('max_execution_time') . "秒",
	);
});
env::check("PHP_SPACE", function ($key) {
	return array(
		'require' => '不限',
		'current' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
	);
});
//--------------------函数、类依赖检查---------------------
env::check("file_get_contents", function ($key) {
	return array(
		'require' => true,
		'current' => function_exists('file_get_contents'),
	);
});
/**
 * 环境信息
 */
class env {
	static $items = array();
	/**
	 * 环境信息注册
	 * @param  string  $key   项
	 * @param  Closure $check 闭包
	 */
	public static function reg($key, Closure $check) {
		$value = $check($key);
		if (isset($value)) {
			static::$items[$key] = $value;
		}
	}
	/**
	 * 检查
	 * @param  string $key   项
	 * @param  Closure $check 闭包
	 */
	public static function check($key, Closure $check = null) {
		if (isset(static::$items[$key])) {
			return $check(static::$items[$key], $key);
		}
		$value = $check($key);
		if (isset($value)) {
			static::$items[$key] = $value;
		}
	}
	/**
	 * 获取
	 * @param  string $key   项
	 * @param  Closure $check 闭包
	 * @return fixed 值
	 */
	public static function get($key, Closure $check = null) {
		if ($check == null) {
			return static::$items[$key];
		}
		return $check($key);
	}
}