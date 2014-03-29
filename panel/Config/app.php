<?php
//应用开发定义配置

//应用名
$cfg['app_name'] = 'App';
//相关目录
//附加库
$cfg['app_dir']['addons'] = 'Addons';
//插件
$cfg['app_dir']['plugin'] = 'Addons/Plugin';
//配置
$cfg['app_dir']['config'] = 'Config';
//控制器
$cfg['app_dir']['controller'] = 'Controller';
//应用库
$cfg['app_dir']['lib'] = 'Custom';
//应用资源
$cfg['app_dir']['source'] = 'Source';
//应用视图
$cfg['app_dir']['view'] = 'View';
//应用模型
$cfg['app_dir']['model'] = 'Model';
//语言包
$cfg['app_dir']['language'] = 'Language';

$config['appcfg'] = $cfg;
return $config;