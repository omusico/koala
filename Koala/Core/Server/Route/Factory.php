<?php
namespace Server\Route;
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
}