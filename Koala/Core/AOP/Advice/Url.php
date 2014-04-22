<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Core\AOP\Advice;
use Core\AOP\AdviceContainer;
use Core\AOP\LazyAdviceException;
use View;
class Url{
	//解析url参数
	//例如 https://github.com/lunnlew/koala?cd=1&f=1|id/1/cs/1
	public function parseUrl(AdviceContainer $container){
		$params = $container->getParams();
		$query_str=$vars_str='';
		$vars = array();
		if(strpos($params['url'],'|')!==false)
			list($params['url'],$vars_str)=explode('|',$params['url']);

		if(strpos($params['url'],'?')!==false)
			list($params['url'],$query_str)=explode('?',$params['url']);

		$url_parts = parse_url($params['url']);
		//解析可能存在的查询串
		if($query_str!='')
			parse_str($query_str,$vars);
		//解析可能存在的变量串 如id/1/name/2
		if($vars_str!='')
			$vars=array_merge($vars,parse_varstr($vars_str));

		$url_parts['params'] = $vars;

		if(!isset($url_parts['scheme']))
			$url_parts['scheme'] = 'http';
		if(!isset($url_parts['host']))
			$url_parts['host'] = 'localhost';
		if(!isset($url_parts['path']))
			$url_parts['path'] = '';
		$container->setAdviceResult('url_parts',$url_parts);
	}
	//解析vars参数
	public function parseVar(AdviceContainer $container){
		$params = $container->getParams();
		//字符串查询串
		if(is_string($params['vars'])){
			parse_str($params['vars'],$url_params);
		}else{//索引数组
			$url_params = $params['vars'];
		}
		$container->setAdviceResult('url_params',$url_params);
	}
	//解析suffix逻辑
	public function parseSuffix(AdviceContainer $container){
		$params = $container->getParams();
		if($params['suffix']){
			$suffix = C('URL_HTML_SUFFIX','.html');
		}else{
			$suffix = '';
		}
		$container->setAdviceResult('url_suffix',$suffix);
	}
	//重定向行为
	public function redirect(AdviceContainer $container){
		$params = $container->getParams();
		if($params['redirect']){
			echo '重定向到'.$container->getRet();
		}
	}
}