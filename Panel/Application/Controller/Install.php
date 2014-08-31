<?php
/**
 * KoalaCMS - A PHP CMS System In Koala FrameWork
 *
 * @package  KoalaCMS
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Controller;
/**
 * index controller
 */

class Install extends PublicController {
	public function index() {}
	public function step1() {
		$runtime = array(
			'操作系统'       => \env::get("PHP_OS"),
			'PHP版本'          => \env::get("PHP_VERSION"),
			'PHP运行方式'    => \env::get("PHP_RUNMODE"),
			'上传附件限制' => \env::get("PHP_UPLOADSIZE"),
			'执行时间限制' => \env::get("PHP_MAXTIME"),
			'剩余空间'       => \env::get("PHP_SPACE"),
			'服务器时间'    => \env::get("PHP_SERVER_TIME"),
			'北京时间'       => \env::get("BEIJING_TIME"),
		);
		foreach ($runtime as $key => $value) {
			$runtimes[] = array_merge(array('item' => $key), $value);
		}
		$function = array(
			'file_get_contents' => \env::get("file_get_contents"),
		);
		foreach ($function as $key => $value) {
			$functions[] = array_merge(array('item' => $key), $value);
		}

		$permissions = array();

		$infos = array('runtime' => $runtimes, 'function' => $functions, 'permission' => $permissions);
		\FrontData::assign('infos', $infos);

	}
	public function step2() {
		$data_source = array(
			'数据库类型' => array(
				'type'   => 'select',
				'option' => array(
					'mysql' => 'mysql',
				),
				'id'   => 'dataAccessType',
				'name' => 'dataAccessType',
				'info' => '数据类型'
			),
			'数据库服务器' => array(
				'type'   => 'txt',
				'option' => '127.0.0.1',
				'id'     => 'dbServer',
				'name'   => 'dbServer',
				'info'   => '数据库服务器，数据库服务器IP，一般为127.0.0.1',
			),
			'数据库名' => array(
				'type'   => 'txt',
				'option' => '',
				'id'     => 'dbName',
				'name'   => 'dbName',
				'info'   => '',
			),
			'数据用户' => array(
				'type'   => 'txt',
				'option' => '',
				'id'     => 'dbUser',
				'name'   => 'dbUser',
				'info'   => '',
			),
			'用户密码' => array(
				'type'   => 'password',
				'option' => '',
				'id'     => 'dbPass',
				'name'   => 'dbPass',
				'info'   => '',
			),
			'数据端口' => array(
				'type'   => 'txt',
				'option' => '3306',
				'id'     => 'dbPort',
				'name'   => 'dbPort',
				'info'   => '数据库服务连接端口，如mysql默认3306',
			),
			'表前缀' => array(
				'type'   => 'txt',
				'option' => 'koala_',
				'id'     => 'dbPre',
				'name'   => 'dbPre',
				'info'   => '数据表前缀，同一个数据库运行多个系统时请修改为不同的前缀',
			)
		);
		foreach ($data_source as $key => $value) {
			$html = getFormHtml($value['type'], $value['option'], $value['id'], $value['name']);
			unset($value['type']);
			unset($value['option']);
			unset($value['name']);
			$data_sources[] = array_merge(array('item' => $key, 'html' => $html), $value);
		}
		$admin_info = array(
			'Email' => array(
				'type'   => 'email',
				'option' => '',
				'id'     => 'email',
				'name'   => 'email',
				'info'   => '填写正确的邮箱便于收取提醒邮件',
			),
			'密码' => array(
				'type'   => 'password',
				'option' => '',
				'id'     => 'password',
				'name'   => 'password',
				'info'   => '',
			),
			'确认密码' => array(
				'type'   => 'password',
				'option' => '',
				'id'     => 'repassword',
				'name'   => 'repassword',
				'info'   => '',
			),
		);
		foreach ($admin_info as $key => $value) {
			$html = getFormHtml($value['type'], $value['option'], $value['id'], $value['name']);
			unset($value['type']);
			unset($value['option']);
			unset($value['name']);
			$admin_infos[] = array_merge(array('item' => $key, 'html' => $html), $value);
		}
		$infos = array('data_source' => $data_sources, 'admin_info' => $admin_infos);
		\FrontData::assign('infos', $infos);

	}
	public function step2_create() {
		extract($_POST, true);
		//检测管理员信息
		if (empty($email) || empty($password)) {
			\FrontData::assign('waitSecond', 5);
			\FrontData::assign('jumpUrl', U('Install/step2'));
			//\FrontData::error('请填写完整管理员信息');
		} else if ($password != $repassword) {
			//\FrontData::error('确认密码和密码不一致');
		} else {
			//缓存管理员信息
		}

		//检测数据库配置
		if (empty($dataAccessType) || empty($dbServer) || empty($dbName) || empty($dbUser) || empty($dbPass) || empty($dbPort) || empty($dbPre)) {
			//\FrontData::error('请填写完整的数据库配置');
		} else {
			//缓存数据库配置
		}

		//跳转到数据库安装页面
		redirect(U('Install/step3'));
	}
	public function step3() {

	}
}