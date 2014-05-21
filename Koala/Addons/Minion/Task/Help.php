<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Minion\Task;
/**
 * Help-Information for help
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
class Help extends \Koala\Core\Task{
	/**
	 * Generates a help list for all tasks
	 *
	 * @return null
	 */
	protected function _execute(array $params){
		print_r($params);exit;
		//$tasks = $this->_compile_task_list(Kohana::list_files('classes/Task'));

		//$view = new View('minion/help/list');

		//$view->tasks = $tasks;

		//echo $view;
	}
}
