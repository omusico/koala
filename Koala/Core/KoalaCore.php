<?php
//目录分隔符
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

//框架核心版本
define("FRAME_VERSION",'1.0');

//框架发布时间
define('FRAME_RELEASE','20140323');

//核心初始化需求

//加载单例实现
include(__DIR__.'/Singleton.php');

/**
 * WEB方式核心初始化实现类
 */
class KoalaCore extends Singleton{
    /**
     * 需延迟执行的closure;
     */
    static $closure = null;
    /**
     * 执行应用
     * 若应用没有实现子类execute,则使用该默认方法
     * @static
     * @access public
     */
    public static function execute(){
        $dispatcher = \Core\AOP\Aop::getInstance(Dispatcher::factory('mvc'));
        $u = \Core\AOP\Aop::getInstance('URL');
        $test_url = rtrim(APP_RELATIVE_URL,'/');
        if(!empty($test_url))
            $url = str_replace(APP_RELATIVE_URL,'',$_SERVER['REQUEST_URI']);
        else
            $url = $_SERVER['REQUEST_URI'];
        //请求选项
        $options = $u->requestOption($url,1);
        //视图文件
        View::setTemplateOptions($options['path']);
        //控制器分发
        $dispatcher->execute(
            //获取控制器类
            function()use($options){
                if(C('MULTIPLE_GROUP')){
                    list($group,$module,$action) = $options['path'];
                    !defined('GROUP_NAME') AND define('GROUP_NAME',$group);
                    $class = $group.'\Controller\\'.$module;
                }
                else{
                    list($module,$action) = $options['path'];
                    $class = 'Controller\\'.$module;
                }
                !defined('MODULE_NAME') AND define('MODULE_NAME',ucwords($module));
                !defined('ACTION_NAME') AND define('ACTION_NAME',$action);
                return $class;
            },
            //获取控制器方法
            function()use($options){return array_pop($options['path']);}
        );
    }
    /**
     * 部分延迟执行的代码,用于延迟搜集可由应用自定义的参数，常量等代码
     * @static
     * @access public
     */
    public static function lazyInitialize(Closure $initializer,$options=array()){
        self::$closure[] = array(
            'closure'=>$initializer,
            'params'=>array(self::getInstance(get_called_class()),$options)
            );
    }
    /**
     * 执行 延迟执行的代码
     * @static
     * @access public
     */
    public static function executeLazy(){
        if(count(self::$closure)>0){
            foreach (self::$closure as $key => $value) {
                call_user_func_array($value['closure'],$value['params']);
            }
        }
    }
}

//加载类加载器
include(__DIR__.'/ClassLoader.php');