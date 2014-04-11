<?php
require_once("lib/alipay_submit.class.php");
require_once("lib/alipay_notify.class.php");
/**
 * 支付宝双功能交易接口适配器
 */
class Server_Payment_Adapter_Alipay_Dualfun extends Server_Payment_Adapter_Alipay{
	//接口配置
	var $config = array();
	//请求参数
	var $param = array(
		//固定参数
		"service" => "trade_create_by_buyer",
		"payment_type"	=> "1",//支付类型
		);
}
?>