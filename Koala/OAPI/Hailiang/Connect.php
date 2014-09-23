<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Hailiang;
use Koala\OAPI\Base;

/**
 * 海量云分词服务
 * http://home.hylanda.com/show_5_19.html
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Connect extends Base {
	/**
	 * 构造函数
	 */
	final public function __construct() {
		$this->cfg = include (__DIR__ . '/Api/hlsegment.php');
	}
	/**
	 * 获取token
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getToken($str = '');
	
	/**
	 * 获取xmldata
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getXmlData($str=''){
		$str = <<<EOT
<?xml version="1.0" encoding="UTF-8"?>
<Root>
	<Input>
		<Property Name="Uri">{$u}</Property>
		<Property Name="Title">{$title}</Property>
		<Property Name="Content">{$_GET['w']}</Property>
		<Property Name="Date">{$date}</Property>
	</Input>
	<ProcessList Template="">
		<Resource ID="1" Adapter="DA_hlsegment" OutputXml="true"  IgnoreFailed="true">
			<Param Name="Input" Value="Content" />
			<Param Name="Output" Value="HLSegToken" />
			<Param Name="CustomCalcSign" Value="POS_TAG" />
			<Param Name="OutputFieldSign" Value="" />
		</Resource>
		<Resource ID="2" Adapter="ClearSegmentProxy" OutputXml="false" IgnoreFailed="true" /> 
	</ProcessList>
</Root>
EOT; 
	return $str;
	}
}