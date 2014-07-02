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
 * Config controller
 */
class Config extends PublicController{
	public function index(){}
	public function _write(){
		$file = \Config::getPath('Config/App.php');
		$arr = include($file);
		$arr[$_REQUEST['name']] = $_REQUEST['value'];
		file_put_contents($file, "<?php\r\nreturn ".var_export($arr,true).";\r\n?>");
	}
}