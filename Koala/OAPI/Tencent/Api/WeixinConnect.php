<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * wx开放平台网站接入方式api列表 20140622
 * 
 * https://open.weixin.qq.com/cgi-bin/frame?t=resource/res_main_tmpl&verify=1&lang=zh_CN
 */
$callbackUrl = '';
//请求获取auth_code,然后需要在响应回调redirectUrl处获取auth_code并保存
$cfg['get_auth_code'] = array(
	'url'=>'https://open.weixin.qq.com/connect/qrconnect',
	'callbackUrl'=>$callbackUrl,
	'method'=>'get',
	'redirect'=>true,
	'commonParam'=> array(),
	'requestParam'=>array('response_type|@code','appid|getAppKey','redirect_uri|getRedirectUri','state','scope|@get_user_info'),
	);
//通过Authorization Code获取Access Token,openid
$cfg['get_access_token'] = array(
	'url'=>'https://api.weixin.qq.com/sns/oauth2/access_token',
	'callbackUrl'=>$callbackUrl,
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=>array('grant_type|@authorization_code','appid|getAppKey','secret|getAppSecret','code|getAuthCode')
	);
//刷新access_token有效期,获取Access Token,openid
$cfg['refresh_access_token'] = array(
	'url'=>'https://api.weixin.qq.com/sns/oauth2/refresh_token',
	'callbackUrl'=>$callbackUrl,
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=>array('grant_type|@refresh_token','appid|getAppKey','refresh_token|getRefreshToken')
	)
//检查access_token有效性
$cfg['refresh_access_token'] = array(
	'url'=>'https://api.weixin.qq.com/sns/auth',
	'callbackUrl'=>$callbackUrl,
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=>array('access_token|getAccessToken','openid|getOpenid')
	)
//获取用户个人信息（UnionID机制）
$cfg['refresh_access_token'] = array(
	'url'=>'https://api.weixin.qq.com/sns/userinfo',
	'callbackUrl'=>$callbackUrl,
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=>array('access_token|getAccessToken','openid|getOpenid')
	)
return $cfg;