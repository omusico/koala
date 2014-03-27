<?php
/**
 * 日志服务
 */
class Log{
	/**
     * Detailed debug information
     */
    const DEBUG = 100;

    /**
     * Interesting events
     *
     * Examples: User logs in, SQL logs.
     */
    const INFO = 200;

    /**
     * Uncommon events
     */
    const NOTICE = 250;

    /**
     * Exceptional occurrences that are not errors
     *
     * Examples: Use of deprecated APIs, poor use of an API,
     * undesirable things that are not necessarily wrong.
     */
    const WARNING = 300;

    /**
     * Runtime errors
     */
    const ERROR = 400;

    /**
     * Critical conditions
     *
     * Example: Application component unavailable, unexpected exception.
     */
    const CRITICAL = 500;

    /**
     * Action must be taken immediately
     *
     * Example: Entire website down, database unavailable, etc.
     * This should trigger the SMS alerts and wake you up.
     */
    const ALERT = 550;

    /**
     * Urgent alert.
     */
    const EMERGENCY = 600;

    /**
     * Monolog API version
     *
     * This is only bumped when API breaks are done and should
     * follow the major version of the library
     *
     * @var int
     */
    const API = 1;
    /**
    * 操作句柄数组
    * @var array
    */
    static protected $handlers = array();
	//实例化日志
	public static function factory($type=''){
		if(empty($type)||!is_string($type)){
			$type = C('Log:DEFAULT','Monolog');
		}
		if(!isset(self::$handlers[$type])){
			self::$handlers[$type] = Server_Log_Factory::getInstance($type,C('Log:'.$type));
		}
		return self::$handlers[$type];
	}
}