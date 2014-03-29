<?php
namespace Controller;
use Controller_PublicController;
use View;
class AppCreator extends Controller_PublicController{
	public function index(){
		$app_path = ROOT_PATH.C('appcfg:app_name');
		if(!is_dir($app_path))
		{
			View::assign('notbuild',true);
			View::assign('createApp',U('AppCreator/Create'));
		}
		else
			View::assign('notbuild',false);
		//读取应用配置
        View::assign('cfg',C('appcfg'));
		// coding
		View::display();
	}
	/**
	 * 根据配置创建一个应用
	 */
	public function create(){
		self::createDir();
		self::createFile();
		echo '建立成功';
	}
	/**
	 * 创建应用目录结构
	 */
	protected function createDir(){
		$app_path = ROOT_PATH.C('appcfg:app_name','App').'/';
		$dirs = C('appcfg:app_dir');
		foreach ($dirs as $dirname) {
			mkdir($app_path.$dirname,0777,true);
		}
	}
	/**
	 * 创建示例文件
	 */
	protected function createFile(){
		//编译设置
        require_once(FRAME_PATH.'Initialise/BuildItems/build.php');
	}
}