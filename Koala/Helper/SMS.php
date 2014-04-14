<?php
//短信发送助手
//see http://www.smschinese.cn/api.shtml
class Helper_SMS{
	static $option = array();
	public static function factory($option){
		self::$option = $option;
		return new static();
	}
	public function send($smsMob='',$smsText=''){
		extract(self::$option);
		if(empty($smsMob)||empty($smsText)){
			return false;
		}
		$url="http://utf8.sms.webchinese.cn/?Uid=$uid&Key=$key&smsMob=$smsMob&smsText=$smsText";
    	if(function_exists('file_get_contents')){
        	$file_contents = file_get_contents(urlencode($url));
    	}else{
	        $ch = curl_init();
	        $timeout = 5;
	        curl_setopt ($ch, CURLOPT_URL, $url);
	        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	        $file_contents = curl_exec($ch);
	        curl_close($ch);
    	}
    	sleep(1);
    	return $file_contents;
	}
}