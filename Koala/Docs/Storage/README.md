Storage使用示例
===============
简要说明
---------------
    - Storage类,位于Library/Server/Storage.php,基准目录由Drive目录[SAE|BAE|(没有前缀)]Storage类参数$storage_area控制.
    - 文件路径是以该基准目录为起点的相对路径
        - file.txt => 最终会生成 $storage_area."file.txt"的绝对路径
        - data/myfile/2013/file.txt => 最终会生成 $storage_area."data/myfile/2013/file.txt"的绝对路径
    - 对于非云环境,Storage使用的数据写目录由$storage_area=STOR_PATH参数控制
    - 对于云环境,,Storage使用的数据写目录由$storage_area='Domain'(for SAE)参数控制
    - 目前对SAE有较完善支持,BAE也可以使用基础功能


#####写文件
    $ret = Storage::write('myfile.txt','这是我的文件内容');
#####读取文件
    echo Storage::read('myfile.txt');
#####上传文件
    $ret = Storage::upload('fromfile.txt','tofile.txt');
#####复制文件
    $ret = Storage::copy('fromfile.txt','tofile.txt');
#####删除文件
    $ret = Storage::delete('myfile.txt');
####获得文件url
    $ret = Storage::getUrl('/path/to/myfile.txt');
####检查文件是否存在
    $ret = Storage::fileExists('/path/to/myfile.txt');
####建立路径
    $ret = Storage::mkdir('/path/to/'); 
####移除路径
    $ret = Storage::remove('/path/to/');
####获得文件列表(包含子目录)
    $ret = Storage::getList('/path/to/');
####获得指定目录文件列表(不含子目录)
    $ret = Storage::getListByPath('/path/to/');
####读取文件到数组
    $ret = Storage::read2Arr('/path/to/myfile.txt');
####重命名文件
    $ret = Storage::rename('/path/to/oldname','/path/to/newname');
####获得文件属性
    $ret = Storage::getFileAttr('/path/to/myfile');
####设置文件属性
    $ret = Storage::setFileAttr('/path/to/myfile');
####以及其他函数(不稳定或者非通用)
    -import,setArea
注意
-------
    -下面的函数在云环境下尚未实现
    -包括 copy,remove,rename,read2Arr,getFileAttr