<?php
/**
 * KoalaCMS - A PHP CMS System In Koala FrameWork
 *
 * @package  KoalaCMS
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Controller;
use View;
/**
 * 应用创建处理类 controller
 */
class Start extends PublicController{
	/**
	 * 应用创建配置页
	 */
	public function index(){
		$file = \Config::getPath('Config/App.php');
		$arr = include($file);
		\FrontData::assign('createcfg',$arr);
	}
	/**
	 * 处理创建的方法
	 */
	public function _createApp(){
		$file = \Config::getPath('Config/App.php');
		$arr = include($file);
		if($arr['projectpath']=='@'){
			$arr['projectpath'] = PROTECT_PATH_DEFAULT;
		}
		if($arr['apppath']=='@'||!is_dir($arr['apppath'])){
			$arr['apppath'] = PROTECT_PATH_DEFAULT.$arr['appname'];
		}
		if($arr['releasepath']=='@'||!is_dir($arr['releasepath'])){
			$arr['releasepath'] = PROTECT_PATH_DEFAULT.$arr['releasename'];
		}
		if(!is_writable($arr['projectpath'])||!is_writable($arr['releasepath'])){
			View::assign('createcfg',$arr);
			\FrontData::assign('state','error');
			\FrontData::assign('msg',View::render('Start/page/_checkEnv_error'));
		}else{
			exec('git clone https://github.com/lunnlew/koalaDemo.git '.$arr['apppath']);
			\FrontData::assign('state','success');
			\FrontData::assign('msg','创建应用成功!');
		}
	}
}