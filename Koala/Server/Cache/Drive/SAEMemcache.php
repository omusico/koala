<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * SAE Memcache缓存实现
 *
 * @package  Koala\Server\Cache
 * @subpackage  Drive
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
namespace Koala\Server\Cache\Drive;
use Koala\Server\Cache\Base;

final class SAEMemcache extends Base {
	/**
	 * 检查驱动状态
	 * @return bool
	 */
	function checkDriver() {
		if (function_exists("memcache_init")) {
			return true;
		}
		return false;
	}
	/**
	 *  初始化服务
	 * @return bool
	 */
	function initServer() {
		$this->mmc = memcache_init();
		if (!$this->mmc) {
			throw new \Koala\Exception\NotSupportedException('初始化SAE Memcahce失败!');
		}
		$version = $this->mmc->get('version_' . $group());//无数据第一次运行时的警告怎样抑制?
		if (!empty($version)) {
			$this->version = $version;
		} else {
			$this->mmc->set('version_' . $this->group(), $this->version);
		}
	}
	/**
	 * 设置缓存值
	 * @param string  $key    缓存key
	 * @param string  $var    缓存值
	 * @param integer $expire 过期时间
	 */
	function set($key, $var, $compress = '', $expire = 3600) {
		if (!$this->mmc) {return;
		}

		if (!$expire) {
			$expire = $this->options['expire'];
		}
		if ($compress != '') {
			$this->options['compress'] = $compress;
		}
		return $this->mmc->set($this->key($key), $var, $this->options['compress'] ? MEMCACHE_COMPRESSED : 0, $expire);
	}
	/**
	 * 获取缓存值
	 * @param string  $key    缓存key
	 * @return fixed      缓存值
	 */
	function get($key) {
		if (!$this->mmc) {return;
		}

		return $this->mmc->get($this->key($key));
	}
	/**
	 * 增值操作
	 * @param  string  $key    缓存key
	 * @param  integer $value 整数值 默认为1
	 * @return bool          value/false
	 */
	function incr($key, $value = 1) {
		if (!$this->mmc) {return;
		}

		return $this->mmc->increment($this->key($key), $value);
	}
	/**
	 * 减值操作
	 * @param  string  $key    缓存key
	 * @param  integer $value 整数值 默认为1
	 * @return bool         value/false
	 */
	function decr($key, $value = 1) {
		if (!$this->mmc) {return;
		}

		return $this->mmc->decrement($this->key($key), $value);
	}
	/**
	 * 删除缓存项
	 * @param  string  $key    缓存key
	 * @return bool         true/false
	 */
	function delete($key) {
		if (!$this->mmc) {return;
		}

		return $this->mmc->delete($this->key($key));
	}
	/**
	 * 压缩缓存项
	 *
	 * 默认大于2k以0.2压缩比压缩.
	 * @param  integer $threshold   数据大小
	 * @param  float   $min_savings 压缩比
	 */
	function compress($threshold = 2000, $min_savings = 0.2) {
		if (!$this->mmc) {return;
		}

		$this->mmc->setCompressThreshold($threshold, $min_savings);
	}
	/**
	 * 缓存过期
	 * @return
	 */
	function flush() {
		if (!$this->mmc) {return;
		}

		if (FALSE === $this->version) {
			$this->version = 1;
		} else {
			++$this->version;
		}
		$this->mmc->set('version_' . $this->group(), $this->version);
	}
	/**
	 * 缓存清空
	 * @return
	 */
	function flushAll() {
		if (!$this->mmc) {return;
		}

		return $this->mmc->flush();
	}
}