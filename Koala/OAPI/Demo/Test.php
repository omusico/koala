<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Demo;
use Core\Request\BaseV2 as RequestBase;

/**
 */
class Test extends RequestBase {
	function _getCookie($name){
		if(is_array($this->api_params[$this->api_name]['cookie'])){
			$cookies = array();
			foreach ($this->api_params[$this->api_name]['cookie'] as $key => $value) {
				$cookies[] = $key.'='.$value;
			}
			return $cookies;
		}else{
			return explode(';', $this->api_params[$this->api_name]['cookie']);
		}
	}

}