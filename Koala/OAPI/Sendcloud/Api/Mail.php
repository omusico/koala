<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

/**
 * http://sendcloud.sohu.com/api-doc/web-api
 */
//
$cfg['send_email'] = array(
	'url' => ' https://sendcloud.sohu.com/webapi/mail.send.json',
	'method' => 'post',
	'commonParam' => array('api_user|getUser', 'api_key|getKey'),
	'requestParam' => array(
		'to',
		'use_maillist',
		'subject',
		'html',
		'from',
		'fromname',
		'cc',
		'bcc',
		'replyto',
		'headers',
		'files',
		'x_smtpapi',
		'resp_email_id',
		'gzip_compress',
	),
);
//http://sendcloud.sohu.com/api-doc/web-api-maillist-detail
//创建邮件列表(建议使用post请求，注意不要使用multipart-post)
$cfg['create_email_list'] = array(
	'url' => ' https://sendcloud.sohu.com/webapi/list.create.json',
	'method' => 'post',
	'commonParam' => array('api_user|getUser', 'api_key|getKey'),
	'requestParam' => array(
		'address',
		'name',
		'description',
	),
);
//查询邮件列表
$cfg['get_email_list'] = array(
	'url' => ' https://sendcloud.sohu.com/webapi/list.get.json',
	'method' => 'get',
	'commonParam' => array('api_user|getUser', 'api_key|getKey'),
	'requestParam' => array(
		'address',
		'start|@0',
		'limit|@100',
	),
);
//删除邮件列表
$cfg['del_email_list'] = array(
	'url' => ' https://sendcloud.sohu.com/webapi/list.delete.json',
	'method' => 'get',
	'commonParam' => array('api_user|getUser', 'api_key|getKey'),
	'requestParam' => array(
		'address',
	),
);
//更新邮件列表
$cfg['update_email_list'] = array(
	'url' => ' https://sendcloud.sohu.com/webapi/list.update.json',
	'method' => 'post',
	'commonParam' => array('api_user|getUser', 'api_key|getKey'),
	'requestParam' => array(
		'address',
		'toAddress',
		'name',
		'description',
	),
);
//添加邮件列表成员
$cfg['add_list_member'] = array(
	'url' => ' https://sendcloud.sohu.com/webapi/list_member.add.json',
	'method' => 'post',
	'commonParam' => array('api_user|getUser', 'api_key|getKey'),
	'requestParam' => array(
		'mail_list_addr',
		'member_addr',
		'name',
		'vars',
		'subscribed',
		'upsert',
	),
);
//删除邮件列表成员
$cfg['del_list_member'] = array(
	'url' => ' https://sendcloud.sohu.com/webapi/list_member.delete.json',
	'method' => 'post',
	'commonParam' => array('api_user|getUser', 'api_key|getKey'),
	'requestParam' => array(
		'mail_list_addr',
		'member_addr',
		'name',
	),
);
//查询邮件列表成员
$cfg['get_list_member'] = array(
	'url' => ' https://sendcloud.sohu.com/webapi/list_member.get.json',
	'method' => 'get',
	'commonParam' => array('api_user|getUser', 'api_key|getKey'),
	'requestParam' => array(
		'mail_list_addr',
		'member_addr',
		'start',
		'limit',
	),
);
//更新邮件列表成员
$cfg['update_list_member'] = array(
	'url' => ' https://sendcloud.sohu.com/webapi/list_member.update.json',
	'method' => 'post',
	'commonParam' => array('api_user|getUser', 'api_key|getKey'),
	'requestParam' => array(
		'mail_list_addr',
		'member_addr',
		'name',
		'vars',
	),
);
return $cfg;