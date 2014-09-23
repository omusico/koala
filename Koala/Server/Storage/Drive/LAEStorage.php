<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Storage\Drive;
use Koala\Server\Storage\Base;

/**
 * 非云计算环境下的Storage驱动
 * 所有文件名使用相对于数据存储区域的路径
 */
final class LAEStorage extends Base {
	//数据存储区
	var $bucket = '';
	//构造函数
	final public function __construct() {
		$this->bucket = STOR_PATH;
	}
	//向文件写入内容
	final public function write($file, $content, $mode = 0) {
		$file = $this->bucket . $file;
		!is_dir(dirname($file)) && mkdir(dirname($file), 0777, true);
		return file_put_contents($file, $content, $mode);
	}
	//从文件读取内容
	final public function read($file) {
		$file = $this->bucket . $file;
		return file_get_contents($file);
	}
	//上传某个文件
	final public function upload($tmpfile, $file) {
		$file = $this->bucket . $file;
		!is_dir(dirname($file)) && mkdir(dirname($file), 0777, true);
		return copy($tmpfile, $file);
	}
	//复制某个文件
	final public function copy($fromfile, $tofile) {
		$fromfile = $this->bucket . $fromfile;
		$tofile   = $this->bucket . $tofile;
		!is_dir(dirname($tofile)) && mkdir(dirname($tofile), 0777, true);
		return copy($fromfile, $tofile);
	}
	//删除某个文件
	final public function delete($file) {
		return unlink($file);
	}
	//移除某个路径
	final public function remove($path) {
		$path = $this->bucket . $path;
		if (is_dir($path)) {
			$handle = @opendir($path);
			while (($file = @readdir($handle)) !== false) {
				if ($file != "." && $file != "..") {
					$dir = $path . "/" . $file;
					is_dir($dir) ? self::remove(str_replace($this->bucket, '', $dir)) : @unlink($dir);
				}
			}
			closedir($handle);
			return rmdir($path);
		} else {
			return unlink($path);
		}
	}
	//获得某个文件的url
	final public function getUrl($file) {
		$file = $this->bucket . $file;
		return str_replace(STOR_PATH, STOR_URL, $file);
	}
	//检查某个文件是否存在
	final public function fileExists($file) {
		$file = $this->bucket . $file;
		return file_exists($file);
	}
	//建立一个目录//建立多级目录
	final public function mkdir($path) {
		$path = $this->bucket . $path;
		return mkdir($path, 0777, true);
	}
	//获得某个路径文件列表
	final public function getList($path, &$files = array()) {
		$path = $this->bucket . $path;
		if (!is_dir($path)) {return null;
		}

		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				$newpath = $path . '/' . $file;
				if (is_dir($newpath)) {
					self::getList(str_replace($this->bucket, '', $newpath), $files);
				} else {
					$files[] = str_replace($this->bucket, '', $newpath);
				}
			}
		}
		return $files;
	}
	//获取指定路径文件
	final public function getListByPath($path) {
		$path = $this->bucket . $path;

		if (!is_dir($path) || !file_exists($path)) {
			$slist['fileNum'] = 0;
			return $slist;
		}
		$file_list = array();
		$dirNum    = $fileNum    = 0;
		$dirs      = $files      = array();
		if ($handle = opendir($path)) {
			$i = 0;
			while (false !== ($filename = readdir($handle))) {
				if ($filename{0} == '.') {continue;
				}

				$file = $path . $filename;
				if (is_dir($file)) {
					$dirNum++;
					$dirs[] = array(
						'name'       => $filename,
						'fullName'   => str_replace($this->bucket, '', $file),
						'uploadTime' => filemtime($file),
						'length'     => 0,
					);
				} else {
					$fileNum++;
					$files[] = array(
						'Name'       => $filename,
						'fullName'   => str_replace($this->bucket, '', $file),
						'uploadTime' => filemtime($file),
						'length'     => filesize($file)
					);
				}
			}
			closedir($handle);
		}
		$file_list = array('dirs' => $dirs, 'files' => $files, 'dirNum' => $dirNum, 'fileNum' => $fileNum);
		return $file_list;
	}
	//从文件读取内容到数组
	final public function read2Arr($file) {
		$file = $this->bucket . $file;
		return file($file);
	}
	//重命名一个文件
	final public function rename($file, $newfile) {}
	//获得某个前缀的文件列表
	final public function getListBypf($prefix = '') {}
	//获得某个文件的属性
	final public function getFileAttr($file, $attr = array()) {}

	//----------另外的方法----------
	//设置当前访问的数据存储路径,使用绝对路径
	public function setArea($path) {
		$this->bucket = $path;
	}
	//引入文件
	final public function import($file) {
		$file = $this->bucket . $file;
		return include ($file);
	}
}