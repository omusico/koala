<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * API地址
 * http://www.tuling123.com/openapi/cloud/api.jsp?section=7
 */
$cfg['tuling'] = array(
	'url'=>'http://www.tuling123.com/openapi/api',
	'method'=>'get',
	'header'=>array(
		'Content-Type|@text/html; charset=utf-8',
		),
	'requestParam'=>array(
		'key|getAppKey',
		'info',
		'userid',
		'loc',
		'lon',
		'lat'
		)
	);
return $cfg;