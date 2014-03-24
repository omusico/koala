<?php
//+++++++++++++运行模式及环境检查++++++++++++
//-------------------信息注册--------------
//php运行版本
env::reg('PHPVERSION',function($key){return PHP_VERSION;});
//php运行环境
env::reg('ISCLI',function($key){
	$is_cli = false;
	if(stripos(php_sapi_name(),'cli')!==false){$is_cli = true;}
	//cli模式下,$_SERVER['OS']有效
	if($is_cli&&stripos($_SERVER['OS'],'Win')!==false){
		define('CONSOLE_CHARSET','GBK');
	}else{
		define('CONSOLE_CHARSET','UTF-8');
	}
	define("RUNCLI",$is_cli);
	return RUNCLI;
});
//应用引擎环境
env::reg('APPENGINE',function($key){
	//新浪SAE检测
	if(defined('SAE_ACCESSKEY')){
		define("APPENGINE","SAE");
	}elseif(isset($_SERVER['HTTP_BAE_ENV_APPID'])){//BAE检测
		define("APPENGINE","BAE");
	}else{//本地应用环境
	    define("APPENGINE","LAE");
	}
	return APPENGINE;
});
//应用绝对路径
env::reg('ABSOLUTETDIR',function($key){
	return realpath('.');
});
//应用相对目录路径
env::reg('RELATIVEDIR',function($key){
	if(RUNCLI)//cli $_SERVER['SERVER_NAME'] 无效
	return;
	$pathname = str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']),'', str_replace('\\', '/',ROOT_PATH));
	//站点
	define('SITE_URL','http://'.$_SERVER['SERVER_NAME'].$pathname);
	define('ROOT_RELPATH',$pathname);
	//应用目录名,以服务器根目录到应用首页所在目录的相对目录。
	$pathname .= str_replace(ROOT_PATH,'',APP_PATH);
	if(APPENGINE=='BAE'){//BAE $_SERVER['DOCUMENT_ROOT'] 与 ROOT_PATH 不在同一路径分支。
		$pathname = basename($pathname).DIRECTORY_SEPARATOR;
	}
	//应用
	define('APP_URL','http://'.$_SERVER['SERVER_NAME'].$pathname);
	return $pathname;
});

//php最低版本
env::reg('MINPHPVERSION',function($key){return "5.3";});
env::reg("DEBUG",function($key){
		return DEBUG;
	});
//--------------------信息检查---------------------
env::check("PHPVERSION",function($value,$key){
	if(version_compare($value,env::get("MIN".$key),"<")){
		echo '当前PHP运行版本['.$value."]低于最低需求版本[".env::get("MIN".$key)."]";
		exit;
	}
	if(version_compare($value,"4.2.3","<=")){
		//register_globals设置关闭
		env::check("register_globals",function($key){
			ini_set($key, 0);
		});
	}
});
//调试模式的全局设置
env::check("DEBUG",function($key){
	//调试模式显示所有错误信息
	if(DEBUG){
		ini_set("display_errors","On");
	}else{
		//关掉错误提示
		error_reporting(0);
		ini_set("display_errors","Off");
	}
	
});

/**
 * 环境信息
 */
class env{
    static $items = array();
    /**
     * 环境信息注册
     * @param  string  $key   项
     * @param  Closure $check 闭包
     */
    public static function reg($key,Closure $check){
        $value = $check($key);
        if(!empty($value)){
            static::$items[$key] = $value;
        }
    }
    /**
     * 检查
     * @param  string $key   项
     * @param  Closure $check 闭包
     */
    public static function check($key,Closure $check=null){
        if(isset(static::$items[$key])){
            return $check(static::$items[$key],$key);
        }
        return $check($key);
    }
    /**
     * 获取
     * @param  string $key   项
     * @param  Closure $check 闭包
     * @return fixed 值
     */
    public static function get($key,Closure $check=null){
        if($check==null){
            return static::$items[$key];
        }
        return $check($key);
    }
}