<?php
$payment = new Server_Payment_Payment();
$pay = $payment->setAdapter("Alipay_Direct",array(
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
        "notify_url"    => "http://www.xxx.com/notify_url.php",
        "return_url"    => "http://www.xxx.com/return_url.php",
        "seller_email"  => $_POST['WIDseller_email'],
        "out_trade_no"  => $_POST['WIDout_trade_no'],
        "subject"       => $_POST['WIDsubject'],
        "total_fee"     => $_POST['WIDtotal_fee'],
        "body"  => $_POST['WIDbody'],
        "show_url"      => $_POST['WIDshow_url'],
        "anti_phishing_key"     => "",
        "exter_invoke_ip"       =>  "",
        "_input_charset"        => trim(strtolower($instance->config['input_charset']))
        );
});
//建立请求
$alipaySubmit = new AlipaySubmit($pay->config);
$html_text = $alipaySubmit->buildRequestForm($pay->param,"get", "确认");
echo $html_text;