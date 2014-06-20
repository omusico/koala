<?php
defined('IN_KOALA') or exit();
//
//see https://github.com/jpfuentes2/php-activerecord
//
if (!defined('PHP_VERSION_ID') || PHP_VERSION_ID < 50300)
	die('PHP ActiveRecord requires PHP 5.3 or higher');

define('PHP_ACTIVERECORD_VERSION_ID','1.0');

if (!defined('PHP_ACTIVERECORD_AUTOLOAD_PREPEND'))
	define('PHP_ACTIVERECORD_AUTOLOAD_PREPEND',true);
if (!defined('PHP_ACTIVERECORD_AUTOLOAD_DISABLE'))
	spl_autoload_register('activerecord_autoload',false,PHP_ACTIVERECORD_AUTOLOAD_PREPEND);

define('ARDIR',FRAME_PATH.'External/ActiveRecord/');
require ARDIR.'Utils.php';
require ARDIR.'Exceptions.php';

ClassLoader::initialize(function($instance){
    //注册_autoload函数
    $instance->register();
    $instance->registerNamespaces(array(
        'ActiveRecord'=>FRAME_PATH.'External'
    ));
});

ActiveRecord\Config::initialize(function($cfg)
{
   $cfg->set_model_directory(MODEL_PATH);
   $cfg->set_connections(array(
        'development' => C('DB_TYPE').'://'.C('DB_USER').':'.C('DB_PASS').'@'.C('DB_HOST_M').':'.C('DB_PORT').'/'.C('DB_NAME').'?decode=true/&/charset='.C('DB_CHARSET')));
   //$cfg->set_cache("Memcache://localhost");
});

class ActiveModel extends ActiveRecord\Model{
	//全局表前缀//在子类可覆盖
	static $tpr = 'koala_';
	public function __construct(array $attributes=array(), $guard_attributes=true, $instantiating_via_find=false, $new_record=true){
		self::$tpr = C('DB_PREFIX');
		parent::__construct($attributes, $guard_attributes, $instantiating_via_find, $new_record);
	}
	//将数据装换为非对象数组
	public static function conv2arr($objlist){
		$list = array();
		foreach ($objlist as $key => $obj) {
			$list[] = $obj->to_array();
		}
		return $list;
	}
	/**
     * 获得记录数
	 */
    public static function getNum(){
        $sql = "SHOW TABLE STATUS FROM ".C('DB_NAME')." LIKE '".self::table_name()."'";
        $sth = self::query($sql);
        $rows = $sth->fetchAll();
        return $rows[0]['rows'];
    }
}
?>