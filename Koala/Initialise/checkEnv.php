<?php
//+++++++++++++运行模式及环境检查++++++++++++
//php版本最低需求
env::reg('MIN_PHP_VERSION',function($key){return "5.3";});

//应用引擎环境
env::check('APP_ENGINE',function($key){
    //新浪SAE检测
    if(defined('SAE_ACCESSKEY')){
        define("APPENGINE","SAE");
    }elseif(isset($_SERVER['HTTP_BAE_ENV_APPID'])){//BAE检测
        define("APPENGINE","BAE");
    }else{//本地应用环境
        define("APPENGINE","LAE");
    }
    $result = array(
            'require'=>'',
            'current'=> APPENGINE
            );
    return $result;
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
    if(ENTRANCE_PATH==APP_PATH)
        $pathname = $pathname;
    else
        $pathname = $pathname.basename($pathname).DIRECTORY_SEPARATOR;
	//应用
	define('APP_URL','http://'.$_SERVER['SERVER_NAME'].$pathname);
	define('APP_RELATIVE_URL',$pathname);
    define('SOURCE_RELATIVE_URL',$pathname.'Source/');

	return $pathname;
});

//--------------------运行环境检查---------------------
env::check("PHP_OS",function($key){
    $result = array(
        'require'=>'不限',
        'current'=>PHP_OS
        );
    return $result;
});
env::check("PHP_VERSION",function($key){
    $result = array(
        'require'=>env::get("MIN_".$key),
        'current'=>PHP_VERSION
        );
    if(version_compare(PHP_VERSION,env::get("MIN_".$key),"<")){
        $result['msg'] = '当前PHP运行版本['.PHP_VERSION."]低于最低需求版本[".env::get("MIN_".$key)."]";
        $result['state'] = 'error';
    }else{
        $result['msg'] = "";
        $result['state'] = 'success';
    }
    if(version_compare(PHP_VERSION,"4.2.3","<=")){
        //register_globals设置关闭
        env::check("register_globals",function($key){
            ini_set($key, 0);
        });
    }
    return $result;
});
env::check("PHP_RUNMODE",function($key){
    $result = array(
        'require'=>'不限',
        'current'=>php_sapi_name()
        );
    return $result;
});
env::check("PHP_UPLOADSIZE",function($key){
    $result = array(
            'require'=>'不限',
            'current'=>ini_get('upload_max_filesize'),
            );
    return $result;
});
env::check("PHP_MAXTIME",function($key){
    $result = array(
            'require'=>'不限',
            'current'=>ini_get('max_execution_time') . "秒",
            );
    return $result;
});
env::check("PHP_SPACE",function($key){
    $result = array(
            'require'=>'不限',
            'current'=>round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            );
    return $result;
});
env::check("PHP_SERVER_TIME",function($key){
    $result = array(
            'require'=>'',
            'current'=> date("Y年n月j日 H:i:s"),
            );
    return $result;
});
env::check("BEIJING_TIME",function($key){
    $result = array(
            'require'=>'',
            'current'=> gmdate("Y年n月j日 H:i:s", time() + 8 * 3600)
            );
    return $result;
});
//--------------------函数、类依赖检查---------------------
env::check("file_get_contents",function($key){
    $result = array(
            'require'=>true,
            'current'=>function_exists('file_get_contents'),
            );
    return $result;
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
        $value = $check($key);
        if(!empty($value)||isset($value)){
            static::$items[$key] = $value;
        }
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