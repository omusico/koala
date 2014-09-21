<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Core\Plugin;
/**
 * 插件基类
 */
abstract class Base {
	/**
	 * 插件属性项
	 * @var array
	 */
	protected $attributes = array();
	/**
	 * 插件构造方法
	 * @param array $config 配置项
	 */
	public function __construct($config = array()) {
		$this->attributes = array_merge($this->attributes, $config);
	}
	/**
	 * 插件视图路径
	 * @final
	 * @param string $path 视图路径
	 */
	public function setTemplatePath($path = '') {}
	/**
	 * 设置插件主题名
	 * @final
	 * @param  string $theme 主题名
	 */
	public function setTheme($theme = 'default') {}
	/**
	 * 模板变量赋值
	 * @final
	 * @param  string $name  变量名
	 * @param  fixed $value 变量值
	 */
	public function assign($name, $value) {}
	/**
	 * 视图输出
	 * @final
	 * @param  string $template 模板文件名
	 */
	public function display($template = '') {}
	/**
	 * 模板渲染
	 * @final
	 * @param  string $template 模板文件名
	 * @return string           模板渲染结果
	 */
	public function render($template = '') {}
	/**
	 * 必须实现安装入口
	 *  @abstract
	 */
	//abstract public function install();
	/**
	 * 必须实现卸载入口
	 * @abstract
	 */
	//abstract public function uninstall();
}