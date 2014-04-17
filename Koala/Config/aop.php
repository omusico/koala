<?php
return array(
	array(
        'event'	    => 'before',
        'point'     => array('class'=>'Controller\Home\Index2', 'method'=>'index'),
        'advice'    => array('class'=>'Core\AOP\Advice\Log', 'method'=>'before'),
    )
);