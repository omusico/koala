<?php
/**
 * 该文件中存放的是框架必须函数和一些常用函数
 */
/**
 * 支持ajax和普通访问下的信息提示
 * @param    mixed        $message  消息内容
 * @param    int          $type   消息类型
 */
function message($message, $type = \Core\Front\MessageState::INFO) {
	if (is_ajax()) {
		if (is_array($message)) {
			exit(json_encode($message));
		} else {

			exit($message);
		}
	} else {
		switch ($type) {
			case \Core\Front\MessageState::COMMON:
				\View::display(\FrontData::get('tpl'));
				break;
			case \Core\Front\MessageState::ERROR:
				\View::error($message);
				break;
			case \Core\Front\MessageState::SUCCESS:
			case \Core\Front\MessageState::INFO:
			default:
				\View::success($message);
				break;
		}
		exit;
	}
}
/**
 * 产生随机字符串
 *
 * @param    int        $length  输出长度
 * @param    string     $chars   可选的 ，默认为 0123456789
 * @return   string     字符串
 */
function random($length, $chars = '0123456789') {
	$hash = '';
	$max = strlen($chars) - 1;
	for ($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}
/**
 * 生成随机字符串
 * @param string $lenth 长度
 * @return string 字符串
 */
function createRandomstr($lenth = 6) {
	return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}
/**
 * 建立较低碰撞率ID(短串)
 * @param  string $namespace 名称前缀
 * @return string            id串
 */
function createShortGuid($namespace = '') {
	static $guid = '';
	$uid = uniqid("", true);
	$data = $namespace;
	$data .= $_SERVER['REQUEST_TIME'];
	$data .= $_SERVER['HTTP_USER_AGENT'];
	$data .= $_SERVER['LOCAL_ADDR'];
	$data .= $_SERVER['LOCAL_PORT'];
	$data .= $_SERVER['REMOTE_ADDR'];
	$data .= $_SERVER['REMOTE_PORT'];
	$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
	$guid = substr($hash, 0, 8) .
	'-' .
	substr($hash, 8, 4) .
	'-' .
	substr($hash, 12, 4);
	return $guid;
}
/**
 * 建立较低碰撞率ID(长串)
 * @param  string $namespace 名称前缀
 * @return string            id串
 */
function createGuid($namespace = '') {
	static $guid = '';
	$uid = uniqid("", true);
	$data = $namespace;
	$data .= $_SERVER['REQUEST_TIME'];
	$data .= $_SERVER['HTTP_USER_AGENT'];
	$data .= $_SERVER['LOCAL_ADDR'];
	$data .= $_SERVER['LOCAL_PORT'];
	$data .= $_SERVER['REMOTE_ADDR'];
	$data .= $_SERVER['REMOTE_PORT'];
	$hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
	$guid = substr($hash, 0, 8) .
	'-' .
	substr($hash, 8, 4) .
	'-' .
	substr($hash, 12, 4) .
	'-' .
	substr($hash, 16, 4) .
	'-' .
	substr($hash, 20, 12);
	return $guid;
}
/**
 * URL组装 支持不同URL模式 // U('BlogAdmin/Index/Index#top@localhost?id=1');
 * @param string $url URL表达式，格式：'[分组/模块/操作#锚点@域名]?参数1=值1&参数2=值2...'
 * @param string|array $vars 传入的参数，支持数组和字符串
 * @param string $suffix 伪静态后缀，默认为true表示获取配置值
 * @param boolean $redirect 是否跳转，如果设置为true则表示跳转到该URL地址
 * @param boolean $domain 是否显示域名
 * @return string
 */
function U($url = '', $vars = '', $suffix = true, $redirect = false, $domain = false, $overwite = false) {
	$u = new \URL;
	return $u->Assembler($url, $vars, $suffix, $redirect, $domain, $overwite);
}
/**
 * 语言项加载
 * @param string $item 语言项
 */
function L($item) {
	$item = strtoupper($item);
	$LANG = include (LANG_PATH . '/main.php');
	return isset($LANG[$item]) ? $LANG[$item] : $item;
}
/**
 * model
 * @param string $table [description]
 */
function M($table = '') {
	Model::$table_name = $table;
	Model::$tpr = C('DB_PREFIX');
	return new Model();
}
/**
 * 数组转义
 * @param  array $arr_r 需处理数组
 */
function addslashes_array(&$arr_r) {
	foreach ($arr_r as &$val) {is_array($val) ? addslashes_array($val) : $val = addslashes($val);
	}

	unset($val);
}

/**
 * URL重定向
 * @param string $url 重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string $msg 重定向前的提示信息
 * @return void
 */
function redirect($url, $time = 0, $msg = '') {
	//多行URL地址支持
	$url = str_replace(array("\n", "\r"), '', $url);
	if (empty($msg)) {
		$msg = "系统将在{$time}秒之后自动跳转到{$url}！";
		if (!headers_sent()) {
			// redirect
			if (0 === $time) {
				header('Location: ' . $url);
			} else {
				header("refresh:{$time};url={$url}");
				echo ($msg);
			}
			exit();
		} else {
			$str = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
			if ($time != 0) {
				$str .= $msg;
			}

			exit($str);
		}
	}
}

/**
 * 字符串命名风格转换
 * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
 * @param string $name 字符串
 * @param integer $type 转换类型
 * @return string
 */
function parse_name($name, $type = 0) {
	if ($type) {
		return ucfirst(preg_replace_callback('/_([a-zA-Z])/', function ($match) {return strtoupper($match[1]);}, $name));
	} else {
		return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
	}
}

/**
 * $rule,要验证的规则名称；
 * $uid,用户的id；
 * $relation，规则组合方式，默认为‘or’，以上三个参数都是根据Auth的check（）函数来的，
 * $t,符合规则后，执行的代码
 * $f，不符合规则的，执行代码，默认为抛出字符串‘没有权限’
 */
function authcheck($rule, $uid, $relation = 'or', $t, $f = '没有权限') {
	if ($relation == '') {
		$relation = 'or';
	}
	$auth = new Helper_Authority();
	return $auth->getAuth($rule, $uid, $relation) ? $t : $f;
}

//=====环境检测函数=====
/**
 * 是否是flash请求
 * @return boolean
 */
function is_flash() {
	return isset($_SERVER['HTTP_USER_AGENT']) && (stripos($_SERVER['HTTP_USER_AGENT'], 'Shockwave') !== false || stripos($_SERVER['HTTP_USER_AGENT'], 'Flash') !== false);
}

/**
 * ajax请求判断
 * @return boolean
 */
function is_ajax() {
	$is_ajax = false;
	//针对jq等常用框架
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
		$is_ajax = true;
	}
	//建议在使用ajax时发送header变量 request_type=ajax
	if (isset($_SERVER['HTTP_REQUEST_TYPE']) && $_SERVER['HTTP_REQUEST_TYPE'] == 'ajax') {
		$is_ajax = true;
	}
	return $is_ajax;
}
/**
 * pajax请求判断
 * @link https://github.com/defunkt/jquery-pjax pajax
 * @return boolean
 */

function is_pjax() {
	return array_key_exists('HTTP_X_PJAX', $_SERVER) && $_SERVER['HTTP_X_PJAX'];
}
/**
 * 判断是否是 https 连接
 * @return boolean
 */
function is_ssl() {
	if ($_SERVER['HTTPS'] != "on") {
		return false;
	} else {
		return true;
	}
}
/**
 * 判断是否是移动设备
 * @return boolean
 */
function is_mobile() {
	// 如果有HTTP_X_WAP_PROFILE则一定是移动设备
	if (isset($_SERVER['HTTP_X_WAP_PROFILE'])) {
		return true;
	}

	//此条摘自TPM智能切换模板引擎，适合TPM开发
	if (isset($_SERVER['HTTP_CLIENT']) && 'PhoneClient' == $_SERVER['HTTP_CLIENT']) {
		return true;
	}

	//如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
	if (isset($_SERVER['HTTP_VIA']))
	//找不到为flase,否则为true
	{return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
	}

	//判断手机发送的客户端标志,兼容性有待提高
	if (isset($_SERVER['HTTP_USER_AGENT'])) {
		$clientkeywords = array(
			'nokia', 'sony', 'ericsson', 'mot', 'samsung', 'htc', 'sgh', 'lg', 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android', 'netfront', 'symbian', 'ucweb', 'windowsce', 'palm', 'operamini', 'operamobi', 'openwave', 'nexusone', 'cldc', 'midp', 'wap', 'mobile',
		);
		//从HTTP_USER_AGENT中查找手机浏览器的关键字
		if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
			return true;
		}
	}
	//协议法，因为有可能不准确，放到最后判断
	if (isset($_SERVER['HTTP_ACCEPT'])) {
		// 如果只支持wml并且不支持html那一定是移动设备
		// 如果支持wml和html但是wml在html之前则是移动设备
		if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
			return true;
		}
	}
	return false;
}
/**
 * 获取请求方式 get,post,put
 * @return [type] [description]
 */
function get_request_method() {
	return strtolower($_SERVER['REQUEST_METHOD']);
}
/**
 * 获取客户端ip
 * @return string ip地址
 */
function get_ip() {
	if (getenv("HTTP_CLIENT_IP")) {
		$ip = getenv("HTTP_CLIENT_IP");
	} else if (getenv("HTTP_X_FORWARDED_FOR")) {
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	} else if (getenv("REMOTE_ADDR")) {
		$ip = getenv("REMOTE_ADDR");
	} else {
		$ip = "Unknow";
	}

	return $ip;
}

//===========配置函数
/**
 * 获得配置值
 * @param string $key  配置项
 * @param string $defv 默认值
 */
function C($key, $defv = '', $runtime = false) {
	if (strpos($key, 'Plugin') === 0) {
		list($pre, $name) = explode('\\', $key);
		if (file_exists(APP_ADDONS_PATH . 'Plugin\\' . $name . '\config.php')) {
			return require (APP_ADDONS_PATH . 'Plugin\\' . $name . '\config.php');
		}
	}

	return Config::getItem($key, $defv, $runtime);
}

//============文件系统函数
/**
 * 递归目录文件列表
 * @param  string $dir     需递归的目录
 * @param  array  $list    存放结果的数组
 * @param  string $search  搜索字符串
 * @param  string $replace 替换字符串
 * @return
 */
function listDir($dir = '.', &$list = array(), $search = '', $replace = '') {
	if ($handle = opendir($dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file == '.' || $file == '..') {
				continue;
			}
			if (is_dir($sub_dir = realpath($dir . '/' . $file))) {
				// echo 'FILE in PATH:'.$dir.':'.$file.'<br>';
				listDir($sub_dir, $list, $search, $replace);
			} else {
				if ($search != '' || $replace != '') {
					$tdir = str_replace($search, $replace, $dir);
				} else {
					$tdir = $dir;
				}
				$list[$tdir][] = $file;
				//echo 'FILE:'.$file.'<br>';
			}
		}
		closedir($handle);
	}
}
/**
 * @param   string  $directory  directory name
 * @param   array   $paths      list of paths to search
 * @return  array
 */
function listFiles($directory = NULL, array $paths = NULL) {
	if ($directory !== NULL) {
		// Add the directory separator
		$directory .= DIRECTORY_SEPARATOR;
	}

	if ($paths === NULL) {
		// Use the default paths
		$paths = array(APP_PATH, FRAME_PATH);
		;
	}

	// Create an array for the files
	$found = array();

	foreach ($paths as $path) {
		if (is_dir($path . $directory)) {
			// Create a new directory iterator
			$dir = new DirectoryIterator($path . $directory);

			foreach ($dir as $file) {
				// Get the file name
				$filename = $file->getFilename();

				if ($filename[0] === '.' OR $filename[strlen($filename) - 1] === '~') {
					// Skip all hidden files and UNIX backup files
					continue;
				}

				// Relative filename is the array key
				$key = $directory . $filename;

				if ($file->isDir()) {
					if ($sub_dir = listFiles($key, $paths)) {
						if (isset($found[$key])) {
							// Append the sub-directory list
							$found[$key] += $sub_dir;
						} else {
							// Create a new sub-directory list
							$found[$key] = $sub_dir;
						}
					}
				} else {
					if (!isset($found[$key])) {
						// Add new files to the list
						$found[$key] = realpath($file->getPathName());
					}
				}
			}
		}
	}

	// Sort the results alphabetically
	ksort($found);

	return $found;
}
//文件目录排序 for kindeditor
function cmp_func($a, $b) {
	global $order;
	if ($a['is_dir'] && !$b['is_dir']) {
		return -1;
	} else if (!$a['is_dir'] && $b['is_dir']) {
		return 1;
	} else {
		if ($order == 'size') {
			if ($a['filesize'] > $b['filesize']) {
				return 1;
			} else if ($a['filesize'] < $b['filesize']) {
				return -1;
			} else {
				return 0;
			}
		} else if ($order == 'type') {
			return strcmp($a['filetype'], $b['filetype']);
		} else {
			return strcmp($a['filename'], $b['filename']);
		}
	}
}
//解析/id/1/name/2 格式 到 array('id'=>1,'name'=>2)
function parse_varstr($var_str, $del = '/') {
	$one = $two = array();
	$args = explode($del, $var_str);
	if (count($args) % 2 != 0) {array_pop($args);
	}

	foreach ($args as $key => $value) {
		if ($key % 2 == 0) {
			$one[] = $value;
		} else {

			$two[] = $value;
		}
	}

	return array_combine($one, $two);
}
/**
 * 类加载
 * @param  string $class_path 类路径别名
 * @return object             类实例
 */
function import($class_path, $class) {
	if (strpos('#', $class_path) === 0) {
		$base_path = FRAME_PATH;
	}if (strpos('@', $class_path) === 0) {
		$base_path = APP_PATH;
	}
	if (file_exists($base_path . $class_path . $class . '.php')) {
		include ($base_path . $class_path . $class . '.php');
		return new $class();
	} else {
		return null;
	}
}
//===============数组处理=========
function getValueRec($keys = array(), $arr = array(), &$depth = 0) {
	foreach ($keys as $index => $key) {
		if ($depth == 1) {$key = strtolower($key);}
		$arr = isset($arr[$key]) ? $arr[$key] : null;
		if ($arr === null) {
			$depth = 0;
			break;
		}
		$depth++;
	}
	$depth = 0;
	return $arr;
}

function urlsafe_base64_encode($str) {
	return str_replace(array('+', '/'), array('-', '_'), base64_encode($str));
}
function hookTrigger($hook, $param = null, $callable = null, $return = false) {
	return \Core\Plugin\Manager::trigger($hook, $param, $callable, $return);
}