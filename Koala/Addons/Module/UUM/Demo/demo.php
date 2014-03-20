<?php
//认证Demo

use UUM\IdentityFactory;
$IdentityFamily = IdentityFactory::createExtension('UUM\Extension\PassIdentity,UUM\Extension\IPIdentity');
$IdentityFamily->append($user);
//各个认证模块的状态
$status = $IdentityFamily->getStatus();

//根据状态信息以及认证策略判断
//根据具体业务处理

//比如 如果密码认证通过则为true
if($staus['UUM\Extension\PassIdentity']==true){
	echo 'ok';
}
//扩展需要自行实现

