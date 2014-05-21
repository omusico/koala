<?php
namespace Koala\Server\Counter;
class Base implements Face{
    //初始化
    function __construct(){}
    /**
     * 建立一个计数器
     * @param  string $name 计数器名称
     * @param  int $value   计数器值
     * @param  int $expires 计数器过期时间
     * @return bool       true/false
     */
    public function create($name,$value=0,$expires=-1){}
    /**
     * 移除一个计数器
     * @param  string $name 计数器名称
     * @return bool       true/false
     */
    public function remove($name){}
    /**
     * 设置计数器的值
     * @param string $name 计数器名称
     * @param int $value 计数器值
     * @return bool       计数器值/false
     */
    public function set($name,$value){}
    /**
     * 获得计数器的值
     * @param  string $name 计数器名称
     * @return int       值/false
     */
    public function get($name){}
    /**
     * 获得多个计数器的值
     * 
     * $list格式
     * array(
     * name1,name2,....
     * )
     * 返回数据格式
     * array('计数器名'=>计数器值
     * ...
     * )
     * 
     * @param array $list 计数器列表
     * @return array       计数器键值对/false
     */
    public function mget($list){}
    /**
     * 设置多个计数器的值
     * 
     * $keys格式
     * array('计数器名'=>计数器值
     * ...
     * )
     * 
     * @param array $keys 计数器键值对
     * @return bool       成功计数器数量/false
     */
    public function mset($keys){}
    /**
     * 对计数器减
     * @param  string $name 计数器名称
     * @param  int $value 需要减值
     * @return bool       计数器值/false
     */
    public function decrease($name,$value){}
    /**
     * 对计数器加
     * @param  string $name 计数器名称
     * @param  int $value 需要加值
     * @return bool       计数器值/false
     */
    public function increase($name,$value){}
    /**
     * 获得所有计数器列表
     * 返回数据格式
     * array(
     * array('name'=>$name,'value'=>$value),
     * ...
     * )
     * @return array 计数器列表数组/false
     */
    public function getAllList(){}
    /**
     * 判断计数器是否存在
     * @param  string $name 计数器名称
     * @return boolean       true/false
     */
    public function isExist($name){}
    /**
     * 获得计数器数量
     * @return int num/false
     */
    public function getNums(){}
}
?>