<?php
namespace Koala\Server\Image\Drive;
use Koala\Server\Image\Base;
/**
 * Image服务驱动
 * 
 * php最低支持版本5.4
 */
final class LAEImage extends Base{
	var $object = '';
	var $files = array();
	var $width = '';
	var $height = '';
	var $mode = \Koala\Server\Image\Mode::WIDTH;
	public function __construct(mixed $files){
		if(is_array($files)){
			foreach ($files as $key => $file) {
				$this->files[$key]['name']=$file;
				$this->files[$key]['ext'] = pathinfo($file)['extension'];
				$this->files[$key]=array_merge($this->files[$key],$this->getImgResource($file,$this->files[$key]['ext']));
			}
		}else{
			$this->files[] = 
			array(
				'name'=>$files,
				'ext'=>pathinfo($files)['extension']
				);
			$this->files[0]=array_merge($this->files[0],$this->getImgResource($file,$this->files[0]['ext']));
		}
	}
	public function setWidth(){
		$args = func_get_args();
		if(is_array($args[0])){
			$args = $args[0];
		}
		$this->width = $args;
		return $this;
	}
	public function setHeight(){
		$args = func_get_args();
		if(is_array($args[0])){
			$args = $args[0];
		}
		$this->height = $args;
		return $this;
	}
	public function thumb($mode=\Koala\Server\Image\Mode::WIDTH){
		$params=array();
		//宽度上下限
		if(($mode&\Koala\Server\Image\Mode::MAXWIDTH)
			&&($mode&\Koala\Server\Image\Mode::MINWIDTH)
			){
			$this->width = array_pad($this->width,2,0);
			sort($this->width);
			list($params['minwidth'],$params['maxwidth']) = $this->width;
		}elseif($mode&\Koala\Server\Image\Mode::MAXWIDTH){
			//宽度上限
			$params['maxwidth'] = $this->width[0];
		}elseif($mode&\Koala\Server\Image\Mode::MINWIDTH){
			//宽度下限
			$params['minwidth'] = $this->width[0];
		}
		//高度上下限
		if(($mode&\Koala\Server\Image\Mode::MAXHEIGHT)
			&&($mode&\Koala\Server\Image\Mode::MINHEIGHT)
			){
			$this->height = array_pad($this->height,2,0);
			sort($this->height);
			list($params['minheight'],$params['maxheight']) = $this->height;
		}elseif($mode&\Koala\Server\Image\Mode::MAXHEIGHT){
			//高度上限
			$params['maxheight'] = $this->height[0];
		}elseif($mode&\Koala\Server\Image\Mode::MINHEIGHT){
			//高度下限
			$params['minheight'] = $this->height[0];
		}
		//指定宽度
		if($mode&\Koala\Server\Image\Mode::WIDTH){
			$params['width'] = $this->width[0];
		}
		//指定高度
		if($mode&\Koala\Server\Image\Mode::HEIGHT){
			$params['height'] = $this->height[0];
		}
		$this->_thumb($params);
		return $this;
	}
	private function _thumb($params=array()){
		foreach ($this->files as $key => $file) {
			print_r($file);exit;
		}
	}
	private function getImgResource($filename,$ext){
		$attr = array();
		switch ($ext) {
			case 'jpg':
				$arr['resource'] = imagecreatefromjpeg($filename);
				$arr['size'] = getimagesize($filename);
				break;
			
			default:
				# code...
				break;
		}
		return $arr;
	}
}