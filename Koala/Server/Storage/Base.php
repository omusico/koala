<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Storage;
class Base implements Face {
	var $bucket;
	/**
	 * 向文件写入内容
	 * @param  string $file    文件
	 * @param  string $content 内容
	 * @return bool          true/false
	 */
	public function write($file, $content) {}
	/**
	 * 从文件读取内容
	 * @param  string $file 文件
	 * @return string       文件内容
	 */
	public function read($file) {}
	/**
	 * 上传某个文件
	 * @param  string $tmpfile 需要上传的文件
	 * @param  string $file    目标文件
	 * @return bool          true/false
	 */
	public function upload($tmpfile, $file) {}
	/**
	 * 复制某个文件
	 * @param  string $fromfile 源文件
	 * @param  string $tofile   目标文件
	 * @return bool          true/false
	 */
	public function copy($fromfile, $tofile) {}
	/**
	 * 删除某个文件
	 * @param  string $file 文件
	 * @return bool          true/false
	 */
	public function delete($file) {}
	/**
	 * 建立一个目录
	 * @param  string $path 路径
	 * @return bool       true/false
	 */
	public function mkdir($path) {}
	/**
	 * 移除某个路径
	 * @param  string $path 路径
	 * @return bool          true/false
	 */
	public function remove($path) {}
	/**
	 * 获得某个路径文件列表
	 * return array(
	 * array(
	 * 'name'=>'1.txt',
	 * 'fullName'=>'/path/to/1.txt',
	 * 'uploadTime'=>'121324242',
	 * 'size'=>1212,
	 * )
	 * )
	 * @param  string $path 路径
	 * @return array       文件列表
	 */
	public function getList($path) {}
	/**
	 * 获得某个文件的url
	 * @param  string $file 文件
	 * @return string       url
	 */
	public function getUrl($file) {}
	/**
	 * 获得某个文件的属性
	 * @param  string $file 文件
	 * @param  array  $attr 属性数组
	 * @return array       索引数组
	 */
	public function getFileAttr($file, $attr = array()) {}
	/**
	 * 检查某个文件是否存在
	 * @param  string $file 文件
	 * @return bool          true/false
	 */
	public function fileExists($file) {}
	/**
	 * 重命名一个文件
	 * @param  string $file 文件
	 * @param  string $newfile 文件
	 * @return bool          true/false
	 */
	public function rename($file, $newfile) {}
	/**
	 * 从文件读取内容到数组
	 * @param  string $file 文件
	 * @return array       数组
	 */
	public function read2Arr($file) {}
}