<?php
class Core_Channel_Base implements Core_Channel_Face{
    //初始化
    function __construct(){}
    public function createChannel(channel,$duration=3600){}
    public function sendMessage($channel,$content){}
}
?>