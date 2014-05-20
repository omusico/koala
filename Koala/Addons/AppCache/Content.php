<?php
defined('IN_KOALA') or exit();
class AppCache_Content{
    protected static $instance = null;
	protected $group = 'Content'; 
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
    public function setContent($content_id,$content,$expire=3600){
       return self::$instance->set($content_id,$content,$expire);
    }
    public function getContent($cache_id){
        //得到分页数据 
        $artdata = self::$instance->get($cache_id);
        if( FALSE === $artdata){
            return null;
        } 
        return $artdata; 
    }
    public function updateContent($conditions='',$data=''){
        //更新数据库数据操作 
        
        $type='new';
        $page='1';
        $limit=0;
        //设置memcached的key，在key的末端加上版本号 
        $cache_id = 'type'.$type.'_page'.$page.'_limit'.$limit;

        self::$instance->set($cache_id,'qaz');

        //更新Content的版本，这样所有Content表相关的缓存就都失效了，下次调用getContent函数的时候将生成新的缓存数据 
       	self::$instance->flush();
    }
}
?>