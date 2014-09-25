<?php
use Koala\Core\Router\Controller;
use Koala\Core\Router\PatternCompiler;
use Koala\Core\Router\RouteType;

define('REQUEST_METHOD_GET', 1);
define('REQUEST_METHOD_POST', 2);
define('REQUEST_METHOD_PUT', 3);
define('REQUEST_METHOD_DELETE', 4);
define('REQUEST_METHOD_PATCH', 5);
define('REQUEST_METHOD_HEAD', 6);
define('REQUEST_METHOD_OPTIONS', 7);

class Router {
	public $routes = array();

	public $staticRoutes = array();

	public $routesById = array();

	public $subrouter = array();

	public $id;

	/**
	 * When expand is enabled, all mounted Router will expand the routes to the parent router.
	 * This improves the dispatch performance when you have a lot of sub router to dispatch.
	 *
	 * When expand is enabled, the pattern comparison strategy for
	 * strings will match the full string.
	 *
	 * When expand is disabled, the pattern comparison strategy for
	 * strings will match the prefix.
	 */
	public $expand = true;

	public static $id_counter = 0;

	public static function generate_id() {
		return ++static::$id_counter;
	}

	public function getId() {
		if ($this->id) {
			return $this->id;
		}
		return $this->id = self::generate_id();
	}

	public function appendRoute($pattern, $callback, $options = array()) {
		$this->routes[] = array(RouteType::STATIC_ROUTE, $pattern, $callback, $options);
	}

	public function appendPCRERoute($routeArgs, $callback) {
		$this->routes[] = array(
			RouteType::PREG_ROUTE, // PCRE
			$routeArgs['compiled'],
			$callback,
			$routeArgs,
		);
	}

	public function mount($pattern, $router, $options = array()) {
		if ($router instanceof Controller) {
			$router = $router->expand();
		}

		if ($this->expand) {
			// rewrite subrouter routes
			foreach ($router->routes as $route) {
				switch ($route[0]) {
					case RouteType::PREG_ROUTE:
						$newPattern = $pattern . $route[3]['pattern'];
						$routeArgs  = PatternCompiler::compile($newPattern,
							array_merge_recursive($route[3], $options));
						$this->appendPCRERoute($routeArgs, $route[2]);
						break;
					case RouteType::STATIC_ROUTE:
					default:
						$this->routes[] = array(
							false,
							$pattern . $route[1],
							$route[2],
							isset($route[3]) ? array_merge($options, $route[3]) : $options,
						);
						break;
				}
			}
		} else {
			$routerId = $router->getId();
			$this->add($pattern, $routerId, $options);
			$this->subrouter[$routerId] = $router;
		}
	}

	public function delete($pattern, $callback, $options = array()) {
		$options['method'] = REQUEST_METHOD_DELETE;
		$this->add($pattern, $callback, $options);
	}

	public function put($pattern, $callback, $options = array()) {
		$options['method'] = REQUEST_METHOD_PUT;
		$this->add($pattern, $callback, $options);
	}

	public function get($pattern, $callback, $options = array()) {
		$options['method'] = REQUEST_METHOD_GET;
		$this->add($pattern, $callback, $options);
	}

	public function post($pattern, $callback, $options = array()) {
		$options['method'] = REQUEST_METHOD_POST;
		$this->add($pattern, $callback, $options);
	}

	public function patch($pattern, $callback, $options = array()) {
		$options['method'] = REQUEST_METHOD_PATCH;
		$this->add($pattern, $callback, $options);
	}

	public function head($pattern, $callback, $options = array()) {
		$options['method'] = REQUEST_METHOD_HEAD;
		$this->add($pattern, $callback, $options);
	}

	public function options($pattern, $callback, $options = array()) {
		$options['method'] = REQUEST_METHOD_OPTIONS;
		$this->add($pattern, $callback, $options);
	}

	public function any($pattern, $callback, $options = array()) {
		$this->add($pattern, $callback, $options);
	}

	public function add($pattern, $callback, $options = array()) {
		//class:method  to  array(class,method)
		if (is_string($callback) && strpos($callback, ':') !== false) {
			$callback = explode(':', $callback);
		}

		// compile place holder to patterns
		$pcre = strpos($pattern, ':') !== false;
		switch (true) {
			case strpos($pattern, ':') !== false:
				$routeArgs = PatternCompiler::compile($pattern, $options);

				// generate a pcre pattern route
				$route = array(
					RouteType::PREG_ROUTE, // PCRE
					$routeArgs['compiled'],
					$callback,
					$routeArgs,
				);
				if (isset($options['id'])) {
					$this->routesById[$options['id']] = $route;
				}
				return $this->routes[] = $route;
				break;

			default:
				$route = array(
					RouteType::STATIC_ROUTE,
					$pattern,
					$callback,
					$options,
				);
				if (isset($options['id'])) {
					$this->routesById[$options['id']] = $route;
				}
				// generate a simple string route.
				return $this->routes[] = $route;
				break;
		}
	}

	public function getRoute($id) {
		if (isset($this->routesById[$id])) {
			return $this->routesById[$id];
		}

	}

	public function sort() {
		usort($this->routes, array(&$this, 'sort_routes'));
	}

	public function sort_routes($a, $b) {
		if ($a[0] == RouteType::PREG_ROUTE && $b[0] == RouteType::PREG_ROUTE) {
			return strlen($a[3]['compiled']) > strlen($b[3]['compiled']);
		} elseif ($a[0] == RouteType::PREG_ROUTE) {
			return 1;
		} elseif ($b[0] == RouteType::PREG_ROUTE) {
			return -1;
		}
		if (strlen($a[1]) > strlen($b[1])) {
			return 1;
		} elseif (strlen($a[1]) == strlen($b[1])) {
			return 0;
		} else {
			return -1;
		}
	}

	public function compile($outFile, $sortBeforeCompile = true) {
		// compile routes to php file as a cache.
		if ($sortBeforeCompile) {
			$this->sort();
		}

		$code = '<?php return ' . $this->export() . ';';
		return file_put_contents($outFile, $code);
	}

	public function getSubRouter($id) {
		if (isset($this->subrouter[$id])) {
			return $this->subrouter[$id];
		}
	}

	public static function getRequestMethodConstant($method) {
		switch (strtoupper($method)) {
			case "POST":
				return REQUEST_METHOD_POST;
			case "GET":
				return REQUEST_METHOD_GET;
			case "PUT":
				return REQUEST_METHOD_PUT;
			case "DELETE":
				return REQUEST_METHOD_DELETE;
			case "PATCH":
				return REQUEST_METHOD_PATCH;
			case "HEAD":
				return REQUEST_METHOD_HEAD;
			case "OPTIONS":
				return REQUEST_METHOD_OPTIONS;
			default:
				return 0;
		}
	}

	public function match($path) {
		$reqmethod = self::getRequestMethodConstant(@$_SERVER['REQUEST_METHOD']);
		foreach ($this->routes as $route) {
			switch ($route[0]) {
				case RouteType::PREG_ROUTE:
					//匹配路径并提取参数
					if (!preg_match($route[1], $path, $regs)) {
						continue;
					}
					$route[3]['vars'] = $regs;
					//请求方法是否一致
					if (isset($route[3]['method']) && $route[3]['method'] != $reqmethod) {
						continue;
					}
					//域名是否一致
					if (isset($route[3]['domain']) && $route[3]['domain'] != $_SERVER["HTTP_HOST"]) {
						continue;
					}
					//https是否一致
					if (isset($route[3]['secure']) && $route[3]['secure'] && $_SERVER["HTTPS"]) {
						continue;
					}

					return $route;
					break;
				case RouteType::STATIC_ROUTE:
				default:
					// prefix match is used when expanding is not enabled.
					if ((is_int($route[2]) && strncmp($route[1], $path, strlen($route[1])) === 0) || $route[1] == $path) {
						//请求方法是否一致
						if (isset($route[3]['method']) && $route[3]['method'] != $reqmethod) {
							continue;
						}
						//域名是否一致
						if (isset($route[3]['domain']) && $route[3]['domain'] != $_SERVER["HTTP_HOST"]) {
							continue;
						}
						//https是否一致
						if (isset($route[3]['secure']) && $route[3]['secure'] && $_SERVER["HTTPS"]) {
							continue;
						}

						return $route;
					} else {
						continue;
					}
					break;
			}
		}
		//
		return false;
	}

	public function dispatch($path) {
		if ($route = $this->match($path)) {
			if (is_int($route[2])) {
				$subrouter = $this->subrouter[$route[2]];

				// sub-path and call subrouter to dispatch
				// for pcre pattern?
				switch ($route[0]) {
					case RouteType::PREG_ROUTE:
						$matchedString = $route[3]['vars'][0];
						return $subrouter->dispatch(substr($path, strlen($matchedString)));
						break;
					case RouteType::STATIC_ROUTE:
					default:
						$s = substr($path, strlen($route[1]));
						return $subrouter->dispatch(
							substr($path, strlen($route[1])) ?  : ''
						);
						break;
				}

			} else {
				return $route;
			}
		}
	}

	public function length() {
		return count($this->routes);
	}

	public function getRoutes() {
		return $this->routes;
	}

	public function setRoutes($routes) {
		$this->routes = $routes;
	}

	public function export() {
		return var_export($this, true);
	}

	public static function __set_state($array) {
		$router            = new self;
		$router->routes    = $array['routes'];
		$router->subrouter = $array['subrouter'];
		$router->expand    = $array['expand'];
		if (isset($array['routesById'])) {
			$router->routesById = $array['routesById'];
		}
		$router->id = $array['id'];
		return $router;
	}

}
