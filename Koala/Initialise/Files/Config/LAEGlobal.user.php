<?php
//数据库
//'DB_DSN' => 'mysql://root:root@localhost:3306/candy',
$cfg["DB_TYPE"]='mysql'; // 数据库类型
$cfg["DB_HOST_M"]='localhost'; // 服务器地址
$cfg["DB_NAME"]='candy'; // 数据库名
$cfg["DB_USER"]='root'; // 用户名
$cfg["DB_PASS"]=''; // 密码
$cfg["DB_PORT"]= 3306; // 端口
$cfg["DB_PREFIX"]='candy_'; // 数据库表前缀
$cfg["DB_CHARSET"] = 'UTF8';

//模板引擎
$cfg['Template_Engine']=array(
  'default'=>'twig',
  'tengine'=>array(),
  'smarty'=>array(
                'TemplateDir'=>'[VIEW_PATH][THEME_NAME]',
                'CompileDir'=>'[COMPILE_PATH]',
                'PluginDir'=>'[PLUGIN_PATH]Smarty/plugin',
                'ConfigDir'=>'[PLUGIN_PATH]Smarty/config',
                'CacheDir'=>'[COMPILE_PATH]',
                'debugging'=>false,
                'caching'=>true,
                'cache_lifetime'=>3600,
                'left_delimiter'=>'{%',
                'right_delimiter' =>'%}',
                'compile_locking'=>false,
                'plugins'=>array(
                    'function'=>array('L'=>'L','U'=>'U','PU'=>'PU','cats'=>'cats'),
                    ),
                ),
  'twig'=>array(
    'template_path'=>'[VIEW_PATH][THEME_NAME]',//or array(path1,$path2,...)
    'cache'=>false,
    'cache_path'=>'[COMPILE_PATH]',
    'debug'=>false,
    'charset'=>'UTF-8',
    'autoescape'=>'html',
    'optimizations'=>-1
    )
  );
return $cfg;