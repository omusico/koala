<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Controller;
/**
 * Controller基类
 * 
 * @package  Koala
 * @subpackage  Server\Controller
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Base{

    /**
     * 视图实例对象
     * @var view
     * @access protected
     */    
    protected $view     =  null;

    /**
     * 当前控制器名称
     * @var name
     * @access protected
     */      
    private   $name     =  '';

    /**
     * 控制器参数
     * @var config
     * @access protected
     */      
    protected $config   =   array();

   /**
     * 架构函数 取得模板对象实例
     * @access public
     */
    public function __construct() {         
        //控制器初始化
        if(method_exists($this,'_initialize'))
            $this->_initialize();
    }

   /**
     * 获取当前Action名称
     * @access protected
     */
    protected function getActionName() {
        if(empty($this->name)) {
            // 获取Action名称
            $this->name     =   substr(get_class($this),0,-6);
        }
        return $this->name;
    }
    /**
     * 操作错误跳转的快捷方法
     * @access protected
     * @param string $message 错误信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
    protected function error($message='',$jumpUrl='',$ajax=false) {
        $this->dispatchJump($message,0,$jumpUrl,$ajax);
    }

    /**
     * 操作成功跳转的快捷方法
     * @access protected
     * @param string $message 提示信息
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @return void
     */
    protected function success($message='',$jumpUrl='',$ajax=false) {
        $this->dispatchJump($message,1,$jumpUrl,$ajax);
    }

    /**
     * 默认跳转操作 支持错误导向和正确跳转
     * 调用模板显示 默认为public目录下面的success页面
     * 提示页面为可配置 支持模板标签
     * @param string $message 提示信息
     * @param Boolean $status 状态
     * @param string $jumpUrl 页面跳转地址
     * @param mixed $ajax 是否为Ajax方式 当数字时指定跳转时间
     * @access private
     * @return void
     */
    private function dispatchJump($message,$status=1,$jumpUrl='',$ajax=false) {
        if(true === $ajax || IS_AJAX) {// AJAX提交
            $data           =   is_array($ajax)?$ajax:array();
            $data['info']   =   $message;
            $data['status'] =   $status;
            $data['url']    =   $jumpUrl;
            $this->ajaxReturn($data);
        }
        if(is_int($ajax)) \FrontData::assign('waitSecond',$ajax);
        if(!empty($jumpUrl)) \FrontData::assign('jumpUrl',$jumpUrl);
        // 提示标题
        \FrontData::assign('msgTitle',$status? L('_OPERATION_SUCCESS_') : L('_OPERATION_FAIL_'));
        //如果设置了关闭窗口，则提示完毕后自动关闭窗口
        if(\FrontData::get('closeWin'))    \FrontData::assign('jumpUrl','javascript:window.close();');
        \FrontData::assign('status',$status);   // 状态
        //保证输出不受静态缓存影响
       // C('HTML_CACHE_ON',false);
        if($status) { //发送成功信息
            \FrontData::assign('message',$message);// 提示信息
            // 成功操作后默认停留1秒
            if(!\FrontData::get('waitSecond'))    \FrontData::assign('waitSecond','1');
            // 默认操作成功自动返回操作前页面
            if(!\FrontData::get('jumpUrl')) \FrontData::assign("jumpUrl",$_SERVER["HTTP_REFERER"]);
            \FrontData::display(C('TMPL_ACTION_SUCCESS'));
        }else{
            \FrontData::assign('error',$message);// 提示信息
            //发生错误时候默认停留3秒
            if(!\FrontData::get('waitSecond'))   \FrontData::assign('waitSecond','3');
            // 默认发生错误的话自动返回上页
            if(!\FrontData::get('jumpUrl')) \FrontData::assign('jumpUrl',"javascript:history.back(-1);");
            \FrontData::display(C('TMPL_ACTION_ERROR'));
            // 中止执行  避免出错后继续执行
            exit ;
        }
    }
    /**
     * Ajax方式返回数据到客户端
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type AJAX返回数据格式
     * @return void
     */
    protected function ajaxReturn($data,$type='') {
        if(func_num_args()>2) {// 兼容3.0之前用法
            $args           =   func_get_args();
            array_shift($args);
            $info           =   array();
            $info['data']   =   $data;
            $info['info']   =   array_shift($args);
            $info['status'] =   array_shift($args);
            $data           =   $info;
            $type           =   $args?array_shift($args):'';
        }
        if(empty($type)) $type  =   C('DEFAULT_AJAX_RETURN');
        switch (strtoupper($type)){
            case 'JSON' :
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode($data));
            case 'XML'  :
                // 返回xml格式数据
                header('Content-Type:text/xml; charset=utf-8');
                exit(xml_encode($data));
            case 'JSONP':
                // 返回JSON数据格式到客户端 包含状态信息
                header('Content-Type:application/json; charset=utf-8');
                $handler  =   isset($_GET[C('VAR_JSONP_HANDLER')]) ? $_GET[C('VAR_JSONP_HANDLER')] : C('DEFAULT_JSONP_HANDLER');
                exit($handler.'('.json_encode($data).');');  
            case 'EVAL' :
                // 返回可执行的js脚本
                header('Content-Type:text/html; charset=utf-8');
                exit($data);            
            default     :
                // 用于扩展其他返回格式数据
                tag('ajax_return',$data);
        }
    }
    public function __call($method,$args) {}
   /**
     * 析构方法
     * @access public
     */
    public function __destruct() {}
}