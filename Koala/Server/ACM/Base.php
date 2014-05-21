<?php
namespace Koala\Server\ACM;
/**
 * 访问控制基类
 */
Abstract class Base{
	/**
	 * 验证方法
	 * @param  Object  $Operator      操作者对象
	 * @param  Object  $OperateMethod 操作方法对象
	 * @param  Object  $AccessObject  业务对象
	 * @return boolean                true/flase
	 */
	abstract public function isValidate(\Object $Operator,\Object $OperateMethod=null,\Object $AccessObject=null);
}