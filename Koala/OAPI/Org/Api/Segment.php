<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * api列表
 *
 *http://www.vapsec.com/fenci/
 */
$cfg['segment'] = array(
	'url' => 'http://open.vapsec.com/segment/get_word',
	'method' => 'post',
	'requestParam' => array(
		'word', //最多100个字
		'token|getAccessToken',
		'format|@string'//xml,json,string
	)
);
return $cfg;