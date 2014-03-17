<?php
//系统环境检测函数库
//是否安全连接
function is_ssl(){
    return false;
}
//返回请求方式
function getMethod(){
    return $_SERVER['REQUEST_METHOD'];
}
//是否是flash请求
function is_flash(){
     return isset($_SERVER['HTTP_USER_AGENT']) && (stripos($_SERVER['HTTP_USER_AGENT'],'Shockwave')!==false || stripos($_SERVER['HTTP_USER_AGENT'],'Flash')!==false);
}
//ajax请求判断
function is_ajax(){
    //jquery  HTTP_X_REQUESTED_WITH
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      return true;
    }
    //跨域
    if(isset($_SERVER['HTTP_ACCEPT'])){
        switch ($_SERVER['HTTP_ACCEPT']){  
            case 'application/json, text/javascript, */*':  
                //  JSON 格式  
                //break;  
            case 'text/javascript, application/javascript, */*':  
                // javascript 或 JSONP 格式  
                return true;
                break;  
            case 'text/html, */*':  
                //  HTML 格式  
                break;  
            case 'application/xml, text/xml, */*':  
                //  XML 格式  
                break;  
        }
    }
    return false;
}
/**
* 获得当前的域名
*
* @return string
*/
function getDomain(){

    /* 协议 */
    $protocol = (isset($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')) ? 'https://' : 'http://';

    /* 域名或IP地址 */
    if (isset($_SERVER['HTTP_X_FORWARDED_HOST']))
    {
        $host = $_SERVER['HTTP_X_FORWARDED_HOST'];
    }
    elseif (isset($_SERVER['HTTP_HOST']))
    {
        $host = $_SERVER['HTTP_HOST'];
    }
    else
    {
        /* 端口 */
        if (isset($_SERVER['SERVER_PORT']))
        {
            $port = ':' . $_SERVER['SERVER_PORT'];

            if ((':80' == $port && 'http://' == $protocol) || (':443' == $port && 'https://' == $protocol))
            {
            $port = '';
            }
        }
        else
        {
            $port = '';
        }

    if (isset($_SERVER['SERVER_NAME']))
    {
        $host = $_SERVER['SERVER_NAME'] . $port;
    }
    elseif (isset($_SERVER['SERVER_ADDR']))
    {
        $host = $_SERVER['SERVER_ADDR'] . $port;
    }
    }
    $domain['protocol'] = $protocol;
    $domain['host'] = $host;
    return $domain;
}
?>