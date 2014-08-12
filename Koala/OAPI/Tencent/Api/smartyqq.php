<?php
//for w.qq.com
//
//登录前检查
//ptui_checkVC('0','!HCP','\x00\x00\x00\x00\x2d\x40\x03\x80', 'aeb108a669d8079bd218d84b9368d8c5510d9145084690b22f549e6ddc8bd510df25916241be24d37ec72a769263d16c');
//ptui_checkVC('1','9Oi1C8ltY-MK4wmqjbonib_ynKTHjWUo','\x00\x00\x00\x00\x14\x7e\xe7\x64', '');

//for  http://w.qq.com/
//response  ptvfsession/verifysession onfirmuin ptisp=ctc
//登录前检测
$cfg['check_before_login'] = array(
	'url'=>'https://ssl.ptlogin2.qq.com/check',
	'method'=>'get',
	'requestParam'=>array(
		'uin|getUin',
		'appid|@501004106',
		'js_ver|@10088',
		'js_type|@0',
		'login_sig|getLoginSig',
		'u1|@http://w.qq.com/proxy.html',
		'r|getRandnum'
		),
	//'cookie'=>array('chkuin|getUin')
	);
//获取登陆验证码
$cfg['get_login_verifycode'] = array(
	'url'=>'https://ssl.captcha.qq.com/getimage',
	'method'=>'get',
	'requestParam'=>array(
		'uin|getUin',
		'aid|@501004106',
		'r|getRandnum'
		),/*
	'cookie'=>array(
		'pgv_info|@ssid=s306391428',
		'pgv_pvid|@7716084296')*/
	);
//一次登陆
$cfg['login_first'] = array(
	'url'=>'https://ssl.ptlogin2.qq.com/login',
	'method'=>'get',
	'requestParam'=>array(
		'u|getUin',
		'verifycode|getVerifycode',
		'p|getEncodePass',
		'webqq_type|@10',
		'remember_uin|@1',
		'login2qq|@1',
		'aid|@501004106',
		'u1|@http://w.qq.com/proxy.html?login2qq=1&webqq_type=10',
		'h|@1',
		'ptredirect|@0',
		'ptlang|@2052',
		'daid|@164',
		'from_ui|@1',
		'pttype|@1',
		'dumy',
		'fp|@loginerroralert',
		'action|@0-24-875627',
		'mibao_css|@m_webqq',
		't|@1',
		'g|@1',
		'js_type|@0',
		'js_ver|@10088',
		'login_sig'
		),/*
	'cookie'=>array(
		'chkuin|getUin',
		'confirmuin|getUin',
		'ptisp|@ctc',
		'verifysession|getCookie',
		'ptvfsession|getCookie',
		)*/
	);
//check_sig
$cfg['check_sig'] = array(
	'url'=>'',
	'method'=>'get',
	'requestParam'=>array(),
	'cookie'=>array()
	);
//二次登陆
$cfg['login_second'] = array(
	'url'=>'http://d.web2.qq.com/channel/login2',
	'method'=>'post',
	'form-urlencode'=>true,
	'header'=>array(
		'Host|@d.web2.qq.com',
		'Origin|@http://d.web2.qq.com',
		'Content-Type|@application/x-www-form-urlencoded',
		'Referer|@http://d.web2.qq.com/proxy.html?v=20110331002&callback=1&id=3',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'r|makeFrom'
		),
	'r'=>array(
		'ptwebqq|getCookie',
		'clientid|getRandnum',
		'psessionid',
		'status|@online'
		)
	);
//js_version 
$cfg['get_js_version'] = array(
	'url'=>'https://ui.ptlogin2.qq.com/ptui_ver.js',
	'method'=>'get',
	'requestParam'=>array('v|getRandnum'),
	);
/**
 * 获取用户好友
 */
$cfg['get_user_friends2'] = array(
	'url'=>'http://s.web2.qq.com/api/get_user_friends2',
	'method'=>'post',
	'form-urlencode'=>true,
	'header'=>array(
		'Host|@s.web2.qq.com',
		'Origin|@http://s.web2.qq.com',
		'Content-Type|@application/x-www-form-urlencoded',
		'Referer|@http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'r|makeFrom'
		),
	'r'=>array(
		'vfwebqq|getData',
		'hash|getHash'
		)
	);
/**
 * 获取用户群组
 */
$cfg['get_group_name_list_mask2'] = array(
	'url'=>'http://s.web2.qq.com/api/get_group_name_list_mask2',
	'method'=>'post',
	'form-urlencode'=>true,
	'header'=>array(
		'Host|@s.web2.qq.com',
		'Origin|@http://s.web2.qq.com',
		'Content-Type|@application/x-www-form-urlencoded',
		'Referer|@http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'r|makeFrom'
		),
	'r'=>array(
		'vfwebqq|getData',
		'hash|getHash'
		)
	);
/**
 * 获取讨论列表
 */
$cfg['get_discus_list'] = array(
	'url'=>'http://s.web2.qq.com/api/get_discus_list',
	'method'=>'get',
	'header'=>array(
		'Host|@s.web2.qq.com',
		'Origin|@http://s.web2.qq.com',
		'Referer|@http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'clientid|getRandnum',
		'psessionid|getData',
		'vfwebqq|getData',
		't|getRandnum',
		)
	);
/**
 * 获取用户信息
 */
$cfg['get_self_info2'] = array(
	'url'=>'http://s.web2.qq.com/api/get_self_info2',
	'method'=>'get',
	'header'=>array(
		'Host|@s.web2.qq.com',
		'Origin|@http://s.web2.qq.com',
		'Referer|@http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		't|getRandnum',
		)
	);
/**
 * 获取用户头像
 * image/webp
 */
$cfg['get_face'] = array(
	'url'=>'http://face0.web.qq.com/cgi/svr/face/getface',
	'method'=>'get',
	'header'=>array(
		'Origin|@http://s.web2.qq.com',
		'Referer|@http://w.qq.com',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'cache|@1',
		'type|@1',
		'f|@40',
		'uin|getUin',
		't|getRandnum',
		'vfwebqq|getData',
		)
	);
/**
 * 设置在线状态
 */
$cfg['change_status2'] = array(
	'url'=>'http://d.web2.qq.com/channel/change_status2',
	'method'=>'get',
	'header'=>array(
		'Host|@d.web2.qq.com',
		'Referer|@http://d.web2.qq.com/proxy.html?v=20130916001&callback=1&id=2',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'newstatus|getNewStatus',
		'clientid|getRandnum',
		'psessionid|getData',
		'vfwebqq|getData',
		't|getRandnum',
		)
	);
/**
 * 获取在线状态
 */
$cfg['get_online_buddies2'] = array(
	'url'=>'http://d.web2.qq.com/channel/get_online_buddies2',
	'method'=>'get',
	'header'=>array(
		'Host|@d.web2.qq.com',
		'Referer|@http://d.web2.qq.com/proxy.html?v=20130916001&callback=1&id=2',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'newstatus|getNewStatus',//该值在改变状态后，查询状态需要.
		'clientid|getRandnum',
		'psessionid|getData',
		'vfwebqq|getData',
		't|getRandnum',
		)
	);
/**
 * 获取会话列表
 */
$cfg['get_recent_list2'] = array(
	'url'=>'http://d.web2.qq.com/channel/get_recent_list2',
	'method'=>'post',
	'form-urlencode'=>true,
	'header'=>array(
		'Host|@d.web2.qq.com',
		'Origin|@http://d.web2.qq.com',
		'Content-Type|@application/x-www-form-urlencoded',
		'Referer|@http://d.web2.qq.com/proxy.html?v=20130916001&callback=1&id=2',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'r|makeFrom'
		),
	'r'=>array(
		'clientid|getRandnum',
		'psessionid|getData',
		'vfwebqq|getData',
		)
	);
/**
 * 轮寻
 */
$cfg['poll2'] = array(
	'url'=>'http://d.web2.qq.com/channel/poll2',
	'method'=>'post',
	'form-urlencode'=>true,
	'header'=>array(
		'Host|@d.web2.qq.com',
		'Origin|@http://d.web2.qq.com',
		'Content-Type|@application/x-www-form-urlencoded',
		'Referer|@http://d.web2.qq.com/proxy.html?v=20130916001&callback=1&id=2',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'r|makeFrom'
		),
	'r'=>array(
		'clientid|getRandnum',
		'psessionid|getData',
		'vfwebqq|getData',
		'key'
		)
	);
/**
 * 获取群信息
 */
$cfg['get_group_info_ext2'] = array(
	'url'=>'http://s.web2.qq.com/api/get_group_info_ext',
	'method'=>'get',
	'header'=>array(
		'Host|@s.web2.qq.com',
		'Origin|@http://s.web2.qq.com',
		'Referer|@http://d.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'gcode|getgcode',
		'vfwebqq|getData',
		't|getRandnum',
		)
	);
/**
 * 获取好友信息
 */
$cfg['get_friend_info2'] = array(
	'url'=>'http://s.web2.qq.com/api/get_friend_info2',
	'method'=>'get',
	'header'=>array(
		'Host|@s.web2.qq.com',
		'Referer|@http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'tuin|gettuin',
		'vfwebqq|getData',
		'clientid|getRandnum',
		'psessionid|getData',
		'vfwebqq|getData',
		)
	);
/**
 * 发送对话信息
 */
$cfg['send_buddy_msg2'] = array(
	'url'=>'http://d.web2.qq.com/api/send_buddy_msg2',
	'method'=>'post',
	'form-urlencode'=>true,
	'header'=>array(
		'Host|@d.web2.qq.com',
		'Origin|@http://d.web2.qq.com',
		'Content-Type|@application/x-www-form-urlencoded',
		'Referer|@http://d.web2.qq.com/proxy.html?v=20130916001&callback=1&id=2',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'r|makeFrom'
		),
	'r'=>array(
		'to|getToUin',
		'content|getmsg',
		'face',
		'msg_id',
		'clientid|getRandnum',
		'psessionid|getData'
		)
	);
/**
 * 获取好友对话历史
 */
$cfg['webqq_chat_history'] = array(
	'url'=>'http://web2.qq.com/cgi-bin/webqq_chat/',
	'method'=>'get',
	'header'=>array(
		'Host|@web2.qq.com',
		'Referer|@http://w.qq.com/',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'tuin|getToUin',
		'cmd|@1',
		'vfwebqq|getData',
		'page|@0',
		'row|@10',
		'callback|@mq.model.record.getRecordSuccess'
		)
	);
/**
 * 获取好友uin
 */
$cfg['get_friend_uin2'] = array(
	'url'=>'http://s.web2.qq.com/api/get_friend_uin2',
	'method'=>'get',
	'header'=>array(
		'Host|@s.web2.qq.com',
		'Referer|@http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'tuin|getToUin',
		'type|@1',
		'vfwebqq|getData',
		't|getRandnum',
		)
	);
/**
 * 获取个性签名
 */
$cfg['get_single_long_nick2'] = array(
	'url'=>'http://s.web2.qq.com/api/get_single_long_nick2',
	'method'=>'get',
	'header'=>array(
		'Host|@s.web2.qq.com',
		'Referer|@http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'tuin|getToUin',
		'vfwebqq|getData',
		't|getRandnum',
		)
	);
/**
 * 获取getvfwebqq值
 */
$cfg['getvfwebqq'] = array(
	'url'=>'http://s.web2.qq.com/api/getvfwebqq',
	'method'=>'get',
	'header'=>array(
		'Host|@s.web2.qq.com',
		'Referer|@http://s.web2.qq.com/proxy.html?v=20130916001&callback=1&id=1',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'ptwebqq|getCookie',
		'clientid|getRandnum',
		'psessionid',
		't|getRandnum',
		)
	);

//for http://user.qzone.qq.com/
$cfg['get_qqzone_userinfo'] = array(
	'url'=>'http://user.qzone.qq.com/p/base.s8/cgi-bin/user/cgi_userinfo_get_all',
	'method'=>'get',
	'header'=>array(
		'Host|@user.qzone.qq.com',
		'Referer|@http://user.qzone.qq.com/759169920/profile/qzbase',
		'User-Agent|@Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/36.0.1985.125 Chrome/36.0.1985.125'
		),
	'requestParam'=>array(
		'uin|getUin',
		'vuin|getUin',
		'fupdate|@1',
		'rd|getRandnum',
		'g_tk|getRandnum'
		)
	);
return $cfg;