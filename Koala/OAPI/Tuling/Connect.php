<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Tuling;
use Koala\OAPI\Base;
/**
 *图灵机器人
 *http://www.tuling123.com/
 */
final class Connect extends Base{
	/**
	 * 构造函数
	 */
	final public function __construct(){
		parent::__construct();
		$this->cfg = include(__DIR__.'/Api/tuling.php');
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
	/**
	 * 获取key
	 * @param  string $str [description]
	 * @return mixed
	 */
	final protected function _getAppKey($str=''){
		exit('[TODO]'.__METHOD__);
		return  '';
	}
}