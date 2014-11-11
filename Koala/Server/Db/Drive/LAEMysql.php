<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Db\Drive;
use Koala\Server\Db\Base;

final class LAEMysql extends Base {
	/**
	 * 架构函数 读取数据库配置信息
	 * @access public
	 * @param array $config 数据库配置数组
	 */
	public function __construct($config = '') {
		switch (extension_loaded('mysql')) {
			case false:
				exit('no mysql extension!');
				break;
			case true:
			default:
				if (!empty($config)) {
					$this->config = $config;
					if (empty($this->config['params'])) {
						$this->config['params'] = '';
					}
				}
				break;
		}
	}
	/**
	 * 连接数据库方法
	 * @access public
	 */
	public function connect($config = '', $linkNum = 0, $force = false) {
		if (!isset($this->links[$linkNum])) {
			if (empty($config)) {
				$config = $this->config;
			}
			// 处理不带端口号的socket连接情况
			$host = $config['db_host'] . ($config['db_port'] ? ":{$config['db_port']}" : '');
			// 是否长连接
			$pconnect = !empty($config['params']['persist']) ? $config['params']['persist'] : $this->pconnect;
			if ($pconnect) {
				$this->links[$linkNum] = mysql_pconnect($host, $config['db_user'], $config['db_pass'], 131072);
			} else {
				$this->links[$linkNum] = mysql_connect($host, $config['db_user'], $config['db_pass'], true, 131072);
			}
			if (!$this->links[$linkNum] || (!empty($config['db_name']) && !mysql_select_db($config['db_name'], $this->links[$linkNum]))) {
				exit(mysql_error());
			}
			$dbVersion = mysql_get_server_info($this->links[$linkNum]);
			//使用UTF8存取数据库
			mysql_query("SET NAMES '" . $config['db_charset'] . "'", $this->links[$linkNum]);
			//设置 sql_model
			if ($dbVersion > '5.0.1') {
				mysql_query("SET sql_mode=''", $this->links[$linkNum]);
			}
			// 标记连接成功
			$this->connected = true;
			// 注销数据库连接配置信息
			if (!(bool) C('DB_DEPLOY_TYPE', false)) {
				unset($this->config);
			}
		}
		return $this->links[$linkNum];
	}
	/**
	 * 释放查询结果
	 * @access public
	 */
	public function free() {
		if (is_resource($this->current_query)) {
			mysql_free_result($this->current_query);
		}
		$this->current_query = null;
	}
	/**
	 * 执行语句
	 * @access public
	 * @param string $str  sql指令
	 * @return integer|false
	 */
	public function execute($str) {
		//连接主服务器
		if ($this->initConnect(true)) {
			$this->query_str = $str;
			//释放前次的查询结果
			if ($this->current_query) {$this->free();}
			if (false === (mysql_query($str, $this->current_link))) {
				$this->error();
			} else {
				$this->num_rows = mysql_affected_rows($this->current_link);
				$this->lastInsID = mysql_insert_id($this->current_link);
				return $this->num_rows;
			}
		}
		return false;
	}
	/**
	 * 执行查询 返回数据集
	 * @access public
	 * @param string $str  sql指令
	 * @return mixed
	 */
	public function query($str) {
		if (0 === stripos($str, 'call')) {// 存储过程查询支持
			$this->close();
			$this->connected = false;
		}
		$this->initConnect(false);
		if (!$this->current_link) {return false;
		}

		$this->queryStr = $str;
		//释放前次的查询结果
		if ($this->current_query) {$this->free();}
		$this->current_query = mysql_query($str, $this->current_link);
		$this->debug();
		if (false === $this->current_query) {
			$this->error();
			return false;
		} else {
			$this->numRows = mysql_num_rows($this->current_query);
			return $this->getAll();
		}
	}
	/**
	 * 启动事务
	 * @access public
	 * @return void
	 */
	public function startTrans() {
		$this->initConnect(true);
		if (!$this->current_link) {return false;
		}

		//数据rollback 支持
		if ($this->transTimes == 0) {
			mysql_query('START TRANSACTION', $this->current_link);
		}
		$this->transTimes++;
		return;
	}

	/**
	 * 用于非自动提交状态下面的查询提交
	 * @access public
	 * @return boolen
	 */
	public function commit() {
		if ($this->transTimes > 0) {
			$result = mysql_query('COMMIT', $this->current_link);
			$this->transTimes = 0;
			if (!$result) {
				$this->error();
				return false;
			}
		}
		return true;
	}

	/**
	 * 事务回滚
	 * @access public
	 * @return boolen
	 */
	public function rollback() {
		if ($this->transTimes > 0) {
			$result = mysql_query('ROLLBACK', $this->current_link);
			$this->transTimes = 0;
			if (!$result) {
				$this->error();
				return false;
			}
		}
		return true;
	}

	/**
	 * 获得所有的查询数据
	 * @access private
	 * @return array
	 */
	private function getAll() {
		//返回数据集
		$result = array();
		if ($this->numRows > 0) {
			while ($row = mysql_fetch_assoc($this->current_query)) {
				$result[] = $row;
			}
			mysql_data_seek($this->current_query, 0);
		}
		return $result;
	}

	/**
	 * 取得数据表的字段信息
	 * @access public
	 * @return array
	 */
	public function getFields($tableName) {
		$result = $this->query('SHOW COLUMNS FROM ' . $this->parseKey($tableName));
		$info = array();
		if ($result) {
			foreach ($result as $key => $val) {
				$info[$val['Field']] = array(
					'name' => $val['Field'],
					'type' => $val['Type'],
					'notnull' => (bool) (strtoupper($val['Null']) === 'NO'), // not null is empty, null is yes
					'default' => $val['Default'],
					'primary' => (strtolower($val['Key']) == 'pri'),
					'autoinc' => (strtolower($val['Extra']) == 'auto_increment'),
				);
			}
		}
		return $info;
	}

	/**
	 * 取得数据库的表信息
	 * @access public
	 * @return array
	 */
	public function getTables($dbName = '') {
		if (!empty($dbName)) {
			$sql = 'SHOW TABLES FROM ' . $dbName;
		} else {
			$sql = 'SHOW TABLES ';
		}
		$result = $this->query($sql);
		$info = array();
		foreach ($result as $key => $val) {
			$info[$key] = current($val);
		}
		return $info;
	}

	/**
	 * 替换记录
	 * @access public
	 * @param mixed $data 数据
	 * @param array $options 参数表达式
	 * @return false | integer
	 */
	public function replace($data, $options = array()) {
		foreach ($data as $key => $val) {
			$value = $this->parseValue($val);
			if (is_scalar($value)) {// 过滤非标量数据
				$values[] = $value;
				$fields[] = $this->parseKey($key);
			}
		}
		$sql = 'REPLACE INTO ' . $this->parseTable($options['table']) . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $values) . ')';
		return $this->execute($sql);
	}

	/**
	 * 插入记录
	 * @access public
	 * @param mixed $datas 数据
	 * @param array $options 参数表达式
	 * @param boolean $replace 是否replace
	 * @return false | integer
	 */
	public function insertAll($datas, $options = array(), $replace = false) {
		if (!is_array($datas[0])) {return false;
		}

		$fields = array_keys($datas[0]);
		array_walk($fields, array($this, 'parseKey'));
		$values = array();
		foreach ($datas as $data) {
			$value = array();
			foreach ($data as $key => $val) {
				$val = $this->parseValue($val);
				if (is_scalar($val)) {// 过滤非标量数据
					$value[] = $val;
				}
			}
			$values[] = '(' . implode(',', $value) . ')';
		}
		$sql = ($replace ? 'REPLACE' : 'INSERT') . ' INTO ' . $this->parseTable($options['table']) . ' (' . implode(',', $fields) . ') VALUES ' . implode(',', $values);
		return $this->execute($sql);
	}

	/**
	 * 关闭数据库
	 * @access public
	 * @return void
	 */
	public function close() {
		if ($this->current_link) {
			mysql_close($this->current_link);
		}
		$this->current_link = null;
	}

	/**
	 * 数据库错误信息
	 * 并显示当前的SQL语句
	 * @access public
	 * @return string
	 */
	public function error() {
		$this->error = mysql_errno() . ':' . mysql_error($this->current_link);
		if ('' != $this->queryStr) {
			$this->error .= "\n [ SQL语句 ] : " . $this->queryStr;
		}
		exit($this->error);
		return $this->error;
	}

	/**
	 * SQL指令安全过滤
	 * @access public
	 * @param string $str  SQL字符串
	 * @return string
	 */
	public function escapeString($str) {
		if ($this->current_link) {
			return mysql_real_escape_string($str, $this->current_link);
		} else {
			return mysql_escape_string($str);
		}
	}

	/**
	 * 字段和表名处理添加`
	 * @access protected
	 * @param string $key
	 * @return string
	 */
	protected function parseKey(&$key) {
		$key = trim($key);
		if (!is_numeric($key) && !preg_match('/[,\'\"\*\(\)`.\s]/', $key)) {
			$key = '`' . $key . '`';
		}
		return $key;
	}
}