<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * SMS短信通API
 * http://www.smschinese.cn/api.shtml
 *
 * 如需要加密参数，请把Key变量名改成KeyMD5，KeyMD5=接口秘钥32位MD5加密，大写。
 */

/**
 * 短信发送
 */
$cfg['utf8_send_sms'] = array(
	'url'=>'http://utf8.sms.webchinese.cn',
	'method'=>'get',
	'requestParam'=>array(
		'Uid',
		'Key',
		'smsMob',
		'smsText'
		)
	);
$cfg['gbk_send_sms'] = array(
	'url'=>'http://gbk.sms.webchinese.cn',
	'method'=>'get',
	'requestParam'=>array(
		'Uid',
		'Key',
		'smsMob',
		'smsText'
		)
	);
/**
 * 短信数量
 */
$cfg['utf8_get_num'] = array(
	'url'=>'http://sms.webchinese.cn/web_api/SMS/',
	'method'=>'get',
	'requestParam'=>array(
		'Action|@SMS_Num',
		'Uid',
		'Key',
		)
	);
$cfg['gbk_get_num'] = array(
	'url'=>'http://sms.webchinese.cn/web_api/SMS/GBK/',
	'method'=>'get',
	'requestParam'=>array(
		'Action|@SMS_Num',
		'Uid',
		'Key',
		)
	);
/**
 * SMS短信通上行回复API
 */
$cfg['utf8_get_reply'] = array(
	'url'=>'http://sms.webchinese.cn/web_api/SMS/',
	'method'=>'get',
	'requestParam'=>array(
		'Action|@UP',
		'Uid',
		'Key',
		'Prompt|@0'
		)
	);
$cfg['gbk_get_reply'] = array(
	'url'=>'http://sms.webchinese.cn/web_api/SMS/GBK/',
	'method'=>'get',
	'requestParam'=>array(
		'Action|@UP',
		'Uid',
		'Key',
		'Prompt|@0'
		)
	);
return $cfg;