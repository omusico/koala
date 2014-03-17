fis-cfg.js文件生成说明
===============
简要说明
---------------
    - fis-cfg.js是FIS发布依据的重要文件
    - 生成该文件的脚本是build-fis.php

####生成处理步骤
    - 使用json_encode函数将配置数组转为json串
    - 取消json化的转义过程,使用stripslashes反转义
    - 去掉正则表达式两端的引号(似乎因为fis并不支持标准json解析)
        -  str_replace(array('"',"'/^","/i'"),array("'","/^","/i")，$str)
    - 写入fis-cfg.js文件
####配置说明
######详细配置项参考FIS官方站
####注意事项
    - 发布在子目录时(地址栏是'http://mydomain.com/app/'的情况)
        -如果不配置domain项,则必须修改相应的replease发布到根相对目录(服务器web目录到具体发布目录的路径)下
        -如果配置domain项,release项发布到应用相对路径(应用根目录到具体目录的路径)
        -但是pack项在前台查看源码时并没有加上绝对路径，所以不支持此种情况
    - 发布在根目录时(地址栏是'http://mydomain.com/',或者'http://app.mydomain.com/'的情况)
        - domain项不必须(链接其他域名资源的例外)
        - pack项可以正常使用配置