<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Engine\Drive;
use Koala\Server\Engine\Base;
/**
 * Tengine引擎驱动
 * 
 * @package  Koala
 * @subpackage  Server\Engine\Drive
 * @author    LunnLew <lunnlew@gmail.com>
 */
final class Tengine extends Base{
	var $object = '';
	public function __construct($option=array()){}
	/**
	 * 注册变量
	 * @param  string $key
	 * @param  mixed $value
	 */
	public function assign($key,$value){}
	/**
	 * 模板输出
	 * @param  string $tpl 模板名
	 */
	public function display($tpl=''){}
	/**
	 * 返回模板
	 * @param  string $tpl 模板名
	 */
	public function fetch($tpl=''){}
}