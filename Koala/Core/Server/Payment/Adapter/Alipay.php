<?php
/**
 * 支付宝交易接口
 */
class Server_Payment_Adapter_Alipay extends Server_Payment_Base_PaymentAdapter{
	//接口配置
	var $config = array();
	//请求参数
	var $param = array();
	//设置适配器配置
	public function setConfig($config){
		if(is_array($config)){
			$this->config = $config;
		}
		return $this;
	}
	//设置请求参数
	public function setParameter(Closure $initParam){
        $param = $initParam($this);
        if(is_array($param)){
			$this->param = array_merge($this->param,$param);
		}
		return $this;
    }
	//设置日志目录
	public function setLogDir($dir){}
	//设置日志名
	public function setLogName($file){}
	//设置产品信息
	public function setProductInfo($product){}
	//设置购买人信息
	public function setCustomerInfo($customer){}
	//设置订单信息
	public function setOrderInfo($order){}
	//设置物流信息
	public function setShippingInfo($shipping){}
	//异步通知
	public function notifyUrl(Closure $logic){
		$logic($this);
	}
	//同步响应
	public function returnUrl(Closure $logic){
		$logic($this);
	}
}
?>