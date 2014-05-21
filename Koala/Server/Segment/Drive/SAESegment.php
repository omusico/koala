<?php
namespace Koala\Server\Segment\Drive;
use Koala\Server\Segment\Base;

/**
 * 
 *分词服务
 *
 */
class SAESegment extends Server\Segment\Base{
	var $object = '';
	public function __construct(){
		$this->object = new \SaeSegment();
	}
}
?>