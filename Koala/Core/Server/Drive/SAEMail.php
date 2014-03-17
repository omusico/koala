<?php
defined('IN_Koala') or exit();
/**
 * SAE环境下的Mail驱动
 */
final class Drive_SAEMail extends Base_Mail{
	//云服务对象
    var $object = '';
	public function __construct(){
		$this->object = new SaeMail();
	}

}
?>