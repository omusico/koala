<?php
defined('IN_KOALA') or exit();
class AppCache_Block{
	protected static $instance = null;
	protected $group = 'Block'; 
    protected $version = 1;
    public function __construct(&$instance,$config=array(),$group=''){
        if(isset($instance))
            self::$instance=$instance;
        else
            trigger_error('未初始化cache实例!');
        if($group==''){
            self::$instance->group = $this->group;
        }else{
            self::$instance->group = $group;
        }
        if($config){
            self::$instance->cfg = $config + self::$instance->cfg;//合并配置
        }
    }
    public function set($block_id,$block_content){
    	//key
        $cache_id = $block_id;
        return self::$instance->set($cache_id,$block_content);
    }
    public function get($block_id){
    	return self::$instance->get($cache_id);
    }
    public function del($block_id){
    	return self::$instance->delete($cache_id);
    }
    public function flush(){
    	return self::$instance->flush();
    }
    ///////////////////////////////////
}
?>