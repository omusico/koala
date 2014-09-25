<?php
/**
 * $router = new Router;
 * $router->get(APP_RELATIVE_URL . 'manage.php?s=:m(/:a)', ['Controller', 'execute']);
 * $route = $router->dispatch($_SERVER['REQUEST_URI']);
 * print_r($route);
 */
class Controller {
	public function execute($m, $a) {
		print_r(func_get_args());
		exit;
	}
}