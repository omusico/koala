<?php
/**
 * method's value  is upper
 */
function getBaseString($method,$baseurl,$params=array()){
	ksort($params);reset($params);
	return $method.'&'.urlencode($baseurl).'&'.urlencode(http_build_query($params));
}
/**
 * method's value  is upper
 */
function sign($method,$baseurl,$params=array()){
	echo base64_encode(hash_hmac('sha1',getBaseString($method,$baseurl,$params),'GDdmIQH6jhtmLUypg82g&',true));
}