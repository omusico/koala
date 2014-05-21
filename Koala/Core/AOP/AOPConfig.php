<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Core\AOP;

class AOPConfig{
    static function get(){
        $aop_config = include(FRAME_PATH.'Config/aop.php');
        if(is_file(APP_PATH.'Config/aop.php')){
        	$aop_config_app = include(APP_PATH.'Config/aop.php');
       		$aop_config = array_merge($aop_config,$aop_config_app);
        }
        return array_reverse($aop_config);
    }
}