<?php
namespace Plugin\Focus;
use Plugin;
/**
 * 插件实现类
 */
class Action{
    protected $name = 'Focus';
    protected $focus_id = 1;//焦点图id
    protected $focus_style_id=1;//焦点图样式id
    protected $enable_arrow=1;//启用左右箭头
    protected $enable_contrl=0;//启用控制区
    protected $enable_contrl_smallpic = 1;//启用小图区
    protected $enable_contrl_btn = 0;//启用点按钮区
	//解析函数的参数是pluginManager的引用
    function __construct($plugin){
        //注册这个插件
        if($plugin!='')
            $plugin::register('focus',array($this, 'getFocus'),array('focus'));

    }

    function getFocus($focus_id='focus'){
        $cache = \Cache::Factory('memcache');
        $appcache = new \AppCache_Content($cache,'',$this->name);
        $arr = $appcache->getContent($focus_id);
        if(!$arr){
            //重新从数据库得到数据并设置新的memcached缓存
            $focus = array(
            array(
                'url'=>'#',
                'src'=>'http://www.17zixue.com/demo/17/images/42766101.jpg',
                'title'=>'测试',
                'id'=>1,
                ),
            array(
                'url'=>'#',
                'src'=>'http://www.17zixue.com/demo/17/images/42813100.jpg',
                'title'=>'测试',
                'id'=>2,
                ),
            );
            $tagstr = base64_encode(json_encode($focus));
            $appcache->setContent($focus_id,$tagstr);
            $arr = $tagstr;
        }
       // $arr=getContent($this->name,$focus_id);
        
        if(is_string($arr))
            $arr = json_decode(base64_decode($arr),true);

        $html = self::makeFocus($arr);
        echo $html;
    }
    function makeFocus($arr){
        foreach( $arr as $img ){
            $fdata = array(
                'url'=>$img['url'],
                'src'=>$img['src'],
                'title'=>$img['title'],
                'imgid'=>$img['id'],
                'thumbsrc'=>$img['src'],
                );
            $style_filter = self::getStyleFilter($fdata);
            foreach ($style_filter['filter'] as $k => $v) {
                array_walk_recursive($style_filter['style'],"var_filter",array($v,$k));
            }
            $html['img'][]=$style_filter['style'][0];//
            $html['thumbimg'][]=$style_filter['style'][1];//
        }
        $style_filter['filter']['imgdiv'] = implode('', $html['img']);
        $style_filter['filter']['thumbimgdiv'] = implode('', $html['thumbimg']);
        foreach ($style_filter['filter'] as $k => $v) {
            array_walk_recursive($style_filter['label_style'],"var_filter",array($v,$k));
        }
        return $style_filter['label_style'][0];
    }
    /**
     * 焦点图样式
     * @param  string $data 样式相关数据
     * @return array       样式数组
     */
    function getStyleFilter($data=''){
        if(!empty($data))
            extract($data);
        switch ($this->focus_style_id){
            case 1:
                $filter = array(
                    'focus'=>'[STYLE]<div class="focuswrap">[FOCUSAREA]</div>[JQ][JS]',
                    'focusarea'=>'<div id="focusarea">[BIGAREA][SMALLAREA]</div>',
                    'bigarea'=>'<div id="bigarea">[BTNPREV][IMGDIV][BTNNEXT]</div>',
                    'smallarea'=>'<div id="thumbs"><ul>[THUMBBTNPREV][THUMBIMGDIV][THUMBBTNNEXT]</ul></div>',
                    'imgdiv'=>'<div id=image_'.$imgid.'><a href='.$url.'><img src='.$src.' alt='.$title.'/></a>[TITLE]</div>',
                    'style'=>'<link rel="stylesheet" type="text/css" href="Addons/Plugin/Focus/style/focus.css">',
                    'title'=>'<div class="title"><h3>'.$title.'</h3></div>',
                    'jq'=>'<script type="text/javascript" src="Addons/Plugin/Focus/style/jq.js"></script>',
                    'js'=>'<script type="text/javascript" src="Addons/Plugin/Focus/style/focus.js"></script>',
                    );
                if($this->enable_arrow){
                    $filter['btnprev']='<p class="bigbtnPrev"><span id="big_play_prev"></span></p>';
                    $filter['btnnext']='<p class="bigbtnNext"><span id="big_play_next"></span></p>';
                }else{
                    $filter['btnprev']=$filter['btnnext']='';
                }
                if($this->enable_contrl&&$this->enable_contrl_smallpic){
                    $filter['thumbimgdiv']='<li class="slideshowItem"><a id="thumb_'.$imgid.'" href="#" class=""><img src='.$thumbsrc.' alt='.$title.' width="90" height="60"></a></li>';
                    $filter['thumbbtnprev']='<li class="first btnPrev"><img id="play_prev" src="Addons/Plugin/Focus/style/img/left.png"></li>';
                    $filter['thumbbtnnext']='<li class="last btnNext"><img id="play_next" src="Addons/Plugin/Focus/style/img/right.png"></li>';
                }else{
                    $filter['thumbimgdiv']=$filter['thumbbtnprev']=$filter['thumbbtnnext']='';
                }
                $label_style = array('[FOCUS]');
                $style = array('[IMGDIV]','[THUMBIMGDIV]');
                break;
        }
        return array('filter'=>$filter,'style'=>$style,'label_style'=>$label_style);
    }
        
}
?>