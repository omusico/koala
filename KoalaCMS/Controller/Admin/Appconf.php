<?php
namespace Controller\Admin;
use Controller_PublicController;
use View;
class Appconf extends Controller_PublicController{
	public function __construct(){
		parent::__construct();
	}
	public function _before_index(){
		//echo __METHOD__.'<br>';
	}
	public function index(){
		$cfg = include(ROOT_PATH.'KoalaCMS/Config/LAEGlobal.user.php');
		foreach ($cfg as $key => $value) {
			if(!is_array($value))
            	$infos[] = array('item'=>L($key),'value'=>$value);
        }
        View::assign('cfg',$infos);
		// coding
		View::display();
	}
	public function subconf(){
		switch (\Dispatcher::$options['params']['type']) {
			case 'db':
				$cfg = include(ROOT_PATH.'KoalaCMS/Config/LAEGlobal.user.php');
				foreach ($cfg as $key => $value) {
					if(!is_array($value)&&stripos($key,'db')!==false)
		            	$infos[] = array('item'=>L($key),'value'=>$value);
		        }break;
		    case 'template':
				$cfg = include(ROOT_PATH.'KoalaCMS/Config/LAEGlobal.user.php');
				foreach ($cfg as $key => $value) {
					if(stripos($key,'template')!==false)
		            	$infos[] = array('item'=>L($key),'value'=>json_encode($value));
		        }
				break;
		}
		View::assign('cfg',$infos);
		View::display();
	}
	public function _after_index(){
		//echo __METHOD__.'<br>';
	}
}