<?php
function var_filter(&$value,$key,$arr){
    //array_walk_recursive($arr,"var_filter",array($v,$k));
    $value = str_replace("[".strtoupper($arr[1])."]",$arr[0],$value);
}
function pluginTrigger($plugin_name,$data=''){
    PluginManagerSTC::getInstance($plugin_name);
    PluginManagerSTC::trigger($plugin_name,$data);
}
function PT($plugin_name,$data=''){
    PluginManagerSTC::getInstance($plugin_name);
    PluginManagerSTC::trigger($plugin_name,$data);
}
function   strToHex($string,$exp=''){   
      $hex="";   
      for   ($i=0;$i<strlen($string);$i++)   
      $hex.=$exp.dechex(ord($string[$i]));   
      $hex=strtoupper($hex);   
      return   $hex;   
   }   
function   hexToStr($hex,$exp=''){
    $hex=str_replace($exp,'', $hex);
      $string="";   
      for   ($i=0;$i<strlen($hex)-1;$i+=2)   
      $string.=chr(hexdec($hex[$i].$hex[$i+1]));   
      return   $string;   
}
//命令行参数解析
function parseShell($argv,$isunix=false){
    $_ARG = array();
    foreach ($argv as $arg){
    if(preg_match('#^-{1,2}([a-zA-Z0-9]*)=?(.*)$#', $arg, $matches)){
        $key = $matches[1];
        switch ($matches[2]){
        case '':
        case 'true':
          $arg = true;
          break;
        case 'false':
          $arg = false;
          break;
        default:
          $arg = $matches[2];
        }
        /* make unix like -afd == -a -f -d */
        if($isunix&&preg_match("/^-([a-zA-Z0-9]+)/", $matches[0], $match)){
            $string = $match[1];
            for($i=0; strlen($string) > $i; $i++) {
                $_ARG[$string[$i]] = true;
            }
        }else{
            $_ARG[$key] = $arg;    
        }    

    }else{
      $_ARG['input'][] = $arg;
    }
  }
  return $_ARG;
}
 /**
    *$rule,要验证的规则名称；
    *$uid,用户的id；
    *$relation，规则组合方式，默认为‘or’，以上三个参数都是根据Auth的check（）函数来的，
    *$t,符合规则后，执行的代码
    *$f，不符合规则的，执行代码，默认为抛出字符串‘没有权限’
    */
function authcheck($rule,$uid,$relation='or',$t,$f='没有权限'){
    if($relation==''){
        $relation='or';
    }
    $auth=new Helper_Authority();
    return $auth->getAuth($rule,$uid,$relation)?$t:$f;
}
/**
 * 字符串命名风格转换
 * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
 * @param string $name 字符串
 * @param integer $type 转换类型
 * @return string
 */
function parse_name($name, $type=0) {
    if ($type) {
        return ucfirst(preg_replace("/_([a-zA-Z])/e", "strtoupper('\\1')", $name));
    } else {
        return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
    }
}
function listDir($dir = '.',&$list=array(),$search='',$replace=''){
    if ($handle = opendir($dir)) {
        while (false !== ($file = readdir($handle))) {
            if($file == '.' || $file == '..'){
                continue;
            }
            if(is_dir($sub_dir = realpath($dir.'/'.$file))){
               // echo 'FILE in PATH:'.$dir.':'.$file.'<br>';
                listDir($sub_dir,$list,$search,$replace);
            }else{
                if($search!=''||$replace!='')
                    $tdir = str_replace($search, $replace, $dir);
                else{
                    $tdir = $dir;
                }
                $list[$tdir][] = $file;
                //echo 'FILE:'.$file.'<br>';
            }
        }
        closedir($handle);
    }
}
/**
 * URL重定向
 * @param string $url 重定向的URL地址
 * @param integer $time 重定向的等待时间（秒）
 * @param string $msg 重定向前的提示信息
 * @return void
 */
function redirect($url, $time=0, $msg='') {
    //多行URL地址支持
    $url        = str_replace(array("\n", "\r"), '', $url);
    if (empty($msg))
        $msg    = "系统将在{$time}秒之后自动跳转到{$url}！";
    if (!headers_sent()) {
        // redirect
        if (0 === $time) {
            header('Location: ' . $url);
        } else {
            header("refresh:{$time};url={$url}");
            echo($msg);
        }
        exit();
    } else {
        $str    = "<meta http-equiv='Refresh' content='{$time};URL={$url}'>";
        if ($time != 0)
            $str .= $msg;
        exit($str);
    }
}

/**
 * 生成随机字符串
 * @param string $lenth 长度
 * @return string 字符串
 */
function createRandomstr($lenth = 6) {
    return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}
/**
* 产生随机字符串
*
* @param    int        $length  输出长度
* @param    string     $chars   可选的 ，默认为 0123456789
* @return   string     字符串
*/
function random($length, $chars = '0123456789') {
    $hash = '';
    $max = strlen($chars) - 1;
    for($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}
//w文件目录排序 for kindeditor
function cmp_func($a, $b) {
    global $order;
    if ($a['is_dir'] && !$b['is_dir']) {
        return -1;
    } else if (!$a['is_dir'] && $b['is_dir']) {
        return 1;
    } else {
        if ($order == 'size') {
            if ($a['filesize'] > $b['filesize']) {
                return 1;
            } else if ($a['filesize'] < $b['filesize']) {
                return -1;
            } else {
                return 0;
            }
        } else if ($order == 'type') {
            return strcmp($a['filetype'], $b['filetype']);
        } else {
            return strcmp($a['filename'], $b['filename']);
        }
    }
}
//字符串截取
function sub_str($str,$len=0){
    return implode('',getSplit($str,$len));
}
//获取控制器类名
function getController($group,$module,$depr='\\',$namespace='Controller'){
    return $namespace.$depr.$group.$depr.$module;
}

/**
 * 建立较低碰撞率ID
 * @param  string $namespace 名称前缀
 * @return string            id串
 */
function createShortGuid($namespace = '') {     
    static $guid = '';
    $uid = uniqid("", true);
    $data = $namespace;
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= $_SERVER['LOCAL_ADDR'];
    $data .= $_SERVER['LOCAL_PORT'];
    $data .= $_SERVER['REMOTE_ADDR'];
    $data .= $_SERVER['REMOTE_PORT'];
    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
    $guid = substr($hash,  0,  8) . 
            '-' .
            substr($hash,  8,  4) .
            '-' .
            substr($hash, 12,  4) ;
    return $guid;
  }
function createGuid($namespace = '') {     
    static $guid = '';
    $uid = uniqid("", true);
    $data = $namespace;
    $data .= $_SERVER['REQUEST_TIME'];
    $data .= $_SERVER['HTTP_USER_AGENT'];
    $data .= $_SERVER['LOCAL_ADDR'];
    $data .= $_SERVER['LOCAL_PORT'];
    $data .= $_SERVER['REMOTE_ADDR'];
    $data .= $_SERVER['REMOTE_PORT'];
    $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
    $guid = substr($hash,  0,  8) . 
            '-' .
            substr($hash,  8,  4) .
            '-' .
            substr($hash, 12,  4) .
            '-' .
            substr($hash, 16,  4) .
            '-' .
            substr($hash, 20, 12) ;
    return $guid;
  }
?>