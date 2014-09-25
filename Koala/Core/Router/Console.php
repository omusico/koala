<?php
namespace Koala\Core\Router;
use CLIFramework\Application;

class Console extends Application {
	const NAME    = 'phpux';
	const VERSION = "1.5.1";

	public function init() {
		parent::init();
		$this->registerCommand('compile');
	}

	public function brief() {
		return 'Router - High Performance PHP Router.';
	}
}
