<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Addons\Demo;
use Plugin;
/**
* 插件实现类 Demo
*  Plugin::trigger('hello');
*  Plugin::trigger('hi');
*  Plugin::trigger('bye');
*/
class Action{
    /**
    * 供插件管理器主动加载的入口
    * @param string $plugin 插件管理器
    */
    function __construct(){
        //你想自动挂接的钩子列表
        Plugin::register('hello', array(&$this,'sayHello'));
        Plugin::register('bye', 'Addons\Demo\Action::sayBye');
        Plugin::register('hi', 'Addons\Demo\Action::sayHi',array('demo'));
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