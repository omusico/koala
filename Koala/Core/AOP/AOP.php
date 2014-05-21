<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Core\AOP;
/**
 * AOP实现类
 */
class AOP{
	/**
	 * ReflectionMethod对象 数组
	 * @var array
	 */
    private static $method_reflection = array();
    //合并配置
    private static $aop_config = array();
    //自定义配置
    private $config = array();
    //调用 配置参数
    private $call_config = array();
    /**
     * 构造
     * @param string $class 业务类
     */
    function __construct($class){
        if(is_object($class)){
            $this->class = $class;
        }else
        $this->class = ucwords($class);
    }
    /**
     * 获取包装$class 的 对象实例
     * @param  string $class 业务类
     * @return Object   
     */
    public static function getInstance($class){
        self::$aop_config = AOPConfig::get();
        return new self($class);
    }
    /**
     * 获取 业务类 所有的 advices 信息
     * @param  string $class  业务类
     * @param  string $method 方法
     * @return array         配置
     */
    public function getAdvices($class, $method){
        if(is_object($class))
            $class = get_class($class);
        //合并配置
        $aop_config = array_reverse(array_merge(self::$aop_config, $this->config, $this->call_config));
        //重置本次调用配置
        $this->call_config = array();
        list($class_pre) = explode('/',str_replace('\\','/', $class));
        //匹配后的配置
        $advice_configs = array();
        foreach ($aop_config as $config){
            //首字母大写
            $point_class = ucwords($config['point']['class']);
            //匹配
            if (( $point_class== $class || in_array($class_pre, explode(',',$config['point']['class']))) && 
                ($config['point']['method'] == $method || $config['point']['method'] == '*')
            ){
                $advice_configs[] = $config;
            }
        }
        return $advice_configs;
    }
    /**
     * 配置加载
     * @param  fixed  $config 配置
     * @return object        self
     */
    function config($config){
        $this->config[] = $config;
        return $this;
    }
    /**
     * 移除配置
     * @param  fixed  $config 配置
     * @return object        self
     */
    function unconfig($unconfig){
        foreach (self::$aop_config as $n => $config){
            if ($config == $unconfig)
            {
                unset(self::$aop_config[$n]);
            }
        }
        sort(self::$aop_config);

        foreach ($this->config as $n => $config){
            if ($config == $unconfig)
            {
                unset($this->config[$n]);
            }
        }
        sort($this->config);

        foreach ($this->call_config as $n => $config){
            if (isset($config['advice']['class'])){
                $_config = array('class'=>$config['advice']['class'], 'method'=>$config['advice']['method']);
            }
            else if (isset($config['advice']['object'])){
                $_config = array('object'=>$config['advice']['class'], 'method'=>$config['advice']['method']);
            }
            if ($_config == $unconfig){
            
                unset($this->call_config[$n]);
            }
        }
        sort($this->call_config);

        return $this;
    }
    /**
     * 利用call方法为业务类添加切面
     * @param  string $method 业务类的方法
     * @param  array $params 业务类方法参数
     * @return fixed         返回值
     */
    function __call($method, $params){
        $advice_configs = $this->getAdvices($this->class, $method);
        if(is_object($this->class)){
           $advice_container = new AdviceContainer($this->class);
        }else
            $advice_container = new AdviceContainer(new $this->class());
        //根据配置生成关系
        foreach ($advice_configs as $config){
            //方面方法参数
            $_params = isset($config['advice']['params']) ? $config['advice']['params'] : array();
            //增加方面逻辑
            if (isset($config['advice']['class'])){
                //生成切面对象
                $advice_proxy = new AdviceProxy($config['event'], new $config['advice']['class'], $config['advice']['method'], $_params);
                // 添加切面链, 生成一个递归对象链
                $advice_container = $advice_container->addAdvice($advice_proxy);
            }else if (isset($config['advice']['object'])){
                 //生成切面对象
                $advice_proxy = new AdviceProxy($config['event'], $config['advice']['object'], $config['advice']['method'], $_params);
                 // 添加切面链, 生成一个递归对象链
                $advice_container = $advice_container->addAdvice($advice_proxy);
            }
        }
        if(is_object($this->class))
            $class = get_class($this->class);
        else
            $class = $this->class;
        //缓存方法
        if (!isset(self::$method_reflection[$class][$method])){
            $callee = new \ReflectionMethod($class, $method);
            self::$method_reflection[$class][$method] = $callee;
        }else
        {
            $callee = self::$method_reflection[$class][$method];
        }
        //调用执行对象链
        $ret = call_user_func(array($advice_container, $method), $class, $params, $callee->getParameters());
        return $ret;
    }
    /**
     * 前置增强
     * @param  array $advice
     * @return object       
     */
    function before($advice){
        return $this->event($advice, 'before');
    }
    /**
     * 后置增强
     * @param  array $advice
     * @return object       
     */
    function after($advice){
        return $this->event($advice, 'after');
    }
    /**
     * 环绕增强
     * @param  array $advice
     * @return object       
     */
    function around($advice){
        return $this->event($advice, 'around');
    }
    /**
     * 事件配置
     * @param  array $advice
     * @param  string $event before、after、around..
     * @return object   
     */
    private function event($advice, $event){
        if(is_object($this->class))
            $class = get_class($this->class);
        else
            $class = $this->class;

        $this->call_config[] = array(
                    'event'	 => $event,
                    'point' => array('class'=>$class, 'method'=>'*'),
                    'advice'=> $advice,
        );
        return $this;
    }
}