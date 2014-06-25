<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Engine\Drive;
use Koala\Server\Engine\Base;
/**
 * Smarty引擎驱动
 * 
 * @package  Koala
 * @subpackage  Server\Engine\Drive
 * @author    LunnLew <lunnlew@gmail.com>
 */
final class Smarty extends Base{
	var $object = '';
	public function __construct($option=array()){
		foreach ($option as $key => $value) {
			if(is_string($value)){
				preg_match_all('/(?<=\[)([^\]]*?)(?=\])/',$value, $res);
		        foreach ($res[0] as $v) {
		        	if(defined($v))
					$option[$key] = str_replace("[$v]",constant($v),$option[$key]);
		        }
		    }
		}
		$smarty =new \Smarty();
		if(isset($option['TemplateDir']))
			$smarty->addTemplateDir($option['TemplateDir'],0);
		if(isset($option['CompileDir']))
			$smarty->setCompileDir($option['CompileDir']);
		if(isset($option['PluginDir']))
			$smarty->addPluginsDir($option['PluginDir'],0);
		if(isset($option['ConfigDir']))
			$smarty->setConfigDir($option['ConfigDir'],0);
		if(isset($option['debugging']))
			$smarty->debugging = $option['debugging'];
		if(isset($option['caching'])){
			$smarty->caching = $option['caching'];
			$smarty->cache_dir = $option['CacheDir'];
		}
		else $smarty->caching = false;
		if(isset($option['cache_lifetime']))
			$smarty->cache_lifetime = $option['cache_lifetime'];
		if(isset($option['left_delimiter']))
			$smarty->left_delimiter = $option['left_delimiter'];
		if(isset($option['right_delimiter']))
			$smarty->right_delimiter = $option['right_delimiter'];
		if(isset($option['compile_locking']))
			$smarty->compile_locking = $option['compile_locking'];
		if(isset($option['plugins'])){
			if(isset($option['plugins']['function'])){
				foreach ($option['plugins']['function'] as $key => $value) {
					 $smarty->registerPlugin('function',$key,$value);
				}
			}
		}
		$this->object = $smarty;
	}
	/**
	 * 注册变量
	 * @param  string $key
	 * @param  mixed $value
	 */
	public function assign($key,$value){
		return $this->object->assign($key,$value);
	}
	/**
	 * 模板输出
	 * @param  string $tpl 模板名
	 */
	public function display($tpl=''){
		return $this->object->display($tpl);
	}
	/**
	 * 返回模板
	 * @param  string $tpl 模板名
	 */
	public function fetch($tpl=''){
		return $this->object->fetch($tpl);
	}
	/**
	 * 魔术方法
	 * @param  string $method 方法
	 * @param  array $args   参数
	 * @return mixed         返回值
	 */
	public function __call($method,$args){
		return call_user_func_array(array($this->object,$method),$args);
	}
}