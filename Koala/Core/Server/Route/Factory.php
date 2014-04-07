<?php
namespace Server\Route;
use Route;
class Factory extends \Server\Factory{
    
    /**
     * Properties
     */

    /**
     * The namespace of which to collect the routes in
     * when matching, so you can define routes under a
     * common endpoint
     *
     * @var string
     * @access protected
     */
    protected static $namespace;
    
    /**
     * Methods
     */

    /**
     * Constructor
     *
     * @param string $namespace The initial namespace to set
     * @access public
     */
    public function __construct($namespace = null)
    {
        self::$namespace = $namespace;
    }
    /**
     * 获取完成类名
     * @param  string $type 类型
     * @return string       类名
     */
    public static function getServerName($type){
        $server_name = 'Route';
        switch($type){
            case 'route':
                $server_name = 'Route';
            break;
        }
        return self::getRealName('Route',$server_name);
    }
    /**
     * Gets the value of namespace
     *
     * @access public
     * @return string
     */
    public static function getNamespace()
    {
        return self::$namespace;
    }

    /**
     * Sets the value of namespace
     *
     * @param string $namespace The namespace from which to collect the Routes under
     * @access public
     * @return Factory
     */
    public static function setNamespace($namespace)
    {
        self::$namespace = (string) $namespace;
    }

    /**
     * Append a namespace to the current namespace
     *
     * @param string $namespace The namespace from which to collect the Routes under
     * @access public
     * @return Factory
     */
    public static function appendNamespace($namespace)
    {
        self::$namespace .= (string) $namespace;
    }


    /**
     * Constants
     */

    /**
     * The value given to path's when they are entered as null values
     *
     * @const string
     */
    const NULL_PATH_VALUE = '*';


    /**
     * Methods
     */

    /**
     * Check if the path is null or equal to our match-all, null-like value
     *
     * @param mixed $path
     * @access protected
     * @return boolean
     */
    protected static function pathIsNull($path)
    {
        return (static::NULL_PATH_VALUE === $path || null === $path);
    }

    /**
     * Quick check to see whether or not to count the route
     * as a match when counting total matches
     *
     * @param string $path
     * @access protected
     * @return boolean
     */
    protected static function shouldPathStringCauseRouteMatch($path)
    {
        // Only consider a request to be matched when not using 'matchall'
        return !self::pathIsNull($path);
    }

    /**
     * Pre-process a path string
     *
     * This method wraps the path string in a regular expression syntax baesd
     * on whether the string is a catch-all or custom regular expression.
     * It also adds the namespace in a specific part, based on the style of expression
     *
     * @param string $path
     * @access protected
     * @return string
     */
    protected static function preprocessPathString($path)
    {
        // If the path is null, make sure to give it our match-all value
        $path = (null === $path) ? static::NULL_PATH_VALUE : (string) $path;

        // If a custom regular expression (or negated custom regex)
        if (self::$namespace && $path[0] === '@' || ($path[0] === '!' && $path[1] === '@')) {
            // Is it negated?
            if ($path[0] === '!') {
                $negate = true;
                $path = substr($path, 2);
            } else {
                $negate = false;
                $path = substr($path, 1);
            }

            // Regex anchored to front of string
            if ($path[0] === '^') {
                $path = substr($path, 1);
            } else {
                $path = '.*' . $path;
            }

            if ($negate) {
                $path = '@^' . self::$namespace . '(?!' . $path . ')';
            } else {
                $path = '@^' . self::$namespace . $path;
            }

        } elseif (self::$namespace && self::pathIsNull($path)) {
            // Empty route with namespace is a match-all
            $path = '@^' . self::$namespace . '(/|$)';
        } else {
            // Just prepend our namespace
            $path = self::$namespace . $path;
        }

        return $path;
    }

    /**
     * Build a Route instance
     *
     * @param callable $callback    Callable callback method to execute on route match
     * @param string $path          Route URI path to match
     * @param string|array $method  HTTP Method to match
     * @param boolean $count_match  Whether or not to count the route as a match when counting total matches
     * @param string $name          The name of the route
     * @static
     * @access public
     * @return Route
     */
    public static function build($callback, $path = null, $method = null, $count_match = true, $name = null)
    {
        return Route::factory(
            array(
                $callback,
                self::preprocessPathString($path),
                $method,
                self::shouldPathStringCauseRouteMatch($path), // Ignore the $count_match boolean that they passed
                $name
                ),
            '',
            true
            );
    }
}