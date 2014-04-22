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
    )
);