<?php
namespace Server\Segment\Drive;
use Server\Segment\Base;

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