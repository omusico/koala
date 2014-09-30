<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 腾讯开放平台网站接入方式api列表 20140622
 *
 * http://wiki.connect.qq.com/api%E5%88%97%E8%A1%A8
 * http://wiki.open.qq.com/wiki/website/API%E5%88%97%E8%A1%A8
 */
//请求获取auth_code,然后需要在响应回调redirectUrl处获取auth_code并保存
$cfg['get_auth_code'] = array(
	'url' => 'https://graph.qq.com/oauth2.0/authorize',
	'method' => 'get',
	'redirect' => true,
	'commonParam' => array(),
	'requestParam' => array('response_type|@code', 'client_id|getAppKey', 'redirect_uri|getCodeRedirectUri', 'state', 'scope|@get_user_info'),
);
//通过Authorization Code获取Access Token
$cfg['get_access_token'] = array(
	'url' => 'https://graph.qq.com/oauth2.0/token',
	'method' => 'get',
	'commonParam' => array(),
	'requestParam' => array('grant_type|@authorization_code', 'client_id|getAppKey', 'client_secret|getAppSecret', 'code|getAuthCode', 'state', 'redirect_uri|getCodeRedirectUri'),
);
//通过REFRESH_TOKEN获取Access Token
$cfg['refresh_access_token'] = array(
	'url' => 'https://graph.qq.com/oauth2.0/access_token',
	'method' => 'get',
	'commonParam' => array(),
	'requestParam' => array('grant_type|@refresh_token', 'client_id|getAppKey', 'refresh_token|getRefreshToken'),
);
//通过Access Token获取Openid
$cfg['get_openid'] = array(
	'url' => 'https://graph.qq.com/oauth2.0/me',
	'method' => 'get',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken'),
);
/**
 * 参考手册
 * http://wiki.open.qq.com/wiki/website/API%E5%88%97%E8%A1%A8
 */
$commonParam = array('access_token|getAccessToken', 'oauth_consumer_key|getAppKey', 'openid|getOpenid');
//访问用户资料
$cfg['get_user_info'] = array(
	'url' => 'https://graph.qq.com/user/get_user_info',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json'),
);
//获取QQ会员的基本信息
$cfg['get_vip_info'] = array(
	'url' => 'https://graph.qq.com/user/get_vip_info',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json'),
);
//获取QQ会员的高级信息
$cfg['get_vip_rich_info'] = array(
	'url' => 'https://graph.qq.com/user/get_vip_rich_info',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json'),
);
//获取用户QQ空间相册列表
$cfg['list_album'] = array(
	'url' => 'https://graph.qq.com/photo/list_album',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json'),
);
//上传一张照片到QQ空间相册
//$api->apply('upload_pic',$uploadparams)
//详细上传参数参考
//http://wiki.open.qq.com/wiki/website/upload_pic
$cfg['upload_pic'] = array(
	'url' => 'https://graph.qq.com/photo/upload_pic',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array(
		'picture', 'photodesc', 'title', 'albumid', 'mobile', 'x', 'y', 'needfeed', 'successnum', 'picnum', 'format|@json'),
);
//在用户的空间相册里，创建一个新的个人相册
$cfg['add_album'] = array(
	'url' => 'https://graph.qq.com/photo/add_album',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('albumname', 'albumdesc', 'priv', 'format|@json'),
);
//获取用户QQ空间相册中的照片列表
$cfg['list_photo'] = array(
	'url' => 'https://graph.qq.com/photo/list_photo',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('albumid', 'format|@json'),
);
//判断是否认证空间粉丝
$cfg['check_page_fans'] = array(
	'url' => 'https://graph.qq.com/user/check_page_fans',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('page_id', 'format|@json'),
);
//获取登录用户在腾讯微博详细资料
$cfg['get_info'] = array(
	'url' => 'https://graph.qq.com/user/get_info',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json'),
);
//发表一条微博
$cfg['add_t'] = array(
	'url' => 'https://graph.qq.com/t/add_t',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('content', 'clientip', 'longitude', 'latitude', 'syncflag', 'compatibleflag', 'format|@json'),
);
//删除一条微博
$cfg['del_t'] = array(
	'url' => 'https://graph.qq.com/t/del_t',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('id', 'format|@json'),
);
//发表一条带图片的微博
$cfg['add_pic_t'] = array(
	'url' => 'https://graph.qq.com/t/add_pic_t',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('content', 'pic', 'clientip', 'longitude', 'latitude', 'syncflag', 'compatibleflag', 'format|@json'),
);
//获取单条微博的转发或点评列表
$cfg['get_repost_list'] = array(
	'url' => 'https://graph.qq.com/t/get_repost_list',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('flag', 'rootid', 'pageflag', 'pagetime', 'reqnum', 'twitterid', 'format|@json'),
);
//获取他人微博资料
$cfg['get_other_info'] = array(
	'url' => 'https://graph.qq.com/user/get_other_info',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('name', 'fopenid', 'format|@json'),
);
//我的微博粉丝列表
$cfg['get_fanslist'] = array(
	'url' => 'https://graph.qq.com/relation/get_fanslist',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('reqnum', 'startindex', 'mode', 'install', 'sex', 'format|@json'),
);
//我的微博偶像列表
$cfg['get_idollist'] = array(
	'url' => 'https://graph.qq.com/relation/get_idollist',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('reqnum', 'startindex', 'mode', 'install', 'format|@json'),
);
//收听某个微博用户
$cfg['add_idol'] = array(
	'url' => 'https://graph.qq.com/relation/add_idol',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('name', 'fopenids', 'format|@json'),
);
//取消收听某个微博用户
$cfg['del_idol'] = array(
	'url' => 'https://graph.qq.com/relation/del_idol',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('name', 'fopenids', 'format|@json'),
);
//在这个网站上将展现您财付通登记的收货地址
$cfg['get_tenpay_addr'] = array(
	'url' => 'https://graph.qq.com/cft_info/get_tenpay_addr',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('offset', 'limit', 'ver', 'format|@json'),
);
return $cfg;