Counter使用示例
===============
简要说明
---------------
    - Counter类,位于Library/Server/Counter.php
    - 目前对SAE和BAE有较完善支持


#####建立一个计数器
    $ret = Counter::create('test',10,-1);
#####移除一个计数器
    $ret = Counter::remove('test');
#####设置计数器的值
    $ret = Counter::set('test',20);
#####获得计数器的值
    $ret = Counter::get('test');
#####获得多个计数器的值
    $ret = Counter::mget(array('test'));
#####设置多个计数器的值
    $ret = Counter::mset(array('test'=>10));
#####对计数器减
    $ret = Counter::decrease('test',2);
#####对计数器加
    $ret = Counter::increase('test',2);
#####获得所有计数器列表
    $ret = Counter::getAllList();
#####判断计数器是否存在
    $ret = Counter::isExist('test');
#####获得计数器数量
    $ret = Counter::getNums();

#####注意
    -因BAE没有mget,mget,getNums的原生方法,故进行了二次封装
    -SAE有mget而似乎没有mset原生方法法,故进行了二次封装