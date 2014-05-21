<?php
return array(
	array(
        'event'	    => 'before',
        'point'     => array('class'=>'URL', 'method'=>'Assembler'),
        'advice'    => array('class'=>'Core\AOP\Advice\Url', 'method'=>'parseUrl'),
    ),
    array(
        'event'	    => 'before',
        'point'     => array('class'=>'URL', 'method'=>'Assembler'),
        'advice'    => array('class'=>'Core\AOP\Advice\Url', 'method'=>'parseVar'),
    ),
    array(
        'event'	    => 'before',
        'point'     => array('class'=>'URL', 'method'=>'Assembler'),
        'advice'    => array('class'=>'Core\AOP\Advice\Url', 'method'=>'parseSuffix'),
    ),
    array(
        'event'	    => 'after',
        'point'     => array('class'=>'URL', 'method'=>'Assembler'),
        'advice'    => array('class'=>'Core\AOP\Advice\Url', 'method'=>'redirect'),
    ),
    array(
        'event'     => 'after',
        'point'     => array('class'=>'Koala\Server\Dispatcher\Drive\Dispatcher', 'method'=>'execute'),
        'advice'    => array('class'=>'Core\Front\Advice\FrontAdvice', 'method'=>'output'),
    )
);