<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 云通讯开放平台api列表
 * TODO  XML支持未实现
 * http://docs.yuntongxun.com/index.php/%E9%A6%96%E9%A1%B5
 */
$SoftVersion = '2013-12-26';
$header      = array(
	'Accept|@application/json', //application/xml
	'Content-Type|getContentType',
	//'Content-Length',
	'Authorization|getAuthorization',
);
$cfg['api_base'] = array(
	'url'       => 'https://sandboxapp.cloopen.com:8883/' . $SoftVersion,
	'urltpl'    => '/Accounts/{accountSid}/{func}/{funcdes}?sig={sig}',
	'suburltpl' => '/SubAccounts/{subAccountSid}/{func}/{funcdes}?sig={sig}',
);
/**
 * 主帐号信息查询
 */
$cfg['get_account_info'] = array(
	'method'       => 'get',
	'header'       => $header,
	'requestParam' => array('accountSid|getAccountSid', 'func|@AccountInfo', 'funcdes', 'sig|getSign', 'content|getContent', 'Content-Length|getLengthStr'),
);
/**
 * 创建子帐号
 * @param friendlyName 子帐号名称
 */
$cfg['create_sub_account'] = array(
	'method'       => 'post',
	'header'       => $header,
	'contentParam' => array('appId|getAppKey', 'friendlyName'),
	'requestParam' => array('accountSid|getAccountSid', 'func|@SubAccounts', 'funcdes', 'sig|getSign', 'content|getContent', 'Content-Length|getLengthStr'),
);
/**
 * 获取子帐号
 * @param startNo 开始的序号，默认从0开始
 * @param offset 一次查询的最大条数，最小是1条，最大是100条
 */
$cfg['get_sub_account'] = array(
	'method'       => 'post',
	'header'       => $header,
	'contentParam' => array('appId|getAppKey', 'startNo|@0', 'offset|@100'),
	'requestParam' => array('accountSid|getAccountSid', 'func|@GetSubAccounts', 'funcdes', 'sig|getSign', 'content|getContent', 'Content-Length|getLengthStr'),
);
/**
 * 子帐号信息查询
 * @param friendlyName 子帐号名称
 */
$cfg['get_sub_account_info'] = array(
	'method'       => 'post',
	'header'       => $header,
	'contentParam' => array('appId|getAppKey', 'friendlyName'),
	'requestParam' => array('accountSid|getAccountSid', 'func|@QuerySubAccountByName', 'funcdes', 'sig|getSign', 'content|getContent', 'Content-Length|getLengthStr'),
);
/**
 * 发送短信
 * @param to 短信接收彿手机号码集合,用英文逗号分开
 * @param body 短信正文
 */
$cfg['send_sms'] = array(
	'method'       => 'post',
	'header'       => $header,
	'contentParam' => array('to', 'body', 'appId|getAppKey'),
	'requestParam' => array('accountSid|getAccountSid', 'func|@SMS', 'funcdes|@Messages', 'sig|getSign', 'content|getContent', 'Content-Length|getLengthStr'),
);
/**
 * 发送模板短信
 * @param to 短信接收彿手机号码集合,用英文逗号分开
 * @param datas 内容数据
 * @param $templateId 模板Id
 */
//http://docs.yuntongxun.com/index.php/模板短信
$cfg['template_sms'] = array(
	'method'       => 'post',
	'header'       => $header,
	'contentParam' => array('to', 'appId|getAppKey', 'templateId', 'datas'),
	'requestParam' => array('accountSid|getAccountSid', 'func|@SMS', 'funcdes|@TemplateSMS', 'sig|getSign', 'content|getContent', 'Content-Length|getLengthStr'),
);
/**
 * 双向回呼
 * @param from 主叫电话号码
 * @param to 被叫电话号码
 * @param customerSerNum 被叫侧显示的客服号码
 * @param fromSerNum 主叫侧显示的号码
 * @param promptTone 第三方自定义回拨提示音
 */
$cfg['callback'] = array(
	'method'       => 'post',
	'header'       => $header,
	'sub'          => true,
	'contentParam' => array('from', 'to', 'customerSerNum', 'fromSerNum', 'promptTone'),
	'requestParam' => array('accountSid|getAccountSid', 'func|@Calls', 'funcdes|@Callback', 'sig|getSign', 'content|getContent', 'Content-Length|getLengthStr'),
);
/**
 * 营销外呼
 * @param to 被叫号码
 * @param mediaName 语音文件名称，格式 wav。与mediaTxt不能同时为空。当不为空时mediaTxt属性失效。
 * @param mediaTxt 文本内容
 * @param displayNum 显示的主叫号码
 * @param playTimes 循环播放次数，1－3次，默认播放1次。
 * @param respUrl 营销外呼状态通知回调地址，云通讯平台将向该Url地址发送呼叫结果通知。
 */
$cfg['landing_call'] = array(
	'method'       => 'post',
	'header'       => $header,
	'contentParam' => array('playTimes', 'mediaTxt', 'mediaName', 'to', 'appId|getAppKey', 'displayNum', 'respUrl'),
	'requestParam' => array('accountSid|getAccountSid', 'func|@Calls', 'funcdes|@LandingCalls', 'sig|getSign', 'content|getContent', 'Content-Length|getLengthStr'),
);
/**
 * 语音验证码
 * @param verifyCode 验证码内容，为数字和英文字母，不区分大小写，长度4-8位
 * @param playTimes 播放次数，1－3次
 * @param to 接收号码
 * @param displayNum 显示的主叫号码
 * @param respUrl 语音验证码状态通知回调地址，云通讯平台将向该Url地址发送呼叫结果通知
 */
$cfg['voice_verify'] = array(
	'method'       => 'post',
	'header'       => $header,
	'contentParam' => array('verifyCode', 'playTimes', 'to', 'appId|getAppKey', 'displayNum', 'respUrl'),
	'requestParam' => array('accountSid|getAccountSid', 'func|@Calls', 'funcdes|@VoiceVerify', 'sig|getSign', 'content|getContent', 'Content-Length|getLengthStr'),
);
/**
 * IVR外呼
 * //Dial
 * " <Request>
 * <Appid>$this->AppId</Appid>
 * <Dial number='$number'  userdata='$userdata' record='$record'></Dial>
 * </Request>";
 * @param number   待呼叫号码，为Dial节点的属性
 * @param userdata 用户数据，在<startservice>通知中返回，只允许填写数字字符，为Dial节点的属性
 * @param record   是否录音，可填项为true和false，默认值为false不录音，为Dial节点的属性
 */
$cfg['ivrdial'] = array(
	'method'       => 'post',
	'header'       => $header,
	'format'       => 'xml',
	'contentParam' => array('AppId|getAppKey', 'Dial'),
	'requestParam' => array('accountSid|getAccountSid', 'func|@ivr', 'funcdes|@dial', 'sig|getSign', 'content|getContent', 'Content-Length|getLengthStr'),
);
/**
 * 话单下载
 * @param date     day 代表前一天的数据（从00:00 – 23:59）;week代表前一周的数据(周一 到周日)；month表示上一个月的数据（上个月表示当前月减1，如果今天是4月10号，则查询结果是3月份的数据）
 * @param keywords   客户的查询条件，由客户自行定义并提供给云通讯平台。默认不填忽略此参数
 */
$cfg['bill_records'] = array(
	'method'       => 'post',
	'header'       => $header,
	'contentParam' => array('appId|getAppKey', 'date', 'keywords'),
	'requestParam' => array('accountSid|getAccountSid', 'func|@BillRecords', 'funcdes', 'sig|getSign', 'content|getContent', 'Content-Length|getLengthStr'),
);
return $cfg;