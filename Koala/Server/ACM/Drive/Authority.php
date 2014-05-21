<?php
namespace Koala\Server\ACM\Drive;
use Koala\Server\ACM\Base as Base;
use Koala\Server\ACM\Logic as Logic;
class Authority extends Base{
    /**
     * 配置项
     * @var array
     */
    var $options = array(
        'AUTH_ON' => true, //认证开关
        //'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        //'AUTH_GROUP' => 'auth_group', //用户组数据表名
        //'AUTH_GROUP_ACCESS' => 'auth_group_access', //用户组明细表
        //'AUTH_RULE' => 'auth_rule', //权限规则表
        //'AUTH_USER' => 'members'//用户信息表
    );
    public function __construct($options=array()){

    }
    /**
     * 验证方法
     * @todo 未来实现
     * @param  Object  $Operator      操作者对象
     * @param  Object  $OperateMethod 操作方法对象
     * @param  Object  $AccessObject  业务对象
     * @return boolean                true/flase
     */
    public function isValidate(\Object $Operator,\Object $OperateMethod=null,\Object $AccessObject=null){
        //查询操作者权限ID串//
        $rules = self::getUserAuth($Operator->id);
    }
    /**
     * 验证方法
     * 
     * checkAuth('name1,name2,...',1,'or') 只要有[一个存在]则true
     * checkAuth(array('name1','name2',...),1,'and') 只要有[一个name不存在]则false
     * 
     * @param  string/array $name    权限标识
     * @param  int $uid      用户id
     * @param  string $relation 组合关系
     * @return boolean                true/flase
     */
    public function checkAuth($name, $uid, $relation='or') {
        //如果不启用则为真
        if (!$this->options['AUTH_ON'])
            return true;
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
            return true;
        }
        $diff = array_diff($name, $list);
        if ($relation=='and' and empty($diff)) {
            return true;
        }
        return false;
    }

    /**
     * 获取用户权限
     */
    public function getUserAuth($uid){
        //获取用户组(用户可属于多个组)
        $grouplist = Logic\AuthGroupAcess::getList('id,uid,gid',array('id = ?',$uid));
        //处理组
        foreach ($grouplist as $key => $value) {
           $arr_gid[] = $value['gid'];
        }
        //取得用户组权限
        $arr_rule = self::getGroupAuth($arr_gid);
        $rules = array();
        //合并用户所有组的权限
        foreach ($arr_rule as $key => $value) { 
           $rules = array_merge($rules,$value);
        }
        //去除重复
        $str = implode(',',$rules);
        $rules = explode(',',$str);
        $arr_rule = array_unique($rules);

        //查询权限串信息
        $rules = Logic\AuthRule::getList('*',array('id in(?)',$arr_rule));
        //处理返回标识
        foreach ($rules as $r) {
            if ($r['type'] == 1) {
                //条件验证
                $user = Logic\AuthUser::getById($uid);
                $command = preg_replace('/\{(\w*?)\}/e', '$user[\'\\1\']', $r['condition']);
                @(eval('$condition=(' . $command . ');'));
                if ($condition) {
                    $authList[] = $r['name'];
                }
            } else {
                //存在就通过
                $authList[] = $r['name'];
            }
        }
        return $authList;
    }
    /**
     * 获取用户组权限
     */
    public function getGroupAuth($arr_gid){
        if(!is_array($arr_gid)){
            if(is_string($arr_gid)){
                if(stripos($arr_gid,',')===false)
                    $arr_gid = array($arr_gid);
                else
                    $arr_gid = explode(',',$arr_gid);
            }else{
                $arr_gid = array($arr_gid);
            }
        }
        //获取用户组权限
        $rulelist = Logic\AuthGroup::getList('id,rules',array('id in(?)',$arr_gid));
        
        //处理权限(采用并集)
        foreach ($rulelist as $key => $value) {
           $arr_rule[$value['id']][] = $value['rules'];
        }
        return $arr_rule;
    }
}