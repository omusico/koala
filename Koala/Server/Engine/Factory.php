<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Koala\Server\Engine;
/**
 * 模板引擎工厂类
 * 
 * @package  Koala
 * @subpackage  Server\Engine
 * @author    Lunnlew <Lunnlew@gmail.com>
 */
class Factory extends \Koala\Server\Factory{
    public static function getServerName($name){
        $server_name = 'Smarty';
        switch($name){
            case 'twig':
                $server_name = 'Twig' ;
                break;
            case 'tengine':
                $server_name = 'Tengine' ;
                break;
            case 'smarty':
            default:
                $server_name = 'Smarty' ;
        }
        return self::getRealName('Engine',$server_name);
    }
}