<?php
//see  
//https://ui.ptlogin2.qq.com/js/10088/mq_comm.js
//http://pub.idqqimg.com/smartqq/js/mq.js
function ptui_checkVC($b, $e, $c) {
	return func_get_args();
}
//$window in window(0),top(1),parent(2)
function ptuiCB($status, $l, $href, $window=1, $msg, $nick){
	return func_get_args();
}
/**
 * uin转换为十六进制字符
 * @param  [type] $str [description]
 * @return [type]      [description]
 */
function uin2hex($str='') {
	$maxLength = 16;
	$hex=dechex((int)$str);
	$len = strlen($hex);
	for ($i = $len; $i < $maxLength; $i++) {
	   	$hex = "0".$hex;
	}
	$arr = [];
	for ($j = 0; $j < $maxLength; $j += 2) {
	   	array_push($arr,"\\x".substr($hex,$j, 2));
	}
	eval("\$result = \"" . implode("",$arr)."\";");
	return $result;
}
/**
 * 16进制字符 转 bin
 * 
 * @access public
 * @param string 16进制字符
 * @return string
 */
function hexchar2bin($str=''){
	$arr = [];
	$len = strlen($str);
	for ($i = 0; $i < $len; $i = $i + 2) {
	   	array_push($arr,"\\x". substr($str,$i,2));
	}
	eval("\$temp = \"" . implode("",$arr)."\";");
	return $temp;
}
function qqhash($uin,$ptwebqq){
	for ($N = $ptwebqq."password error", $T = "", $V = []; ; ){
		if (strlen($T) <= strlen($N)) {
		 	$T .= $uin;
		 	if (strlen($T) == strlen($N))break;
		} else {
			$T = substr($T, 0,strlen($N));break;
		}
	}
	for ($U = 0; $U < strlen($T); $U++)
		$V[$U] = uniord(substr($T,$U)) ^ uniord(substr($N,$U));
	$N = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F"];
	$T = "";
	for ($U = 0; $U < count($V); $U++) {
		$T .= $N[$V[$U] >> 4 & 15];
		$T .= $N[$V[$U] & 15];
	}
	return $T;
}
/**
 * 模拟 JavaScript charCodeAt函数 
 * 
 * protected
 * @param string $str
 * @return int
 */
function uniord($str){
	list(, $ord) = unpack('N', mb_convert_encoding($str, 'UCS-4BE', 'UTF-8'));
	return $ord;
}