<?php
defined('IN_KOALA') or exit();
/**
 * 分页类
 * ===> $this->styleDir/$this->styleName/style.css
 * ===> $this->styleDir/$this->styleName/style.php
 * ===> $this->styleDir/$this->styleName/container.php
 * 
 * //使用示例
 * $page = new Pagination(Article::getItemNum(),20,intval($_GET['pageid']));
 * //设置数据
 * $page->setSourceCall('Article::getPagin',array('id,title,des,time'));
 * //设置分页样式
 * $page->setTemplate('default');
 * //组装分页数据
 * $page->makePagination('http://www.domain.com/article/showlist/');
 * View::assign('pagination',$page->pagin);
 * View::assign('pagStyle',$page->geStyleUrl(WIDGET_URL));
 * View::assign('artlist',$page->data);
 * View::assign('cpageid',$page->currentPageId);
 * View::assign('pageNum',$page->pageNums);
 * 
 */
class Helper_Pagination{
	//------------核心参数
	//当前分页id
	var $currentPageId = 1;
	//当前总记录数
	var $itemNums = 0;
	//分页大小
	var $pageSize = 10;
	//当前总页数
	var $pageNums = 1;
	//------------样式参数
	//分页类的样式目录
	var $styleDir = "pagination/";
	//当前分页样式名
	var $styleName = 'default';
	//分页容器
	protected $container = array(
		'page'=>'<div class="pagination">%s</div>',
		'jump'=>'<select class="span1" onchange="location.href=this.options[this.selectedIndex].value">%s</select>',
		);
	//-------------显示参数
	//分页条元素数
	var $length = 7;//包括上3页,当前页,下3页
	//url地址
	protected $commonurl = '';
	//用于前端显示的参数表
	protected $param = array();
	//显示元素//部位名( -> _makeFirst,...)  =>部位模板名
	protected $show = array(
		'First'=>'first_last',//第一页
		'Prev'=>'prev',//上一页
		'PrevNum'=>'link',//上几页
		'Current'=>'current',//当前页
		'NextNum'=>'link',//下几页
		'Next'=>'next',//下一页
		'Last'=>'first_last',//最后页
		'Jump'=>'jump',
		);
	//默认模板
	protected $defaultTemplate = array(
		'first_last'=>'<a href="%s%s" title="%s" data-pjax=".content-body">%s</a>',
		'prev'=>'<a href="%s%s" title="%s" class="prev" data-pjax=".content-body">%s</a>',
		'next'=>'<a href="%s%s" title="%s" class="next" data-pjax=".content-body">%s</a>',
		'link'=>'<a href="%s%s" title="%s" data-pjax=".content-body">%s</a>',
		'current'=>'<span title="%s" class="current">%s</span>',
		'jump'=>'<option value="%s" %s>%s</option>',
		);
	//----------------处理数据
	//页面id变量参数
	var $varPageid= 'pageid';
	//当前页的数据
	var $data = array();
	//当前分页条
	var $pagin = '';
	
	/**
	 * 构造函数
	 * @param integer $total  总记录数
	 * @param integer $size   分页大小
	 * @param integer $pageid 当前页id
	 * @param array   $param  前端额外参数
	 */
	public function __construct($total=0,$size=1,$pageid=1,$param=array()){
		//总记录数
		$this->itemNums = $total;
		//分页大小
		$this->pageSize = $size;
		//计算页数
		$this->pageNums = ceil($total/$size);
		//当前页id
		$this->currentPageId = min(max(1,$pageid),$this->pageNums);
		//额外参数
		$this->param = $param;
	}
	//设置样式目录
	public function setTemplateDir($dir='pagination'){
		$this->styleDir = $dir;
	}
	//设置样式名
	public function setTemplate($name='default'){
		$this->styleName = $name;
	}
	//增加前端参数
	public function addParam($key,$value){
		$this->param[$key]=$value;
	}
	//设置前端参数值
	public function setParam($key,$value){
		if(isset($this->param[$key])){
			$this->param[$key]=$value;
		}
	}
	//设置数据资源
	public function setSource($array,$attr='data'){
		$this->$attr = $array;
	}
	/**
	 * 设置数据回调函数,并设置数据
	 * 
	 * $callback = 'class::method'  => class::method($param[0],$param[1],...)
	 * $callback = 'func'  => func($param[0],$param[1],...)
	 * $callback = array($instance,'method')  => $instance->method($param[0],$param[1],...)
	 * 
	 * //回调函数第一个参数必须是$startOffet 
	 * //回调函数第二个参数必须是分页面大小$pagesize
	 * //其他参数跟随在后(当然参数可视具体情况使用)
	 * 
	 * //=>>limit $startOffet,$pagesize
	 * 
	 * // ===>  sql= sql . limit $param[0],$param[1]
	 * 
	 * @param string/array $callback 回调
	 * @param array $param     回调函数的额外参数
	 * @param  string attr 要设置的属性值
	 * @param  int $cover 1合并,2重设值
	 * @param string $delimiter 分隔符
	 */
	public function setSourceCall($callback,$param=array(),$attr='data',$cover=1,$delimiter='::'){
		//
		if(!isset($this->$attr)){
			$this->$attr = array();
		}
		//将参数合并
		array_unshift($param,(max(($this->currentPageId-1),0))*$this->pageSize,$this->pageSize);
		if(is_string($callback))//支持func,class::method
			$call = explode($delimiter,$callback);
		else if(is_array($callback))//支持array(func),array(instance,method)
			$call = $callback;
		switch (count($call)) {
			case 1:
				$data = call_user_func_array($call[0],$param);
				break;
			case 2:
			default:
				$data = call_user_func_array(array($call[0],$call[1]),$param);
				break;
		}
		//注意:强制转化为array
		if($cover==1)$this->$attr=array_merge((array)$this->$attr,(array)$data);
		else
			$this->$attr=$data;
	}
	/**
	 * 生成分页条
	 * @param  string $baseurl  
	 * @param  string $callback 用于生成url的回调函数
	 */
	function makePagination($baseurl='',$callback=''){
		self::_makeBsaeUrl($baseurl,$callback);
		self::_makePaginationData();
		return $this->pagin;
	}
	//处理分页数据
	protected function _makePaginationData(){
		$this->container  = $this->getContainer();
		$templates = $this->getTemplate();
		foreach ($this->show as $item => $value) {
			$method = '_make'.$item;
			$pageData[$item] = self::$method($templates[$value]);
		}
		$this->pagin = sprintf($this->container['page'],implode('',$pageData));
	}
	/**
	 * 生成基本url
	 * @param  string $baseurl  url
	 * @param  string $callback 用于生成url的回调函数
	 * @return string           
	 */
	protected function _makeBsaeUrl($baseurl,$callback=''){
		if(!empty($callback)&&is_callable($callback)){
			$param = array_push($this->param,$this->varPageid);
			$this->commonurl = call_user_func_array($callback,array($baseurl,$param));
		}else{
			//其他参数
			$this->commonurl = sprintf("%s",$baseurl.http_build_query($this->param));
			//保证顺序为pageid=$pageid
			$this->commonurl .= "&".$this->varPageid."=";
		}
		return $this->commonurl;
	}
	//第一页
	protected function _makeFirst($tempalte){
		$args = func_get_args();
		array_push($args,$this->commonurl,1,'第一页','第一页');
		return call_user_func_array('sprintf',$args);
	}
	//上一页
	protected function _makePrev($tempalte){
		$args=func_get_args();
		array_push($args,$this->commonurl,max(1,$this->currentPageId-1),'上一页','上一页');
		return call_user_func_array('sprintf',$args);
	}
	//前几页
	protected function _makePrevNum($tempalte){
		$prevNum = $params = array();
		$num = floor($this->length/2);
		for($i=1;$i<=$num;$i++){
			$value = $this->currentPageId-$i;
			if($value<=0||$value>$this->currentPageId){//如果小于0或者大于当前页
				break;
			}
			array_unshift($params,$this->commonurl,$value,'第'.$value.'页',$value);
			array_unshift($prevNum,$tempalte);
		}
		array_unshift($params,implode('',$prevNum));
		return call_user_func_array('sprintf',$params);
	}
	//当前页
	protected function _makeCurrent($tempalte){
		$args = func_get_args();
		array_push($args,'第'.$this->currentPageId.'页',$this->currentPageId);
		return call_user_func_array('sprintf',$args);
	}
	//后几页
	protected function _makeNextNum($tempalte){
		$nextNum = $params = array();
		$num = floor($this->length/2);
		for($i=1;$i<=$num;$i++){
			$value = $this->currentPageId+$i;
			if($value>$this->pageNums){break;}//如果大于最大页数
			array_push($params,$this->commonurl,$value,'第'.$value.'页',$value);
			array_push($nextNum,$tempalte);
		}
		array_unshift($params,implode('',$nextNum));
		return call_user_func_array('sprintf',$params);
	}
	//下一页
	protected function _makeNext($tempalte){
		$args=func_get_args();
		array_push($args,$this->commonurl,min($this->currentPageId+1,$this->pageNums),'下一页','下一页');
		return call_user_func_array('sprintf',$args);
	}
	//最后页
	protected function _makeLast($tempalte){
		$args=func_get_args();
		array_push($args,$this->commonurl,$this->pageNums,'最后页','最后页');
		return call_user_func_array('sprintf',$args);
	}
	//跳转
	protected function _makeJump($tempalte){
		$jump = $params = array();
		for($i = 1; $i <= $this->pageNums; $i++){
			if($this->currentPageId == $i) $selected = " selected";
			else $selected = "";
	      	array_push($params,$this->commonurl.$i,$selected,$i);
	      	array_push($jump,$tempalte);
	    }
	    array_unshift($params,implode('',$jump));
		return sprintf($this->container['jump'],call_user_func_array('sprintf',$params));
	}
	//获取样式模版
	function getTemplate($name='style.php'){
		$filename = $this->styleDir.'/'.$this->styleName.'/'.$name;
		if(file_exists($filename)){
			$style = include_once($filename);
		}else{
			$style = $this->defaultTemplate;
		}
		return $style;
	}
	//获取容器模版
	function getContainer($name='container.php'){
		$filename = $this->styleDir.$this->styleName.'/'.$name;
		if(file_exists($filename)){
			$style = include_once($filename);
		}else{
			$style = $this->container;
		}
		return $style;
	}
	//返回样式url
	function geStyleUrl($styleUrl,$name='style.css'){
		return $styleUrl.$this->styleName.'/'.$name;
	}
}