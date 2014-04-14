<?php
namespace Base;
/**
 * REST 基类
 */
abstract class REST{
	/**
	 * get操作
	 */
	abstract public function get();
	/**
	 * post操作
	 */
	abstract public function post();
	/**
	 * put操作
	 */
	abstract public function put();
	/**
	 * delete操作
	 */
	abstract public function delete();
}