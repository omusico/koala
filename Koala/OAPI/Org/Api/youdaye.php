<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 *邮大爷EPS
 * https://www.youdaye.com/docs.htm
 */

/**
 * email发送
 * EPS用于发送邮件的帐号或者WebAPI的调用帐号不是登录站点后台的帐号，用户需要登录站点后台进行发信域名的设置后，获取发送邮件和调用API的帐号和密码
 */
$cfg['send_email'] = array(
	'url'          => 'https://api.youdaye.com/webapi/send.mail.json',
	'method'       => 'post',
	'requestParam' => array(
		'api_user|getAppUser',
		'api_key|getAppKey',
		'sender|getSender', //发送邮件的用户名和发信域名有关
		'to',
		'subject',
		'message',
	)
);
return $cfg;