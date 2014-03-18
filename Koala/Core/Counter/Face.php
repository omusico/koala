<?php
interface Core_Counter_Face{
    //初始化
    function __construct();
    //建立一个计数器
    public static function create();
    //移除一个计数器
    public static function remove();
    //获得某项的值
    public static function get();
    //设置计数器的值
    public static function set();
    //获得多个计数器的值
    public static function mget();
    //设置多个计数器的值
    public static function mset();
    //对计数器减
    public static function decrease();
    //对计数器加
    public static function increase();
    //获得计数器列表
    public static function getAllList();
    //判断计数器是否存在
    public static function isExist();
    //获得计数器数量
    public static function getNums();
}
?>