<?php
/**
 * URL处理类
 */
class URL{
	//URL各部分
	static $_items=array();
	//统一化不同环境的原始请求URL
	public static function standard($url=''){
		if($url!=''){
			self::$_items = parse_url($url);
			$path = self::$_items['path'];
			self::$_items['pathinfo'] = str_replace(str_replace('\\','/',APP_RELATIVE_URL),'',$path);
			unset(self::$_items['path']);
		}else{
			//请求协议
			list(self::$_items['scheme'])=explode('/', strtolower($_SERVER['SERVER_PROTOCOL']));
			//域名
			isset($_SERVER['HTTP_HOST']) AND (self::$_items['host'] = $_SERVER['HTTP_HOST']);
			//端口
			self::$_items['port'] = $_SERVER['SERVER_PORT'];
			//脚本文件名
			self::$_items['script'] = $_SERVER['SCRIPT_NAME'];
			//pathinfo路径
			if(isset($_SERVER['PATH_INFO'])){
				self::$_items['pathinfo'] = $_SERVER['PATH_INFO'];
				isset($_SERVER['QUERY_STRING']) AND (self::$_items['query_string'] = $_SERVER['QUERY_STRING']);
			}else{
				$part = explode('&',$_SERVER['QUERY_STRING']);
				self::$_items['pathinfo'] = array_shift($part);
				self::$_items['query_string'] = implode('&',$part);
			}
		}
		
	}
	public static function getUrl(){
		//规范URL
		return self::$_items['scheme']."://".
		self::$_items['host'].":".
		self::$_items['port'].self::$_items['script'].
		self::$_items['pathinfo']."?".self::$_items['query_string'];


	}

	/**
	 * 请求URL分析器
	 */
	public static function Parser($url='',$mode=''){
		self::standard($url);
		//获得当前URL模式
		if(!is_numeric($mode)){
			$mode = C('URLMODE',2);
		}
		switch ($mode) {
			case 1://使用普通url解析器//index.php?group=admin&module=index
				$option =self::ParserInCommon();
				break;
			case 3://兼容模式//index.php?s=Admin~Index~index
				$option =self::ParserInCompatible();
				break;
			case 2:
			default://默认使用PATHINFO解析模式//index.php/admin/index
				$option =self::ParserInPathinfo();
				break;
		}
		return $option;
	}
	//普通模式URL解析
	protected static function ParserInCommon(){
		//是否启用了多应用模式//默认单应用
		if(C('MULTIPLE_APP',0)){
			//如果在已有的应用列表中
			if(in_array($_REQUEST[C('VAR_APP','app')],C('APP:LIST',array('APP1')))){
				$app_name = $_paths[] = ucwords($_REQUEST[C('VAR_APP','app')]);
			}else{
				$app_name = $_paths[] = C('APP:DEFAULT','APP1');
			}
		}else{
			$app_name = basename(APP_RELATIVE_URL);
		}
		!defined('APP_NAME') AND define('APP_NAME',$app_name);
		//是否启用了多分组//默认多分组
		if(C('MULTIPLE_GROUP',1)){
			$group_name = $_paths[] = isset($_REQUEST[C('VAR_GROUP','g')])?ucfirst($_REQUEST[C('VAR_GROUP','g')]):C('GROUP:DEFAULT','Home');
			!defined('GROUP_NAME') AND define('GROUP_NAME',$group_name);
		}
		//模块
		$module_name = $_paths[] =  isset($_REQUEST[C('VAR_MODULE','m')])?ucfirst($_REQUEST[C('VAR_MODULE','m')]):ucfirst(C('MODULE:DEFAULT','Index'));

		!defined('MODULE_NAME') AND define('MODULE_NAME',$module_name);
		//action
		if(isset($_REQUEST[C('VAR_ACTION','a')])){
			$action_name = $_paths[] = $_REQUEST[C('VAR_ACTION','a')];
		}else{
			$action_name = $_paths[] = C('ACTION:DEFAULT','index');
		}
		!defined('ACTION_NAME') AND define('ACTION_NAME',$action_name);

		//参数进行合并
		$_params = $_REQUEST;
		//组装URL选项
		$_options = array('paths'=>$_paths,'params'=>$_params);
		return $_options;
	}
	//PATHINFO模式URL解析
	protected static function ParserInPathinfo(){
		$one = $two = $_params = array();
		$str = self::$_items['pathinfo'];
		if($suffix = C('URL_HTML_SUFFIX','.html')){
			if(stripos($str,$suffix)!==false)
				$str = str_replace($suffix,'', $str);
		}
		//获取pathinfo并去除空值
		$_paths = array_filter(explode(C('URL_PATHINFO_DEPR'),$str));

		self::ParserPaths($_paths,$result);

		//剩余参数
		if(!empty($_paths)){
			if(count($_paths)%2!=0){
				array_pop($_paths);
			}
			//组装参数
			foreach ($_paths as $key => $value) {
				if($key%2==0)
					$one[] = $value;
				else
					$two[] = $value;
			}
			$_params = array_combine($one,$two);
		}
		if(isset(self::$_items['query_string'])){
			parse_str(self::$_items['query_string'],$params);
			$_params = array_merge($_params,$params);
		}
		//组装URL选项
		$_options = array('paths'=>$result,'params'=>$_params);
		return $_options;
	}
	protected static function ParserInCompatible(){
		$one = $two = $_params = array();
		$str = self::$_items['pathinfo'];
		if($suffix = C('URL_HTML_SUFFIX','.html')){
			if(stripos($str,$suffix)!==false)
				$str = str_replace($suffix,'', $str);
		}
		parse_str($str,$param);
		if(isset($param[C('URL_VAR','s')]))
		$_paths = array_filter(explode(C('URL_PATHINFO_DEPR','/'),$param[C('URL_VAR','s')]));

		self::ParserPaths($_paths,$result);

		//剩余参数
		if(!empty($_paths)){
			if(count($_paths)%2!=0){
				array_pop($_paths);
			}
			//组装参数
			foreach ($_paths as $key => $value) {
				if($key%2==0)
					$one[] = $value;
				else
					$two[] = $value;
			}
			$_params = array_combine($one,$two);
		}
		if(isset(self::$_items['query_string'])){
			parse_str(self::$_items['query_string'],$params);
			$_params = array_merge($_params,$params);
		}
		//组装URL选项
		$_options = array('paths'=>$result,'params'=>$_params);
		return $_options;
	}
	/**
	 * 解析path 到 控制器 参数
	 * 
	 * @param array $paths path参数
	 * @access protected
	 */
	protected static function ParserPaths(&$paths=array(),&$result=array()){
		//是否启用了多应用模式//默认单应用
		if(C('MULTIPLE_APP',0)){
			//如果在已有的应用列表中
			if(in_array(current($paths),C('APP:LIST',array('APP1')))){
				$app_name = $result[] = ucwords(array_shift($paths));
			}else{
				$app_name = $result[] = C('APP:DEFAULT','APP1');
			}
			!defined('APP_NAME') AND define('APP_NAME',$app_name);
		}
		//是否启用了多分组//默认多分组
		if(C('MULTIPLE_GROUP',1)){
			//如果在已有的分组列表中
			if(is_array($paths)&&in_array(current($paths),C('GROUP:LIST',array('Home')))){
				$group_name = $result[] = ucfirst(array_shift($paths));
			}else{
				$group_name = $result[] = C('GROUP:DEFAULT','Home');
			}
			!defined('GROUP_NAME') AND define('GROUP_NAME',$group_name);
		}
		//模块
		if(empty($paths)){
			$module_name = $result[] = ucfirst(C('MODULE:DEFAULT','Index'));
		}else{
			$module_name = $result[] = ucfirst(array_shift($paths));
		}
		!defined('MODULE_NAME') AND define('MODULE_NAME',$module_name);
		//action
		if(empty($paths)){
			$action_name =$result[] =  C('ACTION:DEFAULT','index');
		}else{
			$action_name = $result[] = array_shift($paths);
		}
		!defined('ACTION_NAME') AND define('ACTION_NAME',$action_name);
	}
	/**
	 * URL组装 支持不同URL模式 // Assembler('BlogAdmin/Index/Index#top@localhost?id=1');
	 * @param string $url URL表达式，格式：'[分组/模块/操作#锚点@域名]?参数1=值1&参数2=值2...'
	 * @param string|array $vars 传入的参数，支持数组和字符串
	 * @param string $suffix 伪静态后缀，默认为true表示获取配置值
	 * @param boolean $redirect 是否跳转，如果设置为true则表示跳转到该URL地址
	 * @param boolean $domain 是否显示域名
	 * @return string
	 */
	public static function Assembler($url='',$vars='',$suffix=true,$redirect=false,$domain=false){
		switch (C('URLMODE',2)) {
			case 1://使用普通url组装器//index.php?group=admin&module=index
				//self::ParserInPathinfo($url);
				return self::AssemblerInCommon($url,$vars,$suffix,$redirect,$domain);
				break;
			case 3://兼容模式//index.php?s=Admin~Index~index
				//self::PreAssemblerInCompatible($url);
				return self::AssemblerInCompatible($url,$vars,$suffix,$redirect,$domain);
				break;
			case 2:
			default://默认使用PATHINFO组装器模式//index.php/admin/index
				//进行参数预处理
				//self::ParserInPathinfo($url);
				return self::AssemblerInPathinfo($url,$vars,$suffix,$redirect,$domain);
				break;
		}
	}
	protected static function AssemblerInCommon($url,$vars='',$suffix=true,$redirect=false,$domain=false){
		// 解析URL
		$info   =  parse_url($url);
		//开始组装
		//如果为空则默认为当前方法
		$url    =  !empty($info['path'])?$info['path']:ACTION_NAME;
	    if(isset($info['fragment'])) { // 解析锚点
	        $anchor =   $info['fragment'];
	        if(false !== strpos($anchor,'?')) { // 解析参数
	            list($anchor,$info['query']) = explode('?',$anchor,2);
	        }        
	        if(false !== strpos($anchor,'@')) { // 解析域名
	            list($anchor,$host)    =   explode('@',$anchor, 2);
	        }
	    }elseif(false !== strpos($url,'@')) { // 解析域名
	        list($url,$host)    =   explode('@',$info['path'], 2);
	    }
	    if(isset($host)) {
    		$domain = $host.(strpos($host,'.')?'':strstr(self::$_items['host'],'.'));
		}
	    // 解析参数// aaa=1&bbb=2 转换成数组
	    if(is_string($vars)) { parse_str($vars,$vars);}
	    if(isset($info['query'])) { // 解析地址里面参数 合并到vars
	        parse_str($info['query'],$params);
	        $vars = array_merge($params,$vars);
	    }
	    $depr = C('URL_PATHINFO_DEPR','/');
	    // 解析分组、模块和操作
        $url        =   trim($url,$depr);
        $var        =   array();
        $options = self::Parser($url,2);
        $vars = array_merge($vars,$options['params']);
        //是否启用了多应用模式
		if(C('MULTIPLE_APP',0)){
			$var[C('VAR_APP','app')] = array_shift($options['paths']);
		}
		//是否启用了多分组
		if(C('MULTIPLE_GROUP',1)){
			$var[C('VAR_GROUP','g')] = array_shift($options['paths']);
		}
		
        $var[C('VAR_MODULE','m')]       =   array_shift($options['paths']);
        $var[C('VAR_ACTION','a')]       =   array_shift($options['paths']);

		$url        =   SITE_RELATIVE_URL.'?'.http_build_query(array_reverse($var));
        if(!empty($vars)) {
            $vars   =   urldecode(http_build_query($vars));
            $url   .=   '&'.$vars;
        };
	    unset($options);
	    if(isset($anchor)){$url  .= '#'.$anchor;}

	    if($domain) {
	        $url   =  (is_ssl()?'https://':'http://').$domain.$url;
	    }
	    return $url;
	}
	protected static function AssemblerInPathinfo($url,$vars='',$suffix=true,$redirect=false,$domain=false){
		// 解析URL
		$info   =  parse_url($url);
		//开始组装
		//如果为空则默认为当前方法
		$url    =  !empty($info['path'])?$info['path']:ACTION_NAME;
	    if(isset($info['fragment'])) { // 解析锚点
	        $anchor =   $info['fragment'];
	        if(false !== strpos($anchor,'?')) { // 解析参数
	            list($anchor,$info['query']) = explode('?',$anchor,2);
	        }        
	        if(false !== strpos($anchor,'@')) { // 解析域名
	            list($anchor,$host)    =   explode('@',$anchor, 2);
	        }
	    }elseif(false !== strpos($url,'@')) { // 解析域名
	        list($url,$host)    =   explode('@',$info['path'], 2);
	    }
	    if(isset($host)) {
    		$domain = $host.(strpos($host,'.')?'':strstr(self::$_items['host'],'.'));
		}
	    // 解析参数// aaa=1&bbb=2 转换成数组
	    if(is_string($vars)) { parse_str($vars,$vars);}
	    if(isset($info['query'])) { // 解析地址里面参数 合并到vars
	        parse_str($info['query'],$params);
	        $vars = array_merge($params,$vars);
	    }
	    $depr = C('URL_PATHINFO_DEPR','/');
	    // 解析分组、模块和操作
        $url        =   trim($url,$depr);
        $var        =   array();
        $options = self::Parser($url);
        $vars = array_merge($vars,$options['params']);
        //是否启用了多应用模式
		if(C('MULTIPLE_APP',0)){
			$var[C('VAR_APP','app')] = array_shift($options['paths']);
		}
		//是否启用了多分组
		if(C('MULTIPLE_GROUP',1)){
			$var[C('VAR_GROUP','g')] = array_shift($options['paths']);
		}
		
        $var[C('VAR_MODULE','m')]       =   array_shift($options['paths']);
        $var[C('VAR_ACTION','a')]       =   array_shift($options['paths']);

        $url = rtrim(SITE_RELATIVE_URL,$depr).$depr.implode($depr,$var);

        $url = rtrim($url,$depr);
        if(!empty($vars)) { // 添加参数
            foreach ($vars as $var => $val){
                if('' !== trim($val))   $url .= $depr . $var . $depr . urlencode($val);
            }                
        }
    	if($suffix) {
            $suffix   =  $suffix===true?C('URL_HTML_SUFFIX','.html'):$suffix;
            if($pos = strpos($suffix, '|')){
                $suffix = substr($suffix, 0, $pos);
            }
            if($suffix && '/' != substr($url,-1)){
                $url  .=  '.'.ltrim($suffix,'.');
            }
        };
	    if(isset($anchor)){$url  .= '#'.$anchor;}
	    if($domain) {
	        $url   =  (is_ssl()?'https://':'http://').$domain.$url;
	    }
	    return $url;
	}
	protected static function AssemblerInCompatible($url,$vars='',$suffix=true,$redirect=false,$domain=false){
		// 解析URL
		$info   =  parse_url($url);
		//开始组装
		//如果为空则默认为当前方法
		$url    =  !empty($info['path'])?$info['path']:ACTION_NAME;
	    if(isset($info['fragment'])) { // 解析锚点
	        $anchor =   $info['fragment'];
	        if(false !== strpos($anchor,'?')) { // 解析参数
	            list($anchor,$info['query']) = explode('?',$anchor,2);
	        }        
	        if(false !== strpos($anchor,'@')) { // 解析域名
	            list($anchor,$host)    =   explode('@',$anchor, 2);
	        }
	    }elseif(false !== strpos($url,'@')) { // 解析域名
	        list($url,$host)    =   explode('@',$info['path'], 2);
	    }
	    if(isset($host)) {
    		$domain = $host.(strpos($host,'.')?'':strstr(self::$_items['host'],'.'));
		}
	    // 解析参数// aaa=1&bbb=2 转换成数组
	    if(is_string($vars)) { parse_str($vars,$vars);}
	    if(isset($info['query'])) { // 解析地址里面参数 合并到vars
	        parse_str($info['query'],$params);
	        $vars = array_merge($params,$vars);
	    }
	    $depr = C('URL_PATHINFO_DEPR','/');
	    // 解析分组、模块和操作
        $url        =   trim($url,$depr);
        $var        =   array();
        $options = self::Parser($url,2);
        $vars = array_merge($vars,$options['params']);
        //是否启用了多应用模式
		if(C('MULTIPLE_APP',0)){
			$var[C('VAR_APP','app')] = array_shift($options['paths']);
		}
		//是否启用了多分组
		if(C('MULTIPLE_GROUP',1)){
			$var[C('VAR_GROUP','g')] = array_shift($options['paths']);
		}
		
        $var[C('VAR_MODULE','m')]       =   array_shift($options['paths']);
        $var[C('VAR_ACTION','a')]       =   array_shift($options['paths']);

        $url = rtrim(SITE_RELATIVE_URL,$depr).$depr.'?'.C('URL_VAR','s').'='.implode($depr,$var);

        $url = rtrim($url,$depr);
        if(!empty($vars)) { // 添加参数
            foreach ($vars as $var => $val){
                if('' !== trim($val))   $url .= $depr . $var . $depr . urlencode($val);
            }                
        }
    	if($suffix) {
            $suffix   =  $suffix===true?C('URL_HTML_SUFFIX','.html'):$suffix;
            if($pos = strpos($suffix, '|')){
                $suffix = substr($suffix, 0, $pos);
            }
            if($suffix && '/' != substr($url,-1)){
                $url  .=  '.'.ltrim($suffix,'.');
            }
        };
	    if(isset($anchor)){$url  .= '#'.$anchor;}
	    if($domain) {
	        $url   =  (is_ssl()?'https://':'http://').$domain.$url;
	    }
	    return $url;
	}
}