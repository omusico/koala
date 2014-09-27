<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * api列表
 *http://home.hylanda.com/show_5_19.html
 */
$cfg['segment'] = array(
	'url'=>'http://freeapi.hylanda.com/rest/se/segment/realtime',
	'method'=>'post',
	'requestParam'=>array(
		//http://home.hylanda.com/show_5_19.html
		'xmlparam|getXmlData',
		'appkey|getAppKey',
		'v|@1.0',
		'time',
		'format|@json',//xml
		)
	);
return $cfg;