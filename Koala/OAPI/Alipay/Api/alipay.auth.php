<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * alipay api列表
 */
$callbackUrl ='';
 /**
  * 请求用户登录授权
  */
 $cfg['get_auth_code_login'] = array(
	'url'=>'http://openauth.alipaydev.com/oauth2/authorize.htm',
	'callbackUrl'=>$callbackUrl,
	'method'=>'get',
	'redirect'=>true,
	'commonParam'=> array(),
	'requestParam'=>array('client_id','redirect_uri','scope','state','view'),
	);
  /**
  * 请求用户支付授权
  */
  $cfg['get_auth_code_pay'] = array(
	'url'=>'http://openauth.alipaydev.com/oauth2/authorize.htm',
	'callbackUrl'=>$callbackUrl,
	'method'=>'get',
	'redirect'=>true,
	'commonParam'=> array(),
	'requestParam'=>array('client_id','redirect_uri','scope|@p','state','view'),
	);