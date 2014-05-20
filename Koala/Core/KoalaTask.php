<?php
//目录分隔符
defined('DS') or define('DS', DIRECTORY_SEPARATOR);

//框架核心版本
define("FRAME_VERSION",'1.0');

//框架发布时间
define('FRAME_RELEASE','20140323');

//核心初始化需求

//加载单例实现
include(__DIR__.'/Singleton.php');

/**
 * CLI方式核心初始化实现类
 */
class KoalaCore extends Singleton{
 	/**
     * 执行应用
     * 若应用没有实现子类execute,则使用该默认方法
     * @static
     * @access public
     */
    public static function execute(){
        //使用命令行解析器
        Task::factory(KoalaCLI::options())->execute();
    }
}
/**
 * 内核初始化进程
 */
KoalaCore::initialize(function(){

});

/**
 * 需要延迟初始化的部分
 */
KoalaCore::lazyInitialize(function(){
	
});