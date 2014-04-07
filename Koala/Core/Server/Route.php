<?php
/**
 * 
 *路由服务
 *
 */
class Route{

    /**
     * Class properties
     */

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
    //
    public static function exe(Request $request = null,AbstractResponse $response = null,$send_response = true,$capture = self::DISPATCH_NO_CAPTURE){
        
        // Set/Initialize our objects to be sent in each callback
        self::$request = $request ?: Request::createFromGlobals();
        self::$response = $response ?: new Response();
        self::$service = new ServiceProvider();
        self::$routes = Collection::factory('route');

        // Bind our objects to our service
        self::$service->bind(self::$request, self::$response);

        // Prepare any named routes
        self::$routes->prepareNamed();

        // Grab some data from the request
        $uri = self::$request->pathname();
        $req_method = self::$request->method();
        // Set up some variables for matching
        $skip_num = 0;
        $matched = self::$routes->cloneEmpty(); // Get a clone of the routes collection, as it may have been injected
        $methods_matched = array();
        $params = array();

        $apc=false;//todo;
        foreach ((Array)self::$routes as $routes) {
            foreach ($routes as $key => $route) {
                if ($skip_num > 0) {
                    $skip_num--;
                    continue;
                }
                // Grab the properties of the route handler
                $method = $route->getMethod();
                $path = $route->getPath();
                $count_match = $route->getCountMatch();
                // Keep track of whether this specific request method was matched
                $method_match = null;
                // Was a method specified? If so, check it against the current request method
                if (is_array($method)) {
                    foreach ($method as $test) {
                        if (strcasecmp($req_method, $test) === 0) {
                            $method_match = true;
                        } elseif (strcasecmp($req_method, 'HEAD') === 0
                              && (strcasecmp($test, 'HEAD') === 0 || strcasecmp($test, 'GET') === 0)) {

                            // Test for HEAD request (like GET)
                            $method_match = true;
                        }
                    }

                    if (null === $method_match) {
                        $method_match = false;
                    }
                } elseif (null !== $method && strcasecmp($req_method, $method) !== 0) {
                    $method_match = false;

                    // Test for HEAD request (like GET)
                    if (strcasecmp($req_method, 'HEAD') === 0
                        && (strcasecmp($method, 'HEAD') === 0 || strcasecmp($method, 'GET') === 0 )) {

                        $method_match = true;
                    }
                } elseif (null !== $method && strcasecmp($req_method, $method) === 0) {
                    $method_match = true;
                }
                 // If the method was matched or if it wasn't even passed (in the route callback)
                $possible_match = (null === $method_match) || $method_match;

                // ! is used to negate a match
                if (isset($path[0]) && $path[0] === '!') {
                    $negate = true;
                    $i = 1;
                } else {
                    $negate = false;
                    $i = 0;
                }


                // Check for a wildcard (match all)
                if ($path === '*') {
                    $match = true;

                } elseif (($path === '404' && $matched->isEmpty() && count($methods_matched) <= 0)
                       || ($path === '405' && $matched->isEmpty() && count($methods_matched) > 0)) {

                    // Easily handle 40x's
                    // TODO: Possibly remove in future, here for backwards compatibility
                    self::$onHttpError($route);

                    continue;

                } elseif (isset($path[$i]) && $path[$i] === '@') {
                    // @ is used to specify custom regex

                    $match = preg_match('`' . substr($path, $i + 1) . '`', $uri, $params);

                } else {
                    // Compiling and matching regular expressions is relatively
                    // expensive, so try and match by a substring first

                    $expression = null;
                    $regex = false;
                    $j = 0;
                    $n = isset($path[$i]) ? $path[$i] : null;

                    // Find the longest non-regex substring and match it against the URI
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

                    // Check if there's a cached regex string
                    if (false !== $apc) {
                        $regex = apc_fetch("route:$expression");
                        if (false === $regex) {
                            $regex = self::$compileRoute($expression);
                            apc_store("route:$expression", $regex);
                        }
                    } else {
                        $regex = self::compileRoute($expression);
                    }

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
                            self::$request->paramsNamed()->merge($params);
                        }

                        // Handle our response callback
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

                    // Keep track of possibly matched methods
                    $methods_matched = array_merge($methods_matched, (array) $method);
                    $methods_matched = array_filter($methods_matched);
                    $methods_matched = array_unique($methods_matched);
                }
            }
            // Handle our 404/405 conditions
            try {
                if ($matched->isEmpty() && count($methods_matched) > 0) {
                    // Add our methods to our allow header
                    self::$response->header('Allow', implode(', ', $methods_matched));

                    if (strcasecmp($req_method, 'OPTIONS') !== 0) {
                        throw HttpException::createFromCode(405);
                    }
                } elseif ($matched->isEmpty()) {
                    throw HttpException::createFromCode(404);
                }
            } catch (HttpExceptionInterface $e) {
                // Grab our original response lock state
                $locked = self::$response->isLocked();

                // Call our http error handlers
                self::$httpError($e, $matched, $methods_matched);

                // Make sure we return our response to its original lock state
                if (!$locked) {
                    self::$response->unlock();
                }
            }

            try {
                if (self::$response->chunked) {
                    self::$response->chunk();

                } else {
                    // Output capturing behavior
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

                // Test for HEAD request (like GET)
                if (strcasecmp($req_method, 'HEAD') === 0) {
                    // HEAD requests shouldn't return a body
                    self::$response->body('');

                    if (ob_get_level()) {
                        ob_clean();
                    }
                }
            } catch (LockedResponseException $e) {
                // Do nothing, since this is an automated behavior
            }

            // Run our after dispatch callbacks
           // self::$callAfterDispatchCallbacks();

            if ($send_response && !self::$response->isSent()) {
                self::$response->send();
            }
        }
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
    /**
     * Compiles a route string to a regular expression
     *
     * @param string $route     The route string to compile
     * @access protected
     * @return void
     */
    protected static function compileRoute($route)
    {
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
    protected static function handleRouteCallback($route, $matched, $methods_matched)
    {
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