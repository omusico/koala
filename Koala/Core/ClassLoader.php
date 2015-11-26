<?php
//类加载器
//参考 PSR0规范 https://github.com/hfcorriez/fig-standards/blob/zh_CN/%E6%8E%A5%E5%8F%97/PSR-0.md
class ClassLoader extends Singleton {
	//名称空间map
	protected $namespaces = array();
	//前缀map
	protected $prefixes = array();
	//目录list
	protected $dirs = array();
	//名称空间分隔符
	protected $separator = '/';
	//获得名称空间映射表
	public function getNamespaces() {
		return $this->namespaces;
	}
	//获取目录列表
	public function getDirs() {
		return $this->dirs;
	}
	//注册名称空间
	public function registerNamespaces(array $namespaces) {
		$this->namespaces = array_merge($this->namespaces, $namespaces);
	}
	public function registerNamespace($namespace, $path) {
		if (is_array($path)) {
			if (!isset($this->namespaces[$namespace])) {$this->namespaces[$namespace] = array();
			}
			$this->namespaces[$namespace] = array_merge((array) $this->namespaces[$namespace], $path);
		} else {
			$this->namespaces[$namespace] = rtrim($path, '\\/');
		}
	}
	//注册目录列表
	public function registerDirs(array $dirs) {
		$this->dirs = array_unique(array_merge($this->dirs, $dirs));
	}
	//注册目录
	public function registerDir($dir, $path) {
		$this->dirs[$dir] = rtrim($path, '\\/');
	}
	//设置分隔符
	public function setSeparator($separator = '/') {
		$this->separator = $separator;
	}
	//类加载器注册
	public function register() {
		spl_autoload_register(array($this, 'loadClass'));
	}
	//类加载
	public function loadClass($class) {
		$class = str_replace(array('\\', '_'), $this->separator, $class);
		$parts = explode($this->separator, $class);
		$fnamespace = $parts[0];
		$path = implode($this->separator, $parts);
		$cname = array_pop($parts);
		if (strpos($class, $this->separator) !== false) {
			//根据名称空间搜索
			if (isset($this->namespaces[$fnamespace])) {
				if (is_array($this->namespaces[$fnamespace])) {
					foreach ($this->namespaces[$fnamespace] as $dir) {
						$file = $dir . '/' . $path . '.php';
						if (is_file($file)) {
							include $file;
							break;
						}
					}
				} else {
					if (file_exists($this->namespaces[$fnamespace] . '/' . $path . '.php')) {
						include $this->namespaces[$fnamespace] . '/' . $path . '.php';
					} else {
						include $this->namespaces[$fnamespace] . '/' . $path . '/' . $cname . '.php';
					}
				}
			}
		} else {
			//根据目录搜索
			foreach ($this->dirs as $dir) {
				$file = $dir . '/' . $path . '.php';//dir/class.php
				if (file_exists($file)) {
					include $file;
					break;
				} else {
						if (is_file($file)) {
							include $dir . '/' . $path . "/$cname.php";//dir/class/class.php
							break;
						}
				}
			}
		}
	}
	//函数库加载
	public function LoadFunc($namespace, $list) {
		$funcs = explode(',', $list);
		foreach ($funcs as $file) {
			include $this->namespaces[$namespace] . '/' . $namespace . '/' . $file . '.php';
		}
	}
}