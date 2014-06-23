<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Storage;
/**
 * 工厂类
 * 
 * @package  Koala
 * @subpackage  Server\Storage
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory extends \Koala\Server\Factory{
    public static function getServerName($name){
        $server_name = 'LAEStorage';
        switch($name){
            case 'storage':
                if(APPENGINE=='SAE'){
                    if (function_exists('SAEStorage')) $server_name = 'SAEStorage' ;
                }elseif(APPENGINE=='BAE'){
                    if (class_exists('BaeStorage')) $server_name = 'BaeStorage' ;
                }else{
                    if (class_exists('Storage')) $server_name = 'LAEStorage' ;
                }
            break;
        }
        return self::getRealName('Storage',$server_name);
    }
}