<?php
namespace Koala\Server\Storage\Drive;
use Koala\Server\Storage\Base;

/**
 * SAE的Storage驱动
 * 所有文件名使用相对于数据存储区域的路径
 *
 */
final class SAEStorage extends Base {
	//数据存储区
	var $bucket = 'image';
	//云服务对象
	var $object = '';
	public function __construct($_accessKey = '', $_secretKey = '') {
		$this->object = new \SaeStorage($_accessKey, $_secretKey);
	}

	//将数据写入存储
	final public function write($file, $content = '') {
		return $this->object->write($this->bucket, $file, $content);
	}
	//从文件读取内容
	final public function read($file) {
		return $this->object->read($this->bucket, $file);
	}
	//向某存储上传文件
	final public function upload($srcFile, $destFile) {
		return $this->object->upload($this->bucket, $destFile, $srcFile, array(), false);
	}
	//从文件复制
	final public function copy($fromfile, $tofile) {}

	//从存储删除文件
	final public function delete($file) {
		return $this->object->delete($this->bucket, $file);
	}
	//创建目录(目前通过写入空白文件来达成)
	final public function mkdir($path) {
		return $this->object->write($this->bucket, $path . '/index.html', '', -1, array(), false);
	}
	//移除目录
	final public function remove($path) {}
	//取得指定路径下文件列表
	final public function getList($path) {
		return $this->object->getList($this->bucket, $path);
	}
	//取得文件url
	final public function getUrl($file) {
		return $this->object->getUrl($this->bucket, $file);
	}
	//获得文件属性
	final public function getFileAttr($file, $attr = array()) {}

	//检查文件是否存在
	final public function fileExists($file) {
		return $this->object->fileExists($this->bucket, $file);
	}
	//重命名一个文件
	final public function rename($file, $newfile) {}
	//从文件读取内容到数组
	final public function read2Arr($file) {}
	//-------------------------------------------
	//获得prefix前缀文件列表
	final public function getListBypf($prefix) {
		return $this->object->getList($this->bucket, $prefix);
	}
	//取得指定路径下文件列表（不含子目录）
	final public function getListByPath($path) {
		$path = rtrim($path, '/');
		return $this->object->getListByPath($this->bucket, $path);
	}
	//设置bucket
	public function setArea($path) {
		$this->bucket = $path;
	}
	//设置文件属性
	final public function setFileAttr($file, $attr = array()) {
		return $this->object->setFileAttr($this->bucket, $file, $attr);
	}
	//设置bucket属性
	final public function setbucketAttr($attr = array()) {
		return $this->object->setbucketAttr($this->bucket, $attr);
	}
	//引入文件
	final public function import($file) {
		$content = $this->read($file);
		if (!is_dir(dirname(TMP_PATH . $file))) {mkdir(dirname(TMP_PATH . $file));}
		file_put_contents(TMP_PATH . $file, $content);
		return include (TMP_PATH . '/' . $file);
	}
}