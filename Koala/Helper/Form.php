<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Helper;
/**
 * 表单生成器
 *
 */
/*
$f = new \Helper\Form();
$f->setForm(
array(
'action'=>'index.php',
'method'=>'post'
)
);
$f->addElement('input',array(
'id'=>'name',
'name'=>'name',
'class'=>'text add',
'value'=>'输入框',
));
$f->addElement('select',array(
'id'=>'name',
'name'=>'name',
'content'=>array(
'选项一'=>1,
'选项二'=>2,
'选项三'=>3
)
));
$f->addElement('textarea',array(
'id'=>'namse',
'name'=>'nasme',
'content'=>'sas'
));
$f->addElement('button',array(
'id'=>'namse',
'name'=>'nasme',
'content'=>'提交'
));
$f->addElement('input',array(
'id'=>'namse',
'name'=>'nasme',
'type'=>'submit',
'value'=>'提交'
));
echo $f->renderForm();
 */
class Form {
	/**
	 * 表单元素
	 * @var array
	 */
	private $elements = array();
	/**
	 * 表单属性串
	 */
	private $form_attr = '';
	/**
	 * 处理模板
	 * @var array
	 */
	protected $template = array(
		'form' => '<form %s>[FORM]</form>',
		'input' => '<input %s>',
		'select' => '<select %s> %s</select>',
		'textarea' => '<textarea %s> %s</textarea>',
		'button' => '<button %s> %s</button>',
		'option' => '<option value="%s">%s</option>',
	);
	/**
	 * 构造函数
	 * @param string $template 模板
	 */
	public function __construct($template = '') {
		if (!empty($template)) {
			$this->template = array_merge($this->template, $template);
		}
	}
	/**
	 * 设置表单属性
	 * @param array $attributes 元素属性
	 */
	public function setForm($attributes = array()) {
		$this->form_attr = $this->buildAttributes('form', $attributes);
	}
	/**
	 * 添加表单元素
	 * @param string $element    元素项
	 * @param array  $attributes 元素属性
	 */
	public function addElement($element, $attributes = array()) {
		$this->elements[] = array($element, $attributes);
		return $this;
	}
	/**
	 * 生成Element文本
	 * @param $template 模板
	 * @param $container 容器
	 * @return string 表单文本
	 */
	public function renderElement($container = '%s', $template = '') {
		if (!empty($template)) {
			$this->template = array_merge($this->template, $template);
		}
		$html = '';
		foreach ($this->elements as $key => $element) {
			$html .= $this->buildAttributes($element[0], $element[1]);
		}
		unset($this->elements);
		return sprintf($container, $html);
	}
	/**
	 * 生成表单文本
	 * @param $html 文本
	 * @return string 表单文本
	 */
	public function renderForm($html = '') {
		if ($html === '') {
			$html = $this->renderElement();
		}
		return str_replace('[FORM]', $html, $this->form_attr);
	}
	public function __toString() {
		return $this->renderForm($this->renderElement());
	}
	/**
	 * 组装属性项
	 * @param  string $element    元素项
	 * @param  array  $attributes 属性数组
	 * @return string
	 */
	private function buildAttributes($element, $attributes = array()) {
		$content_html = '';
		if (isset($attributes['content'])) {
			$content_html = $this->buildContent($attributes['content']);
			unset($attributes['content']);
		}
		$attributes_html = '';
		foreach ($attributes as $key => $value) {
			$attributes_html .= ' ' . $key . '="' . $value . '"';
		}
		return call_user_func_array('sprintf', array($this->template[$element], $attributes_html, $content_html));
	}
	/**
	 * 组装选项
	 * @param  array/string  $content 选项值数组/文本
	 * @return string
	 */
	private function buildContent($content) {
		$str_options = $params = array();
		if (is_array($content)) {
			foreach ($content as $name => $val) {
				$params[] = $val;
				$params[] = $name;
			}
			$params = array_reverse($params);
			$params[] = str_repeat($this->template['option'], count($content));
		} else {
			$params[] = $content;
		}
		return call_user_func_array('sprintf', array_reverse($params));
	}
}