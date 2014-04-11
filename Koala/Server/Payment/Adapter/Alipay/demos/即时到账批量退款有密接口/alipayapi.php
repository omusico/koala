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
->setParameter(function($instance){
        return array(
        "partner" => trim($instance->config['partner']),
        "notify_url"    => "http://www.xxx.com/refund_fastpay_by_platform_pwd-PHP-UTF-8/notify_url.php",//服务器异步通知页面路径
        "seller_email"  => $_POST['WIDseller_email'],//卖家支付宝帐户
        "refund_date"   => $_POST['WIDrefund_date'],//退款当天日期//必填，格式：年[4位]-月[2位]-日[2位] 小时[2位 24小时制]:分[2位]:秒[2位]，如：2007-10-01 13:13:13
        "batch_no"      => $_POST['WIDbatch_no'],//批次号 //必填，格式：当天日期[8位]+序列号[3至24位]，如：201008010000001
        "batch_num"     => $_POST['WIDbatch_num'],//退款笔数//必填，参数detail_data的值中，“#”字符出现的数量加1，最大支持1000笔（即“#”字符出现的数量999个）
        "detail_data"   => $_POST['WIDdetail_data'], //退款详细数据
        "_input_charset"        => trim(strtolower($instance->config['input_charset']))
        );
});
//建立请求
$alipaySubmit = new AlipaySubmit($pay->config);
$html_text = $alipaySubmit->buildRequestForm($pay->param,"get", "确认");
echo $html_text;
