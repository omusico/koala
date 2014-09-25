<?php
namespace Koala\Core\Router;
use Koala\Core\Router\Router;
use ReflectionClass;

class RouterCompiler {
	public $router;

	public $idCounter;

	public $callbackValidation = false;

	public function __construct() {
		$this->idCounter = 0;
		$this->router    = new Router;
	}

	public function get() {
		return $this->router;
	}

	public function set($router) {
		$this->router = $router;
	}

	public function merge($router) {
		$routes = $router->getRoutes();
		if ($this->callbackValidation) {
			$this->validateRouteCallback($routes);
		}
		foreach ($routes as $route) {
			if (is_int($route[2])) {
				// rewrite subrouter id
				$subrouter                       = $router->getSubRouter($route[2]);
				$newId                           = ++$this->idCounter;
				$route[2]                        = $newId;
				$this->router->subrouter[$newId] = $subrouter;
			}
			$this->router->routes[] = $route;
		}
		return true;
	}

	static public function sort_routes($a, $b) {
		if ($a[0] == RouteType::PREG_ROUTE && $b[0] == RouteType::PREG_ROUTE) {
			$a_len = strlen($a[3]['compiled']);
			$b_len = strlen($b[3]['compiled']);
			if ($a_len == $b_len) {
				return 0;
			} elseif ($a_len > $b_len) {
				return -1;
			} else {
				return 1;
			}
		} elseif ($a[0] == RouteType::PREG_ROUTE) {
			return -1;
		} elseif ($b[0] == RouteType::PREG_ROUTE) {
			return 1;
		}
		if (strlen($a[1]) > strlen($b[1])) {
			return -1;
		} elseif (strlen($a[1]) == strlen($b[1])) {
			return 0;
		} else {
			return 1;
		}
	}

	/**
	 * @param string $routeFile routeFile, return the Router
	 */
	public function load($routerFile) {
		$router = require $routerFile;
		return $this->merge($router);
	}

	/**
	 * validate controller classes and controller methods before compiling to
	 * route cache.
	 */
	public function validateRouteCallback($routes) {
		foreach ($routes as $route) {
			$callback = $route[2];
			if (is_array($callback)) {
				$class  = $callback[0];
				$method = $callback[1];
				if (!class_exists($class, true)) {
					throw new Exception("Controller {$class} does not exist.");
				}
				// rebless a controller (extract this to common method)
				$controller = new $class;
				if (!method_exists($controller, $method)) {
					throw new Exception("Method $method not found in controller $class.");
				}
			}
		}
	}

	public function compileReflectionParameters() {
		foreach ($this->router->routes as $route) {
			$callback             = $route[2];
			list($class, $method) = $callback;

			$refClass      = new ReflectionClass($class);
			$refMethod     = $refClass->getMethod($method);
			$refParameters = $refMethod->getParameters();

			// HHVM does not support Reflection currently.
			if (!defined('HHVM_VERSION')) {
				// when __reflection is defined, we re-use the reflection info.
				$route[3]['__reflection'] = array();
				foreach ($refParameters as $refParam) {
					// ReflectionParameter
					$param = array(
						'name'     => $refParam->getName(),
						'position' => $refParam->getPosition(),
					);
					if ($refParam->isDefaultValueAvailable()) {
						$param['default'] = $refParam->getDefaultValue();
						if ($refParam->isDefaultValueConstant()) {
							$param['constant'] = $refParam->getDefaultValueConstantName();
						}
					}
					if ($optional = $refParam->isOptional()) {
						$param['optional'] = $optional;
					}
					$route[3]['__reflection']['params'][] = $param;
				}
			}
		}
	}

	/**
	 * Compile merged routes to file.
	 */
	public function compile($outFile) {
		// compile routes to php file as a cache.
		usort($this->router->routes, ['Router\\RouterCompiler', 'sort_routes']);

		$code = $this->router->export();
		return file_put_contents($outFile, "<?php return " . $code . "; /* version */");
	}
}
