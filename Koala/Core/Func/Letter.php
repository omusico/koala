<?php
defined('IN_Koala') or exit();
//单字母函数库
//
function A($class){
    return new $class();
}
function C($key,$defv=''){
    return Config::getItem($key,$defv);
}
/**
 * URL组装 支持不同URL模式 // U('BlogAdmin/Index/Index#top@localhost?id=1');
 * @param string $url URL表达式，格式：'[分组/模块/操作#锚点@域名]?参数1=值1&参数2=值2...'
 * @param string|array $vars 传入的参数，支持数组和字符串
 * @param string $suffix 伪静态后缀，默认为true表示获取配置值
 * @param boolean $redirect 是否跳转，如果设置为true则表示跳转到该URL地址
 * @param boolean $domain 是否显示域名
 * @return string
 */
function U($url='',$vars='',$suffix=true,$redirect=false,$domain=false){
    return Request::UrlAssembler($url,$vars,$suffix,$redirect,$domain);
}
function PU(){
	$args = func_get_args();
	$param[] = array_shift($args);
	if(count($args)%2!=0){
		array_pop($args);
	}
	foreach ($args as $key => $value) {
		if($key%2==0)
			$one[] = $value;
		else
			$two[] = $value;
	}
	$param = array_merge($param,array(array_combine($one,$two)));
	return call_user_func_array('U',$param);
}
function cats(){
    $args = func_get_args();
    $depr = array_shift($args);
    return implode($depr,$args);
}
function L($item){
	$item = strtoupper($item);
    $LANG = include(LANG_PATH.'/main.php');
    return isset($LANG[$item])?$LANG[$item]:$item;
}
?>