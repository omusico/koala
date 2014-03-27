<?php
require_once("lib/alipay_submit.class.php");
require_once("lib/alipay_notify.class.php");
/**
 * 支付宝即时到账批量退款有密接口适配器
 */
class Server_Payment_Adapter_Alipay_Refund extends Server_Payment_Adapter_Alipay{
	//接口配置
	var $config = array();
	//请求参数
	var $param = array(
		//固定参数
		"service" => "refund_fastpay_by_platform_pwd",
		);
}
?>