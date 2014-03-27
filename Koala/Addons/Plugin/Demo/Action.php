<?php
class Plugin_Demo_Action{
    protected $name = 'Demo';
	//解析函数的参数是pluginManager的引用
    function __construct(&$pluginManager='',$param=''){
        //注册这个插件
        //第一个参数是钩子的名称
        //第二个参数是plugin类的引用
        //第三个是插件所执行的方法
        if($pluginManager!='')
            $pluginManager->register($this->name, $this, 'say_hello');

    }

    function say_hello($data=''){
        echo 'Hello World';

    }
}
?>