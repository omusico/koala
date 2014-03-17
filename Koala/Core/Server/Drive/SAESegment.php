<?php
defined('IN_Koala') or exit();
/**
 * SAE分词服务
 */
class Drive_SAESegment extends Base_Segment{
	var $object = '';
	public function __construct(){
		$this->object = new SaeSegment();
	}
	public function Start($str){
	}
}
?>