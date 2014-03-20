<?php
class UUM_UserIdentity{
	public function before(){
		 $user = (object) $_POST;
        $IdentityFamily = \UUM\IdentityFactory::createExtension('UUM\Extension\PassIdentity');
        $IdentityFamily->append($user);
        //各个认证模块的状态
        $status = $IdentityFamily->getStatus();
        //比如 如果密码认证通过则为true
        if($status['UUM\Extension\PassIdentity']['code']){
            echo 'ok';
        }else{
            echo 'no';
        }
	}
}
?>