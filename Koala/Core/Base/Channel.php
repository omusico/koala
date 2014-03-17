<?php
defined('IN_Koala') or exit();
class Base_Channel{
	abstract public function __construct();
	//建立一个通道
    abstract public function createChannel(channel,$duration=3600);
    //推送一条信息
    abstract public function sendMessage($channel,$content);
}
?>