<?php
//公共类
class Controller_PublicController extends Core_Controller_Base{
	public function __construct(){
		self::topnav();
		self::menu();
	}
	public function topnav(){
		$top_nav = array(
			array(
				'name'=>'应用开发',
				'url'=>U('AppCreator')
				),
			array(
				'name'=>'插件开发',
				'url'=>U('Plugin')
				)
			);
		View::assign('topnav',$top_nav);
	}
	public function menu(){
		$menu = array(
			'Plugin'=>array(
				array(
				'name'=>'新建插件',
				'url'=>U('Plugin/newPluginPage')
				)
				),
			);
		View::assign('menu',$menu[MODULE_NAME]);
	}
}