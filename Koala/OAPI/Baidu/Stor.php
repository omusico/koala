<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Baidu;
use Koala\OAPI\Base;
include(__DIR__.'/Lib/func.php');
/**
 */
final class Stor extends Base{
	/**
	 * 构造函数
	 */
	final public function __construct(){
		parent::__construct();
		$this->cfg = include(__DIR__.'/Api/baidu.stor.php');
	}
	/**
	 * 魔术方法
	 * @param  string $method 方法名
	 * @param  array $args   方法参数
	 * @return mixed         返回值
	 */
	final public function __call($method,$args){
		//print_r(func_get_args());
		return '';
	}
}