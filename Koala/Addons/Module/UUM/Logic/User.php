<?php
/**
 * UUM之用户管理
 */
class UUM_Logic_User extends Base_Logic{
    public static function setTable($table){
        if(is_string($table))
            UUM_Model_User::$table_name = $table;
    }
    //用户登录
    public static function Login($username,$password){
    	$obj = UUM_Model_User::find(
    		array("username"=>$username)
    		);
    	if($obj->password == self::encrypt($password,$obj->encrysalt)){
            return array('code'=>1,'msg'=>'用户成功登陆','ext'=>array('user'=>$obj));
        }
    	return array('code'=>0,'msg'=>'用户登陆失败');
    }
    //用户密码修改
    public static function changeLoginPassword($password){
        if(isset($_SESSION[GROUP_NAME]['user'])){
            $oldobj = (Object)$_SESSION[GROUP_NAME]['user'];
            $obj = UUM_Model_User::find(
                array("username"=>$oldobj->username)
            );
            $obj->password = self::encrypt($password,$obj->encrysalt);
            if($obj->save()){
                return array('code'=>1,'msg'=>'登陆密码修改成功');
            }
        }
        return array('code'=>0,'msg'=>'登陆密码修改失败');
    }
    //设置支付密码
    public static function setPayPassword($password){
        if(isset($_SESSION[GROUP_NAME]['user'])){
            $oldobj =(Object)$_SESSION[GROUP_NAME]['user'];
            //在没有设置支付密码情况下
            if(!isset($oldobj->paypass)){
                $obj = UUM_Model_User::find(
                    array("username"=>$oldobj->username)
                );
                $obj->paypass = self::encrypt($paypass,$obj->encrysalt);
                if($obj->save()){
                    return array('code'=>1,'msg'=>'支付密码设置成功');
                }
            }
        }
        return array('code'=>0,'msg'=>'支付密码设置失败');
    }
    //支付密码修改
    public static function changePayPassword($paypass){
        if(isset($_SESSION[GROUP_NAME]['user'])){
            $oldobj = (Object)$_SESSION[GROUP_NAME]['user'];
            $obj = UUM_Model_User::find(
                array("username"=>$oldobj->username)
            );
            $obj->paypass = self::encrypt($paypass,$obj->encrysalt);
            if($obj->save()){
                return array('code'=>1,'msg'=>'支付密码修改成功');
            }
        }
        return array('code'=>0,'msg'=>'支付密码修改失败');
    }
    //注销
    public static function userDestroy(){
        return array('code'=>0,'msg'=>'todo-用户注销失败');
    }
    //密码加密
    public static function encrypt($password,$encrysalt){
    	return md5(md5(trim($password)).$encrysalt);
    }

    //发送手机验证码
    public static function sendVerifyCode(){
        if($ok){
                return array('code'=>1,'msg'=>'验证码发送成功','ext'=>array('verifycode'=>'1234567'));
        }
        return array('code'=>0,'msg'=>'验证码发送失败');
    }
    //添加用户
    public static function add($data){
         /* 密码处理 */
        $data['encrysalt'] = createRandomstr(6);
        $data['password'] = self::encrypt($data['password'],$data['encrysalt']);
        $user = new UUM_Model_User();
        if($user->add($data)){
            return array('code'=>1,'msg'=>'用户添加成功');
        }
         return array('code'=>0,'msg'=>'用户添加失败');
    }
}
?>