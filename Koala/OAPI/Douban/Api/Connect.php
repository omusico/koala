<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

$public_params = array(
		//位于URI
		'uri'=>array('apikey','alt|@json','start-index','max-results'),
		//位于Header
		'header'=>array(),
		//位于Body
		'body'=>array()
		);
 /**
  * 获取未授权的Request Token
  */
 $cfg['get_notauth_request_token'] = array(
	'url'=>'http://www.douban.com/service/auth/request_token',
	'method'=>'get',
	//请求参数
	'request_params'=>array(
		//位于URI
		'uri'=>array(),
		//位于Header
		'header'=>array('oauth_consumer_key','oauth_signature_method','oauth_signature','oauth_timestamp','oauth_nonce','oauth_version|@1.0'),
		//位于Body
		'body'=>array()
		),
	//公共参数
	'public_params'=>$public_params
	);

 /**
  * 请求用户授权Request Token
  */
 $cfg['get_auth_request_token'] = array(
	'url'=>'http://www.douban.com/service/auth/authorize',
	'redirect'=>true,
	'method'=>'get',
	//请求参数
	'request_params'=>array(
		//位于URI
		'uri'=>array('oauth_token','oauth_callback'),
		//位于Header
		'header'=>array(),
		//位于Body
		'body'=>array()
		),
	//公共参数
	'public_params'=>$public_params
	);
  /**
  * 使用授权后的Request Token换取Access Token
  */
 $cfg['get_auth_access_token'] = array(
	'url'=>'http://www.douban.com/service/auth/access_token',
	'method'=>'get',
	//请求参数
	'request_params'=>array(
		//位于URI
		'uri'=>array('oauth_token'),
		//位于Header
		'header'=>array('oauth_consumer_key','oauth_signature_method','oauth_signature','oauth_timestamp','oauth_nonce','oauth_version|@1.0'),
		//位于Body
		'body'=>array()
		),
	//公共参数
	'public_params'=>$public_params
	);
return $cfg;