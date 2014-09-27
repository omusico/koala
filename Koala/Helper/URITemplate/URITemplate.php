<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Helper;
/**
 * URI Template Library For Php
 *
 * $o = Helper\URITemplate::factory('http://{host}{/segments*}/{file}{.extensions*}');
 * # This will give: http://www.host.com/path/to/a/file.x.y
 * $res = $o->expand(array('host'=>'www.host.com','segments'=>['path','to','a'],'file'=>'file','extensions'=>['x','y']));
 * print_r($res);
 */
class URITemplate {
	/**
	 * 服务驱动实例数组
	 * @var array
	 * @static
	 * @access protected
	 */
	protected static $instances = array();
	//已实现的处理类
	var $class = array(
		1 => 'Helper\URITemplate\Drive\RFC6570',
		//2=> 'Helper\URITemplate\Drive\COLON'
	);
	//@see resolve_class
	var $type = array(
		'DEAFULT' => 'RFC6570',
		'RFC6570' => 'RFC6570',
		'COLON'   => 'COLON',
	);
	/**
	 * 服务实例化函数
	 *
	 * @param  string $name    驱动名
	 * @param  array  $options 驱动构造参数
	 * @static
	 * @return object          驱动实例
	 */
	public static function factory() {
		list($tclass, $rest) = call_user_func_array(array(new static , 'resolve_class'), func_get_args());
		//本来参照ruby *$rest的方式，将数组值作为函数参数
		//这里没有好的方式传递参数，只有将数组本身作为参数了..
		if (!isset(self::$instances[$tclass])) {
			self::$instances[$tclass] = new $tclass($rest);
		}
		return self::$instances[$tclass];
	}
	/**
	 *	决定处理方式
	 *
	 * @return array 处理参数
	 */
	public function resolve_class() {
		//参数分组
		$args = func_get_args();
		foreach ($args as $key => $value) {
			if (array_key_exists($value, $this->type)) {
				$symbols[] = $value;
			} else {
				$rest[] = $value;
			}
		}
		//返回处理类名和uri模板
		return array($this->class[$this->type[array_shift($symbols) ?  : $this->type['DEAFULT']]], $rest);
	}
}