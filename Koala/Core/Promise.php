<?php
/**
 * KoalaCMS - A PHP CMS System In Koala FrameWork
 *
 * @package  KoalaCMS
 * @author   LunnLew <lunnlew@gmail.com>
 */
class Promise {
	static $instance = null;
	var $msg = null;
	var $state = 0;
	var $result;
	/**
	 * 获取实例
	 * @return instance  Promise
	 */
	public static function getIns() {
		if (static::$instance == null) {
			static::$instance = new self;
		}
		return static::$instance;
	}
	public function then() {
		$args = func_get_args();
		if ($this->state) {
			if (isset($args[0]) && is_bool($args[0]) && $args[0]) {
				return;
			}
			if (isset($args[0]) && is_callable($args[0])) {
				call_user_func_array($args[0], array($this->state, $this->msg, $this->result));
			} else {
				exit(json_encode(array('info' => isset($args[0]) ? $args[0] . $this->msg : $this->msg, 'status' => 1, 'url' => '', 'state' => 'success')));
			}
		} else {
			if (isset($args[1]) && is_callable($args[1])) {
				call_user_func_array($args[1], array($this->state, $this->msg, $this->result));
			} else {
				exit(json_encode(array('info' => isset($args[1]) ? $args[1] . $this->msg : $this->msg, 'status' => 0, 'url' => '', 'state' => 'fail')));
			}
		}
		return $this;
	}
	public function resolve($state) {
		$this->state = $state;
		return $this;
	}
	public function setMsg($msg) {
		$this->msg = $msg;
		return $this;
	}
	public function setResult($result) {
		$this->result = $result;
		return $this;
	}
	public function setState($state, $msg = null, $result = null) {
		$this->state = $state;
		$this->msg = $msg;
		$this->result = $result;
		return $this;
	}
}
