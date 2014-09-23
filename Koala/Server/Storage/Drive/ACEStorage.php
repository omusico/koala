<?php
namespace Koala\Server\Storage\Drive;
use Koala\Server\Storage\Base;

/**
 * ACE的Storage驱动
 * 所有文件名使用相对于数据存储区域的路径
 *
 */
final class ACEStorage extends Base {
	//数据存储区
	var $bucket = 'image';
	//云服务对象
	var $object = '';
	public function __construct($_accessKey = '', $_secretKey = '') {
		$this->object = \OSSClient::factory(array(
			'AccessKeyId'     => $_accessKey,
			'AccessKeySecret' => $_secretKey,
		));
	}
	//将数据写入存储
	final public function write($file, $content = '', $size = '') {
		$param = array(
			'Bucket'  => $this->bucket,
			'Key'     => $file,
			'Content' => $content,
		);
		if ($content instanceof resource) {
			$param = array_merge($param, array('ContentLength' => $size));
		}
		return $this->object->putObject($param);
	}
	//从文件读取内容
	final public function read($file) {
		$object = $this->object->getObject(array(
			'Bucket' => $this->bucket,
			'Key'    => $file,
		));
		return (string) $object;
	}
	//向某存储上传文件
	final public function upload($srcFile, $destFile) {
	}
	//从存储删除文件
	final public function delete($file) {
		return $this->object->deleteObject(array(
			'Bucket' => $this->bucket,
			'Key'    => $file,
		));
	}
	//创建目录(目前通过写入空白文件来达成)
	final public function mkdir($path) {
	}
	//检查文件是否存在
	final public function fileExists($file) {
	}
	//取得文件url
	final public function getUrl($file) {
	}
	//获得prefix前缀文件列表
	final public function getListBypf($prefix) {
	}
	//取得指定路径下文件列表
	final public function getList($path) {}
	//重命名一个文件
	final public function rename($file, $newfile) {}
	//从文件读取内容到数组
	final public function read2Arr($file) {}
	//获得文件属性
	final public function getFileAttr($file, $attr = array()) {}
	//移除某个路径
	final public function remove($path) {}
	//从文件复制
	final public function copy($fromfile, $tofile) {}
	//-------------------------------------------
	//取得指定路径下文件列表（不含子目录）
	final public function getListByPath($path) {
	}
	//设置bucket
	public function setArea($path) {
	}
	//设置文件属性
	final public function setFileAttr($file, $attr = array()) {
	}
	//引入文件
	final public function import($file) {
	}
}