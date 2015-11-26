<?php
//FIS前端系统工具配置

//为了支持子目录请注意提供域名参数,
//fis release -d d:\wamp\www\subdir --domains
//下面的是域名路径
$domain = 'http://localhost/'.rtrim('/'.ROOT_RELPATH,'/');

$fis_js_cfg = array(
    //插件配置节点
    'modules' => array(
        //编译器插件配置节点
        'parser' => array(
            //使用fis-parser-marked插件编译md后缀文件
            'md' => 'marked'
        )
    ),
    'roadmap' => array(
        'ext' => array(
            //md后缀的文件编译为html
            'md' => 'html'
        ),
        //配置所有资源的domain
        'domain' => $domain,
        'path' => array(
            array(
                //map.json文件
                'reg' => 'map.json',
                'release' => '/Config/map.json'
            ),
            array(
                //skin下的js文件
                'reg' => '/^\/Application(\/.*\.js)/i',
                'release' => '/Source$1'
             ),
            array(
                //skin下的css文件
                'reg' => '/^\/Application(\/.*\.css)/i',
                'release' => '/Source$1'
             ),
            array(
                //Docs
                'reg' => '/^\/Docs(\/.*)/i',
                'release'=>false
            ),
            array(
                //min
                'reg' => '/^\/min(\/.*)/i',
                'release'=>false
             ),
            array(
                //Tools
                'reg' => '/^\/Tools(\/.*)/i',
                'release'=>false
             ),
            array(
                //sh文件
                'reg' => '**.sh',
                //不要发布
                'release' => false
             ),
            array(
                //git文件
                'reg' => '/^\/(.git)$/i',
                //不要发布
                'release' => false
             ),
            array(
                'reg' => '**.ico',
                'useHash' => false
             ),
              array(
                'reg' => '**.png',
                'useHash' => false
             ),
              array(
                'reg' => '**.jpg',
                'useHash' => false
             ),
              array(
                'reg' => '**.gif',
                'useHash' => false
             ),
            array(
                //其他所有文件
                'reg' => '/^\/(.*)$/i',
                'release' => '/$1'
            )
        )
    ),
    'settings' => array(
        'postprocessor' => array(
            //fis-postprocessor-jswrapper插件配置数据
            'jswrapper' => array(
                //使用define包装js组件
                'type' => 'amd'
         )   
       )
    ),
    'pack' => array(
        'pkg/aio.js' => array(
            'Source/Public/js/mod.js',
            'Source/Public/js/**.js',
            '**.js'
        ),
        'pkg/aio.css' =>array(
            'Source/Public/css/bootstrap.css',
            'Source/Public/css/bootstrap-responsive.css',
            'Source/Public/css/style.css',
            'Source/Public/css/**.css',
            '**.css'
        )
    ),
    'deploy' => array(
        'remote' => array(
            'receiver' => 'http=>//myproject/receiver.php',
            'to' => '/var/www/'
        ),
        'local' => array(
            'to' => 'D:/Database/www/candy'
       )
    )
);
$str = str_replace(array('"',"'/^","/i'"),array("'","/^","/i"),stripslashes(json_encode($fis_js_cfg)));
$str = 'fis.config.merge('.$str.');';
file_put_contents('fis-conf.js',$str);
?>