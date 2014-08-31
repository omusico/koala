<?php
return array(
	array(
		'event' => 'after',
		'point' => array('class' => 'Koala\Server\Dispatcher\Drive\Dispatcher', 'method' => 'execute'),
		'advice'                 => array('class' => 'Core\Front\Advice\FrontAdvice', 'method' => 'output'),
	)
);