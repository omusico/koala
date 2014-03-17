<?php
class UUM_Logic_Auth{
	//默认配置
    static $_config = array(
        //'AUTH_ON' => true, //认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        //'AUTH_GROUP' => 'candy_auth_group', //用户组数据表名
        //'AUTH_GROUP_ACCESS' => 'candy_auth_group_access', //用户组明细表
        //'AUTH_RULE' => 'candy_auth_rule', //权限规则表
        //'AUTH_USER' => 'candy_members'//用户信息表
    );
	//生成权限字符列表
	public static function makeRuleList($path=''){
		if(empty($path)){
			$path = CONTRLLER_PATH;
		}
		$list =array();
		listDir($path,$list);
		unset($list[$path]);//remove PublicController.php
		foreach ($list as $dir => $files) {
			$g = basename($dir);
			foreach ($files as $index => $file) {
                $info = pathinfo($file);
				$m = $info['filename'];
				$controller = getController($g,$m,'\\');//Cotroller\Home\Index
				$methods[$g.'-'.$m]  =   get_class_methods($controller);
			}
		}
		foreach ($methods as $key => $values) {
			foreach ($values as $key1 => $value) {
				if(stripos($value, "_")!==0){
					$auth[] = $key.'-'.$value;//Home-Desk-index
				}
			}
			
		}
		return array('code'=>1,'msg'=>'获得Rule列表','ext'=>array('auth'=>$auth));
	}
	//清空权限字符表
	public static function clearAll(){
		if(UUM_Model_Rule::query('TRUNCATE TABLE '.C('DB_PREFIX').'auth_rule')){
			return array('code'=>1,'msg'=>'清空权限字符表成功');
		}
		return array('code'=>0,'msg'=>'清空权限字符表失败');
	}
	//权限字符串入库
	public static function addRuleList($data){
		if(is_array($data)){
			foreach ($data as $key => $value) {
				$res = array('name'=>$value,'title'=>$value,'type'=>0);
				$s = UUM_Model_Rule::add($res);
			}
			if($s){
				return array('code'=>1,'msg'=>'rule列表添加成功');
			}
		}
		return array('code'=>0,'msg'=>'rule列表添加失败');
	}
    //获取权限id串
    public static function getAuthIds($uid){
        $obj = UUM_Model_User::find($uid,array('select'=>'id,gid')
            );
        //获取组权限
        if($obj->gid)///
        $auth = UUM_Logic_Group::getGroupAuth($obj->gid);
        $ids = array();
        $ids = array_merge($ids, explode(',', trim($auth['rules'], ',')));
        $ids = array_unique($ids);
        return $ids;
    }
    //获取权限名列表
    public static function getAuthNames($ids){
      //获取权限
        $rule = new UUM_Model_Rule();
        $rules = $rule->getAll('*',array('id in(?)',$ids));
        return $rules;
    }
	//获取用户权限
	public static function getUserAuth($uid){
        $ids = self::getAuthIds($uid);
        if (empty($ids)) {
            $_authList[$uid] = array();
            return array();
        }
        $rules = self::getAuthNames($ids);
        //循环规则，判断结果。
        $authList = array();
        foreach ($rules as $r) {
            if ($r['type'] == 1) {
                //条件验证
                $userobj = new UUM_Model_User();
                $user = $userobj->getById($uid);
                $command = preg_replace('/\{(\w*?)\}/e', '$user[\'\\1\']', $r['condition']);
                //dump($command);//debug
                @(eval('$condition=(' . $command . ');'));
                if ($condition) {
                    $authList[] = $r['name'];
                }
            } else {
                //存在就通过
                $authList[] = $r['name'];
            }
        }
        $_authList[$uid] = $authList;
        if(self::$_config['AUTH_TYPE']==2){
            //session结果
            $_SESSION['_AUTH_LIST_'.$uid]=$authList;
        }
        return $authList;
	}
	//获得权限$name 可以是字符串或数组或逗号分割， uid为 认证的用户id， $or 是否为or关系，为true是， name为数组，只要数组中有一个条件通过则通过，如果为false需要全部条件通过。
    public static function getAuth($name, $uid, $relation='or') {
        if (!self::$_config['AUTH_ON'])
            return array('code'=>1,'msg'=>'权限验证成功');
        $authList = self::getUserAuth($uid);
        if (is_string($name)) {
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = array($name);
            }
        }
        $list = array(); //有权限的name
        foreach ($authList as $val) {
            if (in_array($val, $name))
                $list[] = $val;
        }
        if ($relation=='or' and !empty($list)) {
             return array('code'=>1,'msg'=>'权限验证成功');
        }
        $diff = array_diff($name, $list);
        if ($relation=='and' and empty($diff)) {
            return array('code'=>1,'msg'=>'权限验证成功');
        }
         return array('code'=>0,'msg'=>'权限验证失败');
    }
}