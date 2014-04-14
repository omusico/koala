<?php
class PluginManagerSTC{
	//已注册的插件监听表
	private static $_listeners = array();
    //实例
    private static $_instance = null;
	//构造函数
	public function __construct($plg=''){
		//获得已经启用的插件表
        $plugins = M('plugin')->where('enable=1')->select();
        
		if(!empty($plugins)&&is_array($plugins)){
            foreach($plugins as $plugin){
                if($plg!=$plugin['name']){continue;}//对不需要的类不进行实例化
            	//类名生成
            	$class = 'Plugin_'.$plugin['name'].'_Action';
            	//开始hook过程
            	new $class($this);

            	/*
            	//有自动加载机制，故这部分可以去除
            	//假定每个插件文件夹中包含一个actions.php文件，它是插件的具体实现
                if (@file_exists(PLUGIN_PATH.$plugin['name'].'/action.php')){
                    include_once(PLUGIN_PATH.$plugin['name'].'/action.php');
                    $class = 'Plugin_'.ucfirst(strtolower($plugin['name'])).'_Action';
                    if (class_exists($class)){
                        //初始化所有插件 

                        //$this 是本类的引用

                       new $class($this);
                    }
                }*/
            }
        }
	}
    public static function getInstance($plugin=''){
        if(self::$_instance==null){
            self::$_instance = new PluginManagerSTC($plugin);
        }
        return  self::$_instance;
    }
	public function register($hook, &$reference, $method){
        //获取插件要实现的方法
        $key = get_class($reference).'->'.$method;
        //将插件的引用连同方法push进监听数组中 

        self::$_listeners[$hook][$key] = array(&$reference, $method);
        #此处做些日志记录方面的东西
    }
    public static function trigger($hook, $data=''){ 
        $result = '';
        //查看要实现的钩子，是否在监听数组之中 

        if (isset(self::$_listeners[$hook]) && is_array(self::$_listeners[$hook]) && count(self::$_listeners[$hook]) > 0){
            // 循环调用开始
            foreach (self::$_listeners[$hook] as $listener){
                // 取出插件对象的引用和方法 

                $class =& $listener[0]; 

                $method = $listener[1]; 

                if(method_exists($class,$method)){
                    // 动态调用插件的方法
                    if($data)
                        $result .= $class->$method($data);
                    else
                        $result .= $class->$method();
                }
            }
        }else{
            //trigger_error('插件'.$hook.'未启用!');
        }
        #此处做些日志记录方面的东西
        return $result;
    } 
}
?>