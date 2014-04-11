<?php
namespace Server\Session;
class Base implements Face{
	public function open($path, $name){
	}
	public function close(){}
	public function read($key){}
	public function write($key,$value){}
	public function destroy($key){}
	public function gc($maxlifetime='3600'){}
}