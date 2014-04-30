<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Core\Logic;
use Base_Logic;
/**
 * 核心模型管理逻辑
 */
class Model extends Base_Logic{
    public static function getList($type,$fileds='*',$where='',$order='id DESC',$start=0,$limit=500){
        $model = 'Core\Logic'.ucwords(strtolower($type));
        $obj = new $model();
        return $obj->getList($fileds,$where,$num,$start,$order);
    } 
}