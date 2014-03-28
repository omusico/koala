<?php
//pathinfo
$cfg['URLMODE']=2;//1普通,2pathinfo,3兼容
$cfg['URL_PATHINFO_DEPR'] = '/';
$cfg["URL_HTML_SUFFIX"]='.html';

//多分组相关配置
$cfg['MULTIPLE_GROUP']=1;
$cfg['GROUP']=array(
  //允许分组列表
  'list'=>'Manage,Home,Admin',
  //默认分组
  'default' => 'Admin'
  );
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
//数据库
$cfg["DB_TYPE"]='mysql'; // 数据库类型
$cfg["DB_HOST_M"]='localhost'; // 服务器地址
$cfg["DB_NAME"]='koalacms'; // 数据库名
$cfg["DB_USER"]='root'; // 用户名
$cfg["DB_PASS"]=''; // 密码
$cfg["DB_PORT"]= 3306; // 端口
$cfg["DB_PREFIX"]='koala_'; // 数据库表前缀
$cfg["DB_CHARSET"] = 'UTF8';
return $cfg;