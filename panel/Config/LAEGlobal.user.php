<?php
//pathinfo
$cfg['URLMODE']=2;//1普通,2pathinfo,3兼容
$cfg['URL_PATHINFO_DEPR'] = '/';
$cfg["URL_HTML_SUFFIX"]='.html';

//多分组相关配置
$cfg['MULTIPLE_GROUP']=0;
//默认模块
$cfg['MODULE']=array('default'=>'Index');
//默认方法
$cfg['ACTION']=array('default'=>'index');
//模板引擎
$cfg['Template_Engine']=array(
  'default'=>'twig',
  'twig'=>array(
    'template_path'=>'[VIEW_PATH][STYLENAME]',//or array(path1,$path2,...)
    'cache'=>false,
    'cache_path'=>'[COMPILE_PATH]',
    'debug'=>false,
    'charset'=>'UTF-8',
    'autoescape'=>'html',
    'optimizations'=>-1
    )
  );
return $cfg;