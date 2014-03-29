<?php
namespace Plugin\TagCloud;
use Plugin;
/**
 * 插件实现类
 */
class Action{
    protected $name ='TagCloud';
    protected $smallest = 8;//定义标签的最小字号，默认为 8
    protected $largest = 22;//定义标签的最大字号，默认为 22
    protected $unit = 'pt';//设置字号类型，如 “pt” 或 “px” 等，默认为 “pt” 类型
    protected $number = 45;//设置标签云数量，默认显示 45 个标签
    protected $orderby = 'name';//设置按 “name” 或 “count” 排序，默认为 “name” 方式
    protected $order = 'ASC';//设置按 “DESC” 或 “ASC” 升降序排列，默认为 “ASC” 升序
    protected $format ='float';//显示方式 “list” 或 “float” 默认“float”
    protected $outer_label = array(//外围标签
        '[ATAG]',
        '<li>[ATAG]</li>',
        );
    protected $apply_color = 1;//1字体彩色,2背景彩色,3
    protected $tag_style_id = 1;//样式id
	//解析函数的参数是pluginManager的引用
    function __construct($plugin){
        //注册这个插件
        //第一个参数是钩子的名称
        //第二个参数是plugin类的引用
        //第三个是插件所执行的方法
        if($plugin!='')
            $plugin->register('TagCloud', array($this, 'getTagCloud'),array('tag'));

    }
    /**
     * 获得标签云
     * @param  string $tag_id 标签云id
     * @return string         标签云串
     */
    function getTagCloud($tag_id='tag'){
        $cache = \Cache::Factory('memcache');
        $tag = new \AppCache_TagCloud($cache,'',$this->name);
        $tag_arr = $tag->getTagCloud($tag_id);
        if(is_string($tag_arr))
            $tag_arr = json_decode(base64_decode($tag_arr),true);

        $tags = self::makeTagCloud($tag_arr);
        echo join( "\n", $tags) . "\n";
    }
    /**
     * 生成标签云
     * @param  array  $data        标签数组array(array('tagname'=>'num'))
     * @param  string $minFontSize 字体大小最小值
     * @param  string $maxFontSize 字体大小最大值
     * @return array               标签云数组
     */
    function makeTagCloud($data = array(), $minFontSize = '', $maxFontSize = ''){
        if($minFontSize!=''&&is_numeric($minFontSize)){
            $this->smallest = $minFontSize;
        }
        if($maxFontSize!=''&&is_numeric($maxFontSize)){
            $this->largest = $maxFontSize;
        }
        $minimumCount = min( array_values( $data ) );
        $maximumCount = max( array_values( $data ) );
        $spread       = $maximumCount - $minimumCount;
        $cloudTags    = array();
        $spread == 0 && $spread = 1;
        foreach( $data as $tag => $count ){
            $size = $this->smallest + ( $count - $minimumCount )* ( $this->largest - $this->smallest ) / $spread;
            $tag=htmlspecialchars(stripslashes($tag));
            $fdata = array(
                'tag'=>$tag,
                'count'=>$count,
                'size'=>$size,
                'unit'=>$this->unit,
                );
            $style_filter = self::getStyleFilter($fdata);
            foreach ($style_filter['filter'] as $k => $v) {
                array_walk_recursive($style_filter['style'],"var_filter",array($v,$k));
            }

            $cloudTags[] = $style_filter['style'][0];
        }
    return $cloudTags;

    }
    /**
     * 标签云样式
     * @param  string $data 样式相关数据
     * @return array       样式数组
     */
    function getStyleFilter($data=''){
        if(!empty($data))
            extract($data);
        if($this->apply_color==1){
            $color = 'color:#[COLOR]';
        }else{
             $color = 'background-color:#[COLOR]';
        }
        switch ($this->tag_style_id){
            case 1:
                $filter = array(
                    'atag'=>'<a[REL][HREF][CLASS][STYLE][TITLE]>[TAG]</a>',
                    'href'=>' href="#"',
                    'style'=>' style="font-size:[SIZE]'.$unit.';'.$color.'"',
                    'rel'=>' rel="nofollow"',
                    'class'=>' class="tag_cloud"',
                    'title'=>' title="'.$tag.' returned a count of '.$count.'"',
                    'tag' => $tag,
                    'size' =>floor($size),
                    'color' => dechex(rand(0,16777215)),
                    );
                $style = array($this->outer_label[0]);
                break;
        }
        return array('filter'=>$filter,'style'=>$style);
        
    }
}
?>