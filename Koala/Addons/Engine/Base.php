<?php
class Engine_Base{
	/**
	 * 返回模板实例
	 * @param  array $option 参数
	 * @return object 	模板实例
	 */
	abstract public static function factory($option=array()){}
}