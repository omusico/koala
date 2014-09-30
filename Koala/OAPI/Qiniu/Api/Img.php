<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

/**
 */
$cfg['small_upload'] = array(
	'url'         => 'http://upload.qiniu.com/',
	'method'      => 'post',
	'commonParam' => array('token|getAccessToken'),
	'requestParam' => array('key', 'file'),
	//http://developer.qiniu.com/docs/v6/api/reference/security/put-policy.html
	'putPolicy' => array(
		'scope',
		'deadline',
		'insertOnly',
		'saveKey',
		'endUser',
		'returnUrl',
		'returnBody',
		'callbackUrl',
		'callbackHost',
		'callbackBody',
		'persistentOps',
		'persistentNotifyUrl',
		'persistentPipeline',
		'fsizeLimit',
		'detectMime',
		'mimeLimit',
	)
);
return $cfg;