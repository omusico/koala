<?php
require_once("lib/alipay_submit.class.php");
require_once("lib/alipay_notify.class.php");
/**
 * 支付宝纯担保交易接口适配器
 */
class Server_Payment_Adapter_Alipay_DirectBankpay extends Server_Payment_Adapter_Alipay{
	//接口配置
	var $config = array();
	//请求参数
	var $param = array(
		//固定参数
		"service" => "create_direct_pay_by_user",
		"payment_type"	=> "1",//支付类型
		);
}
?>