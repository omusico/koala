<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
/**
 * 插件控制器基类
 */
abstract class Addon{
	/**
	 * 插件属性项
	 * @var array
	 */
	protected $attributes = array();
	/**
	 * 插件构造方法
	 * @param array $config 配置项
	 */
	public function __construct($config=array()){
		$this->attributes = array_merge($this->attributes,$config);
	}
	/**
	 * 插件视图路径
	 * @final
	 * @param string $path 视图路径
	 */
	final protected function setTemplatePath($path=''){}
	/**
	 * 设置插件主题名
	 * @final
	 * @param  string $theme 主题名
	 */
	final protected function setTheme($theme='default'){}
	/**
	 * 模板变量赋值
	 * @final
	 * @param  string $name  变量名
	 * @param  fixed $value 变量值
	 */
	final protected function assign($name,$value){}
	/**
	 * 视图输出
	 * @final
	 * @param  string $template 模板文件名
	 */
	final protected function display($template=''){}
	/**
	 * 模板渲染
	 * @final
	 * @param  string $template 模板文件名
	 * @return string           模板渲染结果
	 */
	final protected function fetch($template=''){}
	/**
	 * 必须实现安装入口
	 *  @abstract
	 */
    abstract public function install();
    /**
     * 必须实现卸载入口
     * @abstract
     */
    abstract public function uninstall();
}