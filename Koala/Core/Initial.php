<?php
class Initial{
    static $instance=array();
    /**
     * 配置初始化
     * @param  Closure $initializer 匿名函数
     */
    public static function initialize(Closure $initializer,$option=array()){
        $initializer(self::getInstance(),$option);
    }
    /**
     * 获得实例
     * @return object        对象实例
     */
    public static function getInstance(){
        $class = get_called_class();
        $md5_class = MD5($class);
        if(!isset(static::$instance[$md5_class])){
            static::$instance[$md5_class] = new static();
        }
        return static::$instance[$md5_class];
    }
}