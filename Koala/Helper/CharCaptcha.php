<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Helper;
/**
 * 字符验证码类
 * $c = new CharCaptcha();
 *	$c->make();
 *	echo $c->getCode();
 *	$this->outImg();
 */
class CharCaptcha {
	private $charset = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ23456789';//随机因子
	private $code;//验证码
	private $codelen = 4;//验证码长度
	private $width = 130;//宽度
	private $height = 50;//高度
	private $img;//图形资源句柄
	private $font = '';//指定的字体
	private $fontsize = 20;//指定字体大小
	private $fontcolor;//指定字体颜色
	private $snow = 80;//背景雪花数量
	private $line = 3;//干扰线数量
	private $padding = 3;//图片内边距
	//构造方法初始化
	public function __construct() {}
	//对外生成
	public function make() {
		$this->createBG();
		$this->createCode();
		$this->snowflake();
		$this->createLine();
		$this->createFont();
	}
	//创建图片背景
	private function createBG() {
		$this->img = imagecreatetruecolor($this->width, $this->height);
		$color = imagecolorallocate($this->img, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
		imagefilledrectangle($this->img, 0, $this->height, $this->width, 0, $color);
	}
	//生成验证码
	private function createCode() {
		$_len = strlen($this->charset) - 1;
		for ($i = 0; $i < $this->codelen; $i++) {
			$this->code .= $this->charset[mt_rand(0, $_len)];
		}
	}
	//打雪花
	private function snowflake() {
		for ($i = 0; $i < $this->snow; $i++) {
			$color = imagecolorallocate($this->img, mt_rand(150, 230), mt_rand(150, 230), mt_rand(150, 230));
			imagechar($this->img, 1, mt_rand(0, $this->width), mt_rand(0, $this->height), "*", $color);
			imagecolordeallocate($this->img, $color);
		}
	}
	//画干扰线
	private function createLine() {
		for ($i = 0; $i < $this->line; $i++) {
			$x1 = mt_rand(2, $this->width * 0.2);
			$x2 = mt_rand($this->width * 0.8, $this->width - 2);
			$y1 = mt_rand(2, $this->height - 2);
			$y2 = mt_rand(2, $this->height - 2);
			$color = imagecolorallocate($this->img, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
			imageline($this->img, $x1, $y1, $x2, $y2, $color);
			imagecolordeallocate($this->img, $color);
		}
	}
	//使用内置字体画字符
	private function createFont() {
		$code = $this->code;
		$eachW = $this->width / strlen($code);//图片依据字符个数分配等份数
		$fontWidth = imagefontwidth(5);//取得字体宽度
		$fontHeight = imagefontheight(5);//取得字体高度
		for ($i = 0; $i < strlen($code); $i++) {
			$color = imagecolorallocate($this->img, mt_rand(30, 155), mt_rand(30, 155), mt_rand(30, 150));
			$x = mt_rand($eachW * $i, $eachW * ($i + 1) - $fontWidth);
			$y = mt_rand(3, $this->height - $fontHeight);
			imagechar($this->img, 5, $x, $y, $code{ $i}, $color);//水平画字符
			imagecolordeallocate($this->img, $color);
		}
	}
	//使用外置字体画字符
	//$this->font = dirname(__FILE__).'/font/elephant.ttf';//注意字体路径要写对，否则显示不了图片
	private function createFromFont($font = '') {
		if (!isset($font)) {
			return false;
		} else {
			$this->font = $font;
		}
		//画字符
		$code = $this->code;
		$eachW = $this->width / strlen($code);//图片依据字符个数分配等份数
		$codeArray = str_split($code);
		for ($i = 0; $i < count($codeArray); $i++) {
			//取得字符宽高
			$fontbox = imagettfbbox($this->fontsize, 0, $this->font, $codeArray[$i]);
			$fontWidth = $fontbox[2]-$fontbox[0];
			$fontHeight = $fontbox[1]-$fontbox[7];

			$this->fontcolor = imagecolorallocate($this->img, mt_rand(30, 155), mt_rand(30, 155), mt_rand(30, 150));//字符颜色
			$angle = mt_rand(-20, 20);//字符角度
			if ($i == 0) {
				$start = $eachW * $i + $this->padding;
				$end = $eachW * ($i + 1) - $fontWidth;
			} elseif ($i == count($codeArray)) {
				$start = $eachW * $i;
				$end = $eachW * ($i + 1) - $fontWidth - $this->padding;
			} else {
				$start = $eachW * $i;
				$end = $eachW * ($i + 1) - $fontWidth - $this->padding;
			}
			$x = $start < $end ? mt_rand($start, $end) : $start;
			$y = ($fontHeight + $this->padding) > $this->height ? $this->padding : mt_rand($fontHeight + $this->padding, $this->height - $this->padding);
			imagettftext($this->img, $this->fontsize, $angle, $x, $y, $this->fontcolor, $font, $codeArray[$i]);//用 TrueType 字体向图像写入文本
			imagecolordeallocate($this->img, $this->fontcolor);
		}
	}
	//获取验证码
	public function getCode() {
		return strtolower($this->code);
	}
	//输出图片
	public function outImg() {
		ob_start();
		ob_clean();
		if (imagetypes()&IMG_JPG) {
			header('Content-type:image/jpeg');
			imagejpeg($this->img);
		} elseif (imagetypes()&IMG_GIF) {
			header('Content-type: image/gif');
			imagegif($this->img);
		} elseif (imagetype()&IMG_PNG) {
			header('Content-type: image/png');
			imagepng($this->img);
		} else {
			die("Don't support image type!");
		}
		imagedestroy($this->img);
	}
}