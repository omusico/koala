<?php

copy(FRAME_PATH.'Initialise/Files/Koala.php',ENTRANCE_PATH.C('appcfg:app_name','App').'/Custom/Koala.php');
copy(FRAME_PATH.'Initialise/Files/Func.php',ENTRANCE_PATH.C('appcfg:app_name','App').'/Custom/Func.php');
copy(FRAME_PATH.'Initialise/Files/Config/LAEGlobal.user.php',ENTRANCE_PATH.C('appcfg:app_name','App').'/Config/LAEGlobal.user.php');
mkdir(ENTRANCE_PATH.C('appcfg:app_name','App').'/Controller/Home',0777,true);
mkdir(ENTRANCE_PATH.C('appcfg:app_name','App').'/View/default/Home/Index/page',0777,true);

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
file_put_contents(ENTRANCE_PATH.C('appcfg:app_name','App').'/Controller/Home/Index.php',$content);

$content = "<?php
defined('IN_KOALA') or exit();
use Koala\Server\Controller\Base as ControllerBase;
//公共类
class Controller_PublicController extends ControllerBase{
	public function __construct(){
		// coding
	}
}";
file_put_contents(ENTRANCE_PATH.C('appcfg:app_name','App').'/Controller/PublicController.php',$content);


$content = "Koala框架成功运行!<br>欢迎使用。";
file_put_contents(ENTRANCE_PATH.C('appcfg:app_name','App').'/View/default/Home/Index/page/index.html', $content);
?>