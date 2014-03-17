<?php
namespace UUM\Interfaces;

/**
*认证扩展接口
*/
interface Identity{
	public function append($user);
	public function getStatus();
}