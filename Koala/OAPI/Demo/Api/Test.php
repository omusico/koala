<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
//一般情况
$cfg['common'] = array(
	//API说明
	'summary' => 'API说明',
	//请求URL
	'url'=>'http://m.weather.com.cn/data',
	//请求方法
	'method'=>'get',
	//请求参数
	'request_params'=>array(
		//位于URI
		'uri'=>array('p','p1|@v1','p2|getV'),
		//位于Header
		'header'=>array('h|getH','cookie|getCookie'),
		//位于Body
		'body'=>array('id|getId','id|getId')
		),
	//公共参数
	'public_params'=>array(
		//位于URI
		'uri'=>array('v|@1.1'),
		//位于Header
		'header'=>array('w|getW'),
		//位于Body
		'body'=>array('time|getTime')
		),
	//返回数据类型
	'data_type'=>'JSON',
	//Body类型
	'body_type'=>'JSON',
	//cookie
	'cookie'=>array('ssid'=>'ssssss')
	);
return $cfg;