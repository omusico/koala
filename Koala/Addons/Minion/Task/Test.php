<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Minion\Task;
/**
 * Test
 * 
 * Information for help
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
class Test extends \Koala\Core\Task{
	/**
	 * Generates a help list for all tasks
	 *
	 * @return null
	 */
	protected function _execute(array $params){

	}
	protected function _help(array $params){
		echo 'help';exit;
		//$tasks = $this->_compile_task_list(Kohana::list_files('classes/Task'));

		//$view = new View('minion/help/list');

		//$view->tasks = $tasks;

		//echo $view;
	}
}
