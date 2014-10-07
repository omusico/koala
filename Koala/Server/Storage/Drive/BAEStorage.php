<?php
namespace Koala\Server\Storage\Drive;
use Koala\Server\Storage\Base;

//百度云存储
final class BAEStorage extends Base {
	var $bucket = 'imagefile';
	//云服务对象
	var $object = '';
	//构造函数
	public function __construct() {
		$this->object = new \BCS();
	}
	//向文件写入内容
	final public function write($file, $content) {
		$file = '/' . ltrim($file, '/');
		return $this->object->create_object_by_content($this->bucket, $file, $content);
	}
	//从文件读取内容
	final public function read($file) {}
	//上传某个文件
	final public function upload($tmpfile, $file) {
		$file = '/' . ltrim($file, '/');
		return $this->object->create_object($this->bucket, $file, $tmpfile);
	}
	//复制某个文件
	final public function copy($fromfile, $tofile) {}
	//删除某个文件
	final public function delete($file) {}
	//移除某个路径
	final public function remove($path) {}
	//获得某个路径文件列表
	final public function getList($path) {}
	//获得某个文件的url
	final public function getUrl($file) {
		$file = '/' . ltrim($file, '/');
		return $this->object->generate_get_object_url($this->bucket, $file);
	}
	//获取指定路径文件
	final public function getListByPath($path) {
		$path = '/' . ltrim($path, '/');
		$list = $this->object->list_object_by_dir($this->bucket, $path);
		$list = $list->body;
		$list = json_decode($list, true);
		$file_list = array();
		$dirNum = $fileNum = 0;
		foreach ($list['object_list'] as $key => $value) {
			if ($value['is_dir']) {
				$dirNum++;
				$dirs[] = array(
					'name' => basename($value['object']),
					'fullName' => $value['object'],
					'uploadTime' => $value['mdatetime'],
					'length' => 0,
				);
			} else {
				$fileNum++;
				$files[] = array(
					'Name' => $this->getUrl($value['object']),
					'fullName' => $value['object'],
					'uploadTime' => $value['mdatetime'],
					'length' => $value['size'],
				);
			}
		}
		$file_list = array('dirs' => $dirs, 'files' => $files, 'dirNum' => $dirNum, 'fileNum' => $fileNum);
		return $file_list;
	}
	//获得某个文件的属性
	final public function getFileAttr($file, $attr = array()) {}
	//检查某个文件是否存在
	final public function fileExists($file) {
		$file = '/' . ltrim($file, '/');
		return $this->object->is_object_exist($this->bucket, $file);
	}
	//创建目录(目前通过写入空白文件来达成)
	final public function mkdir($path) {
		$file = '/' . ltrim($path . '/index.html', '/');
		return $this->object->create_object_by_content($this->bucket, $file, '');
	}
	//重命名一个文件
	final public function rename($file, $newfile) {}
	//从文件读取内容到数组
	final public function read2Arr($file) {}
	//------------------------------
	//设置bucket
	final public function setArea($path) {
		$this->bucket = $path;
	}
	//引入文件
	final public function import($file) {
		$file = '/' . ltrim($file, '/');
		$resp = $this->object->get_object($this->bucket, $file);
		$content = $resp->body;
		if (!is_dir(dirname(TMP_PATH . $file))) {mkdir(dirname(TMP_PATH . $file));}
		file_put_contents(TMP_PATH . $file, $content);
		return include (TMP_PATH . '/' . $file);
	}
}