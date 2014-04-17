<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Core\AOP;

class AOPConfig{
    static function get(){
        $aop_config = include(FRAME_PATH.'Config'.DIRECTORY_SEPARATOR.'aop.php');
        if(is_file(APP_PATH.'Config'.DIRECTORY_SEPARATOR.'aop.php')){
        	$aop_config_app = include(APP_PATH.'Config'.DIRECTORY_SEPARATOR.'aop.php');
       		$aop_config = array_merge($aop_config,$aop_config_app);
        }
        return array_reverse($aop_config);
    }
}