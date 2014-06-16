<?php
/**
 * KoalaCMS - A PHP CMS System In Koala FrameWork
 *
 * @package  KoalaCMS
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Server\Image\Drive;
use Koala\Server\Image\Base;
/**
 * SAE Image服务驱动
 * @final
 */
final class SAEImage extends Base{
	/**
	 * 包含相关处理信息的数组
	 * @var array
	 */
	protected $infos = array();
	/**
	 * 允许的图片格式
	 * @var array
	 */
	protected $exts = array('gif','jpeg','png','wbmp','webp','xbm','xpm');
	/**
	 * 文件名重命名 匿名函数
	 * @var string
	 */
	protected $namecall = '';
	/**
	 * 某个画布
	 * @var source/bool
	 */
	protected $canvas = false;
	/**
	 * 构造函数
	 * @param array $files 要处理的图片列表
	 */
	public function __construct(array $files = array()){
		//名称生成方式
		$this->namecall = function($name){
			return 'Other/'.$name.'-'.md5($name);
		};
		//设置文件信息
		foreach ($files as $key => $file) {
			//写入临时文件获取文件名
            $f = new \SaeFetchurl();
            $filename = tempnam(SAE_TMP_PATH, "SAE_IMAGE");
            $data = $f->fetch(str_replace(' ','%20',$file));
            if(!file_put_contents($filename, $data)) {
                continue;
            }
			//取得文件的大小信息
			if(false !== ($this->infos[$file] = getimagesize($filename))){
				//取得扩展名
				//支持格式 see http://www.php.net/manual/zh/function.exif-imagetype.php
				$this->infos[$file]['ext'] = image_type_to_extension(exif_imagetype($filename),0);
				$this->infos[$file]['data'] = $data;
				//如果不在允许的图片类型范围内
				if(!in_array($this->infos[$file]['ext'],$this->exts)){
					unset($this->infos[$file]);
				}
			}else{
				//如果获取信息失败则取消设置
				unset($this->infos[$file]);
			}
		}
	}
	/**
	 * 缩放
	 * @param  int    $width  缩略图宽度
	 * @param  int    $height 缩略图高度
	 * @return
	 */
	public function thumb($width=0,$height=0){
		foreach ($this->infos as $name => $info){
			//返回预处理的大小参数
			extract($this->_getSizes($width,$height,$info[0],$info[1]),EXTR_OVERWRITE);
			//设置画布资源
			$this->setCanvas($dst_w,$dst_h);

			if($this->canvas!==false){
				//支持格式 gif,jpeg,png,wbmp,webp,xbm,xpm
				imagecopyresampled($this->canvas,call_user_func('imagecreatefrom'.$info['ext'],$name),
					0,0,0,0,
					$dst_w,$dst_h,$info[0],$info[1]
					);
				//保存图片资源
				$this->infos[$name]['dst'] = $this->canvas;
			}
		}
		$this->canvas=false;
		return $this;
	}
	//剪裁
	public function crop(){}
	//旋转
	public function rotate(){}
	//透明
	public function transparent(){}
	//锐化
	public function sharpen(){}
	/**
	 * 设置画布资源
	 * @param  int $width 画布宽度
	 * @param  int $height 画布高度
	 * @param  integer $color_red   red部分
	 * @param  integer $color_green green部分
	 * @param  integer $color_blue  blue部分
	 */
	public function setCanvas(int $width,int $height,$color_red=255,$color_green=255,$color_blue=255){
		//新建一个真彩色图像
		$this->canvas = imagecreatetruecolor($width,$height);
		//设置透明
		($this->canvas!==false)&&imagefill($this->canvas,0,0,imagecolortransparent($this->canvas,imagecolorallocate($this->canvas,$color_red,$color_green,$color_blue)));

		return $this;
	}
	/**
	 * 在画布上写字
	 * putenv('GDFONTPATH='.realpath('.'));
	 * @param  string  $text        文本
	 * @param  int     $x           第一个字符的基本点（大概是字符的左下角）x坐标
	 * @param  int     $y           第一个字符的基本点（大概是字符的左下角）y坐标
	 * @param  integer $size        字体的尺寸。根据 GD 的版本，为像素尺寸（GD1）或点（磅）尺寸（GD2）。
	 * @param  string  $fontfile    是想要使用的 TrueType 字体的路径
	 * @param  integer $color_red   red部分
	 * @param  integer $color_green green部分
	 * @param  integer $color_blue  blue部分
	 * @return
	 */
	public function ttftext(string $text,int $x,int $y,$size=8,string $fontfile,$color_red=0,$color_green=0,$color_blue=0){
		if($this->canvas!==false){
			imagettftext($this->canvas,$size,0, $x, $y, imagecolorallocate($this->canvas,$color_red,$color_green,$color_blue) ,$fontfile, $text);
			$this->infos[$text] = array(
				'dst'=>$this->canvas,
				'ext'=>'png',
				'mime'=>'image/png'
				);
		}else{
			foreach ($this->infos as $name => $info){
				imagettftext($this->infos[$name]['dst'],$size,0, $x, $y, imagecolorallocate($this->infos[$name]['dst'],$color_red,$color_green,$color_blue) ,$fontfile, $text);
			}
		}
		return $this;
	}
	/**
	 * 设置文件名生成回调函数
	 * 
	 * @param Closure $func 生成文件名的回调函数
	 */
	public function setNameCall(Closure $func){
		//名称生成方式
		$this->namecall = $func;
		return $this;
	}
	//保存文件
	public function save($file_path='./'){

	}
	//输出
	public function output(){
		ob_start();
		ob_end_clean();
		$file = array_shift($this->infos);
		//header
		header('Content-Type: '.$file['mime']);
		$func = 'image'.$file['ext'];
		//输出图片
		$func($file['dst']);
		//销毁资源
		imagedestroy($file['dst']);
	}
	/**
	 * 获取修正后的缩略图大小参数
	 * 
	 * s:100*100 d:200*100
	 * $s_scale=1 $d_scale=2 $dst_w=100*(100/100)=100 $dst_x=(200-100)/2=50
	 * dst_x=50,dst_y=0,$dst_w=100,$dst_h=100,$s_w=100,$s_h=100
	 *
	 * s:200*100 d:100*100
	 * $s_scale=2 $d_scale=1 $dst_h=100*(100/200)=50 $dst_y=(100-100)/2=0
	 * dst_x=0,dst_y=25,$dst_w=100,$dst_h=50,$s_w=200,$s_h=100
	 * 
	 * @param  int    $d_w 缩略图宽度
	 * @param  int    $d_h 缩略图高度
	 * @param  int    $s_w 原图宽度
	 * @param  int    $s_h 原图高度
	 * @return array       缩略图大小与坐标参数数组
	 */
	protected function _getSizes(int $d_w,int $d_h,int $s_w,int $s_h){
		//$dst_x = $dst_y = 0;
		$dst_w = $d_w;
		$dst_h = $d_h;
		//目标图片比例
		$d_scale = $d_w / $d_h;
		//原图片比例
		$s_scale = $s_w / $s_h;
		//如果目标比例大
		if(($d_scale-$s_scale)>0){
			//以高度为准时目标宽度和x坐标为
			$dst_w = $s_w * ( $d_h / $s_h );
	        //$dst_x = ( $d_w - $dst_w ) / 2;
		}elseif (($d_scale-$s_scale)<0) {
			//以宽度为准时目标高度和y坐标为
	        $dst_h = $s_h * ( $d_w / $s_w );
	        //$dst_y = ( $d_h - $dst_h ) / 2;
	    }
		return array(
			'dst_w'=>$dst_w,'dst_h'=>$dst_h,
			/*'dst_x'=>$dst_x,'dst_y'=>$dst_y*/
			);
	}
}