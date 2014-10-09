<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Cache;
/**
 * 缓存基类
 * @package  Koala\Server\Cache
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Base implements Face {
	/**
	 * 配置项
	 *
	 * @var array
	 * @access protected
	 */
	protected $options = array(
		'group' => '[APP_UUID]',
		'expire' => 3600,
		'compress' => 1,
	);
	/**
	 * 缓存数据版本
	 *
	 * @var integer
	 * @access protected
	 */
	protected $version = 1;
	/**
	 * 构造函数
	 * @param array $options 配置选项
	 */
	function __construct($options = array()) {
		$this->setOption($options);
		if (!$this->checkDriver()) {
			$class = get_called_class();
			throw new \Koala\Exception\NotSupportedException("不能使用驱动[" . substr($class, strripos($class, '\\') + 1) . "],请检查是否支持该扩展!");
		}
		$this->initServer();
	}
	/**
	 *  设置配置项
	 */
	public function setOption($options = array()) {
		if (!empty($options)) {
			$this->options = $options + $this->options;//合并配置
		}
		preg_match_all('/[\w]+/', $this->options['group'], $res);
		$this->options['group'] = '';
		foreach ($res[0] as $key => $value) {
			if (defined($value)) {
				$this->options['group'] .= constant($value);
			} else {
				throw new \Exception('Not Define Constant [' . $value . ']!');
			}
		}
	}
	/**
	 * 检查驱动状态
	 * @abstract
	 * @return bool
	 */
	abstract public function checkDriver();
	/**
	 *  初始化服务
	 *  @abstract
	 * @return bool
	 */
	abstract public function initServer();
	/**
	 * 设置缓存值
	 * @param string  $key    缓存key
	 * @param string  $var    缓存值
	 * @param integer $expire 过期时间
	 */
	abstract public function set($key, $var, $compress = '', $expire = 3600);
	/**
	 * 获取缓存值
	 * @param string  $key    缓存key
	 * @return fixed      缓存值
	 */
	abstract public function get($key);
	/**
	 * 增值操作
	 * @param  string  $key    缓存key
	 * @param  integer $value 整数值 默认为1
	 * @return bool          value/false
	 */
	abstract public function incr($key, $value = 1);
	/**
	 * 减值操作
	 * @param  string  $key    缓存key
	 * @param  integer $value 整数值 默认为1
	 * @return bool         value/false
	 */
	abstract public function decr($key, $value = 1);
	/**
	 * 删除缓存项
	 * @param  string  $key    缓存key
	 * @return bool         true/false
	 */
	abstract public function delete($key);
	/**
	 * 压缩缓存项
	 *
	 * 默认大于2k以0.2压缩比压缩.
	 * @param  integer $threshold   数据大小
	 * @param  float   $min_savings 压缩比
	 */
	abstract public function compress($threshold = 2000, $min_savings = 0.2);
	/**
	 * 缓存过期
	 * @return
	 */
	abstract public function flush();
	/**
	 * 缓存清空
	 * @return
	 */
	abstract public function flushAll();
	/**
	 * 生成完整缓存key
	 *
	 * @param  string $key 缓存key
	 * @access protected
	 * @return string $key 完整缓存key
	 */
	protected function key($key) {
		return $this->options['group'] . '_' . $this->version . '_' . $key;
	}
	/**
	 * 缓存组
	 *
	 * @access protected
	 * @return string 缓存组
	 */
	protected function group() {
		return $this->options['group'];
	}
	/**
	 * 设置缓存前缀对外方法
	 * @param  string $prex 缓存key前缀
	 * @access protected
	 * @return string 缓存组
	 */
	public function setCachePrex($prex) {
		$this->options['group'] = $this->options['group'] . $prex;
	}
}