	$o = \Koala\OAPI::factory('Qiniu\Img');
	$o->setPutPolicy('upload',
		array(
			'scope'    => 'cdnimg',
			'deadline' => time()+3600));
	echo $o->apply('upload',
		array(
			'key'  => 'test.jpg',
			'file' => '@test.jpg',
		)
	);