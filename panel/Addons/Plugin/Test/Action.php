<?php
namespace Plugin\Test;
use Plugin;
/**
 * 插件实现类
 */
class Action{
    /**
     * 供插件管理器主动加载的入口
     * @param string $plugin 插件管理器
     */
    function __construct($plugin){
            //你想自动挂接的钩子列表
            //@todo 请删除按实际情况实现
            $plugin::register('hello', array(&$this,'sayHello'));
    }
    /**
     * 钩子调用的方法
     * @todo 请删除按实际情况实现
     */
    function sayHello(){echo 'Hello World!<br>';}
}