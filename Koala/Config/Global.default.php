<?php
/**
 *本文件为默认配置文件
 */
$cfg['sitename'] = 'myname';
$cfg['site_disable'] = 0;
$cfg['charset'] = 'utf-8';
$cfg['time_zone'] = 'PRC';
$cfg["version"] = '1.0.0';

//模板引擎
$cfg['Template_Engine']=array(
  'default'=>'Tengine',
  'Tengine'=>array(),
  'twig'=>array(
    'template_path'=>'./View',//or array(path1,$path2,...)
    'cache_path'=>'./Cache',
    'debug'=>false,
    'charset'=>'UTF-8',
    'autoescape'=>'html',
    'optimizations'=>-1
    )
  );

//PATHINFO相关配置
$cfg['URLMODE']=1;
$cfg['URL_PATHINFO_DEPR'] = '/';
$cfg["URL_HTML_SUFFIX"]='html';

//多应用相关配置
$cfg['MULTIPLE_APP']=0;
$cfg['APP']=array(
  //允许应用列表
  'list'=>'APP1',
  //默认应用
  'default' => 'APP1'
  );

//多分组相关配置
$cfg['MULTIPLE_GROUP']=1;
$cfg['GROUP']=array(
  //允许分组列表
  'list'=>'Manage,Home,Admin',
  //默认分组
  'default' => 'Home'
  );
//默认模块
$cfg['MODULE']=array('default'=>'Index');
//默认方法
$cfg['ACTION']=array('default'=>'index');

//变量
$cfg['VAR_APP']='app';
$cfg["VAR_GROUP"]='g';
$cfg["VAR_MODULE"]='m';
$cfg["VAR_ACTION"]='a';

//域名部署

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

//服务配置
//CACHE,Channel,Counter,KVDB,Log,Rank,Segment,Storage
//参照格式    详细请查看文档
//
/*
$cfg['Channel'] = array(
  //设置默认
  'default'=>'LAEChannel',
  //驱动配置
  'laechannel'=>array(),//$option
  'saechannel'=>array(),//$option
  'baechannel'=>array(),//$option
  //更多...
  );
$cfg['Counter'] = array(
  //设置默认
  'default'=>'LAECounter',
  //驱动配置
  'laecounter'=>array(),//$option
  'saecounter'=>array(),//$option
  'baecounter'=>array(),//$option
  //更多...
  );
*/
//缓存服务配置
$cfg['CACHE'] = array(
  //设置默认缓存
  'default'=>'LAEMemcache',
  //memcache缓存配置项
  'laememcache'=>array(
    'group'=>'[APP_NAME][APP_VERSION]',
    'expire'=>3600,/* 缓存时间 */
    'compress'=>1,/* 是否压缩存储 */
    'servers'=>array(
      'host'=>'127.0.0.1',
      'port'=>11211
      )
    ),
  //apc
  'laeapc'=>array(
    'group'=>'[APP_NAME][APP_VERSION]',
    'expire'=>3600,
    'compress'=>1
    ),
  //更多...
  );


return $cfg;
?>