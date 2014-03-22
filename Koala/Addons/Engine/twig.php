<?php
class Engine_twig{
	//环境实例
	static $twig='';
	//默认选项
	static $option=array();
	//变量表
	static $vars = array();
	public static function factory($option){
		foreach ($option as $key => $value) {
			if(is_string($value)){
				preg_match_all('/(?<=\[)([^\]]*?)(?=\])/',$value, $res);
		        foreach ($res[0] as $v) {
		        	if(defined($v))
					$option[$key] = str_replace("[$v]",constant($v),$option[$key]);
		        }
		    }
		}
		$loader = new Twig_Loader_Filesystem($option['template_path']);
		unset($option['template_path']);
		if($option['cache']){
			$option['cache'] = $option['cache_path'];
			unset($option['cache_path']);
		}
		self::$twig = new Twig_Environment($loader,$option);
		return new static();
	}
	public function assign($key,$value){
		self::$vars[$key]=$value;
	}
	public function display($tpl){
		$template=self::$twig->loadTemplate($tpl);
		echo $template->render(self::$vars);
	}
	public function render($tpl,$vars=array()){
		self::$vars = array_merge(self::$vars,$vars);
		return self::$twig->render(self::$vars);
	}
	public function __call($method,$args){
		echo '尚未统一化方法支持,你可以直接使用原生代码。<br>';
	}
	public function test(){
		self::$twig->addTokenParser(new Tag_TokenParser_get());
	}
}