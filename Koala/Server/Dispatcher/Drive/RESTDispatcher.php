<?php
namespace Server\Dispatcher\Drive;
use Request;
use AbstractResponse;
use Response;
use ServiceProvider;
use Collection;
use Route;
use Server\Exception\DispatchHaltedException;
use Server\Exception\LockedResponseException;
use Server\Exception\HttpExceptionInterface;
use Server\Exception\HttpException;
//调度器
class RESTDispatcher{
    /**
     * Class properties
     */
    /**
     * Collection of the routes to match on dispatch
     *
     * @var RouteCollection
     * @access protected
     */
    protected $routes;

    /**
     * The Route factory object responsible for creating Route instances
     *
     * @var AbstractRouteFactory
     * @access protected
     */
    protected $route_factory;

    /**
     * An array of error callback callables
     *
     * @var array[callable]
     * @access protected
     */
    protected $errorCallbacks = array();

    /**
     * An array of HTTP error callback callables
     *
     * @var array[callable]
     * @access protected
     */
    protected $httpErrorCallbacks = array();

    /**
     * An array of callbacks to call after processing the dispatch loop
     * and before the response is sent
     *
     * @var array[callable]
     * @access protected
     */
    protected $afterFilterCallbacks = array();


    /**
     * Route objects
     */

    /**
     * The Request object passed to each matched route
     *
     * @var Request
     * @access protected
     */
    protected $request;

    /**
     * The Response object passed to each matched route
     *
     * @var Response
     * @access protected
     */
    protected $response;

    /**
     * The service provider object passed to each matched route
     *
     * @var ServiceProvider
     * @access protected
     */
    protected $service;
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
    //执行调度器
    public function execute(Request $request = null,AbstractResponse $response = null,$send_response = true,$capture = self::DISPATCH_NO_CAPTURE){
        //设置和初始化
        //设置请求对象
        $this->request = $request ?: Request::createFromGlobals();
        //设置响应对象
        $this->response = $response ?: new Response();
        //设置服务提供者对象
        $this->service = new ServiceProvider();
        //设置路由搜集器对象
        $this->routes = Collection::factory('route');
        //绑定服务参数
        $this->service->bind($this->request, $this->response);
        //准备路由索引
        $this->routes->prepareNamed();

        //获取当前请求信息
        //请求url;
        $uri = $this->request->pathname();
        //请求方法
        $req_method = $this->request->method();

        //设置用于路由匹配的相关变量
        //跳过数
        $skip_num = 0;
        //设置一个 路由搜集器 空属性克隆 
        $matched = $this->routes->cloneEmpty();
        $methods_matched = array();
        $params = array();
        ob_start();
        //遍历路由
        foreach ((Array)$this->routes as $routes) {
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
                    $this->onHttpError($route);
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

                    $regex = $this->compileRoute($expression);
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
                            $this->request->paramsNamed()->merge($params);
                        }
                        //执行响应回调函数
                        try {
                            $this->handleRouteCallback($route, $matched, $methods_matched);

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
                $this->response->header('Allow', implode(', ', $methods_matched));
                if (strcasecmp($req_method, 'OPTIONS') !== 0) {
                    throw HttpException::createFromCode(405);
                }
            } elseif ($matched->isEmpty()) {
                throw HttpException::createFromCode(404);
            }
        } catch (HttpExceptionInterface $e) {
            //原始响应的锁定状态
            $locked = $this->response->isLocked();

            //调用http 错误处理方法
            $this->httpError($e, $matched, $methods_matched);
            //确认在返回我们的响应结果时，重置为原始状态
            if (!$locked) {
                $this->response->unlock();
            }
        }

        try {
            if ($this->response->chunked) {
                $this->response->chunk();
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
                            $this->response->body(ob_get_clean());
                        }
                        break;
                    case self::DISPATCH_CAPTURE_AND_PREPEND:
                        if (ob_get_level()) {
                            $this->response->prepend(ob_get_clean());
                        }
                        break;
                    case self::DISPATCH_CAPTURE_AND_APPEND:
                        if (ob_get_level()) {
                            $this->response->append(ob_get_clean());
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
                $this->response->body('');
                if (ob_get_level()) {
                    ob_clean();
                }
            }
        } catch (LockedResponseException $e) {
            // Do nothing, since this is an automated behavior
        }

        //运行后置处理
        //$this->callAfterDispatchCallbacks();

        if ($send_response && !$this->response->isSent()) {
            $this->response->send();
        }
    }
    /**
     * Compiles a route string to a regular expression
     *
     * @param string $route     The route string to compile
     * @access protected
     * @return void
     */
    protected function compileRoute($route){
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
    protected function handleRouteCallback($route, $matched, $methods_matched){
        $Route = get_class(Route::factory());
        $RouteCollection = get_class(Collection::factory('Route'));
        if(!$route instanceof $Route){}
        if(!$matched instanceof $RouteCollection){
        }
        // Handle the callback
        try {
            $returned = call_user_func(
                $route->getCallback(), // Instead of relying on the slower "invoke" magic
                $this->request,
                $this->response,
                $this->service,
                //$this->app,
                //$this, // Pass the Klein instance
                $matched,
                $methods_matched
            );
            if ($returned instanceof AbstractResponse) {
                $this->response = $returned;
            } else {
                // Otherwise, attempt to append the returned data
                try {
                    $this->response->append($returned);
                } catch (LockedResponseException $e) {
                    // Do nothing, since this is an automated behavior
                }
            }
        } catch (DispatchHaltedException $e) {
            throw $e;
        } catch (HttpExceptionInterface $e) {
            // Call our http error handlers
            $this->httpError($e, $matched, $methods_matched);

            throw new DispatchHaltedException();
        } catch (Exception $e) {
            $this->error($e);
        }
    }
    /**
     * Handles an HTTP error exception through our HTTP error callbacks
     *
     * @param HttpExceptionInterface $http_exception    The exception that occurred
     * @param RouteCollection $matched                  The collection of routes that were matched in dispatch
     * @param array $methods_matched                    The HTTP methods that were matched in dispatch
     * @access protected
     * @return void
     */
    protected function httpError(HttpExceptionInterface $http_exception,$matched, $methods_matched)
    {
        $matched_class = get_class(Collection::factory('Route'));
        if(!$matched instanceof $matched_class){
            exit('必须是'.$matched_class);
        }
        if (!$this->response->isLocked()) {
            $this->response->code($http_exception->getCode());
        }

        if (count($this->httpErrorCallbacks) > 0) {
            foreach (array_reverse($this->httpErrorCallbacks) as $callback) {
                if ($callback instanceof Route) {
                    $this->handleRouteCallback($callback, $matched, $methods_matched);
                } elseif (is_callable($callback)) {
                    if (is_string($callback)) {
                        $callback(
                            $http_exception->getCode(),
                            $this,
                            $matched,
                            $methods_matched,
                            $http_exception
                        );
                    } else {
                        call_user_func(
                            $callback,
                            $http_exception->getCode(),
                            $this,
                            $matched,
                            $methods_matched,
                            $http_exception
                        );
                    }
                }
            }
        }

        // Lock our response, since we probably don't want
        // anything else messing with our error code/body
        $this->response->lock();
    }
    /**
     * Adds an HTTP error callback to the stack of HTTP error handlers
     *
     * @param callable $callback            The callable function to execute in the error handling chain
     * @access public
     * @return void
     */
    public function onHttpError($callback)
    {
        $this->httpErrorCallbacks[] = $callback;
    }
}