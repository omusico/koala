<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Cache;
/**
 * 缓存接口
 * @package  Koala\Server\Cache
 * @author    LunnLew <lunnlew@gmail.com>
 */
interface Face{
    /**
     * 设置缓存值
     * @param string  $key    缓存key
     * @param string  $var    缓存值
     * @param integer $expire 过期时间
     */
    function set($key, $var,$compress='',$expire=3600);
    /**
     * 获取缓存值
     * @param string  $key    缓存key
     * @return fixed      缓存值
     */
    function get($key);
    /**
     * 增值操作
     * @param  string  $key    缓存key
     * @param  integer $value 整数值 默认为1
     * @return bool          value/false
     */
    function incr($key, $value=1);
    /**
     * 减值操作
     * @param  string  $key    缓存key
     * @param  integer $value 整数值 默认为1
     * @return bool         value/false
     */
    function decr($key, $value=1);
     /**
     * 删除缓存项
     * @param  string  $key    缓存key
     * @return bool         true/false
     */
    function delete($key);
    /**
     * 压缩缓存项
     *
     * 默认大于2k以0.2压缩比压缩.
     * @param  integer $threshold   数据大小
     * @param  float   $min_savings 压缩比
     */
    function compress($threshold=2000,$min_savings=0.2);
    /**
     * 缓存过期
     * @return
     */
    function flush();
    /**
     * 缓存清空
     * @return
     */
    function flushAll();
}