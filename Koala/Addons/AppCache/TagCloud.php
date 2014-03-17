<?php
defined('IN_Koala') or exit();
class AppCache_TagCloud{
    protected static $instance = null;
	protected $group = 'TagCloud'; 
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
    public function getTagCloud($tag_id){
        //得到数据 
        $artdata = self::$instance->get($tag_id);
        if( FALSE === $artdata){
            //重新从数据库得到数据并设置新的memcached缓存
            $arr = array('Actionscript' => 35, 'Adobe' => 22, 'Array' => 44, 'Background' => 43,
            'Blur' => 18, 'Canvas' => 33, 'Class' => 15, 'Color Palette' => 11, 'Crop' => 42,
            'Delimiter' => 13, 'Depth' => 34, 'Design' => 8, 'Encode' => 12, 'Encryption' => 30,
            'Extract' => 28, 'Filters' => 42);
            $tagstr = base64_encode(json_encode($arr));
            self::$instance->set($tag_id,$tagstr);
            return $tagstr;
        } 
        return $artdata; 
    }
    public function setTagCloud($tag_id,$tagstr,$expire=3600){
       return self::$instance->set($$tag_id,$tagstr,$expire);
    }
    public function updateTagCloud($conditions='',$data=''){
        //更新数据库数据操作 
        
        $type='new';
        $page='1';
        $limit=0;
        //设置memcached的key，在key的末端加上版本号 
        $cache_id = 'type'.$type.'_page'.$page.'_limit'.$limit;

        self::$instance->set($cache_id,'qaz');

        //更新TagCloud的版本，这样所有TagCloud表相关的缓存就都失效了，下次调用getTagCloud函数的时候将生成新的缓存数据 
       	self::$instance->flush();
    }
}
?>