<?php
defined('IN_Koala') or exit();
abstract class Base_View{
	abstract public function assgin($key,$value);
	abstract public function addViewDir($dir);
	abstract public function setViewDir($dir);
	abstract public function setCacheDir($dir);
	abstract public function setCompileDir($dir);
	abstract public function display($tpl);
}
?>