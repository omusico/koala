<?php
require_once("core.function.php");
class Submit {

	var $config;
	/**
	 *网关地址（新）
	 */
	var $gateway_new = 'https://sandbox.99bill.com/gateway/recvMerchantInfoAction.htm';

	function __construct($config){
		$this->config = $config;
	}
    function Submit($config) {
    	$this->__construct($config);
    }
    /**
	 * 生成签名结果
	 * @param $para 要签名的数组
	 * return 签名结果字符串
	 */
	function buildRequestMysign($para) {
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = createLinkstring($para);
		
		$mysign = "";
		/////////////  RSA 签名计算 ///////// 开始 //
		$fp = fopen(dirname(__file__)."/pcarduser.pem", "r");
		$priv_key = fread($fp, 123456);
		fclose($fp);
		$pkeyid = openssl_get_privatekey($priv_key);
		// compute signature
		openssl_sign($prestr, $signMsg, $pkeyid,OPENSSL_ALGO_SHA1);
		// free the key from memory
		openssl_free_key($pkeyid);

	 	$signMsg = base64_encode($signMsg);
		
		return $signMsg;
	}

    /**
     * 生成要请求的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
	function buildRequestPara($para_temp) {
		//除去待签名参数数组中的空值
		$para = paraFilter($para_temp);
		//生成签名结果
		$mysign = $this->buildRequestMysign($para);
		//--------这里保留了空值参数--------
		//签名结果与签名方式加入请求提交参数组中
		$para_temp['signMsg'] = $mysign;
		return $para_temp;
	}
    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本
     */
	function buildRequestForm($para_temp, $method, $button_name) {
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp);
		
		$sHtml = "<form name='kqPay' id='kqPay' action='".$this->gateway_new."' method='".$method."'>";
		while (list ($key, $val) = each ($para)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

		//submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' name='submit' value='".$button_name."'></form>";
		
		$sHtml = $sHtml."<script>document.forms['kqPay'].submit();</script>";
		
		return $sHtml;
	}
}
?>