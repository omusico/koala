<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
/**
 * 控制器分发类
 * 
 * @package  Koala
 * @subpackage  Server
 * @author    Lunnlew <Lunnlew@gmail.com>
 */
namespace Server\Dispatcher\Drive;
use Core\AOP\AdviceContainer;
class Dispatcher{
	protected $options = array();
	/**
     * 执行分发
     * @param  Closure          $classClosure  获取控制器类
     * @param  Closure          $methodClosure 获取控制器方法
     * @param  AdviceContainer $Container     方面容器对象
     */
    public function execute(\Closure $classClosure,\Closure $methodClosure,AdviceContainer $Container){
        //获得控制器Aop对象
        $controller = \Core\AOP\Aop::getInstance($classClosure());
        //获得控制器方法
        $method = $methodClosure();
        try{
            if(!preg_match('/^[_A-Za-z](\w)*$/',$method)){
                // 非法操作
                throw new \ReflectionException();
            }
            $controller->{$method}();
        } catch (\ReflectionException $e) { 
            exit('方法异常');
        }
    }
}