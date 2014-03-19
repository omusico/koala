<?php

//新建项目文件
mkdir(ROOT_PATH.'App',0777,true);
mkdir(ROOT_PATH.'App/Custom',0777,true);
mkdir(ROOT_PATH.'App/Config',0777,true);

copy(FRAME_PATH.'Initialise/Files/Koala.php',ROOT_PATH.'App/Custom/Koala.php');
file_put_contents(ROOT_PATH.'App/Custom/Func.php',"<?php\t\n");
copy(FRAME_PATH.'Initialise/Files/Config/LAEGlobal.user.php',ROOT_PATH.'App/Config/LAEGlobal.user.php');
copy(FRAME_PATH.'Initialise/Files/bootstrap.php',ROOT_PATH.'App/bootstrap.php');


mkdir(ROOT_PATH.'App/Controller',0777,true);
mkdir(ROOT_PATH.'App/Controller/Home',0777,true);
mkdir(ROOT_PATH.'App/Module',0777,true);
mkdir(ROOT_PATH.'App/Language',0777,true);
mkdir(ROOT_PATH.'App/Source',0777,true);
mkdir(ROOT_PATH.'App/View/default/Home/Index/page',0777,true);

$content = "<?php
namespace Controller\Home;
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
		// coding
		View::display();
	}
	public function _after_index(){
		//echo __METHOD__.'<br>';
	}
}";
file_put_contents(ROOT_PATH.'App/Controller/Home/Index.php',$content);

$content = "<?php
defined('IN_Koala') or exit();
//公共类
class Controller_PublicController extends Core_Controller_Base{
	public function __construct(){
		// coding
	}
}";
file_put_contents(ROOT_PATH.'App/Controller/PublicController.php',$content);


$content = "Koala框架成功运行!<br>欢迎使用。";
file_put_contents(ROOT_PATH.'App/View/default/Home/Index/page/index.html', $content);
?>