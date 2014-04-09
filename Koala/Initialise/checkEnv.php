<?php
//+++++++++++++运行模式及环境检查++++++++++++
//-------------------信息注册--------------
//php运行版本
env::reg('PHP_VERSION',function($key){return PHP_VERSION;});
//应用引擎环境
env::reg('APP_ENGINE',function($key){
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
//应用相对URL路径
env::reg('APP_RELATIVE_URL',function($key){
	if(RUNCLI)//cli $_SERVER['SERVER_NAME'] 无效
	return;
	$pathname = str_replace(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']),'', str_replace('\\', '/',ENTRANCE_PATH));
	//站点
	define('SITE_URL','http://'.$_SERVER['SERVER_NAME'].$pathname);
	define('SITE_RELATIVE_URL',$pathname);
	if(APPENGINE=='BAE'){//BAE $_SERVER['DOCUMENT_ROOT'] 与 ENTRANCE_PATH 不在同一路径分支。
		$pathname = basename($pathname).DIRECTORY_SEPARATOR;
	}
	//应用
	define('APP_URL','http://'.$_SERVER['SERVER_NAME'].$pathname);
	define('APP_RELATIVE_URL',$pathname);

	return $pathname;
});

//php最低版本
env::reg('MIN_PHP_VERSION',function($key){return "5.3";});
env::reg("DEBUG",function($key){
		return DEBUG;
	});
//--------------------信息检查---------------------
env::check("PHP_VERSION",function($value,$key){
	if(version_compare($value,env::get("MIN_".$key),"<")){
		echo '当前PHP运行版本['.$value."]低于最低需求版本[".env::get("MIN_".$key)."]";
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