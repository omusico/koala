<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
/**
 * Advice对象链实现
 */
namespace Core\AOP;
use Exception;

class AdviceContainer{
    /**
     * 目标  AdviceContainer对象 或者 主业务对象
     * @var AdviceContainer $target
     */
    private $target;
    /**
     * @var Advice $advice
     */
    private $advice;

    private $class, $method, $params, $method_reflection;
    /**
     * 切面方法的结果
     * @var array
     */
    private $advice_result = array();

    private $lazy_advices = array();
    private $last_lazy_advices = array();

    private $original_method = true;

    private $ret = null;

    function __construct($target, $advice = null)
    {
        $this->target = $target;
        $this->advice = $advice;
    }

    function addAdvice($advice)
    {
        return new self($this, $advice);
    }
    /**
     * 注册延迟调用
     */
    private function lazyAdvices(){
        //如果目标是主业务
        if (method_exists($this->target, $this->method) && ! $this->target instanceof AdviceContainer){
            //存在需要延迟实现的切面具体植入方法,如round
            if (!empty($this->lazy_advices)){
                //如果与最后一次的数据不相同
                if ($this->last_lazy_advices != $this->lazy_advices){
                    //另建一个对象
                    $target = clone $this->target;
                    $container = new AdviceContainer($target);
                    $this->last_lazy_advices = array_reverse($this->lazy_advices);
                    $this->advice = array_pop($this->lazy_advices);
                    //增加切面对项链
                    foreach ($this->lazy_advices as $lazy_advice){
                        $container = $container->addAdvice($lazy_advice);
                    }
                    //设置目标
                    $this->target = $container;
                    // 重置
                    $this->lazy_advices = array();

                }
                else
                {
                    throw new Exception('bad code, loop advices');
                }
            }
        }
    }
    /**
     * 递归链执行
     */
    private function call(){
        //是业务对象时，
        if (method_exists($this->target, $this->method) && ! $this->target instanceof AdviceContainer){
            //是否执行原始方法
            if ($this->original_method){
                //增加主方法与次方法通信
                $params = $this->getParamValues();
                array_pop($params);
                array_push($params,$this);
                $this->ret = call_user_func_array(array($this->target, $this->method), $params);
            }
            return $this->ret;
        }else// AdviceContainer Object
        {
            if ($this->target instanceof AdviceContainer){
                try
                {
                    try
                    {
                        //优先检测执行环绕方法
                        //(拦截主业务,在前后执行一段逻辑, 因为这种特性，所以最先执行)
                        $this->ret = $this->advice->around($this);
                        return $this->ret;
                    }
                    catch(NoAroundAdviceEventException $e)
                    {
                        //当没有环绕方法时，执行前置，主业务进程，后置
                        $this->advice->before($this);
                        //递归执行target
                        $this->ret = $this->proceed();
                        $this->advice->after($this);
                        return $this->ret;
                    }
                }
                catch(LazyAdviceException $e)
                {
                    //否则进行延迟调用
                    $this->lazy_advices[] = $this->advice;
                    $this->ret = $this->proceed();
                    return $this->ret;
                }
                catch(Exception $e)
                {
                    return $this->advice->exception($e);
                }
            }
            else
            {
                throw new Exception('method ' . $this->method . ' is not defined');
            }
        }
    }
    /**
     * 执行对象链，会执行此对象，方法为 主业务类的方法，但对象并没有该方法，即执行__call 方法
     */
    function __call($method, $params){
        $this->method = $method;
        // 得到业务类名 和 业务方法参数
        list ($this->class, $_params, $this->method_reflection) = $params;
        $this->params = array();
        //该行代码在对象链中 保持 参数正确
        $_params = array_values($_params);
        if ($_params){
            /**
             * @var ReflectionParameter $param
             */
            foreach ($params[2] as $k => $param)
            {
                $this->params[$param->getName()] = isset($_params[$k])?$_params[$k]:($param->isDefaultValueAvailable()?$param->getDefaultValue():null);
            }
        }
        //处理延迟调用
        $this->lazyAdvices();
        // 解析对象链，分别执行
        return $this->call();
    }
    //递归执行target
    function proceed(){
        if ($this->target instanceof AdviceContainer){
            $this->target->setAdviceResults($this->getAdviceResults());
            $this->target->setOriginalMethod($this->getOriginalMethod());
            $this->target->setLazyAdvices($this->getLazyAdvices());
            $this->target->setLastLazyAdvices($this->last_lazy_advices);
        }
        
        $ret = call_user_func(array($this->target, $this->method), $this->class, $this->getParamValues(), $this->method_reflection);

        if ($this->target instanceof AdviceContainer){
            $this->setAdviceResults($this->target->getAdviceResults());
        }
        
        return $ret;
    }
    /**
     * 设置方面结果
     * @param string $key 项
     * @param fix $val 值
     */
    function setAdviceResult($key, $val){
        if (false === strpos($key, '.')){
            $prefix = $this->adviceResultPrefix();
            $this->advice_result[$prefix . $key] = $val;
        }else{
           $this->advice_result[$key] = $val;
        }
    }
    /**
     * 获取切面结果
     * @param string $key 项
     * @return fixed $val 值
     */
    function getAdviceResult($key){
        if (false === strpos($key, '.'))
        {
            $key = $this->adviceResultPrefix() . $key;
        }
        return $this->advice_result[$key];
    }
    /**
     * 获取切面结果数组
     * @return array 
     */
    function getAdviceResults(){
        return $this->advice_result;
    }
     /**
     * 设置切面结果数组
     * @return array 
     */
    function setAdviceResults($advice_result){
        return $this->advice_result = $advice_result;
    }
    /**
     * 是否设置了key的值
     * @param string $key 项
     * @return fixed $val 值
     */
    function issetAdviceResult($key){
        if (false === strpos($key, '.'))
        {
            $key = $this->adviceResultPrefix() . $key;
        }
        return array_key_exists($key, $this->advice_result);
    }
    /**
     * 获取key前缀
     */
    private function adviceResultPrefix(){
        $backtrace = debug_backtrace();
        return isset($backtrace[2]) ? $backtrace[2]['class'] . '.' : '';
    }
    /**
     * 设置延迟调用切面
     */
    function setLastLazyAdvices($last_lazy_advices){
        $this->last_lazy_advices = $last_lazy_advices;
    }
    /**
     * 设置主业务方法
     */
    function getMethod()
    {
        return $this->method;
    }
    /**
     * 获取方法参数
     * @param  string $key  项
     * @param  fixed $default 默认值
     * @return fixed          值
     */
    function getParam($key, $default = null) {
        return array_key_exists($key, $this->params) ? $this->params[$key] : $default;
    }
    /**
     * 获取方法参数表
     * @return fixed          值
     */
    function getParams(){
        return $this->params;
    }
    /**
     * 获取类名
     * @return fixed   业务类名
     */
    function getClassName(){
        return $this->class;
    }
    /**
     * 设置方法参数
     * @param  string $key  项
     * @param  fixed $val 值
     */
    function setParam($key, $val){
        if (array_key_exists($key, $this->params))
        {
            $param = & $this->params[$key];
            if (gettype($val) == gettype($param) && ! is_object($val))
            {
                if (is_array($val))
                {
                    $keys = array_keys($param);
                    foreach ($val as $k => $v)
                    {
                        if (in_array($k, $keys))
                        {
                            $param[$k] = $v;
                        }
                    }
                }
                else
                {
                    $param = $val;
                }
                return true;
            }
            return false;
        }
        else
        {
            return false;
        }
    }
    /**
     * 获取非索引数组 参数表
     * @return fix
     */
    function getParamValues(){
        return $this->params;
    }

    /**
     * 设置original method是否运行开关
     * 与原值 与操作
     * @param Bool $bool
     * @return void
     * 
     */
    function setOriginalMethod($bool){
        $this->original_method = $bool && $this->original_method;
    }
    /**
     * 获取业务类原始方法
     * @return string
     */
    function getOriginalMethod(){
        return $this->original_method;
    }
    /**
     * 获取延迟调用切面对象表
     * @return array
     */
    function getLazyAdvices(){
        return $this->lazy_advices;
    }
    /**
     * 设置延迟调用切面对象表
     * @return array
     */
    function setLazyAdvices($lazy_advices){
        $this->lazy_advices = $lazy_advices;
    }

    function getRet(){
        return $this->ret;
    }
}