<?php
class Server_Channel_Base implements Server_Channel_Face{
    //初始化
    function __construct(){}
    public function createChannel(channel,$duration=3600){}
    public function sendMessage($channel,$content){}
}
?>