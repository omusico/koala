Spell类说明
==========
资源文件说明
----
    1、位于DATA_PATH.'word/'目录下
    2、文件列表
        -gk2-1.txt  gbk编码的gbk/2:GB2312汉字区(拼音排序段)汉字表
        
        -gk2-2.txt  gbk编码的gbk/2:GB2312汉字区(非拼音排序段)汉字表
        -gk2-2-1.txt gbk编码的gbk/2:GB2312汉字区(非拼音排序段)汉字首字母分组表
        
        -gk3.txt gbk编码的gbk/3扩展汉字区汉字表
        -gk3-1.txt gbk编码的gbk/3汉字首字母分组表
        
        -gk4.txt gbk编码的gbk/4扩展汉字区汉字表
        -gk4-1.txt gbk编码的gbk/4汉字首字母分组表
        
        -pos.txt gbk/2:GB2312(非拼音序),gbk/3,gbk/4按拼音首字母分组的区域位置描述json串
####生成说明
######pos.txt文件
    foreach ($this->source as $type => $str) {
    	$s = explode("\r\n",$str);
		$num=0;
		foreach ($s as $key => $value) {
			$this->pos[$type][] = $num;
			$len = strlen($value);
			$num = $num+$len;
		}
	}
	file_put_contents(DATA_PATH.'word/pos.txt',json_encode($this->pos));exit;