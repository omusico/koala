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
        $aop_config = include(dirname(ADVICE_PATH).'/config.php');
        return array_reverse($aop_config);
    }
}