<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
use Core\AOP\AdviceContainer;

class URL{
	/**
	 * 获取本次请求url参数
	 * @param  string          $url
	 * @param  boolean         $overwite  是否用默认值覆写
	 * @param  AdviceContainer $container 
	 * @return array
	 */
	public function requestOption($url='',$overwite=true,AdviceContainer $container){
		if(strpos($url,C('URL_HTML_SUFFIX','.html'))!==false)
			$url = substr($url,0,strpos($url,C('URL_HTML_SUFFIX','.html')));
		switch (C('URLMODE',2)) {
			case 1://普通模式
				$url_parts = parse_url($url);
				if(!isset($url_parts['path']))$url_parts['path']='';
				$url_parts['path'] = trim($url_parts['path'],'/');
				$paths = array_filter(explode('/',$url_parts['path']));
				$parts = $this->parserPaths($paths,$overwite);
				break;
			case 3://兼容模式
				$url_parts = parse_url($url);
				$url_parts['path'] = '';
				if(isset($url_parts['query'])){
					parse_str($url_parts['query'],$vars);
					$url_parts['path'] = $vars[C('URL_VAR','s')];
				}
				$url_parts['path'] = trim($url_parts['path'],C('URL_PATHINFO_DEPR','/'));
				$paths = array_filter(explode(C('URL_PATHINFO_DEPR','/'),$url_parts['path']));
				$parts = $this->parserPaths($paths,$overwite);
				
				break;
			case 2:
			default:
				//默认使用PATHINFO模式
				$url_parts['path'] = trim($url,C('URL_PATHINFO_DEPR','/'));
				$paths = array_filter(explode(C('URL_PATHINFO_DEPR','/'),$url_parts['path']));
				$parts = $this->parserPaths($paths,$overwite);
				break;
		}
		$url_parts['path'] = array_slice($parts,0,3);
		$url_parts['params'] = parse_varstr(implode('/',array_slice($parts,3)));
		if(!empty($url_parts['params'])){
			$_GET=array_merge($_GET,$url_parts['params']);
			$_POST=array_merge($_POST,$url_parts['params']);
			$_REQUEST=array_merge($_REQUEST,$url_parts['params']);
		}
		return $url_parts;
	}
	/**
	 * URL组装
	 * @param string $url URL表达式，格式：'[分组/模块/操作]?param1=val1&?param2=val2|param3/val3'
	 * @param string|array $vars 传入的参数，支持数组和字符串
	 * @param string $suffix 伪静态后缀，默认为true表示获取配置值
	 * @param boolean $redirect 是否跳转，如果设置为true则表示跳转到该URL地址
	 * @param boolean $overwite 是否用默认值覆写
	 * @return string
	 */
	public function Assembler($url='',$vars='',$suffix=true,$redirect=false,$overwite=false,AdviceContainer $container){

		$url_parts = $container->getAdviceResult('Core\AOP\Advice\Url.url_parts');
		$url_params = $url_parts['params'];unset($url_parts['params']);
		$url_params = array_merge($url_params,$container->getAdviceResult('Core\AOP\Advice\Url.url_params'));
		$url_suffix = $container->getAdviceResult('Core\AOP\Advice\Url.url_suffix');
		$url_parts['path'] = trim($url_parts['path'],'/');
		$paths = array_filter(explode('/',$url_parts['path']));
		$url_parts['path'] = $this->parserPaths($paths,$overwite);

		$url = '';
		$baseurl = rtrim(APP_RELATIVE_URL,'/').'/';
		if(C('MULTIPLE_ENTRY',0)){
			$baseurl .= basename($_SERVER["SCRIPT_NAME"]);
		}
		switch (C('URLMODE',2)) {
			case 1://使用普通url组装器//index.php?group=admin&module=index
				list($url_params[C('VAR_GROUP','g')],$url_params[C('VAR_MODULE','m')],$url_params[C('VAR_ACTION','a')]) = $url_parts['path'];
				$url=$baseurl.'?'.http_build_query(array_reverse($url_params));
				break;
			case 3://兼容模式//index.php?s=Admin-Index-index-id-1.html
				$depr = C('URL_PATHINFO_DEPR','/');
				$url = $baseurl.'?'.C('URL_VAR','s').'='.implode($depr,$url_parts['path']);
				foreach ($url_params as $var => $val){
                	$url .= $depr . $var . $depr . urlencode($val);
            	}   
				break;
			case 2:
			default:
				//默认使用PATHINFO组装器模式
				//允许多入口
				//index.php/admin/index
				//other.php/admin/index
				//
				$depr = C('URL_PATHINFO_DEPR','/');
				$url = $baseurl.implode($depr,$url_parts['path']);
				foreach ($url_params as $var => $val){
                	$url .= $depr . $var . $depr . urlencode($val);
            	}   
				break;
		}
		//组装
		return $url.$url_suffix;
	}
	/**
	 * 解析paths
	 * 
	 * @param array $paths path参数
	 * @param bool  $overwite 是否用默认值覆写
	 * @access protected
	 * @return array $result 结果
	 */
	protected function parserPaths(&$paths=array(),$overwite=false){
		//处理计数
		$num=0;
		//是否启用了多应用模式//默认单应用
		if(C('MULTIPLE_APP',0)){
			//如果不在已有的应用列表中
			if(!in_array(ucwords(current($paths)),C('APP:LIST',array('APP1')))){
				//是否用默认值
				if($overwite){
					//插入头
					array_unshift($paths,C('APP:DEFAULT','APP1'));
					++$num;
				}
					
			}
		}
		//是否启用了多分组//默认多分组
		if(C('MULTIPLE_GROUP',1)){
			//如果不在已有的分组列表中
			if(!in_array(ucwords($paths[$num]),C('GROUP:LIST',array('Home')))){
				//是否用默认值
				if($overwite){
					array_splice($paths,$num,0,array(C('GROUP:DEFAULT','Home')));
					++$num;
				}
			}else{
				$paths[$num] = ucwords($paths[$num]);
				++$num;
			}
		}
		if(!isset($paths[$num])){
			//模块//是否用默认值
			if($overwite){
				array_splice($paths,$num,0,array(C('MODULE:DEFAULT','Home')));
				++$num;
			}
		}else{
			$paths[$num] = ucwords($paths[$num]);
			++$num;
		}
		if(!isset($paths[$num]))
		//方法//是否用默认值
		if($overwite){
			array_splice($paths,$num,0,array(C('ACTION:DEFAULT','index')));
			++$num;
		}
		return $paths;
	}
}