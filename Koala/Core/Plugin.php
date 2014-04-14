<?php
define("CORE_PLUGIN_PATH",FRAME_PATH.'Addons/Plugin'.DS);
/**
 * 插件管理器
 */
class Plugin{
	//已注册的插件监听表
	private static $_listeners = array();
    //插件参数
    private static $_params = array(); 
    //当前插件实例
    private static $_instance = null;
    /**
     * 插件挂载点注册
     * @param  string $hook     挂载点
     * @param  fixd $callable 可调用的参数
     * @return bool           注册结果
     */
    public static function register($hook,$callable,$param=array()){
        self::$_listeners[$hook][] = $callable;
        if(is_array($callable)){
            if(is_object($callable[0])){
                $string = get_class($callable[0]).$callable[1];
            }else{
                $string = implode(',',$callable);
            }
        }else{
            $string = $callable;
        }
        self::$_params[$hook][$string] = $param;
    }
    /**
     * 挂载点触发器
     * @param  string $hook     挂载点
     * @param  fixd $callable 触发指定的callable
     * @return [type]       [description]
     */
    public static function trigger($hook,$callable=null,$param=array()){
        //查看要实现的钩子，是否在监听数组之中 
        if (isset(self::$_listeners[$hook]) &&!empty(self::$_listeners[$hook])){
            //如果指定钩子
            if(!empty($callable)){
                return call_user_func_array($callable,$param);
            }else{//遍历所有
                foreach (self::$_listeners[$hook] as $callable){
                    if(is_array($callable)){
                       if(is_object($callable[0])){
                            $string = get_class($callable[0]).$callable[1];
                        }else{
                            $string = implode(',',$callable);
                        }
                    }else{
                        $string = $callable;
                    }
                    $param = isset(self::$_params[$hook][$string])?self::$_params[$hook][$string]:array();
                    call_user_func_array($callable,$param);
                }
            }
        }
    }
    /**
     * 用于插件管理器加载插件
     */
    public static function loadPlugin(){
        //遍历核心插件
        $handle  = opendir(CORE_PLUGIN_PATH);
        $arr = array();
        while($file = readdir($handle)){
            if($file=='.'||$file=='..'){
                continue;
            }
            $newpath=CORE_PLUGIN_PATH.$file;
            if(is_dir($newpath)) $arr[] = $file;
        }
        //遍历应用插件
        if(defined('APP_PLUGIN_PATH')){
            //遍历插件
            $handle  = opendir(APP_PLUGIN_PATH);
            $arr = array();
            while($file = readdir($handle)){
                if($file=='.'||$file=='..'){
                    continue;
                }
                $newpath=APP_PLUGIN_PATH.$file;
                if(is_dir($newpath)) $arr[] = $file;
            }
        }
        

        foreach ($arr as $value) {
            $class = 'Plugin\\'.$value.'\\Action';
            new $class('Plugin');
        }
    }
}
?>