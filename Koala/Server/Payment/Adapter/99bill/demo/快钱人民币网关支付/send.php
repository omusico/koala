<?php
$payment = new Server_Payment_Payment();
$pay = $payment->setAdapter("99bill_Direct",array(
	//人民币网关账号，该账号为11位人民币网关商户编号+01,该参数必填。
	'merchantAcctId' => "1001213884201",
	//编码方式，1代表 UTF-8; 2 代表 GBK; 3代表 GB2312 默认为1,该参数必填。
	'inputCharset' => "1",
	//接收支付结果的页面地址，该参数一般置为空即可。
	'pageUrl' => "",
	//服务器接收支付结果的后台地址，该参数务必填写，不能为空。
	'bgUrl' => "http://219.233.173.50:8802/futao/rmb_demo/recieve.php",
	//网关版本，固定值：v2.0,该参数必填。
	'version' =>  "v2.0",
	//语言种类，1代表中文显示，2代表英文显示。默认为1,该参数必填。
	'language' =>  "1",
	//签名类型,该值为4，代表PKI加密方式,该参数必填。
	'signType' =>  "4",
	//支付人姓名,可以为空。
	'payerName' => "", 
	//支付人联系类型，1 代表电子邮件方式；2 代表手机联系方式。可以为空。
	'payerContactType' =>  "1",
	))
->setParameter(function($instance){
        return array(
        	'inputCharset'=>$instance->config['inputCharset'],
        	'pageUrl'=>$instance->config['pageUrl'],
        	'version'=>$instance->config['version'],
        	'language'=>$instance->config['language'],
        	'signType'=>$instance->config['signType'],
        	'signMsg'=>$instance->config['signMsg'],
        	'merchantAcctId'=>$instance->config['merchantAcctId'],
        	'payerName'=>$instance->config['payerName'],
        	'payerContactType'=>$instance->config['payerContactType'],
        	//支付人联系方式，与payerContactType设置对应，payerContactType为1，则填写邮箱地址；payerContactType为2，则填写手机号码。可以为空。
			'payerContact' =>  "2532987@qq.com",
			//商户订单号，以下采用时间来定义订单号，商户可以根据自己订单号的定义规则来定义该值，不能为空。
			'orderId' => date("YmdHis"),
			//订单金额，金额以“分”为单位，商户测试以1分测试即可，切勿以大金额测试。该参数必填。
			'orderAmount' => "1",
			//订单提交时间，格式：yyyyMMddHHmmss，如：20071117020101，不能为空。
			'orderTime' => date("YmdHis"),
			//商品名称，可以为空。
			'productName'=> "苹果", 
			//商品数量，可以为空。
			'productNum' => "5",
			//商品代码，可以为空。
			'productId' => "55558888",
			//商品描述，可以为空。
			'productDesc' => "",
			//扩展字段1，商户可以传递自己需要的参数，支付完快钱会原值返回，可以为空。
			'ext1' => "",
			//扩展自段2，商户可以传递自己需要的参数，支付完快钱会原值返回，可以为空。
			'ext2' => "",
			//支付方式，一般为00，代表所有的支付方式。如果是银行直连商户，该值为10，必填。
			'payType' => "00",
			//银行代码，如果payType为00，该值可以为空；如果payType为10，该值必须填写，具体请参考银行列表。
			'bankId' => "",
			//同一订单禁止重复提交标志，实物购物车填1，虚拟产品用0。1代表只能提交一次，0代表在支付不成功情况下可以再提交。可为空。
			'redoFlag' => "",
			//快钱合作伙伴的帐户号，即商户编号，可为空。
			'pid' => "",
        	);
});
//建立请求
$Submit = new Submit($pay->config);
$html_text = $Submit->buildRequestForm($pay->param,"post", "确认");
echo $html_text;