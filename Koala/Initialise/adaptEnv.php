<?php
defined('IN_Koala') or exit();
Storage::factory()->setArea(STOR_PATH);
//搬移数据写目录
if(!Storage::factory()->fileExists('~runtime.php')){//
	//开始处理对云引擎的支持
	$dirlist = array();
	listDir(APP_PATH.'Config/',$dirlist,APP_PATH.'Config/','');
	foreach ($dirlist as $key => $value) {
		foreach ($value as $k => $v) {
			if(!Storage::factory()->fileExists($key.'/'.$v)){//不覆盖原始存在的文件
				Storage::factory()->upload(APP_PATH.'Config/'.$key.'/'.$v,$key.'/'.$v);
			}
		}
	}
	if(!Storage::factory()->fileExists('~runtime.php'))
		Storage::factory()->write('~runtime.php',"<?php\nreturn true;\n?>");
}
?>