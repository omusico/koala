<?php
class View extends Initial{
	static $engine = null;
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
		if(!empty($tpl)){
			list($action,$module,$group) =array_reverse(explode($depr,$tpl));
		}else{
			list($action,$module,$group) =array(ACTION_NAME,MODULE_NAME,GROUP_NAME);
		}
		if(empty($group)){$group=GROUP_NAME;}
		if(empty($module)){$module=MODULE_NAME;}
		if(empty($action)){$action=ACTION_NAME;}
		return $group.'/'.$module.'/page/'.$action.'.html';
	}
	public static function test(){
		return self::$engine->test();
	}
}