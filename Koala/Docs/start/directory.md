#目录结构
----
###框架核心目录结构

<table>
    <tr>
        <td>目录/文件</td><td>说明</td>
    </tr>
    <tr>
        <td>Addons</td><td>框架附加库目录</td>
    </tr>
    <tr>
        <td>Config</td><td>框架默认惯例配置目录</td>
    </tr>
    <tr>
        <td>Core</td><td>框架核心目录</td>
    </tr>
    <tr>
        <td>Docs</td><td>框架开发手册目录</td>
    </tr>
    <tr>
        <td>Helper</td><td>框架小工具类库</td>
    </tr>
    <tr>
        <td>Initialise</td><td>框架初始化目录</td>
    </tr>
    <tr>
        <td>Source</td><td>框架静态资源目录</td>
    </tr>
    <tr>
        <td>Koala.php</td><td>框架空核心文件</td>
    </tr>
</table>
###应用目录结构(单应用模式)
    
    /
    App/                    应用目录
        Config/             应用配置目录
            LAEGlobal.user.php      表示应用自定义配置(优先级高于框架惯例配置,这里LAE表示非云环境)
        Controller          控制器目录
        Custom/             应用自实现类库
            Koala.php       应用级初始化文件(在首次运行时会生成该文件,开发者需要修改以满足实际情况)
        Language            应用语言包
        Module              应用逻辑模块
        Source              应用静态资源库
        View                模板目录
    Koala/                  框架目录
        /*参照上表*
    Runtime/                运行时写目录(最好所有写文件操作都到这里)
        Compile
        Storage
    index.php               应用入口