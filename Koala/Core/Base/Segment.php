<?php
defined('IN_Koala') or exit();
/**
 * 
 *分词服务抽象类
 *
 */
abstract class Base_Segment{
	/**
	 * 开始分词过程
	 * @param string $str 要分词的字符串
	 */
	abstract public function Start($str);
}
?>