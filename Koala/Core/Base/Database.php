<?php
defined('IN_Koala') or exit();
abstract class Base_Database{
    abstract public function __construct();
    //读操作
    abstract protected function _query($sql);
    //写操作
    abstract protected function _execute($sql);
    /**
     * 获得数据表字段
     * @param  string $table 数据表
     * @return array        字段信息索引数组
     */
    abstract protected function _getFields($table);
    /**
     * 获得数据库表信息
     * @param  string $dbname 数据库
     * @return array          数据表列表
     */
    abstract protected function _getTables($dbname);

    abstract public function __call($method,$args);
    abstract public function __destruct() ;
}    
?>