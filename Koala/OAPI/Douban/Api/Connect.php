<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

$commonParam = array(
	'apikey',
	'alt|@json',
	'start-index',
	'max-results'
	);
 /**
  * 获取未授权的Request Token
  */
 $cfg['get_notauth_request_token'] = array(
	'url'=>'http://www.douban.com/service/auth/request_token',
	'method'=>'get',
	'commonParam'=>$commonParam,
	'header'=>array('oauth_consumer_key','oauth_signature_method','oauth_signature','oauth_timestamp','oauth_nonce','oauth_version|@1.0'),
	'requestParam'=>array(),
	);

 /**
  * 请求用户授权Request Token
  */
 $cfg['get_auth_request_token'] = array(
	'url'=>'http://www.douban.com/service/auth/authorize',
	'redirect'=>true,
	'method'=>'get',
	'commonParam'=> $commonParam,
	'requestParam'=>array('oauth_token','oauth_callback'),
	);
  /**
  * 使用授权后的Request Token换取Access Token
  */
 $cfg['get_auth_access_token'] = array(
	'url'=>'http://www.douban.com/service/auth/access_token',
	'method'=>'get',
	'commonParam'=>$commonParam,
	'header'=>array('oauth_consumer_key','oauth_signature_method','oauth_signature','oauth_timestamp','oauth_nonce','oauth_version|@1.0'),
	'requestParam'=>array('oauth_token'),
	);
return $cfg;