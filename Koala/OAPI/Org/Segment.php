<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Org;
use Koala\OAPI\Base;
/**
 * 矩网智慧 分词服务
 *http://www.vapsec.com/fenci/
 */
final class Segment extends Base{
	/**
	 * 构造函数
	 */
	final public function __construct(){
		parent::__construct();
		$this->cfg = include(__DIR__.'/Api/segment.php');
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
	 * 获取token
	 * @param  string $str [description]
	 * @return mixed
	 */
	final protected function _getToken($str=''){
		return md5(time());
	}
}