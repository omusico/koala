<?php
defined('IN_Koala') or exit();
//校验函数库
/**
 * sql过滤处理
 * 主要对不太长的请求字符串进行处理。
 * @param string $str 要处理的字符串
 */
function SqlInjiectFilter(&$str,$key=''){
    //关键字表
    $keys = array('select','update','insert','and','or','xor','order','union','group','user');
    $rkeys = array('se\lect','up\date','ins\ert','an\d','o\r','x\or','or\der','uni\on','gro\up','us\er');
    //对str进行解码
    $str = urldecode($str);
    //1、空格分割处理关键字
    $arr = explode(' ',$str);
    //深度处理
    foreach ($arr as $key => $value) {
        $ckey = $key;
        $cvalue = $value;
        $tempstr='';
        //对可能存在的关键字进行处理
        $tempstr =str_replace($keys,$rkeys,$cvalue);
        //保存
        $arr[$ckey]=$tempstr;
    }
    //连接
    $str = implode(' ',$arr);
    unset($arr);
    //2、对与sql相关特殊字符右侧新增\
    //特殊字符表
    $char = array('/','*','-',';','%','@','(','<');
    $rchar = array('/\\','*\\','-\\',';\\','%\\','@\\','(\\','<\\');
    $str = str_replace($char, $rchar, $str);

    //return $str;
}

/**
 * 回复sql过滤处理
 * 主要对不太长的请求字符串进行处理。
 * @param string $str 要处理的字符串
 */
function RevertSqlInjiectFilter(&$str,$key=''){
    
    //关键字表
    $rkeys = array('select','update','insert','and','or','xor','order','union','group','user');
    $keys = array('se\lect','up\date','ins\ert','an\d','o\r','x\or','or\der','uni\on','gro\up','us\er');
    //对str进行解码
    $str = urldecode($str);
    //1、空格分割处理关键字
    $arr = explode(' ',$str);
    //深度处理
    foreach ($arr as $key => $value) {
        $ckey = $key;
        $cvalue = $value;
        $tempstr='';
        //对可能存在的关键字进行处理
        $tempstr =str_replace($keys,$rkeys,$cvalue);
        //保存
        $arr[$ckey]=$tempstr;
    }
    //连接
    $str = implode(' ',$arr);
    unset($arr);
    //2、对与sql相关特殊字符右侧侧新增\
    //特殊字符表
    $rchar = array('/','*','-',';','%','@','(');
    $char = array('/\\','*\\','-\\',';\\','%\\','@\\','(\\');
    $str = str_replace($char, $rchar, $str);
    
    //return $str;
}
/**
 * 过滤
 */
function Filter($str,$callfunc='SqlInjiectFilter'){
    if(is_string($str)){
        $strarr = array($str);
    }else{
        $strarr = $str;
    }
    array_walk_recursive($strarr, $callfunc);
    return $strarr;
}
//检查是否是汉字//gbk版
function isCWInGBK($str){
    $iscw = 0;
    if(preg_match("(([\xB0-\xF7][\xA1-\xFE])|([\x81-\xA0][\x40-\xFE])|([\xAA-\xFE][\x40-\xA0])|(\w))+", $str)){
        $iscw =1;
    }
    return $iscw;
}
//检查是否是汉字//utf8版
function isCWInUTF8($str){
    $iscw = 0;
    //4E00-9FFF：常用汉字
    if(preg_match("/^[\x{4E00}-\x{9FFF}]+$/u",$str)){
        $iscw=1;
    }
    //3400-4DBF：罕用汉字A
    if(preg_match("/^[\x{3400}-\x{4DBF}]+$/u",$str)){
        $iscw=1;
    }
    //其他区域20000-2A6DF,2A700-2B73F,F900-FAFF,2F800-2FA1F无数据或者包含少量偏僻数据
    return $iscw;
}


function addslashes_array(&$arr_r) { 
 foreach ($arr_r as &$val) is_array($val) ? addslashes_array($val):$val=addslashes($val); 
 unset($val); 
} 
?>