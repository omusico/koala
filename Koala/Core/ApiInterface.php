<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * Api工厂接口
 *
 * @package  Koala
 * @subpackage  Server
 * @author    LunnLew <lunnlew@gmail.com>
 */
interface ApiInterface {
	/**
	 * 获取服务类名 $prex.$classify.$name
	 * @param  string $classify 分类
	 * @param  string $name 类文件名
	 * @param  string $prex 类名prex
	 * @static
	 * @return string       Api驱动类名
	 */
	public static function getApiName($classify, $name ,$prex='Koala');
}