<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Counter;
/**
 * Counter工厂类
 * 
 * @package  Koala
 * @subpackage  Server\Counter
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory extends \Koala\Server\Factory{
    public static function getServerName($name){
        $server_name = 'LAECounter';
        switch($name){
            case 'counter':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAECounter')) $server_name = 'SAECounter' ;
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeCounter')) $server_name = 'BaeCounter' ;
                }else{
                    if (class_exists('Counter')) $server_name = 'LAECounter' ;
                }
            break;
        }
         return self::getRealName('Counter',$server_name);
    }
}