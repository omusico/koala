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
				'name'=>'配置管理',
				'url'=>U('Appconf')
				),
			array(
				'name'=>'应用开发',
				'url'=>U('Appconf')
				),
			array(
				'name'=>'数据管理',
				'url'=>U('Appconf')
				)
			);
		View::assign('topnav',$top_nav);
	}
	public function menu(){
		$menu = array(
			'Appconf'=>array(
				array(
				'name'=>'数据库配置',
				'url'=>U('Appconf/subconf/type/db')
				),
				array(
				'name'=>'模板引擎配置',
				'url'=>U('Appconf/subconf/type/template')
				),
				)
			);
		View::assign('menu',$menu[MODULE_NAME]);
	}
}