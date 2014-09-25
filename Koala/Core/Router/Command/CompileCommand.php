<?php
namespace Koala\Core\Router\Command;
use CLIFramework\Command;
use Koala\Core\Router\RouterCompiler;

class CompileCommand extends Command {
	public function brief() {return 'compile routes';}

	public function options($opts) {
		$opts->add('o:', 'output file');
	}

	public function execute() {
		$files      = func_get_args();
		$outputFile = $this->options->o ?  : '_router.php';

		$compiler = new RouterCompiler();

		foreach ($files as $file) {
			$compiler->load($file);
		}
		$compiler->compile($outputFile);
	}
}
