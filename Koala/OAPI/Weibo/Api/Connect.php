<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 新浪微博开放平台 网站接入方式api列表 20140622
 * http://open.weibo.com/wiki/%E5%BE%AE%E5%8D%9AAPI
 *
 * 数据结果由Tools/parseWeiboApi.php工具生成并手动修正
 */
//请求获取auth_code,然后需要在响应回调redirectUrl处获取auth_code并保存
$cfg['get_auth_code'] = array(
	'url' => 'https://api.weibo.com/oauth2/authorize',
	'method' => 'get',
	'redirect' => true,
	'commonParam' => array(),
	'requestParam' => array('client_id|getAppKey', 'redirect_uri|getCodeRedirectUri', 'state', 'display', 'forcelogin', 'language', 'scope|@get_user_info'),
);
//通过Authorization Code获取Access Token
$cfg['get_access_token'] = array(
	'url' => 'https://api.weibo.com/oauth2/access_token',
	'method' => 'post',
	'commonParam' => array(),
	'requestParam' => array('grant_type|@authorization_code', 'client_id|getAppKey', 'client_secret|getAppSecret', 'code|getAuthCode', 'redirect_uri|getCodeRedirectUri'),
);

//授权信息查询接口
$cfg['get_token_info'] = array(
	'url' => 'https://api.weibo.com/oauth2/get_token_info',
	'method' => 'post',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken'),
);
//授权回收接口
$cfg['revoke_oauth2'] = array(
	'url' => 'https://api.weibo.com/oauth2/revokeoauth2',
	'method' => 'post',
	'commonParam' => array(),
	'requestParam' => array('access_token|getAccessToken'),
);
//读取接口
//statuses/public_timeline
$cfg["statuses_public_timeline"] = array(
	'summary' => '返回最新的200条公共微博，返回结果非完全实时',
	'url' => 'https://api.weibo.com/2/statuses/public_timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//statuses/friends_timeline
$cfg["statuses_friends_timeline"] = array(
	'summary' => '获取当前登录用户及其所关注用户的最新微博',
	'url' => 'https://api.weibo.com/2/statuses/friends_timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'trim_user|0',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'count',
		6 => 'page',
		7 => 'base_app',
		8 => 'feature',
	),
);
//statuses/home_timeline
$cfg["statuses_home_timeline"] = array(
	'summary' => '获取当前登录用户及其所关注用户的最新微博',
	'url' => 'https://api.weibo.com/2/statuses/home_timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'trim_user',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'count',
		6 => 'page',
		7 => 'base_app',
		8 => 'feature',
	),
);
//statuses/friends_timeline/ids
$cfg["statuses_friends_timeline_ids"] = array(
	'summary' => '获取当前登录用户及其所关注用户的最新微博的ID',
	'url' => 'https://api.weibo.com/2/statuses/friends_timeline/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'feature',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'count',
		6 => 'page',
		7 => 'base_app',
	),
);
//statuses/user_timeline
$cfg["statuses_user_timeline"] = array(
	'summary' => '获取某个用户最新发表的微博列表',
	'url' => 'https://api.weibo.com/2/statuses/user_timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'trim_user',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'screen_name',
		5 => 'since_id',
		6 => 'max_id',
		7 => 'count',
		8 => 'page',
		9 => 'base_app',
		10 => 'feature',
	),
);
//statuses/user_timeline/ids
$cfg["statuses_user_timeline_ids"] = array(
	'summary' => '获取用户发布的微博的ID',
	'url' => 'https://api.weibo.com/2/statuses/user_timeline/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'feature',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'screen_name',
		5 => 'since_id',
		6 => 'max_id',
		7 => 'count',
		8 => 'page',
		9 => 'base_app',
	),
);
//statuses/timeline_batch
$cfg["statuses_timeline_batch"] = array(
	'summary' => '批量获取指定的一批用户的微博列表',
	'url' => 'https://api.weibo.com/2/statuses/timeline_batch.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'feature',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uids',
		4 => 'screen_names',
		5 => 'count',
		6 => 'page',
		7 => 'base_app',
	),
);
//statuses/repost_timeline
$cfg["statuses_repost_timeline"] = array(
	'summary' => '获取指定微博的转发微博列表',
	'url' => 'https://api.weibo.com/2/statuses/repost_timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'filter_by_author',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'id',
		4 => 'since_id',
		5 => 'max_id',
		6 => 'count',
		7 => 'page',
	),
);
//statuses/repost_timeline/ids
$cfg["statuses_repost_timeline_ids"] = array(
	'summary' => '获取一条原创微博的最新转发微博的ID',
	'url' => 'https://api.weibo.com/2/statuses/repost_timeline/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'filter_by_author',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'id',
		4 => 'since_id',
		5 => 'max_id',
		6 => 'count',
		7 => 'page',
	),
);
//statuses/mentions
$cfg["statuses_mentions"] = array(
	'summary' => '获取最新的提到登录用户的微博列表，即@我的微博',
	'url' => 'https://api.weibo.com/2/statuses/mentions.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'filter_by_type',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'count',
		6 => 'page',
		7 => 'filter_by_author',
		8 => 'filter_by_source',
	),
);
//statuses/mentions/ids
$cfg["statuses_mentions_ids"] = array(
	'summary' => '获取@当前用户的最新微博的ID',
	'url' => 'https://api.weibo.com/2/statuses/mentions/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'filter_by_type',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'count',
		6 => 'page',
		7 => 'filter_by_author',
		8 => 'filter_by_source',
	),
);
//statuses/bilateral_timeline
$cfg["statuses_bilateral_timeline"] = array(
	'summary' => '获取双向关注用户的最新微博',
	'url' => 'https://api.weibo.com/2/statuses/bilateral_timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'trim_user',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'count',
		6 => 'page',
		7 => 'base_app',
		8 => 'feature',
	),
);
//statuses/show
$cfg["statuses_show"] = array(
	'summary' => '根据微博ID获取单条微博内容',
	'url' => 'https://api.weibo.com/2/statuses/show.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//statuses/show_batch
$cfg["statuses_show_batch"] = array(
	'summary' => '根据微博ID批量获取微博信息',
	'url' => 'https://api.weibo.com/2/statuses/show_batch.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'trim_user',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'ids',
	),
);
//statuses/querymid
$cfg["statuses_querymid"] = array(
	'summary' => '通过微博（评论、私信）ID获取其MID',
	'url' => 'https://api.weibo.com/2/statuses/querymid.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'is_batch',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'id',
		4 => 'type',
	),
);
//statuses/queryid
$cfg["statuses_queryid"] = array(
	'summary' => '通过微博（评论、私信）MID获取其ID',
	'url' => 'https://api.weibo.com/2/statuses/queryid.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'isBase62',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'mid',
		4 => 'type',
		5 => 'is_batch',
		6 => 'inbox',
	),
);
//statuses/count
$cfg["statuses_count"] = array(
	'summary' => '批量获取指定微博的转发数评论数',
	'url' => 'https://api.weibo.com/2/statuses/count.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'ids',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//statuses/to_me
$cfg["statuses_to_me"] = array(
	'summary' => '获取当前登录用户关注的人发给其的定向微博',
	'url' => 'https://api.weibo.com/2/statuses/to_me.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'trim_user',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'page',
		6 => 'count',
	),
);
//statuses/to_me/ids
$cfg["statuses_to_me_ids"] = array(
	'summary' => '获取当前登录用户关注的人发给其的定向微博ID列表',
	'url' => 'https://api.weibo.com/2/statuses/to_me/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'page',
	),
);
//statuses/go
$cfg["statuses_go"] = array(
	'summary' => '根据ID跳转到单条微博页',
	'url' => 'http://api.weibo.com/2/statuses/go',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
	),
);
//emotions
$cfg["emotions"] = array(
	'summary' => '获取微博官方表情的详细信息',
	'url' => 'https://api.weibo.com/2/emotions.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'language',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'type',
	),
);
//写入接口

//statuses/repost
$cfg["statuses_repost"] = array(
	'summary' => '转发一条微博',
	'url' => 'https://api.weibo.com/2/statuses/repost.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'rip',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'id',
		4 => 'status',
		5 => 'is_comment',
	),
);
//statuses/destroy
$cfg["statuses_destroy"] = array(
	'summary' => '根据微博ID删除指定微博',
	'url' => 'https://api.weibo.com/2/statuses/destroy.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//statuses/update
$cfg["statuses_update"] = array(
	'summary' => '发布一条新微博',
	'url' => 'https://api.weibo.com/2/statuses/update.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'rip',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'status',
		4 => 'visible',
		5 => 'list_id',
		6 => 'lat',
		7 => 'long',
		8 => 'annotations',
	),
);
//statuses/upload
$cfg["statuses_upload"] = array(
	'summary' => '上传图片并发布一条新微博',
	'url' => 'https://upload.api.weibo.com/2/statuses/upload.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'rip',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'status',
		4 => 'visible',
		5 => 'list_id',
		6 => 'pic',
		7 => 'lat',
		8 => 'long',
		9 => 'annotations',
	),
);
//statuses/upload_url_text
$cfg["statuses_upload_url_text"] = array(
	'summary' => '指定一个图片URL地址抓取后上传并同时发布一条新微博',
	'url' => 'https://api.weibo.com/2/statuses/upload_url_text.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'rip',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'status',
		4 => 'visible',
		5 => 'list_id',
		6 => 'url',
		7 => 'pic_id',
		8 => 'lat',
		9 => 'long',
		10 => 'annotations',
	),
);
//statuses/filter/create
$cfg["statuses_filter_create"] = array(
	'summary' => '屏蔽某条微博',
	'url' => 'https://api.weibo.com/2/statuses/filter/create.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//statuses/mentions/shield
$cfg["statuses_mentions_shield"] = array(
	'summary' => '屏蔽某个@到我的微博以及后续由对其转发引起的@提及',
	'url' => 'https://api.weibo.com/2/statuses/mentions/shield.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'follow_up',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'id',
	),
);
//读取接口

//comments/show
$cfg["comments_show"] = array(
	'summary' => '根据微博ID返回某条微博的评论列表',
	'url' => 'https://api.weibo.com/2/comments/show.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'filter_by_author',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'id',
		4 => 'since_id',
		5 => 'max_id',
		6 => 'count',
		7 => 'page',
	),
);
//comments/by_me
$cfg["comments_by_me"] = array(
	'summary' => '获取当前登录用户所发出的评论列表',
	'url' => 'https://api.weibo.com/2/comments/by_me.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'filter_by_source',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'count',
		6 => 'page',
	),
);
//comments/to_me
$cfg["comments_to_me"] = array(
	'summary' => '获取当前登录用户所接收到的评论列表',
	'url' => 'https://api.weibo.com/2/comments/to_me.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'filter_by_source',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'count',
		6 => 'page',
		7 => 'filter_by_author',
	),
);
//comments/timeline
$cfg["comments_timeline"] = array(
	'summary' => '获取当前登录用户的最新评论包括接收到的与发出的',
	'url' => 'https://api.weibo.com/2/comments/timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'trim_user',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'count',
		6 => 'page',
	),
);
//comments/mentions
$cfg["comments_mentions"] = array(
	'summary' => '获取最新的提到当前登录用户的评论，即@我的评论',
	'url' => 'https://api.weibo.com/2/comments/mentions.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'filter_by_source',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'count',
		6 => 'page',
		7 => 'filter_by_author',
	),
);
//comments/show_batch
$cfg["comments_show_batch"] = array(
	'summary' => '根据评论ID批量返回评论信息',
	'url' => 'https://api.weibo.com/2/comments/show_batch.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'cids',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//写入接口

//comments/create
$cfg["comments_create"] = array(
	'summary' => '对一条微博进行评论',
	'url' => 'https://api.weibo.com/2/comments/create.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'rip',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'comment',
		4 => 'id',
		5 => 'comment_ori',
	),
);
//comments/destroy
$cfg["comments_destroy"] = array(
	'summary' => '删除一条评论',
	'url' => 'https://api.weibo.com/2/comments/destroy.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'cid',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//comments/destroy_batch
$cfg["comments_destroy_batch"] = array(
	'summary' => '根据评论ID批量删除评论',
	'url' => 'https://api.weibo.com/2/comments/destroy_batch.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'cids',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//comments/reply
$cfg["comments_reply"] = array(
	'summary' => '回复一条评论',
	'url' => 'https://api.weibo.com/2/comments/reply.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'rip',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'cid',
		4 => 'id',
		5 => 'comment',
		6 => 'without_mention',
		7 => 'comment_ori',
	),
);
//读取接口

//users/show
$cfg["users_show"] = array(
	'summary' => '根据用户ID获取用户信息',
	'url' => 'https://api.weibo.com/2/users/show.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'screen_name',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
	),
);
//users/domain_show
$cfg["users_domain_show"] = array(
	'summary' => '通过个性化域名获取用户资料以及用户最新的一条微博',
	'url' => 'https://api.weibo.com/2/users/domain_show.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'domain',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//users/counts
$cfg["users_counts"] = array(
	'summary' => '批量获取用户的粉丝数、关注数、微博数',
	'url' => 'https://api.weibo.com/2/users/counts.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'uids',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//读取接口

//users/get_top_status
$cfg["users_get_top_status"] = array(
	'summary' => '获取用户主页置顶微博',
	'url' => 'https://api.weibo.com/2/users/get_top_status.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'uid',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//写入接口

//users/set_top_status
$cfg["users_set_top_status"] = array(
	'summary' => '设置当前用户主页置顶微博',
	'url' => 'https://api.weibo.com/2/users/set_top_status.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//users/cancel_top_status
$cfg["users_cancel_top_status"] = array(
	'summary' => '取消当前用户主页置顶微博',
	'url' => 'https://api.weibo.com/2/users/cancel_top_status.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//关注读取接口

//friendships/friends
$cfg["friendships_friends"] = array(
	'summary' => '获取用户的关注列表',
	'url' => 'https://api.weibo.com/2/friendships/friends.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'trim_status',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'screen_name',
		5 => 'count',
		6 => 'cursor',
	),
);
//friendships/friends/remark_batch
$cfg["friendships_friends_remark_batch"] = array(
	'summary' => '批量获取当前登录用户的关注人的备注信息',
	'url' => 'https://api.weibo.com/2/friendships/friends/remark_batch.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'uids',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//friendships/friends/in_common
$cfg["friendships_friends_in_common"] = array(
	'summary' => '获取两个用户之间的共同关注人列表',
	'url' => 'https://api.weibo.com/2/friendships/friends/in_common.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'trim_status',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'suid',
		5 => 'count',
		6 => 'page',
	),
);
//friendships/friends/bilateral
$cfg["friendships_friends_bilateral"] = array(
	'summary' => '获取用户的双向关注列表，即互粉列表',
	'url' => 'https://api.weibo.com/2/friendships/friends/bilateral.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'sort',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'count',
		5 => 'page',
	),
);
//friendships/friends/bilateral/ids
$cfg["friendships_friends_bilateral_ids"] = array(
	'summary' => '获取用户双向关注的用户ID列表，即互粉UID列表',
	'url' => 'https://api.weibo.com/2/friendships/friends/bilateral/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'sort',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'count',
		5 => 'page',
	),
);
//friendships/friends/ids
$cfg["friendships_friends_ids"] = array(
	'summary' => '获取用户关注的用户UID列表',
	'url' => 'https://api.weibo.com/2/friendships/friends/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'cursor',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'screen_name',
		5 => 'count',
	),
);
//粉丝读取接口

//friendships/followers
$cfg["friendships_followers"] = array(
	'summary' => '获取用户的粉丝列表',
	'url' => 'https://api.weibo.com/2/friendships/followers.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'trim_status',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'screen_name',
		5 => 'count',
		6 => 'cursor',
	),
);
//friendships/followers/ids
$cfg["friendships_followers_ids"] = array(
	'summary' => '获取用户粉丝的用户UID列表',
	'url' => 'https://api.weibo.com/2/friendships/followers/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'cursor',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'screen_name',
		5 => 'count',
	),
);
//friendships/followers/active
$cfg["friendships_followers_active"] = array(
	'summary' => '获取用户的活跃粉丝列表',
	'url' => 'https://api.weibo.com/2/friendships/followers/active.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
	),
);
//关系链读取接口

//friendships/friends_chain/followers
$cfg["friendships_friends_chain_followers"] = array(
	'summary' => '获取当前登录用户的关注人中又关注了指定用户的用户列表',
	'url' => 'https://api.weibo.com/2/friendships/friends_chain/followers.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'count',
	),
);
//关系读取接口

//friendships/show
$cfg["friendships_show"] = array(
	'summary' => '获取两个用户之间的详细关注关系情况',
	'url' => 'https://api.weibo.com/2/friendships/show.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'target_screen_name',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'source_id',
		4 => 'source_screen_name',
		5 => 'target_id',
	),
);
//写入接口

//friendships/create
$cfg["friendships_create"] = array(
	'summary' => '关注一个用户',
	'url' => 'https://api.weibo.com/2/friendships/create.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'rip',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'screen_name',
	),
);
//friendships/destroy
$cfg["friendships_destroy"] = array(
	'summary' => '取消关注一个用户',
	'url' => 'https://api.weibo.com/2/friendships/destroy.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'screen_name',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
	),
);
//friendships/followers/destroy
$cfg["friendships_followers_destroy"] = array(
	'summary' => '移除当前登录用户的粉丝',
	'url' => 'https://api.weibo.com/2/friendships/followers/destroy.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'uid',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//friendships/remark/update
$cfg["friendships_remark_update"] = array(
	'summary' => '更新当前登录用户所关注的某个好友的备注信息',
	'url' => 'https://api.weibo.com/2/friendships/remark/update.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'remark',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
	),
);
//读取接口

//friendships/groups
$cfg["friendships_groups"] = array(
	'summary' => '获取当前登陆用户好友分组列表',
	'url' => 'https://api.weibo.com/2/friendships/groups.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'access_token|getAccessToken',
		1 => 'source',
	),
);
//friendships/groups/timeline
$cfg["friendships_groups_timeline"] = array(
	'summary' => '获取当前登录用户某一好友分组的微博列表',
	'url' => 'https://api.weibo.com/2/friendships/groups/timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'feature',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'list_id',
		4 => 'since_id',
		5 => 'max_id',
		6 => 'count',
		7 => 'page',
		8 => 'base_app',
	),
);
//friendships/groups/timeline/ids
$cfg["friendships_groups_timeline_ids"] = array(
	'summary' => '获取当前登陆用户某一好友分组的微博ID列表',
	'url' => 'https://api.weibo.com/2/friendships/groups/timeline/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'feature',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'list_id',
		4 => 'since_id',
		5 => 'max_id',
		6 => 'count',
		7 => 'page',
		8 => 'base_app',
	),
);
//friendships/groups/members
$cfg["friendships_groups_members"] = array(
	'summary' => '获取某一好友分组下的成员列表',
	'url' => 'https://api.weibo.com/2/friendships/groups/members.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'cursor',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'list_id',
		4 => 'count',
	),
);
//friendships/groups/members/ids
$cfg["friendships_groups_members_ids"] = array(
	'summary' => '获取当前登录用户某一好友分组下的成员列表的ID',
	'url' => 'https://api.weibo.com/2/friendships/groups/members/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'cursor',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'list_id',
		4 => 'count',
	),
);
//friendships/groups/members/description
$cfg["friendships_groups_members_description"] = array(
	'summary' => '批量获取当前登录用户好友分组成员的分组说明',
	'url' => 'https://api.weibo.com/2/friendships/groups/members/description.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'list_id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uids',
	),
);
//friendships/groups/is_member
$cfg["friendships_groups_is_member"] = array(
	'summary' => '判断某个用户是否是当前登录用户指定好友分组内的成员',
	'url' => 'https://api.weibo.com/2/friendships/groups/is_member.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'list_id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
	),
);
//friendships/groups/listed
$cfg["friendships_groups_listed"] = array(
	'summary' => '批量获取某些用户在当前登录用户指定好友分组中的收录信息',
	'url' => 'https://api.weibo.com/2/friendships/groups/listed.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'uids',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//friendships/groups/show
$cfg["friendships_groups_show"] = array(
	'summary' => '获取当前登陆用户某个分组的详细信息',
	'url' => 'https://api.weibo.com/2/friendships/groups/show.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'list_id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//friendships/groups/show_batch
$cfg["friendships_groups_show_batch"] = array(
	'summary' => '批量获取好友分组的详细信息',
	'url' => 'https://api.weibo.com/2/friendships/groups/show_batch.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'uids',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'list_ids',
	),
);
//写入接口

//friendships/groups/create
$cfg["friendships_groups_create"] = array(
	'summary' => '创建好友分组',
	'url' => 'https://api.weibo.com/2/friendships/groups/create.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'tags',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'name',
		4 => 'description',
	),
);
//friendships/groups/update
$cfg["friendships_groups_update"] = array(
	'summary' => '更新好友分组',
	'url' => 'https://api.weibo.com/2/friendships/groups/update.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'tags',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'list_id',
		4 => 'name',
		5 => 'description',
	),
);
//friendships/groups/destroy
$cfg["friendships_groups_destroy"] = array(
	'summary' => '删除好友分组',
	'url' => 'https://api.weibo.com/2/friendships/groups/destroy.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'list_id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//friendships/groups/members/add
$cfg["friendships_groups_members_add"] = array(
	'summary' => '添加关注用户到好友分组',
	'url' => 'https://api.weibo.com/2/friendships/groups/members/add.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'list_id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
	),
);
//friendships/groups/members/add_batch
$cfg["friendships_groups_members_add_batch"] = array(
	'summary' => '批量添加用户到好友分组',
	'url' => 'https://api.weibo.com/2/friendships/groups/members/add_batch.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'group_descriptions',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'list_id',
		4 => 'uids',
	),
);
//friendships/groups/members/update
$cfg["friendships_groups_members_update"] = array(
	'summary' => '更新好友分组中成员的分组说明',
	'url' => 'https://api.weibo.com/2/friendships/groups/members/update.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'group_description',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'list_id',
		4 => 'uid',
	),
);
//friendships/groups/members/destroy
$cfg["friendships_groups_members_destroy"] = array(
	'summary' => '删除好友分组内的关注用户',
	'url' => 'https://api.weibo.com/2/friendships/groups/members/destroy.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'list_id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
	),
);
//friendships/groups/order
$cfg["friendships_groups_order"] = array(
	'summary' => '调整当前登录用户的好友分组顺序',
	'url' => 'https://api.weibo.com/2/friendships/groups/order.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'list_ids',
	),
);
//读取接口

//account/get_privacy
$cfg["account_get_privacy"] = array(
	'summary' => '获取当前登录用户的隐私设置',
	'url' => 'https://api.weibo.com/2/account/get_privacy.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'access_token|getAccessToken',
		1 => 'source',
	),
);
//account/profile/school_list
$cfg["account_profile_school_list"] = array(
	'summary' => '获取所有的学校列表',
	'url' => 'https://api.weibo.com/2/account/profile/school_list.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'province',
		4 => 'city',
		5 => 'area',
		6 => 'type',
		7 => 'capital',
		8 => 'keyword',
	),
);
//account/rate_limit_status
$cfg["account_rate_limit_status"] = array(
	'summary' => '获取当前登录用户的API访问频率限制情况',
	'url' => 'https://api.weibo.com/2/account/rate_limit_status.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'access_token|getAccessToken',
		1 => 'source',
	),
);
//account/profile/email
$cfg["account_profile_email"] = array(
	'summary' => '获取用户的联系邮箱',
	'url' => 'https://api.weibo.com/2/account/profile/email.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'access_token|getAccessToken',
		1 => 'source',
	),
);
//account/get_uid
$cfg["account_get_uid"] = array(
	'summary' => 'OAuth授权之后，获取授权用户的UID',
	'url' => 'https://api.weibo.com/2/account/get_uid.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'access_token|getAccessToken',
		1 => 'source',
	),
);
//写入接口

//account/verify_credentials
$cfg["account_verify_credentials"] = NULL;
//读取接口

//account/end_session
$cfg["account_end_session"] = array(
	'summary' => '退出登录',
	'url' => 'https://api.weibo.com/2/account/end_session.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'access_token|getAccessToken',
		1 => 'source',
	),
);
//favorites
$cfg["favorites"] = array(
	'summary' => '获取当前登录用户的收藏列表',
	'url' => 'https://api.weibo.com/2/favorites.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'count',
	),
);
//favorites/ids
$cfg["favorites_ids"] = array(
	'summary' => '获取当前用户的收藏列表的ID',
	'url' => 'https://api.weibo.com/2/favorites/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'count',
	),
);
//favorites/show
$cfg["favorites_show"] = array(
	'summary' => '根据收藏ID获取指定的收藏信息',
	'url' => 'https://api.weibo.com/2/favorites/show.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//favorites/by_tags
$cfg["favorites_by_tags"] = array(
	'summary' => '根据标签获取当前登录用户该标签下的收藏列表',
	'url' => 'https://api.weibo.com/2/favorites/by_tags.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'tid',
		4 => 'count',
	),
);
//favorites/tags
$cfg["favorites_tags"] = array(
	'summary' => '获取当前登录用户的收藏标签列表',
	'url' => 'https://api.weibo.com/2/favorites/tags.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'count',
	),
);
//写入接口

//favorites/by_tags/ids
$cfg["favorites_by_tags_ids"] = array(
	'summary' => '获取当前用户某个标签下的收藏列表的ID',
	'url' => 'https://api.weibo.com/2/favorites/by_tags/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'tid',
		4 => 'count',
	),
);
//favorites/create
$cfg["favorites_create"] = array(
	'summary' => '添加一条微博到收藏里',
	'url' => 'https://api.weibo.com/2/favorites/create.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//favorites/destroy
$cfg["favorites_destroy"] = array(
	'summary' => '取消收藏一条微博',
	'url' => 'https://api.weibo.com/2/favorites/destroy.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//favorites/destroy_batch
$cfg["favorites_destroy_batch"] = array(
	'summary' => '根据收藏ID批量取消收藏',
	'url' => 'https://api.weibo.com/2/favorites/destroy_batch.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'ids',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//favorites/tags/update
$cfg["favorites_tags_update"] = array(
	'summary' => '更新一条收藏的收藏标签',
	'url' => 'https://api.weibo.com/2/favorites/tags/update.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'tags',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'id',
	),
);
//favorites/tags/update_batch
$cfg["favorites_tags_update_batch"] = array(
	'summary' => '更新当前登录用户所有收藏下的指定标签',
	'url' => 'https://api.weibo.com/2/favorites/tags/update_batch.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'tag',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'tid',
	),
);
//读取接口

//favorites/tags/destroy_batch
$cfg["favorites_tags_destroy_batch"] = array(
	'summary' => '删除当前登录用户所有收藏下的指定标签',
	'url' => 'https://api.weibo.com/2/favorites/tags/destroy_batch.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'tid',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//trends/hourly
$cfg["trends_hourly"] = array(
	'summary' => '返回最近一小时内的热门话题',
	'url' => 'https://api.weibo.com/2/trends/hourly.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//trends/daily
$cfg["trends_daily"] = array(
	'summary' => '返回最近一天内的热门话题',
	'url' => 'https://api.weibo.com/2/trends/daily.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//读取接口

//trends/weekly
$cfg["trends_weekly"] = array(
	'summary' => '返回最近一周内的热门话题',
	'url' => 'https://api.weibo.com/2/trends/weekly.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//statuses/tags
$cfg["statuses_tags"] = array(
	'summary' => '获取当前用户的微博标签列表',
	'url' => 'https://api.weibo.com/2/statuses/tags.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//statuses/tags/show_batch
$cfg["statuses_tags_show_batch"] = array(
	'summary' => '根据提供的微博ID批量获取此微博的标签信息',
	'url' => 'https://api.weibo.com/2/statuses/tags/show_batch.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'ids',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//写入接口

//statuses/tag_timeline/ids
$cfg["statuses_tag_timeline_ids"] = array(
	'summary' => '获取当前用户某个标签的微博ID列表',
	'url' => 'https://api.weibo.com/2/statuses/tag_timeline/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'tag',
		4 => 'since_id',
		5 => 'max_id',
		6 => 'count',
	),
);
//statuses/tags/create
$cfg["statuses_tags_create"] = array(
	'summary' => '创建当前登陆用户微博的标签',
	'url' => 'https://api.weibo.com/2/statuses/tags/create.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'tag',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//statuses/tags/destroy
$cfg["statuses_tags_destroy"] = array(
	'summary' => '删除当前登陆用户微博的标签',
	'url' => 'https://api.weibo.com/2/statuses/tags/destroy.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'tag',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//statuses/tags/update
$cfg["statuses_tags_update"] = array(
	'summary' => '更新当前登陆用户微博的标签',
	'url' => 'https://api.weibo.com/2/statuses/tags/update.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'new_tag',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'old_tag',
	),
);
//读取接口

//statuses/update_tags
$cfg["statuses_update_tags"] = array(
	'summary' => '更新当前登陆用户某个微博的标签',
	'url' => 'https://api.weibo.com/2/statuses/update_tags.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'tags',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'id',
	),
);
//tags
$cfg["tags"] = array(
	'summary' => '返回指定用户的标签列表',
	'url' => 'https://api.weibo.com/2/tags.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'count',
	),
);
//tags/tags_batch
$cfg["tags_tags_batch"] = array(
	'summary' => '批量获取用户的标签列表',
	'url' => 'https://api.weibo.com/2/tags/tags_batch.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'uids',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//写入接口

//tags/suggestions
$cfg["tags_suggestions"] = array(
	'summary' => '获取系统推荐的标签列表',
	'url' => 'https://api.weibo.com/2/tags/suggestions.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//tags/create
$cfg["tags_create"] = array(
	'summary' => '为当前登录用户添加新的用户标签',
	'url' => 'https://api.weibo.com/2/tags/create.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'tags',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//tags/destroy
$cfg["tags_destroy"] = array(
	'summary' => '删除一个用户标签',
	'url' => 'https://api.weibo.com/2/tags/destroy.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'tag_id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//读取接口

//tags/destroy_batch
$cfg["tags_destroy_batch"] = array(
	'summary' => '批量删除一组标签',
	'url' => 'https://api.weibo.com/2/tags/destroy_batch.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'ids',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//搜索联想接口

//register/verify_nickname
$cfg["register_verify_nickname"] = array(
	'summary' => '验证昵称是否可用，并给予建议昵称',
	'url' => 'https://api.weibo.com/2/register/verify_nickname.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'nickname',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//search/suggestions/users
$cfg["search_suggestions_users"] = array(
	'summary' => '搜索用户时的联想搜索建议',
	'url' => 'https://api.weibo.com/2/search/suggestions/users.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'q',
	),
);
//search/suggestions/schools
$cfg["search_suggestions_schools"] = array(
	'summary' => '搜索学校时的联想搜索建议',
	'url' => 'https://api.weibo.com/2/search/suggestions/schools.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'type',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'q',
		4 => 'count',
	),
);
//search/suggestions/companies
$cfg["search_suggestions_companies"] = array(
	'summary' => '搜索公司时的联想搜索建议',
	'url' => 'https://api.weibo.com/2/search/suggestions/companies.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'q',
	),
);
//search/suggestions/apps
$cfg["search_suggestions_apps"] = array(
	'summary' => '搜索应用时的联想搜索建议',
	'url' => 'https://api.weibo.com/2/search/suggestions/apps.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'q',
	),
);
//搜索话题接口

//search/suggestions/at_users
$cfg["search_suggestions_at_users"] = array(
	'summary' => '@用户时的联想建议',
	'url' => 'https://api.weibo.com/2/search/suggestions/at_users.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'range',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'q',
		4 => 'count',
		5 => 'type',
	),
);
//读取接口

//search/topics
$cfg["search_topics"] = array(
	'summary' => '搜索某一话题下的微博',
	'url' => 'https://api.weibo.com/2/search/topics.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'q',
		4 => 'count',
	),
);
//suggestions/users/hot
$cfg["suggestions_users_hot"] = array(
	'summary' => '返回系统推荐的热门用户列表',
	'url' => 'https://api.weibo.com/2/suggestions/users/hot.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'category',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//suggestions/users/may_interested
$cfg["suggestions_users_may_interested"] = array(
	'summary' => '获取用户可能感兴趣的人',
	'url' => 'https://api.weibo.com/2/suggestions/users/may_interested.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'count',
	),
);
//suggestions/users/by_status
$cfg["suggestions_users_by_status"] = array(
	'summary' => '根据一段微博正文推荐相关微博用户',
	'url' => 'https://api.weibo.com/2/suggestions/users/by_status.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'num',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'content',
	),
);
//suggestions/statuses/reorder
$cfg["suggestions_statuses_reorder"] = array(
	'summary' => '当前登录用户的friends_timeline微博按兴趣推荐排序',
	'url' => 'https://api.weibo.com/2/suggestions/statuses/reorder.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'section',
		4 => 'count',
	),
);
//suggestions/statuses/reorder/ids
$cfg["suggestions_statuses_reorder_ids"] = array(
	'summary' => '当前登录用户的friends_timeline微博按兴趣推荐排序的微博ID',
	'url' => 'https://api.weibo.com/2/suggestions/statuses/reorder/ids.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'section',
		4 => 'count',
	),
);
//写入接口

//suggestions/favorites/hot
$cfg["suggestions_favorites_hot"] = array(
	'summary' => '返回系统推荐的热门收藏',
	'url' => 'https://api.weibo.com/2/suggestions/favorites/hot.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'count',
	),
);
//读取接口

//suggestions/users/not_interested
$cfg["suggestions_users_not_interested"] = array(
	'summary' => '把某人标识为不感兴趣的人',
	'url' => 'https://api.weibo.com/2/suggestions/users/not_interested.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'uid',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//写入接口

//remind/unread_count
$cfg["remind_unread_count"] = array(
	'summary' => '获取某个用户的各种消息未读数',
	'url' => 'https://rm.api.weibo.com/2/remind/unread_count.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'unread_message',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'callback',
	),
);
//转换接口

//remind/set_count
$cfg["remind_set_count"] = array(
	'summary' => '对当前登录用户某一种消息未读数进行清零',
	'url' => 'https://rm.api.weibo.com/2/remind/set_count.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'type',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//short_url/shorten
$cfg["short_url_shorten"] = array(
	'summary' => '将一个或多个长链接转换成短链接',
	'url' => 'https://api.weibo.com/2/short_url/shorten.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'url_long',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//数据接口

//short_url/expand
$cfg["short_url_expand"] = array(
	'summary' => '将一个或多个短链接还原成原始的长链接',
	'url' => 'https://api.weibo.com/2/short_url/expand.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'url_short',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//short_url/share/counts
$cfg["short_url_share_counts"] = array(
	'summary' => '获取短链接在微博上的微博分享数',
	'url' => 'https://api.weibo.com/2/short_url/share/counts.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'url_short',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//short_url/share/statuses
$cfg["short_url_share_statuses"] = array(
	'summary' => '获取包含指定单个短链接的最新微博内容',
	'url' => 'https://api.weibo.com/2/short_url/share/statuses.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'url_short',
		4 => 'since_id',
		5 => 'max_id',
		6 => 'count',
	),
);
//short_url/comment/counts
$cfg["short_url_comment_counts"] = array(
	'summary' => '获取短链接在微博上的微博评论数',
	'url' => 'https://api.weibo.com/2/short_url/comment/counts.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'url_short',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//读取接口

//short_url/comment/comments
$cfg["short_url_comment_comments"] = array(
	'summary' => '获取包含指定单个短链接的最新微博评论',
	'url' => 'https://api.weibo.com/2/short_url/comment/comments.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'page',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'url_short',
		4 => 'since_id',
		5 => 'max_id',
		6 => 'count',
	),
);
//common/code_to_location
$cfg["common_code_to_location"] = array(
	'summary' => '通过地址编码获取地址名称',
	'url' => 'https://api.weibo.com/2/common/code_to_location.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'codes',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//common/get_city
$cfg["common_get_city"] = array(
	'summary' => '获取城市列表',
	'url' => 'https://api.weibo.com/2/common/get_city.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'language',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'province',
		4 => 'capital',
	),
);
//common/get_province
$cfg["common_get_province"] = array(
	'summary' => '获取省份列表',
	'url' => 'https://api.weibo.com/2/common/get_province.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'language',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'country',
		4 => 'capital',
	),
);
//common/get_country
$cfg["common_get_country"] = array(
	'summary' => '获取国家列表',
	'url' => 'https://api.weibo.com/2/common/get_country.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'language',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'capital',
	),
);
//动态读取接口

//common/get_timezone
$cfg["common_get_timezone"] = array(
	'summary' => '获取时区配置表',
	'url' => 'https://api.weibo.com/2/common/get_timezone.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'language',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//开发指南
$cfg["开发指南"] = NULL;
//place/public_timeline
$cfg["place_public_timeline"] = array(
	'summary' => '获取最新20条公共的位置动态',
	'url' => 'https://api.weibo.com/2/place/public_timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'count',
	),
);
//place/friends_timeline
$cfg["place_friends_timeline"] = array(
	'summary' => '获取当前登录用户与其好友的位置动态',
	'url' => 'https://api.weibo.com/2/place/friends_timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'type',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'since_id',
		4 => 'max_id',
		5 => 'count',
		6 => 'page',
	),
);
//place/user_timeline
$cfg["place_user_timeline"] = array(
	'summary' => '获取某个用户的位置动态',
	'url' => 'https://api.weibo.com/2/place/user_timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'since_id',
		5 => 'max_id',
		6 => 'count',
		7 => 'page',
	),
);
//place/poi_timeline
$cfg["place_poi_timeline"] = array(
	'summary' => '获取某个位置地点的动态',
	'url' => 'https://api.weibo.com/2/place/poi_timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'poiid',
		4 => 'since_id',
		5 => 'max_id',
		6 => 'count',
		7 => 'page',
	),
);
//用户读取接口

//place/nearby_timeline
$cfg["place_nearby_timeline"] = array(
	'summary' => '获取某个位置周边的动态',
	'url' => 'https://api.weibo.com/2/place/nearby_timeline.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'offset',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'lat',
		4 => 'long',
		5 => 'range',
		6 => 'starttime',
		7 => 'endtime',
		8 => 'sort',
		9 => 'count',
		10 => 'page',
		11 => 'base_app',
	),
);
//place/statuses/show
$cfg["place_statuses_show"] = array(
	'summary' => '根据ID获取动态的详情',
	'url' => 'https://api.weibo.com/2/place/statuses/show.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'id',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//place/users/show
$cfg["place_users_show"] = array(
	'summary' => '获取LBS位置服务内的用户信息',
	'url' => 'https://api.weibo.com/2/place/users/show.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
	),
);
//place/users/checkins
$cfg["place_users_checkins"] = array(
	'summary' => '获取用户签到过的地点列表',
	'url' => 'https://api.weibo.com/2/place/users/checkins.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'count',
		5 => 'page',
	),
);
//place/users/photos
$cfg["place_users_photos"] = array(
	'summary' => '获取用户的照片列表',
	'url' => 'https://api.weibo.com/2/place/users/photos.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'count',
		5 => 'page',
	),
);
//地点读取接口

//place/users/tips
$cfg["place_users_tips"] = array(
	'summary' => '（已废弃）获取用户的点评列表',
	'url' => 'https://api.weibo.com/2/place/users/tips.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'count',
		5 => 'page',
	),
);
//place/users/todos
$cfg["place_users_todos"] = array(
	'summary' => '获取用户的todo列表',
	'url' => 'https://api.weibo.com/2/place/users/todos.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'uid',
		4 => 'count',
		5 => 'page',
	),
);
//place/pois/show
$cfg["place_pois_show"] = array(
	'summary' => '获取地点详情',
	'url' => 'https://api.weibo.com/2/place/pois/show.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'poiid',
	),
);
//place/pois/users
$cfg["place_pois_users"] = array(
	'summary' => '获取在某个地点签到的人的列表',
	'url' => 'https://api.weibo.com/2/place/pois/users.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'poiid',
		4 => 'count',
		5 => 'page',
	),
);
//place/pois/tips
$cfg["place_pois_tips"] = array(
	'summary' => '（已废弃）获取地点点评列表',
	'url' => 'https://api.weibo.com/2/place/pois/tips.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'poiid',
		4 => 'count',
		5 => 'page',
		6 => 'sort',
	),
);
//place/pois/photos
$cfg["place_pois_photos"] = array(
	'summary' => '获取地点照片列表',
	'url' => 'https://api.weibo.com/2/place/pois/photos.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'base_app',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'poiid',
		4 => 'count',
		5 => 'page',
		6 => 'sort',
	),
);
//附近读取接口

//place/pois/search
$cfg["place_pois_search"] = array(
	'summary' => '按省市查询地点',
	'url' => 'https://api.weibo.com/2/place/pois/search.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'keyword',
		4 => 'city',
		5 => 'category',
		6 => 'page',
	),
);
//place/pois/category
$cfg["place_pois_category"] = array(
	'summary' => '获取地点分类',
	'url' => 'https://api.weibo.com/2/place/pois/category.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'flag',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'pid',
	),
);
//place/nearby/pois
$cfg["place_nearby_pois"] = array(
	'summary' => '获取附近地点',
	'url' => 'https://api.weibo.com/2/place/nearby/pois.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'offset',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'lat',
		4 => 'long',
		5 => 'range',
		6 => 'q',
		7 => 'category',
		8 => 'count',
		9 => 'page',
		10 => 'sort',
	),
);
//place/nearby/users
$cfg["place_nearby_users"] = array(
	'summary' => '获取附近发位置微博的人',
	'url' => 'https://api.weibo.com/2/place/nearby/users.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'offset',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'lat',
		4 => 'long',
		5 => 'range',
		6 => 'count',
		7 => 'page',
		8 => 'starttime',
		9 => 'endtime',
		10 => 'sort',
	),
);
//地点写入接口

//place/nearby/photos
$cfg["place_nearby_photos"] = array(
	'summary' => '获取附近照片',
	'url' => 'https://api.weibo.com/2/place/nearby/photos.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'offset',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'lat',
		4 => 'long',
		5 => 'range',
		6 => 'count',
		7 => 'page',
		8 => 'starttime',
		9 => 'endtime',
		10 => 'sort',
	),
);
//place/nearby_users/list
$cfg["place_nearby_users_list"] = array(
	'summary' => '获取附近的人',
	'url' => 'https://api.weibo.com/2/place/nearby_users/list.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'offset',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'lat',
		4 => 'long',
		5 => 'count',
		6 => 'page',
		7 => 'range',
		8 => 'sort',
		9 => 'filter',
		10 => 'gender',
		11 => 'level',
		12 => 'startbirth',
		13 => 'endbirth',
	),
);
//place/pois/create
$cfg["place_pois_create"] = array(
	'summary' => '添加地点',
	'url' => 'https://api.weibo.com/2/place/pois/create.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'extra',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'title',
		4 => 'address',
		5 => 'category',
		6 => 'lat',
		7 => 'long',
		8 => 'city',
		9 => 'province',
		10 => 'country',
		11 => 'phone',
		12 => 'postcode',
	),
);
//place/pois/add_checkin
$cfg["place_pois_add_checkin"] = array(
	'summary' => '签到同时可以上传一张图片',
	'url' => 'https://api.weibo.com/2/place/pois/add_checkin.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'public',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'poiid',
		4 => 'status',
		5 => 'pic',
	),
);
//place/pois/add_photo
$cfg["place_pois_add_photo"] = array(
	'summary' => '添加照片',
	'url' => 'https://api.weibo.com/2/place/pois/add_photo.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'public',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'poiid',
		4 => 'status',
		5 => 'pic',
	),
);
//附近写入接口

//place/pois/add_tip
$cfg["place_pois_add_tip"] = array(
	'summary' => '添加点评',
	'url' => 'https://api.weibo.com/2/place/pois/add_tip.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'public',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'poiid',
		4 => 'status',
	),
);
//place/pois/add_todo
$cfg["place_pois_add_todo"] = array(
	'summary' => '添加todo',
	'url' => 'https://api.weibo.com/2/place/pois/add_todo.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'public',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'poiid',
		4 => 'status',
	),
);
//基础位置读取接口

//place/nearby_users/create
$cfg["place_nearby_users_create"] = array(
	'summary' => '用户添加自己的位置',
	'url' => 'https://api.weibo.com/2/place/nearby_users/create.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'long',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'lat',
	),
);
//坐标转换接口

//place/nearby_users/destroy
$cfg["place_nearby_users_destroy"] = array(
	'summary' => '用户删除自己的位置',
	'url' => 'https://api.weibo.com/2/place/nearby_users/destroy.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'access_token|getAccessToken',
		1 => 'source',
	),
);
//location/base/get_map_image
$cfg["location_base_get_map_image"] = array(
	'summary' => '生成一张静态的地图图片',
	'url' => 'https://api.weibo.com/2/location/base/get_map_image.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'traffic',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'center_coordinate',
		4 => 'city',
		5 => 'coordinates',
		6 => 'names',
		7 => 'offset_x',
		8 => 'offset_y',
		9 => 'font',
		10 => 'lines',
		11 => 'polygons',
		12 => 'size',
		13 => 'format',
		14 => 'zoom',
		15 => 'scale',
	),
);
//location/geo/ip_to_geo
$cfg["location_geo_ip_to_geo"] = array(
	'summary' => '根据IP地址返回地理信息坐标',
	'url' => 'https://api.weibo.com/2/location/geo/ip_to_geo.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'ip',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//location/geo/address_to_geo
$cfg["location_geo_address_to_geo"] = array(
	'summary' => '根据实际地址返回地理信息坐标',
	'url' => 'https://api.weibo.com/2/location/geo/address_to_geo.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'address',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//location/geo/geo_to_address
$cfg["location_geo_geo_to_address"] = array(
	'summary' => '根据地理信息坐标返回实际地址',
	'url' => 'https://api.weibo.com/2/location/geo/geo_to_address.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'coordinate',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//POI数据搜索接口

//location/geo/gps_to_offset
$cfg["location_geo_gps_to_offset"] = array(
	'summary' => '根据GPS坐标获取偏移后的坐标',
	'url' => 'https://api.weibo.com/2/location/geo/gps_to_offset.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'coordinate',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//location/geo/is_domestic
$cfg["location_geo_is_domestic"] = array(
	'summary' => '判断地理信息坐标是否是国内坐标',
	'url' => 'https://api.weibo.com/2/location/geo/is_domestic.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'coordinates',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//location/pois/search/by_location
$cfg["location_pois_search_by_location"] = array(
	'summary' => '根据关键词按地址位置获取POI点的信息',
	'url' => 'https://api.weibo.com/2/location/pois/search/by_location.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'q',
		4 => 'category',
		5 => 'city',
		6 => 'page',
	),
);
//POI数据读写接口

//location/pois/search/by_geo
$cfg["location_pois_search_by_geo"] = array(
	'summary' => '根据关键词按坐标点范围获取POI点的信息',
	'url' => 'https://api.weibo.com/2/location/pois/search/by_geo.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'sr',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'q',
		4 => 'coordinate',
		5 => 'cenname',
		6 => 'city',
		7 => 'range',
		8 => 'page',
		9 => 'count',
		10 => 'searchtype',
		11 => 'srctype',
		12 => 'naviflag',
	),
);
//location/pois/search/by_area
$cfg["location_pois_search_by_area"] = array(
	'summary' => '根据关键词按矩形区域获取POI点的信息',
	'url' => 'https://api.weibo.com/2/location/pois/search/by_area.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'q',
		4 => 'category',
		5 => 'coordinates',
		6 => 'city',
		7 => 'page',
	),
);
//移动服务读取接口

//location/pois/show_batch
$cfg["location_pois_show_batch"] = array(
	'summary' => '批量获取POI点的信息',
	'url' => 'https://api.weibo.com/2/location/pois/show_batch.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'srcids',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//交通路线读取接口

//location/pois/add
$cfg["location_pois_add"] = array(
	'summary' => '提交一个新增的POI点信息',
	'url' => 'https://api.weibo.com/2/location/pois/add.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'traffic',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'srcid',
		4 => 'name',
		5 => 'address',
		6 => 'city_name',
		7 => 'category',
		8 => 'longitude',
		9 => 'latitude',
		10 => 'telephone',
		11 => 'pic_url',
		12 => 'url',
		13 => 'tags',
		14 => 'description',
		15 => 'intro',
	),
);
//location/mobile/get_location
$cfg["location_mobile_get_location"] = array(
	'summary' => '根据移动基站WIFI等数据获取当前位置信息',
	'url' => 'https://api.weibo.com/2/location/mobile/get_location.json',
	'dataType' => 'JSON',
	'method' => 'POST',
	'requestParam' => array(
		0 => 'json',
		1 => 'source',
		2 => 'access_token|getAccessToken',
	),
);
//location/line/drive_route
$cfg["location_line_drive_route"] = array(
	'summary' => '根据起点与终点数据查询自驾车路线信息',
	'url' => 'https://api.weibo.com/2/location/line/drive_route.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'type',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'begin_pid',
		4 => 'begin_coordinate',
		5 => 'end_pid',
		6 => 'end_coordinate',
	),
);
//location/line/bus_route
$cfg["location_line_bus_route"] = array(
	'summary' => '根据起点与终点数据查询公交乘坐路线信息',
	'url' => 'https://api.weibo.com/2/location/line/bus_route.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'type',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'begin_pid',
		4 => 'begin_coordinate',
		5 => 'end_pid',
		6 => 'end_coordinate',
	),
);
//地理信息字段说明

//location/line/bus_line
$cfg["location_line_bus_line"] = array(
	'summary' => '根据关键词查询公交线路信息',
	'url' => 'https://api.weibo.com/2/location/line/bus_line.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'q',
		4 => 'city',
		5 => 'page',
	),
);
//location/line/bus_station
$cfg["location_line_bus_station"] = array(
	'summary' => '根据关键词查询公交站点信息',
	'url' => 'https://api.weibo.com/2/location/line/bus_station.json',
	'dataType' => 'JSON',
	'method' => 'GET',
	'requestParam' => array(
		0 => 'count',
		1 => 'source',
		2 => 'access_token|getAccessToken',
		3 => 'q',
		4 => 'city',
		5 => 'page',
	),
);
return $cfg;