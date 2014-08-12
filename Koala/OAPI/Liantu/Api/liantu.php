<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

/**
 * 联图网 二维码 api
 * 
 * http://www.liantu.com/pingtai/
 */
//获取二维码
$cfg['get_qr'] = array(
	'url'=>'http://qr.liantu.com/api.php',
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=>array('text','bg','fg','gc','el','w','m','pt','inpt','logo'),
	);
return $cfg;