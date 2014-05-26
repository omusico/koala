<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Session;
interface Face{
	/**
     * session_open
     */
	public static function open($path, $name);
	/**
     * session_close
     */
	public static function close();
	/**
     * session_read
     * @param mixed $id session id
     */
	public static function read($id);
	/**
     * session_write
     * @param mixed $id session id
     * @param mixed $data session data
     */
	public static function write($id,$data);
	/**
     * session_destroy
     * @param mixed $id session id
     */
	public static function destroy($id);
	/**
     * session_gc
     * @param int $maxLifeTime session最大生存时间
     */
	public static function gc($maxLifeTime='3600');
}