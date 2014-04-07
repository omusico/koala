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
        // Get the arguments in a very loose format
        extract(
            self::parseLooseArgumentOrder(func_get_args()),
            EXTR_OVERWRITE
        );
        $route = Server\Route\Factory::build($callback, $path, $method);

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
     /**
     * Parse our extremely loose argument order of our "respond" method and its aliases
     *
     * This method takes its arguments in a loose format and order.
     * The method signature is simply there for documentation purposes, but allows
     * for the minimum of a callback to be passed in its current configuration.
     *
     * @see Route::respond()
     * @param mixed $args               An argument array. Hint: This works well when passing "func_get_args()"
     *  @named string | array $method   HTTP Method to match
     *  @named string $path             Route URI path to match
     *  @named callable $callback       Callable callback method to execute on route match
     * @access protected
     * @return array                    A named parameter array containing the keys: 'method', 'path', and 'callback'
     */
    protected static function parseLooseArgumentOrder(array $args){
        // Get the arguments in a very loose format
        $callback = array_pop($args);
        $path = array_pop($args);
        $method = array_pop($args);

        // Return a named parameter array
        return array(
            'method' => $method,
            'path' => $path,
            'callback' => $callback,
            'count_match' => true,
            'name' => null,
        );
    }
    
}