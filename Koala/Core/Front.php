<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 前端控制器
 * 
 * @package  Koala
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Front{
	/**
	 * 信息标识
	 * @var int
	 */
    protected static $message_state = \Core\Front\MessageState::COMMON;
    /**
     * 信息内容
     * @var string
     */
    protected static $msg = '';
	/**
	 * 错误信息提示
	 */
	public static function error($msg){
		self::$message_state = \Core\Front\MessageState::ERROR;
		self::$msg=$msg;
	}
	/**
	 * 成功信息提示
	 */
	public static function success($msg){
		self::$message_state = \Core\Front\MessageState::SUCCESS;
		self::$msg=$msg;
	}
	/**
	 * 一般信息提示
	 */
	public static function info($msg){
		self::$message_state = \Core\Front\MessageState::INFO;
		self::$msg=$msg;
	}
	/**
	 * 信息踢死
	 * @param  string $message 信息内容
	 * @param  int $code    信息码
	 */
	public static function message($message,$code=\Core\Front\MessageState::INFO){
		self::$message_state = $code;
		self::$msg=$message;
	}
	/**
	 * 获取信息标识
	 * @return int \Core\Front\MessageState
	 */
	public static function getState(){
      	return self::$message_state;
    }
    /**
     * 获取信息
     * @return string 信息内容
     */
    public static function getMsg(){
      	return self::$msg;
    }
}