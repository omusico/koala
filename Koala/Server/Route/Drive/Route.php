<?php
namespace Koala\Server\Route\Drive;
final class Route{
	/**
     * Properties
     */

    /**
     * The callback method to execute when the route is matched
     *
     * Any valid "callable" type is allowed
     *
     * @var callable
     * @access protected
     */
    protected $callback;

    /**
     * The URL path to match
     *
     * Allows for regular expression matching and/or basic string matching
     *
     * Examples:
     * - '/posts'
     * - '/posts/[:post_slug]'
     * - '/posts/[i:id]'
     *
     * @var string
     * @access protected
     */
    protected $path;

    /**
     * The HTTP method to match
     *
     * May either be represented as a string or an array containing multiple methods to match
     *
     * Examples:
     * - 'POST'
     * - array('GET', 'POST')
     *
     * @var string|array
     * @access protected
     */
    protected $method;

    /**
     * Whether or not to count this route as a match when counting total matches
     *
     * @var boolean
     * @access protected
     */
    protected $count_match;

    /**
     * The name of the route
     *
     * Mostly used for reverse routing
     *
     * @var string
     * @access protected
     */
    protected $name;
	public function __construct($options=array()){
		if(!empty($options))
			$this->setOptions($options);
    }
    public function setOptions($options=array()){
		// Initialize some properties (use our setters so we can validate param types)
        $this->setCallback($options[0]);
        $this->setPath($options[1]);
        $this->setMethod($options[2]);
        $this->setCountMatch($options[3]);
        $this->setName($options[4]);
        return $this;
    }

    /**
     * Get the callback
     *
     * @access public
     * @return callable
     */
    public function getCallback()
    {
        return $this->callback;
    }
    
    /**
     * Set the callback
     *
     * @param callable $callback
     * @throws InvalidArgumentException If the callback isn't a callable
     * @access public
     * @return Route
     */
    public function setCallback($callback)
    {
        if (!is_callable($callback)) {
            throw new \InvalidArgumentException('Expected a callable. Got an uncallable '. gettype($callback));
        }

        $this->callback = $callback;

        return $this;
    }

    /**
     * Get the path
     *
     * @access public
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
    
    /**
     * Set the path
     *
     * @param string $path
     * @access public
     * @return Route
     */
    public function setPath($path)
    {
        $this->path = (string) $path;

        return $this;
    }

    /**
     * Get the method
     *
     * @access public
     * @return string|array
     */
    public function getMethod()
    {
        return $this->method;
    }
    
    /**
     * Set the method
     *
     * @param string|array $method
     * @throws InvalidArgumentException If a non-string or non-array type is passed
     * @access public
     * @return Route
     */
    public function setMethod($method)
    {
        // Allow null, otherwise expect an array or a string
        if (null !== $method && !is_array($method) && !is_string($method)) {
            throw new \InvalidArgumentException('Expected an array or string. Got a '. gettype($method));
        }

        $this->method = $method;

        return $this;
    }

    /**
     * Get the count_match
     *
     * @access public
     * @return boolean
     */
    public function getCountMatch()
    {
        return $this->count_match;
    }
    
    /**
     * Set the count_match
     *
     * @param boolean $count_match
     * @access public
     * @return Route
     */
    public function setCountMatch($count_match)
    {
        $this->count_match = (boolean) $count_match;

        return $this;
    }

    /**
     * Get the name
     *
     * @access public
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    
    /**
     * Set the name
     *
     * @param string $name
     * @access public
     * @return Route
     */
    public function setName($name)
    {
        if (null !== $name) {
            $this->name = (string) $name;
        } else {
            $this->name = $name;
        }

        return $this;
    }


    /**
     * Magic "__invoke" method
     *
     * Allows the ability to arbitrarily call this instance like a function
     *
     * @param mixed $args Generic arguments, magically accepted
     * @access public
     * @return mixed
     */
    public function __invoke($args = null)
    {
        $args = func_get_args();

        return call_user_func_array(
            $this->callback,
            $args
        );
    }
}