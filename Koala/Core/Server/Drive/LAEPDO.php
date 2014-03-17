<?php
defined('IN_Koala') or exit();
class Drive_LAEPDO extends Base_Database{
	public $oobj = null;
	public function __construct() {
        $str = DB_TYPE.":host=".DB_HOST_M.";port=".DB_PORT.";dbname=".DB_NAME;
        $this->oobj = new PDO($str, DB_USER, DB_PASS);
    	$this->oobj->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    //读操作
    protected function _query($sql){
    	return $this->oobj->query($sql);
    }
    //写操作
    protected function _execute($sql){
    	return $this->oobj->execute($sql);
    }
    /**
     * 获得数据表字段
     * @param  string $table 数据表
     * @return array        字段信息索引数组
     */
    protected function _getFields($table){
    	$result =   $this->_query('SHOW COLUMNS FROM '.$this->parseKey($table));
        $info   =   array();
        if($result) {
            foreach ($result as $key => $val) {
                $info[$val['Field']] = array(
                    'name'    => $val['Field'],
                    'type'    => $val['Type'],
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
     * 获得数据库表信息
     * @param  string $dbname 数据库
     * @return array          数据表列表
     */
    protected function _getTables($dbname){
    	if(!empty($dbName)) {
           $sql    = 'SHOW TABLES FROM '.$dbName;
        }else{
           $sql    = 'SHOW TABLES ';
        }
        $result =   $this->_query($sql);
        $info   =   array();
        foreach ($result as $key => $val) {
            $info[$key] = current($val);
        }
        return $info;
    }
    /**
     * 字段和表名处理添加`
     * @access protected
     * @param string $key
     * @return string
     */
    protected function parseKey(&$key) {
        $key   =  trim($key);
        if(!preg_match('/[,\'\"\*\(\)`.\s]/',$key)) {
           $key = '`'.$key.'`';
        }
        return $key;
    }
    public function __call($method,$args){
    	if(stripos($method,'get')===0){
    		return call_user_func_array(array($this,'_'.$method),$args);
    	}
    }
    public function __destruct(){}
}
?>