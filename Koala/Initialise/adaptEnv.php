<?php
defined('IN_Koala') or exit();
Storage::setArea(STOR_PATH);
//搬移数据写目录
if(!Storage::fileExists('~runtime.php')){//
	//开始处理对云引擎的支持
	$dirlist = array();
	listDir(APP_PATH.'Config/',$dirlist,APP_PATH.'Config/','');
	foreach ($dirlist as $key => $value) {
		foreach ($value as $k => $v) {
			if(!Storage::fileExists($key.'/'.$v)){//不覆盖原始存在的文件
				Storage::upload(APP_PATH.'Config/'.$key.'/'.$v,$key.'/'.$v);
			}
		}
	}
	if(!Storage::fileExists('~runtime.php'))
		Storage::write('~runtime.php',"<?php\nreturn true;\n?>");
}
?>