<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
/**
 * 缓存基类
 * @package  Koala\Server\Cache
 * @author    Lunnlew <Lunnlew@gmail.com>
 */
namespace Koala\Server\Cache;
class Base implements Face{
    /**
     * 配置项
     * 
     * @var array
     * @access protected
     */
    protected $options=array(
        'group'=>'[APP_NAME][APP_VERSION]',
        'expire'=>3600,
        'compress'=>1
    );
    /**
     * 缓存数据版本,用于缓存立即失效
     * 
     * @var integer
     * @access protected
     */
    protected $version = 1;
    /**
     * 生成完整缓存key
     * 
     * @param  string $key 缓存key
     * @access protected
     * @return string $key 完整缓存key
     */
    protected function key($key){
        return $this->option['group'].'_'.$this->version.'_'.$key;
    }
    /**
     * 缓存组
     * 
     * @access protected
     * @return string 缓存组
     */
    protected function group(){
        return $this->option['group'];
    }
}