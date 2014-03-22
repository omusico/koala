<?php
//URL请求解析和规范化类
class Request{
	//标准化后的URL
	static $_url='';
	//URL各部分
	static $_items=array();
	//url参数
	static $_params=array();
	//paths
	static $_paths = array();
	//option
	static $_options = array();
	//统一化不同环境的原始请求URL
	public static function standard(){
		//请求协议
		list(self::$_items['protocol'])=explode('/', strtolower($_SERVER['SERVER_PROTOCOL']));
		//域名
		isset($_SERVER['HTTP_HOST']) AND (self::$_items['host'] = $_SERVER['HTTP_HOST']);
		//端口
		self::$_items['port'] = $_SERVER['SERVER_PORT'];
		//脚本文件名
		self::$_items['script'] = $_SERVER['SCRIPT_NAME'];
		//pathinfo路径
		isset($_SERVER['PATH_INFO']) AND (self::$_items['pathinfo'] = $_SERVER['PATH_INFO']);
		//查询串
		isset($_SERVER['QUERY_STRING']) AND (self::$_items['query_string'] = $_SERVER['QUERY_STRING']);
	}
	public static function getUrl(){
		//规范URL
		return self::$_items['protocol']."://".
		self::$_items['host'].":".
		self::$_items['port'].self::$_items['script'].
		self::$_items['pathinfo']."?".self::$_items['query_string'];

	}
	//URL分析器
	public static function UrlParser(){
		//获得当前URL模式
		switch (C('URLMODE',1)) {
			case 1://使用普通url解析器//index.php?group=admin&module=index
				self::UrlParserInCommon();
				break;
			case 3://兼容模式//index.php?s=Admin~Index~index
				self::UrlParserInCompatible();
				break;
			case 2:
			default://默认使用PATHINFO解析模式//index.php/admin/index
				self::UrlParserInPathinfo(self::$_paths);
				break;
		}
	}
	//普通模式URL解析
	protected static function UrlParserInCommon(){
		//是否启用了多应用模式//默认单应用
		if(C('MULTIPLE_APP',0)){
			//如果在已有的应用列表中
			if(in_array($_REQUEST[C('VAR_APP','app')],C('APP:LIST',array('APP1')))){
				$app_name = self::$_paths[] = ucwords($_REQUEST[C('VAR_APP','app')]);
			}else{
				$app_name = self::$_paths[] = C('APP:DEFAULT','APP1');
			}
		}else{
			$app_name = basename(ROOT_RELPATH);
		}
		define('APP_NAME',$app_name);
		//是否启用了多分组//默认多分组
		if(C('MULTIPLE_GROUP',1)){
			$group_name = self::$_paths[] = isset($_REQUEST[C('VAR_GROUP','g')])?ucfirst($_REQUEST[C('VAR_GROUP','g')]):C('GROUP:DEFAULT','Home');
			define('GROUP_NAME',$group_name);
		}
		//模块
		$module_name = self::$_paths[] =  isset($_REQUEST[C('VAR_MODULE','m')])?ucfirst($_REQUEST[C('VAR_MODULE','m')]):ucfirst(C('MODULE:DEFAULT','Index'));

		define('MODULE_NAME',$module_name);
		//action
		if(isset($_REQUEST[C('VAR_ACTION','a')])){
			$action_name = self::$_paths[] = $_REQUEST[C('VAR_ACTION','a')];
		}else{
			$action_name = self::$_paths[] = C('ACTION:DEFAULT','index');
		}
		define('ACTION_NAME',$action_name);

		//参数进行合并
		self::$_params = array_merge(self::$_params,$_REQUEST);

		//组装URL选项
		self::$_options = array_merge(self::$_options,array('paths'=>self::$_paths,'params'=>self::$_params));

	}
	//PATHINFO模式URL解析
	protected static function UrlParserInPathinfo(&$result=array(),$str=''){
		if($str==''){
			$str = self::$_items['pathinfo'];
		}
		//获取pathinfo并去除空值
		$_paths = array_filter(explode(C('URL_PATHINFO_DEPR'),$str));
		//是否启用了多应用模式//默认单应用
		if(C('MULTIPLE_APP',0)){
			//如果在已有的应用列表中
			if(in_array(current($_paths),C('APP:LIST',array('APP1')))){
				$app_name = $result[] = ucwords(array_shift($_paths));
			}else{
				$app_name = $result[] = C('APP:DEFAULT','APP1');
			}
			define('APP_NAME',$app_name);
		}
		//是否启用了多分组//默认多分组
		if(C('MULTIPLE_GROUP',1)){
			//如果在已有的分组列表中
			if(in_array(current($_paths),C('GROUP:LIST',array('Home')))){
				$group_name = $result[] = ucfirst(array_shift($_paths));
			}else{
				$group_name = $result[] = C('GROUP:DEFAULT','Home');
			}
			define('GROUP_NAME',$group_name);
		}
		//模块
		if(empty($_paths)){
			$module_name = $result[] = ucfirst(C('MODULE:DEFAULT','Index'));
		}else{
			$module_name = $result[] = ucfirst(array_shift($_paths));
		}
		define('MODULE_NAME',$module_name);

		//action
		if(empty($_paths)){
			$action_name = $result[] = ucfirst(C('ACTION:DEFAULT','index'));
		}else{
			$action_name = $result[] = ucfirst(array_shift($_paths));
		}
		define('ACTION_NAME',$action_name);

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
			self::$_params = array_combine($one,$two);
		}
		//可能存在的?后的参数进行合并
		$queryParts = explode('&',self::$_items['query_string']);
		$params = array();
		foreach ($queryParts as $param){
			$item = explode('=', $param);
			$params[$item[0]] = $item[1];
		}
		self::$_params = array_merge(self::$_params,$params);

		//组装URL选项
		self::$_options = array_merge(self::$_options,array('paths'=>$result,'params'=>self::$_params));
	}
	public static function options(){
		if(empty(self::$_options))
			self::UrlParser();
		return self::$_options;
	}
	/**
	 * URL组装 支持不同URL模式 // UrlAssembler('BlogAdmin/Index/Index#top@localhost?id=1');
	 * @param string $url URL表达式，格式：'[分组/模块/操作#锚点@域名]?参数1=值1&参数2=值2...'
	 * @param string|array $vars 传入的参数，支持数组和字符串
	 * @param string $suffix 伪静态后缀，默认为true表示获取配置值
	 * @param boolean $redirect 是否跳转，如果设置为true则表示跳转到该URL地址
	 * @param boolean $domain 是否显示域名
	 * @return string
	 */
	public static function UrlAssembler($url='',$vars='',$suffix=true,$redirect=false,$domain=false){
		switch (C('URLMODE',1)) {
			case 1://使用普通url组装器//index.php?group=admin&module=index
				//self::UrlParserInPathinfo($url);
				return self::UrlAssemblerInCommon($url,$vars,$suffix,$redirect,$domain);
				break;
			case 3://兼容模式//index.php?s=Admin~Index~index
				//self::PreUrlAssemblerInCompatible($url);
				return self::UrlAssemblerInPathinfo($url,$vars,$suffix,$redirect,$domain);
				break;
			case 2:
			default://默认使用PATHINFO组装器模式//index.php/admin/index
				//进行参数预处理
				//self::UrlParserInPathinfo($url);
				self::UrlAssemblerInPathinfo($url,$vars,$suffix,$redirect,$domain);
				break;
		}
	}
	protected static function UrlAssemblerInCommon($url,$vars='',$suffix=true,$redirect=false,$domain=false){
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
    		$domain = $host.(strpos($host,'.')?'':strstr($_SERVER['HTTP_HOST'],'.'));
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
        self::UrlParserInPathinfo($result,$url);
        //是否启用了多应用模式
		if(C('MULTIPLE_APP',0)){
			$var[C('VAR_APP','app')] = array_shift($result);
		}
		//是否启用了多分组
		if(C('MULTIPLE_GROUP',1)){
			$var[C('VAR_GROUP','g')] = array_shift($result);
		}
		
        $var[C('VAR_MODULE','m')]       =   array_shift($result);
        $var[C('VAR_ACTION','a')]       =   array_shift($result);

		$url        =   ROOT_RELPATH.'?'.http_build_query(array_reverse($var));
        if(!empty($vars)) {
            $vars   =   urldecode(http_build_query($vars));
            $url   .=   '&'.$vars;
        };
        
	    unset($result);
	    if(isset($anchor)){$url  .= '#'.$anchor;}

	    if($domain) {
	        $url   =  (is_ssl()?'https://':'http://').$domain.$url;
	    }
	    return $url;
	}
	protected static function UrlAssemblerInPathinfo($url,$vars='',$suffix=true,$redirect=false,$domain=false){
		exit(__LINE__);
		$url    =   ROOT_RELPATH.
        $var[C('VAR_GROUP','g')].'/'.
        $var[C('VAR_MODULE','m')].'/'.
        $var[C('VAR_ACTION','a')].'/'.implode($depr,self::$_params);
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
	}
}