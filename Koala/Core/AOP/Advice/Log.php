<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Core\AOP\Advice;
use Core\AOP\AdviceContainer;
/**
 * 日志记录类
 */
class Log{
	function before(AdviceContainer $container){
		echo 'log<br>';
	}
}