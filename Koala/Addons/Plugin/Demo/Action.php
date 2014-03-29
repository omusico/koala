<?php
namespace Plugin\Demo;
use Plugin;
/**
 * 插件实现类
 *  Plugin::trigger('hello');
 *  Plugin::trigger('hi');
 *  Plugin::trigger('bye');
 */
class Action{
    /**
     * 供插件管理器主动加载的入口
     * @param string $plugin 插件管理器
     */
    function __construct($plugin){
            //你想自动挂接的钩子列表
            $plugin::register('hello', array(&$this,'sayHello'));
            $plugin::register('bye', 'Plugin\Demo\Action::sayBye');
            $plugin::register('hi', 'Plugin\Demo\Action::sayHi',array('demo'));
    }
    function sayHello(){
        echo 'Hello World!<br>';

    }
    static function sayBye(){
        echo 'Bye Bye!<br>';

    }
    static function sayHi($name){
        echo 'Hi! I am '.$name.'.<br>';

    }
}
?>