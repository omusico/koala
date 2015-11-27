<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Core\Request;

/**
 * http请求结构
 */
class Structure{
	//请求行
	var $Line;
	//请求头
	var $Headers;
	//请求正文
	var $Body;
}