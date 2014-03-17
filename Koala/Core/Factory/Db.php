<?php
defined('IN_Koala') or exit();
class Factory_Db{
	protected static $instances = array();
  protected $db_type = 'auto';
   /**
    * 生成并返回指定的数据库操作对象
    *  mixed $config : 数据库配置，可以为数组或者为如下格式的字符串
    *    数据库类型://用户名:密码@主机:端口/数据库名   
    *    如:  mysql://root:root@127.0.0.1:3306/mydb//TODO
   */
   static function getInstance($db_type='auto'){
   	if(!array_key_exists($db_type,self::$instances)||self::$instances[$db_type]==''){
   		self::$instances[$db_type] = new Factory_Db();
   		self::$instances[$db_type]->setType($db_type);
      if(stripos(self::$instances[$db_type]->db_type,APPENGINE)!==false){
            $class = 'Drive_'.self::$instances[$db_type]->db_type;
      }else{
          $class = 'Drive_'.self::$instances[$db_type]->db_type;
          if(!class_exists($class)){
               $class = self::$instances[$db_type]->db_type;
          }
      }
      if(class_exists($class)){
        self::$instances[$db_type] = new $class();
      }
	    else
	    	return null;
   	}
   	return self::$instances[$db_type];
   }
   public function setType($db_type='auto'){
        $this->db_type=strtolower($db_type);
        switch($this->db_type){
        	case 'laepdo':
        		if(class_exists('PDO'))$this->db_type = 'LAEPDO';
        		else trigger_error('未发现 PDO 支持!');  
        	break;
          case 'mysql':
              if (function_exists('mysql_connect'))$this->db_type = 'Mysql';
              else trigger_error('未发现 Mysql 支持!');    
          break;
          case 'auto'://try to auto select a cache system
              if (function_exists('mysql_connect'))    $this->db_type = 'Mysql';
              else trigger_error('没有发现任何可用的数据库支持');
          break;
          default://not any cache selected or wrong one selected
              if (isset($db_type)) $msg='未识别的数据库类型<b>'.$db_type.'</b>';
              else $msg='没有设置数据库类型';
              trigger_error($msg);   
          break;
        }
    }
}
?>