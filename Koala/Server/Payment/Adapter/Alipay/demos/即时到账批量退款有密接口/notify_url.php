<?php
$payment = new Server_Payment_Payment();
$pay = $payment->setAdapter("Alipay_Refund",array(
        'partner'=>'132313131',//合作身份者id，以2088开头的16位纯数字
        'key'=>'fafssf',//安全检验码，以数字和字母组成的32位字符
        'sign_type'=>strtoupper('MD5'),//签名方式 不需修改
        'input_charset'=>strtolower('utf-8'),//字符编码格式 目前支持 gbk 或 utf-8
        'cacert'=>getcwd().'\\cacert.pem',////ca证书路径地址，用于curl中ssl校验
        'transport'=>'http',//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        ))
->notifyUrl(function($instance){
	//计算得出通知验证结果
	$alipayNotify = new AlipayNotify($instance->config);
	$verify_result = $alipayNotify->verifyNotify();

	if($verify_result) {//验证成功
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//请在这里加上商户的业务逻辑程序代
		
		//——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
		
	    //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表
		
		//批次号

		$batch_no = $_POST['batch_no'];

		//批量退款数据中转账成功的笔数

		$success_num = $_POST['success_num'];

		//批量退款数据中的详细信息
		$result_details = $_POST['result_details'];


		//判断是否在商户网站中已经做过了这次通知返回的处理
			//如果没有做过处理，那么执行商户的业务程序
			//如果有做过处理，那么不执行商户的业务程序
	        
		echo "success";		//请不要修改或删除

		//调试用，写文本函数记录程序运行情况是否正常
		//logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");

		//——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
		
		/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	}
	else {
	    //验证失败
	    echo "fail";

	    //调试用，写文本函数记录程序运行情况是否正常
	    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
	}