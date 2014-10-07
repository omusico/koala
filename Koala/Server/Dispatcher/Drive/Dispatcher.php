<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 控制器分发类
 *
 * @package  Koala
 * @subpackage  Server
 * @author    LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Dispatcher\Drive;

class Dispatcher {
	protected $options = array();
	/**
	 * 执行分发
	 * @param  Closure          $classClosure  获取控制器类
	 * @param  Closure          $methodClosure 获取控制器方法
	 */
	public function execute($class, $method) {
		//获得控制器Aop对象
		$controller = new $class;
		try {
			if (!preg_match('/^[_A-Za-z](\w)*$/', $method)) {
				// 非法操作
				throw new \ReflectionException();
			}
			$controller->{ $method}();
		} catch (\ReflectionException $e) {
			exit('方法异常');
		}
	}
}