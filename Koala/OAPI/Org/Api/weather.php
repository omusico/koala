<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 国家气象局提供的天气预报接口
 * 接口地址：
 * http://www.weather.com.cn/data/sk/101010100.html
 * http://www.weather.com.cn/data/cityinfo/101010100.html
 * http://m.weather.com.cn/data/101010100.html
 */
/**
 * get_weather_info  api
 */
$cfg['get_weather_info'] = array(
	'url'=>'http://m.weather.com.cn/data',
	'urltpl'=>'/{cityid}.html',
	'method'=>'get',
	'commonParam'=> array(),
	'requestParam'=>array('cityid'),
	);
return $cfg;