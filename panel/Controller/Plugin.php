<?php
namespace Controller;
use Controller_PublicController;
use View;
class Plugin extends Controller_PublicController{
	public function index(){
		View::display();
	}
	public function newPluginPage(){
		View::display();
	}
	public function newPluginProcess(){
		$_POST['name'] = ucwords($_POST['name']);
		$file_path = APP_PLUGIN_PATH.ucwords($_POST['name']).DS;
		if(!is_dir($file_path)){
			//建立插件目录
			mkdir(APP_PLUGIN_PATH.$_POST['name'],0777,true);
			//建立插件实现框架
			$content = file_get_contents(CORE_ADDONS_PATH.'Data/PluginAction.txt');
			$content = str_replace('[PLUGIN_NAME]',ucwords($_POST['name']),$content);
			file_put_contents($file_path.'Action.php',$content);
			//建立插件配置
			file_put_contents($file_path.'Config.php',"<?php\r\nreturn ".var_export($_POST,true).";");
			echo '成功建立插件文件,位于:'.$file_path;
		}else{
			echo '已存在同名插件';
		}
		
	}
}