<?php
class Plugin_Captcha_Action{
    //插件名
    protected $name = 'Captcha';
    //小图标长宽
    protected $ico_w = 20;
    protected $ico_h = 20;
    //容器长宽
    protected $container_w = 200;
    protected $container_h = 100;
    //图片素材列表
    protected $ico_list = array(
        'ico1.png','ico2.png','ico3.png','ico4.png','ico5.png','ico6.png'
        );
	//解析函数的参数是pluginManager的引用
    function __construct(&$pluginManager='',$param=''){
        //注册这个插件
        //第一个参数是钩子的名称
        //第二个参数是plugin类的引用
        //第三个是插件所执行的方法
        if($pluginManager!='')
            $pluginManager->register($this->name, $this, 'Display');

    }
    function Display(){
        //随机取得3个图标
        shuffle($this->ico_list);
        $tico = array_slice($this->ico_list,0,3);
        //选一个图标
        $c_ico = $tico[0];
        //生成当前图片码
        $c_code = createRandomstr(6);
        //保存数据
        $_SESSION['captcha_code'] = $c_code;

        //再次打乱
        shuffle($tico);

    }
    public function getOne(){
        
    }
}
?>