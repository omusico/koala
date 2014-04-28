#惯例配置

###路由
    URLMODE:    路由模式
        默认值: 2
        目前支持参数,1(普通模式),2(PATHINFO),3(兼容模式)
        普通模式:   http://mydomain/index.php?g=home&m=index&a=index&pram1=val1
        PATHINFO:   http://mydomain/index.php/home/index/index/param1/val1
        兼容模式:   http://mydomain/index.php?s=home/index/index/param1/val1
        
    URL_PATHINFO_DEPR:  PATHINFO模式下分隔符
        默认值:/
        
    URL_HTML_SUFFIX:    PATHINFO模式下URL后缀
        默认值: .html

###多应用
    MULTIPLE_APP:   多应用标识
        默认值: 0
        目前支持参数,0(非多应用),1(多应用)
    APP: 多应用模式配置
        list: 应用允许列表
            默认值: APP
        default: 默认访问应用
            默认值: APP
        
        
    参考多应用:http://mydomain/index.php/app/home/index/index/param1/val1
    
###多分组
    MULTIPLE_GROUP:   多分组标识(首字母大写)
        默认值: 0
        目前支持参数,0(非多应用),1(多应用)
    GROUP: 多分组模式配置
        list: 分组允许列表
            默认值: Home,Admin
        default: 默认访问分组
            默认值: Home
###默认模块
    MODULE: 默认模块(首字母大写)
        default:    默认访问模块
            默认值: Index

###默认方法
    ACTION: 默认方法(不区分大小写)
        default:    默认访问方法
            默认值: index

###模板引擎
    Template_Engine:    模板引擎
        目前支持引擎:Tengine(内置),Smarty,Twig
        default:    默认引擎(首字母大写)
            默认值: Tengine
        tengine: Tengine配置项
            默认值:
                array()
        smarty : Smarty引擎配置项
            默认值:
                array(
                'TemplateDir'=>'[VIEW_PATH][THEME_NAME]',
                'CompileDir'=>'[COMPILE_PATH]',
                'PluginDir'=>'[APP_ADDONS_PATH]Smarty/plugin',
                'ConfigDir'=>'[APP_ADDONS_PATH]Smarty/config',
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
                )
        twig : Twig引擎配置项
            默认值:
                array(
                'template_path'=>'[VIEW_PATH][THEME_NAME]',//or array(path1,$path2,...)
                'cache'=>false,
                'cache_path'=>'[COMPILE_PATH]',
                'debug'=>false,
                'charset'=>'UTF-8',
                'autoescape'=>'html',
                'optimizations'=>-1
                )
###核心Server配置
    目前支持服务列表位于 FRAME_PATH.'Core/Server' 目录
    
    <<<配置示例>>>
    
    Cache:    缓存
        default:    默认值
            默认值: LAEMemcache
        laememcache: 配置项
            默认值:
            array(
                'group'=>'[APP_NAME][APP_VERSION]',
                'expire'=>3600,/* 缓存时间 */
                'compress'=>1,/* 是否压缩存储 */
                'servers'=>array(
                    'host'=>'127.0.0.1',
                    'port'=>11211
                )
            )