<?php
namespace Server\Segment\Drive;
use Server_Segment_Base;

/**
 * 
 *分词服务
 *
 */
class SAESegment extends Server_Segment_Base{
	var $object = '';
	public function __construct(){
		$this->object = new \SaeSegment();
	}
}
?>