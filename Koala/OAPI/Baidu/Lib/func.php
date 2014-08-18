<?php

/**
 * method's value  is upper
 */
function sign($flag='MBOTIS',$method='GET',$bucket='',$object='/',$time='',$ip='0.0.0.0',$size=''){
	return $flag.':'.C('Baidu:AccessKey').':'.urlencode(base64_encode(hash_hmac('sha1', implode("\n",func_get_args()), C('Baidu:SecretKey'),true)));
}