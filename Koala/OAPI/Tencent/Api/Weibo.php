<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 腾讯微博开放平台 API
 *
 * http://wiki.open.t.qq.com/index.php/%E9%A6%96%E9%A1%B5
 *
 * http://wiki.open.t.qq.com/index.php/API%E6%96%87%E6%A1%A3#access
 */
//请求获取auth_code
$cfg['get_auth_code'] = array(
	'url' => 'https://open.t.qq.com/cgi-bin/oauth2/authorize',
	'method' => 'get',
	'redirect' => true,
	'commonParam' => array(),
	'requestParam' => array('wap|@0', 'forcelogin|@true', 'response_type|@code', 'client_id|getAppKey', 'redirect_uri|getCodeRedirectUri', 'state', 'scope|@get_user_info'),
);
//通过Authorization Code获取Access Token
$cfg['get_access_token'] = array(
	'url' => 'https://open.t.qq.com/cgi-bin/oauth2/access_token',
	'method' => 'get',
	'commonParam' => array(),
	'requestParam' => array('grant_type|@authorization_code', 'client_id|getAppKey', 'client_secret|getAppSecret', 'code|getAuthCode', 'redirect_uri|getCodeRedirectUri', 'state'),
);
//通过REFRESH_TOKEN获取Access Token
$cfg['refresh_access_token'] = array(
	'url' => 'https://open.t.qq.com/cgi-bin/oauth2/access_token',
	'method' => 'get',
	'commonParam' => array(),
	'requestParam' => array('grant_type|@refresh_token', 'client_id|getAppKey', 'refresh_token|getRefreshToken'),
);
$commonParam = array('oauth_consumer_key|getAppKey', 'access_token|getAccessToken', 'openid|getOpenid', 'clientip|getClientip', 'oauth_version|@2.a', 'scope|@all');
//收听某个微博用户
$cfg['friends_add'] = array(
	'url' => 'https://open.t.qq.com/api/friends/add',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'fopenids'),
);
//取消收听某个好友
$cfg['friends_del'] = array(
	'url' => 'https://open.t.qq.com/api/friends/del',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'fopenid'),
);
//特别收听某用户
$cfg['friends_addspecial'] = array(
	'url' => 'https://open.t.qq.com/api/friends/addspecial',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'fopenid'),
);
//取消特别收听某用户
$cfg['friends_delspecial'] = array(
	'url' => 'https://open.t.qq.com/api/friends/delspecial',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'fopenid'),
);
//将某用户添加到黑名单
$cfg['friends_addblacklist'] = array(
	'url' => 'https://open.t.qq.com/api/friends/addblacklist',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'fopenid'),
);
//将某用户从黑名单移除
$cfg['friends_delblacklist'] = array(
	'url' => 'https://open.t.qq.com/api/friends/delblacklist',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'fopenid'),
);
// 获取我的粉丝列表	friends/fanslist
$cfg['friends_fanslist'] = array(
	'url' => 'https://open.t.qq.com/api/friends/fanslist',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'startindex|@0', 'mode|@0', 'install|@0', 'sex|@0'),
);
// 获取我的粉丝名称列表	friends/fanslist_name
$cfg['friends_fanslist_name'] = array(
	'url' => 'https://open.t.qq.com/api/friends/fanslist_name',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'startindex|@0', 'mode|@0', 'install|@0', 'sex|@0'),
);
// 获取我的粉丝信息列表（简版）	friends/fanslist_s
$cfg['friends_fanslist_s'] = array(
	'url' => 'https://open.t.qq.com/api/friends/fanslist_s',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'startindex|@0', 'mode|@0', 'install|@0'),
);
// 获取用户的粉丝列表	friends/user_fanslist
$cfg['friends_user_fanslist'] = array(
	'url' => 'https://open.t.qq.com/api/friends/user_fanslist',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'startindex|@0', 'mode|@0', 'install|@0', 'name', 'fopenid'),
);
// 获取我的偶像列表	friends/idollist
$cfg['friends_idollist'] = array(
	'url' => 'https://open.t.qq.com/api/friends/idollist',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'startindex|@0', 'mode|@0', 'install|@0'),
);
// 获取我的偶像名称列表（简版）	friends/idollist_name
$cfg['friends_idollist_name'] = array(
	'url' => 'https://open.t.qq.com/api/friends/idollist_name',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'startindex|@0', 'mode|@0', 'install|@0'),
);
// 获取我的偶像列表（简版）	friends/idollist_s
$cfg['friends_idollist_s'] = array(
	'url' => 'https://open.t.qq.com/api/friends/idollist_s',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'startindex|@0', 'mode|@0', 'install|@0'),
);
// 获取用户偶像列表	friends/user_idollist
$cfg['friends_user_idollist'] = array(
	'url' => 'https://open.t.qq.com/api/friends/user_idollist',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'startindex|@0', 'mode|@0', 'install|@0', 'name', 'fopenid'),
);
// 获取我的特别收听列表	friends/speciallist
$cfg['friends_speciallist'] = array(
	'url' => 'https://open.t.qq.com/api/friends/speciallist',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'startindex|@0', 'install|@0'),
);
// 获取用户的特别收听列表	friends/user_speciallist
$cfg['friends_user_speciallist'] = array(
	'url' => 'https://open.t.qq.com/api/friends/user_speciallist',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'startindex|@0', 'install|@0', 'name', 'fopenid'),
);
// 获取用户的双向收听列表	friends/mutual_list
$cfg['friends_mutual_list'] = array(
	'url' => 'https://open.t.qq.com/api/friends/mutual_list',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'startindex|@0', 'install|@0', 'name', 'fopenid'),
);
// 获取用户最亲密的好友列表	friends/get_intimate_friends
$cfg['get_intimate_friends'] = array(
	'url' => 'https://open.t.qq.com/api/friends/get_intimate_friends',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum'),
);
// 黑名单列表	friends/blacklist
$cfg['friends_blacklist'] = array(
	'url' => 'https://open.t.qq.com/api/friends/blacklist',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'startindex|@0'),
);
// 判断账户的收听关系	friends/check
$cfg['friends_check'] = array(
	'url' => 'https://open.t.qq.com/api/friends/check',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'names', 'fopenids', 'flag|@0'),
);
// 好友帐号输入提示	friends/match_nick_tips
$cfg['match_nick_tips'] = array(
	'url' => 'https://open.t.qq.com/api/friends/match_nick_tips',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum', 'match'),
);
//
//发表一条微博信息	t/add
$cfg['t_add'] = array(
	'url' => 'https://open.t.qq.com/api/t/add',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'content', 'clientip|getClientip', 'longitude', 'latitude', 'syncflag', 'compatibleflag|@0', 'empty'),
);
// 发表一条带图片的微博	t/add_pic
$cfg['t_add_pic'] = array(
	'url' => 'https://open.t.qq.com/api/t/add_pic',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'content', 'pic', 'clientip|getClientip', 'longitude', 'latitude', 'syncflag', 'compatibleflag|@0', 'empty'),
);
// 用图片URL发表带图片的微博	t/add_pic_url
$cfg['t_add_pic_url'] = array(
	'url' => 'https://open.t.qq.com/api/t/add_pic_url',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'content', 'pic_url', 'clientip|getClientip', 'longitude', 'latitude', 'syncflag', 'compatibleflag|@0', 'empty'),
);
// 发表带心情的微博	t/add_emotion
$cfg['t_add_emotion'] = array(
	'url' => 'https://open.t.qq.com/api/t/add_emotion',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'content', 'signtype|@1', 'clientip|getClientip', 'longitude', 'latitude', 'syncflag', 'compatibleflag|@0', 'empty'),
);
// 发表音乐微博	t/add_music
$cfg['t_add_music'] = array(
	'url' => 'https://open.t.qq.com/api/t/add_music',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'content', 'music_url', 'music_id', 'music_title', 'music_author', 'clientip|getClientip', 'longitude', 'latitude', 'syncflag', 'compatibleflag|@0', 'empty'),
);
// 发表带视频内容的微博	t/add_video
$cfg['t_add_video'] = array(
	'url' => 'https://open.t.qq.com/api/t/add_video',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'content', 'video_url', 'clientip|getClientip', 'longitude', 'latitude', 'syncflag', 'compatibleflag|@0', 'empty'),
);
// 发表带视频、音乐、图片等内容的微博	t/add_multi
$cfg['t_add_multi'] = array(
	'url' => 'https://open.t.qq.com/api/t/add_multi',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'content', 'video_url', 'pic_url', 'music_url', 'music_title', 'music_author', 'clientip|getClientip', 'longitude', 'latitude', 'syncflag', 'compatibleflag|@0', 'empty'),
);
// 上传一张图片	t/upload_pic
$cfg['t_upload_pic'] = array(
	'url' => 'https://open.t.qq.com/api/t/upload_pic',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pic_url', 'pic', 'pic_type|@1'),
);
// 转发一条微博	t/re_add
$cfg['t_re_add'] = array(
	'url' => 'https://open.t.qq.com/api/t/re_add',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'content', 'reid', 'clientip|getClientip', 'longitude', 'latitude', 'syncflag', 'compatibleflag|@0'),
);
// 删除一条微博	t/del
$cfg['t_del'] = array(
	'url' => 'https://open.t.qq.com/api/t/del',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'id'),
);
// 回复一条微博	t/reply
$cfg['t_reply'] = array(
	'url' => 'https://open.t.qq.com/api/t/reply',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'content', 'reid', 'clientip|getClientip', 'longitude', 'latitude', 'syncflag', 'compatibleflag|@0'),
);
// 评论一条微博	t/comment
$cfg['t_comment'] = array(
	'url' => 'https://open.t.qq.com/api/t/comment',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'content', 'reid', 'clientip|getClientip', 'longitude', 'latitude', 'syncflag', 'compatibleflag|@0'),
);
// 赞一条微博	t/like
$cfg['t_like'] = array(
	'url' => 'https://open.t.qq.com/api/t/like',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'id'),
);
// 取消对一条微博的赞	t/unlike
$cfg['t_unlike'] = array(
	'url' => 'https://open.t.qq.com/api/t/unlike',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'id', 'favoriteId'),
);
// 根据微博ID批量获取微博内容	t/list
$cfg['t_list'] = array(
	'url' => 'https://open.t.qq.com/api/t/list',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'ids'),
);
// 转播数或点评数	t/re_count
$cfg['t_re_count'] = array(
	'url' => 'https://open.t.qq.com/api/t/re_count',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'ids', 'flag|@0'),
);
// 获取转播的再次转播数	t/sub_re_count
$cfg['t_sub_re_count'] = array(
	'url' => 'https://open.t.qq.com/api/t/sub_re_count',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'ids'),
);
// 获取单条微博的转发或评论列表	t/re_list
$cfg['t_re_list'] = array(
	'url' => 'https://open.t.qq.com/api/t/re_list',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'flag|@0', 'rootid', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'twitterid'),
);
// 根据微博ID获取一条微博数据	t/show
$cfg['t_show'] = array(
	'url' => 'https://open.t.qq.com/api/t/show',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'id'),
);
// 根据链接地址获取视频信息	t/getvideoinfo
$cfg['t_getvideoinfo'] = array(
	'url' => 'https://open.t.qq.com/api/t/getvideoinfo',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'video_url'),
);
// 查询某人是否赞过某条微博	t/has_like
$cfg['t_has_like'] = array(
	'url' => 'https://open.t.qq.com/api/t/has_like',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'id', 'names', 'fopenids'),
);
//
// 获取当前用户及所关注用户的最新微博	statuses/home_timeline
$cfg['statuses_home_timeline'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/home_timeline',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'type|@0', 'contenttype|@0'),
);
// 获取当前用户及所关注用户的最新微博ID	statuses/home_timeline_ids
$cfg['statuses_home_timeline_ids'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/home_timeline_ids',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'type|@0', 'contenttype|@0'),
);
// 获取当前用户所关注的认证用户的最新微博	statuses/home_timeline_vip
$cfg['statuses_home_timeline_vip'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/home_timeline_vip',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid'),
);
// 获取当前用户发表的最新微博	statuses/broadcast_timeline
$cfg['statuses_broadcast_timeline'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/broadcast_timeline',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid', 'type|@0', 'contenttype|@0'),
);
// 获取当前用户发表的最新微博ID	statuses/broadcast_timeline_ids
$cfg['statuses_broadcast_timeline_ids'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/broadcast_timeline_ids',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid', 'type|@0', 'contenttype|@0'),
);
// 获取某用户的最新微博	statuses/user_timeline
$cfg['statuses_user_timeline'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/user_timeline',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid', 'type|@0', 'contenttype|@0', 'name', 'fopenid'),
);
// 获取用户发表的最新微博ID	statuses/user_timeline_ids
$cfg['statuses_user_timeline_ids'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/user_timeline_ids',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid', 'type|@0', 'contenttype|@0', 'name', 'fopenid'),
);
// 获取多个用户发表的最新微博	statuses/users_timeline
$cfg['statuses_users_timeline'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/users_timeline',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid', 'type|@0', 'contenttype|@0', 'names', 'fopenids'),
);
// 获取多个用户最新微博的ID	statuses/users_timeline_ids
$cfg['statuses_users_timeline_ids'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/users_timeline_ids',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid', 'type|@0', 'contenttype|@0', 'names', 'fopenids'),
);
// 获取@当前用户的最新微博	statuses/mentions_timeline
$cfg['statuses_mentions_timeline'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/mentions_timeline',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid', 'type|@0', 'contenttype|@0'),
);
// 获取@当前用户的最新微博的ID	statuses/mentions_timeline_ids
$cfg['statuses_mentions_timeline_ids'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/mentions_timeline_ids',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid', 'type|@0', 'contenttype|@0'),
);
// 获取特别收听用户的最新微博	statuses/special_timeline
$cfg['statuses_special_timeline'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/special_timeline',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid', 'type|@0', 'contenttype|@0'),
);
// 获取广播大厅的最新微博	statuses/public_timeline
$cfg['statuses_public_timeline'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/public_timeline',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pos', 'reqnum|@20'),
);
// 获取某地区的微博内容	statuses/area_timeline
$cfg['statuses_area_timeline'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/area_timeline',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pos', 'reqnum|@20', 'country', 'province', 'city'),
);
// 获取某话题的最新微博	statuses/ht_timeline_ext
$cfg['statuses_ht_timeline_ext'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/ht_timeline_ext',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'tweetid', 'time', 'httext', 'htid|@0', 'pageflag|@0', 'flag|@0', 'pagetime', 'reqnum|@20', 'lastid', 'type|@0', 'contenttype|@0'),
);
// 获取用户的微博相册内容	statuses/get_micro_album
$cfg['get_micro_album'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/get_micro_album',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid', 'name', 'fopenid'),
);
// 获取二传手列表	statuses/sub_re_list
$cfg['statuses_sub_re_list'] = array(
	'url' => 'https://open.t.qq.com/api/statuses/sub_re_list',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'rootid', 'type|@1', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid'),
);
//
// 收录指定用户到名单	list/add_to_list
$cfg['list_add_to_list'] = array(
	'url' => 'https://open.t.qq.com/api/list/add_to_list',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'lastid', 'names', 'fopenids'),
);
// 创建名单	list/create
$cfg['list_create'] = array(
	'url' => 'https://open.t.qq.com/api/list/create',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'description', 'tag', 'access'),
);
// 删除名单	list/delete
$cfg['list_delete'] = array(
	'url' => 'https://open.t.qq.com/api/list/delete',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'listid'),
);
// 订阅多个名单	list/follow
$cfg['list_follow'] = array(
	'url' => 'https://open.t.qq.com/api/list/follow',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'listids'),
);
// 查询指定用户所在的所有list	list/get_other_in_list
$cfg['list_get_other_in_list'] = array(
	'url' => 'https://open.t.qq.com/api/list/get_other_in_list',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'fopenid'),
);
// 名单订阅成员列表信息	list/list_followers
$cfg['list_followers'] = array(
	'url' => 'https://open.t.qq.com/api/list/list_followers',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'listid', 'page|@0'),
);
// 查询名单成员列表	list/listusers
$cfg['list_listusers'] = array(
	'url' => 'https://open.t.qq.com/api/list/listusers',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'listid', 'pageflag|@0'),
);
// 筛选指定的用户是否在名单中	list/check_user_in_list
$cfg['check_user_in_list'] = array(
	'url' => 'https://open.t.qq.com/api/list/check_user_in_list',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'listids', 'name', 'fopenid'),
);
// 从名单中删除指定用户	list/del_from_list
$cfg['del_from_list'] = array(
	'url' => 'https://open.t.qq.com/api/list/del_from_list',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'listid', 'names', 'fopenids'),
);
// 修改名单	list/edit
$cfg['list_edit'] = array(
	'url' => 'https://open.t.qq.com/api/list/edit',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'listid', 'name', 'description', 'tag', 'access'),
);
// 查询我创建的名单	list/get_list
$cfg['get_list'] = array(
	'url' => 'https://open.t.qq.com/api/list/get_list',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json'),
);
// 名单属性信息	list/list_attr
$cfg['list_attr'] = array(
	'url' => 'https://open.t.qq.com/api/list/list_attr',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'listids'),
);
// 名单时间线	list/timeline
$cfg['list_timeline'] = array(
	'url' => 'https://open.t.qq.com/api/list/timeline',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'listid', 'type|@0', 'contenttype|@0', 'pageflag|@0', 'pagetime', 'reqnum|@20', 'lastid'),
);
// 查询指定微博用户的名单相关信息	list/list_info
$cfg['list_info'] = array(
	'url' => 'https://open.t.qq.com/api/list/list_info',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'names', 'fopenids'),
);
// 我订阅的名单信息	list/myfollowlist
$cfg['myfollowlist'] = array(
	'url' => 'https://open.t.qq.com/api/list/myfollowlist',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pageflag|@0'),
);
// 取消订阅多个名单	list/undo_follow
$cfg['list_undo_follow'] = array(
	'url' => 'https://open.t.qq.com/api/list/undo_follow',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'listids'),
);
//
// 更新当前登录用户的个人信息	user/update
$cfg['user_update'] = array(
	'url' => 'https://open.t.qq.com/api/user/update',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	//http://open.t.qq.com//download/addresslist.zip
	'requestParam' => array('format|@json', 'nick', 'sex', 'year', 'month', 'day', 'countrycode', 'provincecode', 'citycode', 'introduction'),
);
// 更新当前登录用户的教育信息	user/update_edu
$cfg['user_update_edu'] = array(
	'url' => 'https://open.t.qq.com/api/user/update_edu',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'feildid|@1', 'year', 'schoolid', 'departmentid', 'level'),
);
// 更新当前登录用户的头像信息	user/update_head
$cfg['user_update_head'] = array(
	'url' => 'https://open.t.qq.com/api/user/update_head',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'pic'),
);
// 验证账户的合法性	user/verify
$cfg['user_verify'] = array(
	'url' => 'https://open.t.qq.com/api/user/verify',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'fopenid'),
);
// 获取用户的心情微博	user/emotion
$cfg['user_emotion'] = array(
	'url' => 'https://open.t.qq.com/api/user/emotion',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'fopenid', 'pageflag', 'id|@0', 'timestamp|@0', 'type|@0', 'contenttype|@0', 'emotiontype', 'reqnum|@20', 'listtype|@0'),
);
// 获取当前登录用户的个人资料	user/info
$cfg['user_info'] = array(
	'url' => 'https://open.t.qq.com/api/user/info',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json'),
);
// 获取批量用户的个人资料	user/infos
$cfg['user_infos'] = array(
	'url' => 'https://open.t.qq.com/api/user/infos',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'names', 'fopenids'),
);
// 根据用户ID获取用户信息	user/other_info
$cfg['user_other_info'] = array(
	'url' => 'https://open.t.qq.com/api/user/other_info',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'fopenid'),
);
//
// 订阅话题	fav/addht
$cfg['fav_addht'] = array(
	'url' => 'https://open.t.qq.com/api/fav/addht',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'id'),
);
// 收藏一条微博	fav/addt
$cfg['fav_addt'] = array(
	'url' => 'https://open.t.qq.com/api/fav/addt',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'id'),
);
// 取消订阅话题	fav/delht
$cfg['fav_delht'] = array(
	'url' => 'https://open.t.qq.com/api/fav/delht',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'id'),
);
// 取消收藏一条微博	fav/delt
$cfg['fav_delt'] = array(
	'url' => 'https://open.t.qq.com/api/fav/delt',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'id'),
);
// 获取已订阅话题列表	fav/list_ht
$cfg['fav_list_ht'] = array(
	'url' => 'https://open.t.qq.com/api/fav/list_ht',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum|@5', 'pageflag|@0', 'pagetime|@0', 'lastid|@0'),
);
// 收藏的微博列表	fav/list_t
$cfg['fav_list_ht'] = array(
	'url' => 'https://open.t.qq.com/api/fav/list_ht',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum|@5', 'pageflag|@0', 'pagetime|@0', 'lastid|@0'),
);
//
// 发私信	private/add
$cfg['private_add'] = array(
	'url' => 'https://open.t.qq.com/api/private/add',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'content', 'clientip|getClientip', 'name', 'fopenid', 'contenttype|@1', 'pic'),
);
// 删除一条私信	private/del
$cfg['private_del'] = array(
	'url' => 'https://open.t.qq.com/api/private/del',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'id'),
);
// 获取私信首页会话列表	private/home_timeline
$cfg['fav_home_timeline'] = array(
	'url' => 'https://open.t.qq.com/api/private/home_timeline',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum|@10', 'pageflag|@0', 'pagetime|@0', 'lastid|@0', 'listtype|@0'),
);
// 收件箱	private/recv
$cfg['private_recv'] = array(
	'url' => 'https://open.t.qq.com/api/private/recv',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum|@10', 'pageflag|@0', 'pagetime|@0', 'lastid|@0', 'contenttype|@0'),
);
// 发件箱	private/send
$cfg['private_send'] = array(
	'url' => 'https://open.t.qq.com/api/private/send',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum|@10', 'pageflag|@0', 'pagetime|@0', 'lastid|@0', 'contenttype|@0'),
);
// 获取与某人的私信会话列表	private/user_timeline
$cfg['private_user_timeline'] = array(
	'url' => 'https://open.t.qq.com/api/private/user_timeline',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum|@10', 'pageflag|@0', 'pagetime|@0', 'lastid|@0', 'name', 'fopenid'),
);
//
// 删除最后更新位置	lbs/del_pos
$cfg['lbs_del_pos'] = array(
	'url' => 'https://open.t.qq.com/api/lbs/del_pos',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json'),
);
// 获取身边最新的微博	lbs/get_around_new
$cfg['get_around_new'] = array(
	'url' => 'https://open.t.qq.com/api/lbs/get_around_new',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'longitude', 'latitude', 'pageinfo', 'pagesize|@25'),
);
// 获取身边的人	lbs/get_around_people
$cfg['get_around_people'] = array(
	'url' => 'https://open.t.qq.com/api/lbs/get_around_people',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'longitude', 'latitude', 'pageinfo', 'pagesize|@25', 'gender'),
);
// 获取POI(Point of Interest)	lbs/get_poi
$cfg['get_poi'] = array(
	'url' => 'https://open.t.qq.com/api/lbs/get_poi',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'longitude', 'latitude', 'reqnum|@10', 'radius|@200', 'position|@0'),
);
// 更新地理位置	lbs/update_pos
$cfg['update_pos'] = array(
	'url' => 'https://open.t.qq.com/api/lbs/update_pos',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'longitude', 'latitude'),
);
//
// 短链接转换成长链接	short_url/expand
$cfg['short_url_expand'] = array(
	'url' => 'https://open.t.qq.com/api/short_url/expand',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'short_url'),
);
// 获取短链接在微博上的微博点击数	short_url/share_counts
$cfg['short_url_share_counts'] = array(
	'url' => 'https://open.t.qq.com/api/short_url/share_counts',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'short_url', 'type'),
);
// 长链接转换成短链接	short_url/shorten
$cfg['long_url_shorten'] = array(
	'url' => 'https://open.t.qq.com/api/short_url/shorten',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'long_url'),
);
//
// 根据话题名称查询话题id	ht/ids
$cfg['ht_ids'] = array(
	'url' => 'https://open.t.qq.com/api/ht/ids',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'httexts'),
);
// 根据话题id获取话题相关信息	ht/info
$cfg['ht_info'] = array(
	'url' => 'https://open.t.qq.com/api/ht/info',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'ids'),
);
// 最近使用过的话题	ht/recent_used
$cfg['ht_recent_used'] = array(
	'url' => 'https://open.t.qq.com/api/ht/recent_used',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum|@10', 'sorttype|@0', 'page|@1'),
);
// 是否关注某话题	ht/is_follow
$cfg['ht_is_follow'] = array(
	'url' => 'https://open.t.qq.com/api/ht/is_follow',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'htid', 'httext'),
);
//
// 推荐名人列表	trends/famouslist
$cfg['trends_famouslist'] = array(
	'url' => 'https://open.t.qq.com/api/trends/famouslist',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'classid', 'subclassid'),
);
// 话题热榜	trends/ht
$cfg['trends_ht'] = array(
	'url' => 'https://open.t.qq.com/api/trends/ht',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum|@20', 'pos|@0'),
);
// 转播热榜	trends/t
$cfg['trends_t'] = array(
	'url' => 'https://open.t.qq.com/api/trends/t',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'reqnum|@20', 'pos|@0', 'type|@0'),
);
//
// 添加标签	tag/add
$cfg['tag_add'] = array(
	'url' => 'https://open.t.qq.com/api/tag/add',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'tag'),
);
// 删除标签	tag/del
$cfg['tag_del'] = array(
	'url' => 'https://open.t.qq.com/api/tag/del',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'tagid'),
);
//
// 查看数据更新条数	info/update
$cfg['info_update'] = array(
	'url' => 'https://open.t.qq.com/api/info/update',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'op|@0', 'type'),
);
//
// 发送通知	notice/app_notice  /todo
$cfg['notice_app_notice'] = array(
	'url' => 'https://open.t.qq.com/api/notice/app_notice',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'appkey|getAppKey', 'clientip|getClientip', 'content', 'openid|getOpenid', 'nonce', 'timestamp', 'sig', 'method'),
);
//
// 创建投票	vote/createvote
$cfg['create_vote'] = array(
	'url' => 'https://open.t.qq.com/api/vote/createvote',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'title', 'desc', 'picurl', 'choicetype|@1', 'choicetexts', 'choicepics', 'limit|@1', 'status|@0', 'endtime')
);
// 参与投票	vote/vote
$cfg['vote'] = array(
	'url' => 'https://open.t.qq.com/api/vote/vote',
	'dataType' => 'json/xml',
	'method' => 'post',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'voteid', 'choiceindexs'),
);
// 获取投票统计信息	vote/get_statistics_info
$cfg['get_vote_statistics_info'] = array(
	'url' => 'https://open.t.qq.com/api/vote/get_statistics_info',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'voteid'),
);
// 获取投票信息	vote/get_vote_info
$cfg['get_vote_info'] = array(
	'url' => 'https://open.t.qq.com/api/vote/get_vote_info',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'voteid'),
);
// 获取参与投票的用户信息	vote/get_join_users
$cfg['get_vote_join_users'] = array(
	'url' => 'https://open.t.qq.com/api/vote/get_join_users',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'voteid', 'startindex|@0', 'reqnum|@10'),
);
// 指定用户投票参与信息	vote/check_user_joined
$cfg['check_vote_user_joined'] = array(
	'url' => 'https://open.t.qq.com/api/vote/check_user_joined',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'name', 'voteid', 'joinname'),
);
//
// 获取表情接口	other/get_emotions
$cfg['get_emotions'] = array(
	'url' => 'https://open.t.qq.com/api/other/get_emotions',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'type'),
);
// 一键转播热门排行	other/gettopreadd
$cfg['get_topreadd'] = array(
	'url' => 'https://open.t.qq.com/api/other/gettopreadd',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'type', 'reqnum', 'sourceid', 'country', 'province', 'city'),
);
// 拉取精华转播消息接口	other/quality_trans_conv
$cfg['quality_trans_conv'] = array(
	'url' => 'https://open.t.qq.com/api/other/quality_trans_conv',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'rootid', 'reqnum', 'offset'),
);
// 短url聚合	other/url_converge
$cfg['url_converge'] = array(
	'url' => 'https://open.t.qq.com/api/other/url_converge',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'url', 'reqnum', 'pageflag|@0', 'pageTime|@0', 'tweetid|@0', 'type|@0x01', 'word', 'flag|@0x01', 'detaillevel|@1', 'referer|@1'),
);
// 拉取vip用户的转播消息接口	other/vip_trans_conv
$cfg['vip_trans_conv'] = array(
	'url' => 'https://open.t.qq.com/api/other/vip_trans_conv',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'rootid', 'reqnum', 'pageflag|@0', 'pageTime|@0', 'tweetid|@0'),
);
// 拉取我收听的用户的转播消息接口	other/follower_trans_conv
$cfg['follower_trans_conv'] = array(
	'url' => 'https://open.t.qq.com/api/other/follower_trans_conv',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'rootid', 'reqnum', 'pageflag|@0', 'pageTime|@0', 'tweetid|@0'),
);
// 同话题热门转播排行	other/gettopiczbrank
$cfg['gettopiczbrank'] = array(
	'url' => 'https://open.t.qq.com/api/other/gettopiczbrank',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'checktype|@1', 'topictype|@0', 'topicid', 'topicname', 'reqnum|@10'),
);
// 我可能认识的人	other/kownperson
$cfg['kownperson'] = array(
	'url' => 'https://open.t.qq.com/api/other/kownperson',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'startindex|@0', 'reqnum|@30'),
);
// 通过标签搜索用户	search/userbytag
$cfg['search_userbytag'] = array(
	'url' => 'https://open.t.qq.com/api/search/userbytag',
	'dataType' => 'json/xml',
	'method' => 'get',
	'commonParam' => $commonParam,
	'requestParam' => array('format|@json', 'keyword', 'pagesize|@320', 'page|@1'),
);
return $cfg;