<?php
namespace Koala\Server\Channel;
interface Face{
    //初始化
    function __construct();
    public function createChannel(channel,$duration=3600);
    public function sendMessage($channel,$content);
}