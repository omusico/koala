<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Koala\Helper;
/**
 * 常用正则表达式串
 */
class Regular{
	/**
	 * 匹配中文
	 */
	const CHINESE = '/^[\u4e00-\u9fa5]+$/';
	/**
	 *匹配html标签
	 */
	const HTMLTAG = '/<(.*)>.*<\/\1>|<(.*)\/>/';
	/**
	 * 匹配用户名
	 * 字母开头,允许6-15个字符,允许字母数字下划线
	 */
	const USERNAME = '/^[a-zA-Z][a-zA-Z0-9_]{6,15}$/';
	/**
	 * 匹配一般词组
	 * 中文、英文、数字及下划线
	 */
	const PHRASE = '/^[\u4e00-\u9fa5_a-zA-Z0-9]+$/';
}