<?php
/**
 * 
 *路由服务
 *
 */
class Route{
    /**
    * 操作句柄数组
    * @var array
    */
    static protected $handlers = array();
    public function __construct(){}
    public static function factory($options=array(),$type='',$new=false){
        if(empty($type)||!is_string($type)){
            $type = C('Route:DEFAULT','Route');
        }
        if($new || !isset(self::$handlers[$type])){
            $c_options = C('Route:'.$type);
            if(empty($c_options)){
                $c_options = array();
            }
            $options = array_merge($c_options,$options);
            self::$handlers[$type] = Server\Route\Factory::getInstance($type,$options);
        }
        return self::$handlers[$type];
    }
    //响应绑定
    public static function respond($method, $path = '*', $callback = null){
        $route = Route::factory(self::parseLooseArgumentOrder(func_get_args()),'',true);
        Collection::factory('route')->add($route);
        return $route;
    }
    //搜集一系列在$namespace下的路由
    public static function with($namespace, $routes){
        $previous = Server\Route\Factory::getNamespace();
        Server\Route\Factory::appendNamespace($namespace);
        if (is_callable($routes)) {
            if (is_string($routes)) {
                $routes();
            } else {
                call_user_func($routes);
            }
        } else {
            require $routes;
        }
        Server\Route\Factory::setNamespace($previous);
    }

    protected static function parseLooseArgumentOrder(Array $args){
        $callback = array_pop($args);
        $path = array_pop($args);
        $method = array_pop($args);
        //返回索引数组
        return array(
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
            'count_match' => true,
            'name' => null,
        );
    }
}