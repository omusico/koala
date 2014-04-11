<?php
$payment = new Server_Payment_Payment();
$pay = $payment->setAdapter("99bill_Direct",array(
	//人民币网关账号，该账号为11位人民币网关商户编号+01,该参数必填。
	'merchantAcctId' => "1001213884201",
	//网关版本，固定值：v2.0,该参数必填。
	'version' =>  "v2.0",
	//语言种类，1代表中文显示，2代表英文显示。默认为1,该参数必填。
	'language' =>  "1",
	//签名类型,该值为4，代表PKI加密方式,该参数必填。
	'signType' =>  "4",
	//支付方式，一般为00，代表所有的支付方式。如果是银行直连商户，该值为10，必填。
	'payType' => "00",
	//银行代码，如果payType为00，该值可以为空；如果payType为10，该值必须填写，具体请参考银行列表。
	'bankId' => "",
	//商户订单号，以下采用时间来定义订单号，商户可以根据自己订单号的定义规则来定义该值，不能为空。
	'orderId' => date("YmdHis"),
	//订单提交时间，格式：yyyyMMddHHmmss，如：20071117020101，不能为空。
	'orderTime' => date("YmdHis"),
	//订单金额，金额以“分”为单位，商户测试以1分测试即可，切勿以大金额测试。该参数必填。
	'orderAmount' => "1",
	'dealId'=>'',
	'bankDealId'=>'',
	'dealTime'=>'',
	'payAmount'=>'',
	'fee'=>'',
	//扩展字段1，商户可以传递自己需要的参数，支付完快钱会原值返回，可以为空。
	'ext1' => "",
	//扩展自段2，商户可以传递自己需要的参数，支付完快钱会原值返回，可以为空。
	'ext2' => "",
	'payResult'=>'',
	'errCode'=>'',
	))
->notifyUrl(function($instance){
	//计算得出通知验证结果
	$Notify = new Notify($instance->config);
	$verify_result = $Notify->verifyNotify();
	if ($verify_result == 1) { 
		switch($_REQUEST[payResult]){
				case '10':
						//此处做商户逻辑处理
						$rtnOK=1;
						//以下是我们快钱设置的show页面，商户需要自己定义该页面。
						$rtnUrl="http://219.233.173.50:8802/futao/rmb_demo/show.php?msg=success";
						break;
				default:
						$rtnOK=1;
						//以下是我们快钱设置的show页面，商户需要自己定义该页面。
						$rtnUrl="http://219.233.173.50:8802/futao/rmb_demo/show.php?msg=false";
						break;	
		
		}

	}else{
						$rtnOK=1;
						//以下是我们快钱设置的show页面，商户需要自己定义该页面。
						$rtnUrl="http://219.233.173.50:8802/futao/rmb_demo/show.php?msg=error";
							
	}
}