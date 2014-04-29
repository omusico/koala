<?php
class View extends Initial{
	static $engine = null;
	static $options = array();
	//设置视图引擎
	public function setEngine($type,$option){
		$class = 'Engine_'.$type;
		self::$engine = $class::factory($option);
	}
	/**
	 * 注册变量
	 * @param  string $key
	 * @param  mixed $value
	 */
	public static function assign($key,$value){
		return self::$engine->assign($key,$value);
	}
	/**
	 * 模板输出
	 * @param  string $tpl 模板名
	 */
	public static function display($tpl='',$rec=false){
		return self::$engine->display(self::getTemplateName($tpl,$rec));
	}
	/**
	 * 返回模板
	 * @param  string $tpl 模板名
	 */
	public static function fetch($tpl='',$rec=false){
		return self::$engine->fetch(self::getTemplateName($tpl,$rec));
	}
	/**
	 * 设置请求行为
	 * @param array $options 请求行为参数
	 */
	public static function setTemplateOptions($options=array()){
		self::$options = $options;
	}
	/**
	 * 获得模板文件名
	 * @param  string  $tpl  模板名
	 * @param  boolean $rec  是否原样返回
	 * @param  string  $depr 分隔符
	 * @return string        模板文件完整名
	 */
	protected static function getTemplateName($tpl='',$rec=false,$depr='/'){
		if($rec){
			return $tpl;
		}
		if(empty(self::$options)){
			exit('[View]未设置请求参数');
		}
		if(!empty($tpl)){
			list($a[],$type,$a[],$a[]) =array_reverse(explode($depr,$tpl));
		}else{
			list($a[],$a[],$a[]) =array_reverse(self::$options);
		}
		$a = array_filter($a);
		if(!in_array($type,array('content','page','widget')))
			$type='page';
		$end = '/'.$type.'/'.array_pop($a);
		return implode($depr,$a).$end.'.html';
	}
	public static function test(){
		return self::$engine->test();
	}
	public static function get($name){
		return self::$engine->getTemplateVars($name);
	}
	public static function error($msg){
		self::assign('error',$msg);
		self::display(C('TMPL_ACTION_ERROR'));
		exit;
	}
	public static function success($msg){
		self::assign('message',$msg);
		self::display(C('TMPL_ACTION_SUCCESS'));
		exit;
	}
}