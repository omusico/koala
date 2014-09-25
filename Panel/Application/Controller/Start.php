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

class Start extends PublicController {
	public function indexAction($id, $title) {
		exit('indexAction');
	}
	/**
	 * 应用创建配置页
	 */
	public function index() {
		$o = \Koala\OAPI::factory('Tuling\Connect', array(), 'Library');
		$o->apply('tuling', array());
		print_r($o);
		exit;
		$file = \Config::getPath('Config/App.php');
		$arr  = include ($file);
		\FrontData::assign('createcfg', $arr);
	}
	/**
	 * 处理创建的方法
	 */
	public function _createApp() {
		$file = \Config::getPath('Config/App.php');
		$arr  = include ($file);
		if ($arr['projectpath'] == '@' || !is_dir($arr['projectpath'])) {
			$arr['projectpath'] = PROTECT_PATH_DEFAULT;
			$arr['apppath']     = PROTECT_PATH_DEFAULT . $arr['appname'];
		} else {
			$arr['apppath'] = $arr['projectpath'] . $arr['appname'];
		}
		if ($arr['releasepath'] == '@' || !is_dir($arr['releasepath'])) {
			$arr['releasepath'] = PROTECT_PATH_DEFAULT . $arr['releasename'];
		}
		if (!is_writable($arr['projectpath'])) {
			View::assign('createcfg', $arr);
			\FrontData::assign('state', 'error');
			\FrontData::assign('msg', View::render('Start/page/_checkEnv_error'));
		} elseif (file_exists($arr['apppath'])) {
			\FrontData::assign('state', 'error');
			\FrontData::assign('msg', $arr['appname'] . '应用已存在,位于' . $arr['apppath']);
		} else {
			exec('git clone https://github.com/lunnlew/koalaDemo.git ' . $arr['apppath']);
			\FrontData::assign('state', 'success');
			\FrontData::assign('msg', '应用创建成功!位于' . $arr['apppath']);
		}
	}
}