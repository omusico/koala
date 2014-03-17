使用[FIS](http://fis.baidu.com/)来管理资源示例
===============
简要说明
---------------
    -FIS是百度提供的用于管理前端资源的解决方案
    -参考 [官方网站](http://fis.baidu.com/)

#####生成fis-cfg.js配置文件
    文件init/build-fis.php中是有关生成fis的数据
    对标准json_encode的数据经过处理后就可以使用了
    注意：数据配置项请参考FIS的相关内容
####FIS基本使用示例
#####fis release -d ./Release
    依据fis-cfg.js中的配置将资源发布到Release目录下
    该项操作会生成map.json文件，该文件非常重要,模板解析时将会使用到该文件
#####fis release --watch -d ./Release
    监听变动并发布到Release目录下
######fis release --md5 --pack -d ./Release
    hash化打包并发布到Release目录
####注意：要使用fis的功能模板开发时需要知道'
    -body,head,html标签使用smarty delimiter包含
    -在需要引用资源的地方使用require,widget,script的fis-smarty-plugin函数
    -fis根据这些函数收集资源然后处理
####模板示例
    {%html class="expanded"%}
    {%head%}
    <meta charset="utf-8"/>
    <meta content="{%$description%}" name="description">
    <title>{%$title%}</title>
    <!--[if lt IE 9]>
        <script src="/lib/js/html5.js"></script>
    <![endif]-->
    -<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    {%require name="lib/css/bootstrap.css"%}
    {%require name="lib/css/bootstrap-responsive.css"%}
    {%require name="lib/js/mod.js"%}
    {%require name="lib/js/jquery-1.10.1.js"%}
    {%/head%}
    {%body%}
    <div id="wrapper">
        <div id="sidebar">
            {%widget
                name="widget/sidebar/sidebar.tpl"
                data=$docs
            %}
        </div>
        <div id="container">
            {%widget name="widget/slogan/slogan.tpl"%}
            {%foreach $docs as $index=>$doc%}
                {%widget
                    name="widget/section/section.tpl"
                    call="section"
                    data=$doc index=$index
                %}
            {%/foreach%}
        </div>
    </div>
    {%require name="page/index.css"%}
    {%script%}var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F70b541fe48dd916f7163051b0ce5a0e3' type='text/javascript'%3E%3C/script%3E"));{%/script%}
    {%/body%}
    {%/html%}
####模板目录结构示例
    lib
        js
        css
    widget
        siebar
    page
        index.css