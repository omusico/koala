<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 本地eaccelerator缓存实现
 *
 * @package  Koala\Server\Cache
 * @subpackage  Drive
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
namespace Koala\Server\Cache\Drive;
use Koala\Server\Cache\Base;

final class LAEeaccelerator extends Base {
	/**
	 * 检查驱动状态
	 * @return bool
	 */
	function checkDriver() {
		if (function_exists("eaccelerator_get")) {
			return true;
		}
		return false;
	}
	/**
	 *  初始化服务
	 * @return bool
	 */
	function initServer() {
		$version = @unserialize(eaccelerator_get('version_' . $this->group()));
		if (!empty($version)) {
			$this->version = $version;
		} else {
			eaccelerator_put('version_' . $this->group(), serialize($this->version));
		}
	}
	/**
	 * 设置缓存值
	 * @param string  $key    缓存key
	 * @param string  $var    缓存值
	 * @param integer $expire 过期时间
	 */
	function set($key, $var, $expire = 3600) {
		if (!$expire) {
			$expire = $this->options['expire'];
		}
		return eaccelerator_put($this->key($key), serialize($var), $expire);
	}
	/**
	 * 获取缓存值
	 * @param string  $key    缓存key
	 * @return fixed      缓存值
	 */
	function get($key) {
		return @unserialize(eaccelerator_get($this->key($key)));
	}
	/**
	 * 增值操作
	 * @param  string  $key    缓存key
	 * @param  integer $value 整数值 默认为1
	 * @todo
	 * @return bool          value/false
	 */
	function incr($key, $value = 1) {}
	/**
	 * 减值操作
	 * @param  string  $key    缓存key
	 * @param  integer $value 整数值 默认为1
	 * @todo
	 * @return bool          value/false
	 */
	function decr($key, $value = 1) {}
	/**
	 * 删除缓存项
	 * @param  string  $key    缓存key
	 * @return bool         true/false
	 */
	function delete($key) {
		return eaccelerator_rm($this->key($key));
	}
	/**
	 * 压缩缓存项
	 *
	 * 默认大于2k以0.2压缩比压缩.
	 * @param  integer $threshold   数据大小
	 * @param  float   $min_savings 压缩比
	 * @todo
	 */
	function compress($threshold = 2000, $min_savings = 0.2) {}
	/**
	 * 缓存过期
	 * @return
	 */
	function flush() {
		if (FALSE === $this->version) {
			$this->version = 1;
		} else {
			++$this->version;
		}
		eaccelerator_put('version_' . $this->group(), serialize($this->version));
	}
	/**
	 * 缓存清空
	 * @return
	 */
	function flushAll() {
		@eaccelerator_clean();
		@eaccelerator_clear();
		return;
	}
}