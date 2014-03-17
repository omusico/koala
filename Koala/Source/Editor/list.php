<?php
defined('IN_Koala') or die('错误');
$editor = array(
array('name'=>'ueditor','des'=>'百度编辑器','enable'=>1),
array('name'=>'kindeditor','des'=>'kindeditor编辑器','enable'=>1),
array('name'=>'tinymce','des'=>'tinymce','enable'=>1),
array('name'=>'u_Editor','des'=>'uEditor is a WYSIWYG HTML editor originally based on widgEditor','enable'=>1),
);
//注目前只对ueditor,kindeditor完成了前后台交互功能
return $editor;
?>