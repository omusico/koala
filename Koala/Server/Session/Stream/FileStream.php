<?php
namespace Koala\Server\Session\Stream;
use Koala\Server\Session\Base;
class FileStream extends Base{
	public function __construct($options=array()){}
	public function open($path, $name){}
	public function close(){}
	public function read($key){}
	public function write($key,$value){}
	public function destroy($key){}
	public function gc($maxlifetime='3600'){}
}