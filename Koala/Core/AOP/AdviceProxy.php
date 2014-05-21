<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Core\AOP;
use Exception;

class AdviceProxy{
    /**
     * 4 events
     * @var Advice
     */
    private $before, $after, $around, $exception;
    private $method, $params;

    function __construct($event, $advice, $method, $params = array()){
        $this->$event = $advice;
        $this->method = $method;
        $this->params = $params;
    }

    function __call($event, $params){
        if ($this->$event)
        {
            $params = array_merge($this->params, $params);
            return call_user_func_array(array($this->$event, $this->method), $params);
        }
        else
        {
            return null;
        }
    }

    function around(AdviceContainer $container){
        if ($this->around)
        {
            $this->params[] = $container;
            return call_user_func_array(array($this->around, $this->method), $this->params);
        }
        else
        {
            throw new NoAroundAdviceEventException();
        }
    }

    function exception(Exception $e){
        if ($this->exception)
        {
            
            return $this->exception->{$this->method}($e);
        }
        else
        {
            throw $e;
        }
    }
}