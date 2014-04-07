<?php
//调度器
class Dispatcher extends Initial{
    /**
     * Class properties
     */
    
    static $options = array();
    /**
     * Collection of the routes to match on dispatch
     *
     * @var RouteCollection
     * @access protected
     */
    protected static $routes;

    /**
     * The Route factory object responsible for creating Route instances
     *
     * @var AbstractRouteFactory
     * @access protected
     */
    protected static $route_factory;

    /**
     * An array of error callback callables
     *
     * @var array[callable]
     * @access protected
     */
    protected static $errorCallbacks = array();

    /**
     * An array of HTTP error callback callables
     *
     * @var array[callable]
     * @access protected
     */
    protected static $httpErrorCallbacks = array();

    /**
     * An array of callbacks to call after processing the dispatch loop
     * and before the response is sent
     *
     * @var array[callable]
     * @access protected
     */
    protected static $afterFilterCallbacks = array();


    /**
     * Route objects
     */

    /**
     * The Request object passed to each matched route
     *
     * @var Request
     * @access protected
     */
    protected static $request;

    /**
     * The Response object passed to each matched route
     *
     * @var Response
     * @access protected
     */
    protected static $response;

    /**
     * The service provider object passed to each matched route
     *
     * @var ServiceProvider
     * @access protected
     */
    protected static $service;
    /**
     * Dispatch route output handling
     *
     * Don't capture anything. Behave as normal.
     *
     * @const int
     */
    const DISPATCH_NO_CAPTURE = 0;

    /**
     * Dispatch route output handling
     *
     * Capture all output and return it from dispatch
     *
     * @const int
     */
    const DISPATCH_CAPTURE_AND_RETURN = 1;

    /**
     * Dispatch route output handling
     *
     * Capture all output and replace the response body with it
     *
     * @const int
     */
    const DISPATCH_CAPTURE_AND_REPLACE = 2;

    /**
     * Dispatch route output handling
     *
     * Capture all output and prepend it to the response body
     *
     * @const int
     */
    const DISPATCH_CAPTURE_AND_PREPEND = 3;

    /**
     * Dispatch route output handling
     *
     * Capture all output and append it to the response body
     *
     * @const int
     */
    const DISPATCH_CAPTURE_AND_APPEND = 4;
    /**
     * The regular expression used to compile and match URL's
     *
     * @const string
     */
    const ROUTE_COMPILE_REGEX = '`(\\\?(?:/|\.|))(\[([^:\]]*+)(?::([^:\]]*+))?\])(\?|)`';

    /**
     * The regular expression used to escape the non-named param section of a route URL
     *
     * @const string
     */
    const ROUTE_ESCAPE_REGEX = '`(?<=^|\])[^\]\[\?]+?(?=\[|$)`';
    //执行应用
    public static function execute($options){
        self::$options = $options;
        $action = array_pop($options['paths']);
        $class = 'Controller\\'.implode("\\",$options['paths']);
        $options['c_instance']  = new $class();
        //调用控制器
        $controller = Controller::factory('',$options);
        $custom['const'] = get_defined_constants();
        View::assign('Koala',$custom);
        try{
            if(!preg_match('/^[_A-Za-z](\w)*$/',$action)){
                // 非法操作
                throw new ReflectionException();
            }
            $controller->{$action}();
        } catch (ReflectionException $e) { 
            // 方法调用发生异常后
            echo '方法异常';
        }
    }
    //执行调度器
    public static function exe(Request $request = null,AbstractResponse $response = null,$send_response = true,$capture = self::DISPATCH_NO_CAPTURE){
        //设置和初始化
        //设置请求对象
        self::$request = $request ?: Request::createFromGlobals();
        //设置响应对象
        self::$response = $response ?: new Response();
        //设置服务提供者对象
        self::$service = new ServiceProvider();
        //设置路由搜集器对象
        self::$routes = Collection::factory('route');

        //绑定服务参数
        self::$service->bind(self::$request, self::$response);
        //准备路由索引
        self::$routes->prepareNamed();

        //获取当前请求信息
        //请求url;
        $uri = self::$request->pathname();
        //请求方法
        $req_method = self::$request->method();

        //设置用于路由匹配的相关变量
        //跳过数
        $skip_num = 0;
        //设置一个 路由搜集器 空属性克隆 
        $matched = self::$routes->cloneEmpty();
        $methods_matched = array();
        $params = array();
        //遍历路由
        foreach ((Array)self::$routes as $routes) {
            foreach ($routes as $key => $route) {
                //跳过部分路由
                if ($skip_num > 0) {
                    $skip_num--;
                    continue;
                }
                //获取当前路由的相关属性
                //路由请求方法
                $method = $route->getMethod();
                //路由请求路径
                $path = $route->getPath();
                //路由匹配次数
                $count_match = $route->getCountMatch();
                //用于跟踪路由是否匹配的变量
                $method_match = null;
                //检查是否是指定的请求方法
                //是数组
                if (is_array($method)) {
                    foreach ($method as $test) {
                        if (strcasecmp($req_method, $test) === 0) {
                            $method_match = true;
                        } elseif (strcasecmp($req_method, 'HEAD') === 0
                              && (strcasecmp($test, 'HEAD') === 0 || strcasecmp($test, 'GET') === 0)) {
                            //为HEAD请求测试GET
                            $method_match = true;
                        }
                    }
                    if (null === $method_match) {
                        $method_match = false;
                    }
                } elseif (null !== $method && strcasecmp($req_method, $method) !== 0) {
                    $method_match = false;
                    //为HEAD请求测试GET
                    if (strcasecmp($req_method, 'HEAD') === 0
                        && (strcasecmp($method, 'HEAD') === 0 || strcasecmp($method, 'GET') === 0 )) {
                        $method_match = true;
                    }
                } elseif (null !== $method && strcasecmp($req_method, $method) === 0) {
                    $method_match = true;
                }//请求方法检查完毕

                //如果这个请求匹配成功 或者 都没匹配到路由 
                $possible_match = (null === $method_match) || $method_match;

                // ! 否定匹配
                if (isset($path[0]) && $path[0] === '!') {
                    $negate = true;
                    $i = 1;
                } else {
                    $negate = false;
                    $i = 0;
                }
                //检查通配符(允许所有)
                if ($path === '*') {$match = true;}
                elseif (($path === '404' && $matched->isEmpty() && count($methods_matched) <= 0)
                       || ($path === '405' && $matched->isEmpty() && count($methods_matched) > 0)) {
                    // TODO 未来移除
                    self::$onHttpError($route);
                    continue;

                } elseif (isset($path[$i]) && $path[$i] === '@') {
                    //使用@自定义正则
                    $match = preg_match('`' . substr($path, $i + 1) . '`', $uri, $params);
                } else {
                    // 编译，并使用字符串匹配
                    $expression = null;
                    $regex = false;
                    $j = 0;
                    $n = isset($path[$i]) ? $path[$i] : null;
                    // 寻找最长非正则字符串和相应url
                    while (true) {
                        if (!isset($path[$i])) {
                            break;
                        } elseif (false === $regex) {
                            $c = $n;
                            $regex = $c === '[' || $c === '(' || $c === '.';
                            if (false === $regex && false !== isset($path[$i+1])) {
                                $n = $path[$i + 1];
                                $regex = $n === '?' || $n === '+' || $n === '*' || $n === '{';
                            }
                            if (false === $regex && $c !== '/' && (!isset($uri[$j]) || $c !== $uri[$j])) {
                                continue 2;
                            }
                            $j++;
                        }
                        $expression .= $path[$i++];
                    }

                    $regex = self::compileRoute($expression);
                    //匹配结果
                    $match = preg_match($regex, $uri, $params);
                }
                if (isset($match) && $match ^ $negate) {
                    if ($possible_match) {
                        if (!empty($params)) {
                            /**
                             * URL Decode the params according to RFC 3986
                             * @link http://www.faqs.org/rfcs/rfc3986
                             *
                             * Decode here AFTER matching as per @chriso's suggestion
                             * @link https://github.com/chriso/klein.php/issues/117#issuecomment-21093915
                             */
                            $params = array_map('rawurldecode', $params);
                            //合并参数
                            self::$request->paramsNamed()->merge($params);
                        }
                        //执行响应回调函数
                        try {
                            self::handleRouteCallback($route, $matched, $methods_matched);

                        } catch (DispatchHaltedException $e) {
                            switch ($e->getCode()) {
                                case DispatchHaltedException::SKIP_THIS:
                                    continue 2;
                                    break;
                                case DispatchHaltedException::SKIP_NEXT:
                                    $skip_num = $e->getNumberOfSkips();
                                    break;
                                case DispatchHaltedException::SKIP_REMAINING:
                                    break 2;
                                default:
                                    throw $e;
                            }
                        }

                        if ($path !== '*') {
                            $count_match && $matched->add($route);
                        }
                    }
                    //保存所有可能跟踪结果
                    $methods_matched = array_merge($methods_matched, (array) $method);
                    $methods_matched = array_filter($methods_matched);
                    $methods_matched = array_unique($methods_matched);
                }
            }
        }

        //执行 404/405 条件
        try {
            if ($matched->isEmpty() && count($methods_matched) > 0) {
                //添加允许方法
                self::$response->header('Allow', implode(', ', $methods_matched));
                if (strcasecmp($req_method, 'OPTIONS') !== 0) {
                    throw HttpException::createFromCode(405);
                }
            } elseif ($matched->isEmpty()) {
                throw HttpException::createFromCode(404);
            }
        } catch (HttpExceptionInterface $e) {
            //原始响应的锁定状态
            $locked = self::$response->isLocked();

            //调用http 错误处理方法
            self::$httpError($e, $matched, $methods_matched);
            //确认在返回我们的响应结果时，重置为原始状态
            if (!$locked) {
                self::$response->unlock();
            }
        }

        try {
            if (self::$response->chunked) {
                self::$response->chunk();
            } else {
                //输出行为结果
                switch($capture) {
                    case self::DISPATCH_CAPTURE_AND_RETURN:
                        $buffed_content = null;
                        if (ob_get_level()) {
                            $buffed_content = ob_get_clean();
                        }
                        return $buffed_content;
                        break;
                    case self::DISPATCH_CAPTURE_AND_REPLACE:
                        if (ob_get_level()) {
                            self::$response->body(ob_get_clean());
                        }
                        break;
                    case self::DISPATCH_CAPTURE_AND_PREPEND:
                        if (ob_get_level()) {
                            self::$response->prepend(ob_get_clean());
                        }
                        break;
                    case self::DISPATCH_CAPTURE_AND_APPEND:
                        if (ob_get_level()) {
                            self::$response->append(ob_get_clean());
                        }
                        break;
                    case self::DISPATCH_NO_CAPTURE:
                    default:
                        if (ob_get_level()) {
                            ob_end_flush();
                        }
                }
            }
            //测试是否是HEAD请求
            if (strcasecmp($req_method, 'HEAD') === 0) {
                //不返回body
                self::$response->body('');
                if (ob_get_level()) {
                    ob_clean();
                }
            }
        } catch (LockedResponseException $e) {
            // Do nothing, since this is an automated behavior
        }

        //运行后置处理
        //self::callAfterDispatchCallbacks();

        if ($send_response && !self::$response->isSent()) {
            self::$response->send();
        }
    }
    /**
     * Compiles a route string to a regular expression
     *
     * @param string $route     The route string to compile
     * @access protected
     * @return void
     */
    protected static function compileRoute($route){
        // First escape all of the non-named param (non [block]s) for regex-chars
        if (preg_match_all(static::ROUTE_ESCAPE_REGEX, $route, $escape_locations, PREG_SET_ORDER)) {
            foreach ($escape_locations as $locations) {
                $route = str_replace($locations[0], preg_quote($locations[0]), $route);
            }
        }
        // Now let's actually compile the path
        if (preg_match_all(static::ROUTE_COMPILE_REGEX, $route, $matches, PREG_SET_ORDER)) {
            $match_types = array(
                'i'  => '[0-9]++',
                'a'  => '[0-9A-Za-z]++',
                'h'  => '[0-9A-Fa-f]++',
                's'  => '[0-9A-Za-z-_]++',
                '*'  => '.+?',
                '**' => '.++',
                ''   => '[^/]+?'
            );

            foreach ($matches as $match) {
                list($block, $pre, $inner_block, $type, $param, $optional) = $match;

                if (isset($match_types[$type])) {
                    $type = $match_types[$type];
                }
                // Older versions of PCRE require the 'P' in (?P<named>)
                $pattern = '(?:'
                         . ($pre !== '' ? $pre : null)
                         . '('
                         . ($param !== '' ? "?P<$param>" : null)
                         . $type
                         . '))'
                         . ($optional !== '' ? '?' : null);

                $route = str_replace($block, $pattern, $route);
            }
        }

        return "`^$route$`";
    }
    /**
     * Handle a route's callback
     *
     * This handles common exceptions and their output
     * to keep the "dispatch()" method DRY
     *
     * @param Route $route
     * @param RouteCollection $matched
     * @param int $methods_matched
     * @access protected
     * @return void
     */
    protected static function handleRouteCallback($route, $matched, $methods_matched){
        $Route = get_class(Route::factory());
        $RouteCollection = get_class(Collection::factory('Route'));
        if(!$route instanceof $Route){}
        if(!$matched instanceof $RouteCollection){
        }
        // Handle the callback
        try {
            $returned = call_user_func(
                $route->getCallback(), // Instead of relying on the slower "invoke" magic
                self::$request,
                self::$response,
                self::$service,
                //self::$app,
                //$this, // Pass the Klein instance
                $matched,
                $methods_matched
            );
            if ($returned instanceof AbstractResponse) {
                self::$response = $returned;
            } else {
                // Otherwise, attempt to append the returned data
                try {
                    self::$response->append($returned);
                } catch (LockedResponseException $e) {
                    // Do nothing, since this is an automated behavior
                }
            }
        } catch (DispatchHaltedException $e) {
            throw $e;
        } catch (HttpExceptionInterface $e) {
            // Call our http error handlers
            self::$httpError($e, $matched, $methods_matched);

            throw new DispatchHaltedException();
        } catch (Exception $e) {
            self::$error($e);
        }
    }
}