<?php
namespace Controller;
use Controller_PublicController;
use View;
class Index extends Controller_PublicController{
	public function __construct(){
		parent::__construct();
	}
	public function _before_index(){
		//echo __METHOD__.'<br>';
	}
	public function index(){
		$info = array(
            '框架版本' => FRAME_VERSION,
            '框架发行' => FRAME_RELEASE,
            '主机名IP端口' => $_SERVER['SERVER_NAME'] . ' (' . $_SERVER['SERVER_ADDR'] . ':' . $_SERVER['SERVER_PORT'] . ')',
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式' => php_sapi_name(),
            '框架目录' => FRAME_PATH,
            'MYSQL版本' => function_exists("mysql_close") ? mysql_get_client_info() : '不支持',
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . "秒",
            '剩余空间' => round((@disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            '服务器时间' => date("Y年n月j日 H:i:s"),
            '北京时间' => gmdate("Y年n月j日 H:i:s", time() + 8 * 3600)
        );
	 	foreach ($info as $key => $value) {
            $infos[] = array('item'=>$key,'value'=>$value);
        }
		View::assign('frame_info', $infos);
		// coding
		View::display();
	}
	public function _after_index(){
		//echo __METHOD__.'<br>';
	}
}