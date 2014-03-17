<?php
namespace UFM\Interfaces;

/**
*扩展接口
*/
interface Filter{
	public function append(&$param);
	public function getStatus();
}