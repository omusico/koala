<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Core\Front;
/**
 * 信息提示分类
 * 
 * @package  Koala
 * @author    LunnLew <lunnlew@gmail.com>
 */
class MessageState{
	/**
	 * 信息分类码常量
	 */
	//正常
	const COMMON = -2;
	//错误
	const ERROR = 0;
	//成功
	const SUCCESS = 1;
	//一般
	const INFO = -1;
	//数据
	const DATA = 2;
	//debug
	const DEBUG = 3;
}