<?php
//+++++++++++++运行模式及环境检查++++++++++++
//php版本最低需求
env::reg('MIN_PHP_VERSION', function ($key) {return "5.3";});

//应用引擎环境
env::check('APP_ENGINE', function ($key) {
	if (defined('SAE_ACCESSKEY')) {
		//新浪SAE
		define("APP_ENGINE", "SAE");
		//存储路径
		defined('STOR_PATH') or define('STOR_PATH', C("STOR_PATH", 'bucket' . APP_UUID . '/'));
		//存储访问URL
		defined('STOR_URL') or define('STOR_URL', rtrim(C("STOR_DOMAIN", '/'), '/') . '/' . STOR_PATH);
	} elseif (isset($_SERVER['HTTP_BAE_ENV_APPID'])) {
		//BAE检测
		define("APP_ENGINE", "BAE");
		//存储路径
		defined('STOR_PATH') or define('STOR_PATH', C("STOR_PATH", 'bucket' . APP_UUID . '/'));
		//存储访问URL
		defined('STOR_URL') or define('STOR_URL', rtrim(C("STOR_DOMAIN", '/'), '/') . '/' . STOR_PATH);
	} else {
		//本地应用环境LAE
		define("APP_ENGINE", "LAE");
		//写数据路径
		defined('RUNTIME_PATH') or define('RUNTIME_PATH', APP_PATH . 'Runtime/');
		//存储路径
		defined('STOR_PATH') or define('STOR_PATH', RUNTIME_PATH . 'Storage/');
		//存储访问URL
		defined('STOR_URL') or define('STOR_URL', APP_RELATIVE_URL . 'Runtime/Storage/');
		//日志路径
		defined('LOG_PATH') or define('LOG_PATH', STOR_PATH);
	}

	is_file(FRAME_PATH . 'Initialise/Class' . APP_ENGINE . ".php") AND require (FRAME_PATH . 'Initialise/Class' . APP_ENGINE . ".php");
	is_file(FRAME_PATH . 'Initialise/Constant' . APP_ENGINE . ".php") AND include (FRAME_PATH . 'Initialise/Constant' . APP_ENGINE . '.php');
	return array(
		'require' => '',
		'current' => APP_ENGINE
	);
});
if (!RUNCLI) {
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

		//站点
		define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . $test_path);
		define('SITE_RELATIVE_URL', $test_path);

		$pathname = str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '', str_replace('\\', '/', ENTRANCE_PATH));
		//BAE
		if (APP_ENGINE == 'BAE') {//BAE $_SERVER['DOCUMENT_ROOT'] 与 ENTRANCE_PATH 不在同一路径分支。
			$pathname = basename($pathname) . DIRECTORY_SEPARATOR;
		}
		if ($pathname != $test_path) {
			$test_path = $pathname;
		}
		//应用
		define('APP_URL', 'http://' . $_SERVER['HTTP_HOST'] . $test_path);
		define('APP_RELATIVE_URL', $test_path);
		define('SOURCE_RELATIVE_URL', $test_path . 'Source/');

		return $test_path;
	});
}
//--------------------运行环境检查---------------------
env::check("PHP_OS", function ($key) {
	return array(
		'require' => '不限',
		'current' => PHP_OS
	);
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
env::check("PHP_RUNMODE", function ($key) {
	$result = array(
		'require' => '不限',
		'current' => php_sapi_name()
	);
	return $result;
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
env::check("PHP_SERVER_TIME", function ($key) {
	return array(
		'require' => '',
		'current' => date("Y年n月j日 H:i:s"),
	);
});
env::check("BEIJING_TIME", function ($key) {
	return array(
		'require' => '',
		'current' => gmdate("Y年n月j日 H:i:s", time()+8 * 3600)
	);
});
//--------------------函数、类依赖检查---------------------
env::check("file_get_contents", function ($key) {
	return array(
		'require' => true,
		'current' => function_exists('file_get_contents'),
	);
});

//设定时区
date_default_timezone_set(C('time_zone', 'Asia/Hong_Kong'));
//设置本地化环境
setlocale(LC_ALL, "chs");
//不输出可替代字符
mb_substitute_character('none');

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
		if (!empty($value)) {
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
		if (!empty($value) || isset($value)) {
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