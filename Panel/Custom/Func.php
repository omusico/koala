<?php

//==========视图函数库
/**
 * smarty调用函数
 * {'url'|PU:'id':1:'page':1}   =>   url?id=1&page=1
 */
function PU(){
    $param = $one =$two =array();
    $args = func_get_args();
    $param[] = array_shift($args);
    if(count($args)%2!=0){
        array_pop($args);
    }
    foreach ($args as $key => $value) {
        if($key%2==0)
            $one[] = $value;
        else
            $two[] = $value;
    }
    $param = array_merge($param,array(array_combine($one,$two)));

    return call_user_func_array('U',$param);
}
/**
 * 字符串拼接
 * smarty调用函数
 * {'/'|cats:'s1':'s2':'s3'}   =>   s1/s2/s3
 */
function cats(){
    $args = func_get_args();
    $depr = array_shift($args);
    return implode($depr,$args);
}
function getFormHtml($type='',$option='',$id='',$name=''){
    if($type=='') $type = 'txt';
    switch ($type) {
        case 'select':
            $html = '<select class="form-control" id="'.$id.'" name="'.$name.'">';
            foreach ($option as $key => $value) {
                $html .= '<option value="'.$value.'"">'.$key.'</option>';
            }
            $html .='</select>';
            break;
        
        default:
            $html = '<input type="'.$type.'" class="form-control" id="'.$id.'" name="'.$name.'" value="'.$option.'"/>';
            break;
    }
    return $html;
}