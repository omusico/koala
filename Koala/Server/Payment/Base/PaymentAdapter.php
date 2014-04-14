<?php
/**
 * UPM适配器虚基类
 */
abstract class Server_Payment_Base_PaymentAdapter{
	//设置适配器配置
	//配置必须：商户号,安全密匙,异步通知url,同步响应url
	abstract public function setConfig($config);
	//设置请求参数
	abstract public function setParameter(Closure $initParam);
	//设置日志目录
	abstract public function setLogDir($dir);
	//设置日志名
	abstract public function setLogName($file);
	//设置产品信息
	abstract public function setProductInfo($product);
	//设置购买人信息
	abstract public function setCustomerInfo($customer);
	//设置订单信息
	abstract public function setOrderInfo($order);
	//设置物流信息
	abstract public function setShippingInfo($shipping);
	//异步通知
	abstract public function notifyUrl(Closure $logic);
	//同步响应
	abstract public function returnUrl(Closure $logic);
}
?>