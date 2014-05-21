<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Engine;
/**
 * 模板引擎接口
 * 
 * @package  Koala
 * @subpackage  Server\Engine
 * @author    LunnLew <lunnlew@gmail.com>
 */
interface Face{
	public function assign($key,$value);
	public function set($key,$value);
	public function get($key);
	public function render($tpl);
	public function display($tpl='');
}