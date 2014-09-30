<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 百度 网站接入方式api列表 20140622
 *
 * http://developer.baidu.com/wiki/index.php?title=%E5%B8%AE%E5%8A%A9%E6%96%87%E6%A1%A3%E9%A6%96%E9%A1%B5/%E7%BD%91%E7%AB%99%E6%8E%A5%E5%85%A5
 */
$callbackUrl = '';
//请求获取auth_code,然后需要在响应回调redirectUrl处获取auth_code并保存
//http://developer.baidu.com/wiki/index.php?title=docs/oauth/authorization
$cfg['get_auth_code'] = array(
	'url' => 'http://openapi.baidu.com/oauth/2.0/authorize',
	'callbackUrl' => $callbackUrl,
	'method' => 'get',
	'redirect' => true,
	'commonParam' => array(),
	'requestParam' => array('response_type|@code', 'client_id|getAppKey', 'redirect_uri|getRedirectUri', 'state', 'scope', 'display', 'force_login', 'confirm_login'),
);
//通过Authorization Code获取Access Token,然后需要在响应回调redirectUrl处获取access_token并保存
$cfg['get_access_token'] = array(
	'url' => 'https://openapi.baidu.com/oauth/2.0/token',
	'method' => 'get',
	'commonParam' => array(),
	'requestParam' => array('grant_type|@authorization_code', 'client_id|getAppKey', 'client_secret|getAppSecret', 'code|getAuthCode', 'redirect_uri|getRedirectUri'),
);
//http://developer.baidu.com/wiki/index.php?title=docs/oauth/rest/file_data_apis_list
//passport/users/getLoggedInUser
$cfg['passport_users_getLoggedInUser'] = array(
	'summary' => '返回当前登录用户的用户名、用户uid、用户头像',
	'url' => 'https://openapi.baidu.com/rest/2.0/passport/users/getLoggedInUser',
	'dataType' => 'JSON',
	'method' => 'POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken'),
);
//passport/users/getInfo
$cfg['passport_users_getInfo'] = array(
	'summary' => '返回指定用户的用户资料',
	'url' => 'https://openapi.baidu.com/rest/2.0/passport/users/getInfo',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken'),
);
//passport/users/isAppUser
$cfg['passport_users_isAppUser'] = array(
	'summary' => '判定当前用户是否已经为应用授权',
	'url' => 'https://openapi.baidu.com/rest/2.0/passport/users/isAppUser',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'uid', 'appid'),
);
//passport/users/hasAppPermission
$cfg['passport_users_hasAppPermission'] = array(
	'summary' => '判断指定用户是否具有某个数据操作权限',
	'url' => 'https://openapi.baidu.com/rest/2.0/passport/users/hasAppPermission',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'ext_perm', 'uid'),
);
//passport/users/hasAppPermissions
$cfg['passport_users_hasAppPermissions'] = array(
	'summary' => '判断指定用户是否具有某一批数据操作权限',
	'url' => 'https://openapi.baidu.com/rest/2.0/passport/users/hasAppPermissions',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'ext_perms', 'uid'),
);
//friends/getFriends
$cfg['friends_getFriends'] = array(
	'summary' => '返回用户好友资料',
	'url' => 'https://openapi.baidu.com/rest/2.0/friends/getFriends',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'page_no', 'page_size', 'sort_type'),
);
//friends/areFriends
$cfg['friends_areFriends'] = array(
	'summary' => '获得指定用户之间好友关系',
	'url' => 'https://openapi.baidu.com/rest/2.0/friends/areFriends',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'uids1', 'uids2'),
);
//passport/auth/expireSession
$cfg['passport_auth_expireSession'] = array(
	'summary' => '使access_token,session_key过期',
	'url' => 'https://openapi.baidu.com/rest/2.0/passport/auth/expireSession',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken'),
);
//passport/auth/revokeAuthorization
$cfg['passport_auth_revokeAuthorization'] = array(
	'summary' => '撤销用户授予第三方应用的权限',
	'url' => 'https://openapi.baidu.com/rest/2.0/passport/auth/revokeAuthorization',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'uid'),
);
//super/msg/setnum
$cfg['super_msg_setnum'] = array(
	'summary' => '数据推送',
	'url' => 'https://openapi.baidu.com/rest/2.0/super/msg/setnum',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'msgdetail', 'msgnum'),
);
//super/msg/getnum
$cfg['super_msg_getnum'] = array(
	'summary' => '数据查看',
	'url' => 'https://openapi.baidu.com/rest/2.0/super/msg/getnum',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken'),
);
//hao123/saveOrder
$cfg['hao123_saveOrder'] = array(
	'summary' => '团购订单信息提交',
	'url' => 'https://openapi.baidu.com/rest/2.0/hao123/saveOrder',
	'dataType' => 'JSON',
	'method' => 'POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'order_id', 'order_time', 'order_city', 'title', 'logo', 'url', 'price', 'goods_num', 'sum_price', 'summary', 'expire', 'addr', 'uid', 'mobile', 'tn', 'baiduid', 'bonus'),
);
//hao123/updateExpire
$cfg['hao123_updateExpire'] = array(
	'summary' => '更新消费券有效期（在更改消费券有效期后调用）。',
	'url' => 'https://openapi.baidu.com/rest/2.0/hao123/updateExpire',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'order_id', 'order_ids'),
);
//hao123/useOrder
$cfg['hao123_useOrder'] = array(
	'summary' => '标记消费券消为已用',
	'url' => 'https://openapi.baidu.com/rest/2.0/hao123/useOrder',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'order_id', 'used_time'),
);
//iplib/query
$cfg['iplib_query'] = array(
	'summary' => '查询IP地址所在地区',
	'url' => 'https://openapi.baidu.com/rest/2.0/iplib/query',
	'dataType' => 'JSON',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'ip'),
);
//batch/run
$cfg['batch_run'] = array(
	'summary' => '批量调用开放API',
	'url' => 'https://openapi.baidu.com/batch/run',
	'dataType' => 'JSON',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'method'),
);
//bql/query
$cfg['bql_query'] = array(
	'summary' => '批量调用开放API',
	'url' => 'https://openapi.baidu.com/bql/query',
	'dataType' => 'JSON',
	'method' => 'GET/POST',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'q'),
);
//callback/add
$cfg['callback_add'] = array(
	'summary' => '事件处理中心',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/callback/add',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_name', 'url'),
);
//callback/get
$cfg['callback_get'] = array(
	'summary' => '查询私有事件',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/callback/get',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_id'),
);
//callback/update
$cfg['callback_update'] = array(
	'summary' => '更新私有事件',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/callback/update',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_id', 'event_name', 'url'),
);
//callback/delete
$cfg['callback_delete'] = array(
	'summary' => '删除私有事件',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/callback/delete',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_id'),
);
//callback/trigger
$cfg['callback_trigger'] = array(
	'summary' => '触发私有事件',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/callback/trigger',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_id', 'msg'),
);
//event/add
$cfg['event_add'] = array(
	'summary' => '注册普通事件',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/event/add',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_name', 'producer', 'subscriber'),
);
//event/get
$cfg['event_get'] = array(
	'summary' => '查看普通事件',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/event/get',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_id'),
);
//event/update
$cfg['event_update'] = array(
	'summary' => '更新普通事件',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/event/update',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_id', 'event_name', 'producer', 'subscriber'),
);
//event/delete
$cfg['event_delete'] = array(
	'summary' => '删除普通事件',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/event/delete',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_id'),
);
//event/trigger
$cfg['event_trigger'] = array(
	'summary' => '触发普通事件',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/event/trigger',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_id', 'msg'),
);
//subscription/add
$cfg['subscription_add'] = array(
	'summary' => '订阅普通事件',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/subscription/add',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_id', 'msg'),
);
//subscription/add
$cfg['subscription_add'] = array(
	'summary' => '订阅普通事件',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/subscription/add',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_id', 'url'),
);
//subscription/get
$cfg['subscription_get'] = array(
	'summary' => '查询普通事件订阅信息',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/subscription/get',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'sub_id'),
);
//subscription/update
$cfg['subscription_update'] = array(
	'summary' => '修改普通事件订阅关系',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/subscription/update',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'sub_id', 'url'),
);
//subscription/delete
$cfg['subscription_delete'] = array(
	'summary' => '取消订阅普通事件',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/subscription/delete',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'sub_id'),
);
//subscription/eventlist
$cfg['subscription_eventlist'] = array(
	'summary' => '获取可订阅普通事件列表',
	'url' => 'https://openapi.baidu.com/rest/2.0/epc/v1/subscription/eventlist',
	'dataType' => 'JSON/JSONP',
	'method' => 'GET',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken', 'callback', 'event_id', 'event_name'),
);
return $cfg;