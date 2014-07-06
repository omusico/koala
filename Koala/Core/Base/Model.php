<?php
//模块实体基类
class Base_Model extends ActiveModel{
	//获得模型类
	public static function getModel(){
		$class = str_replace('Logic', 'Model',get_called_class());
        $class::$tpr = C('DB_PREFIX');
        return $class;
	}
    /**
     * 是否存在记录
     * @param  array  $where 查询条件
     * @return boolean       true/false
     */
    public static function isExist($where){
        $model = static::getModel();
        $obj = $model::count(
            array('conditions' =>$where)
            );
        if($obj){
            return array('code'=>1,'msg'=>'存在');
        }
        return array('code'=>0,'msg'=>'不存在');
    }
    //数据列表
    public static function getData($pagesize=20,$pageid=1,$fields='*',$where='',$order='id DESC',$style='Badoo'){
        $model = static::getModel();
        $page = new Helper_Pagination($model::count(array('conditions' =>$where)),$pagesize,$pageid);
        //获取数据
        $page->setSourceCall("$model::getPagin",array($fields,$where,$order));
        //分页模板目录
        $page->setTemplateDir(WIDGET_PATH.'pagination/');
        //设置分页样式
        $page->setTemplate($style);
        return $page;
    }
	/**
     * 供分页类的回调函数
     * @param  integer $start  偏移
     * @param  integer $size   条数
     * @param  string  $fileds 字段
     * @param  string  $order  排序
     */
    public static function getPagin($start=0,$size=1,$fileds='id',$where='',$order='id DESC'){
    	$model = static::getModel();
        $objlist=$model::find('all',
            array(
                'conditions'=>$where,
                'select' => $fileds,
                'order' => $order,
                'offset'=>$start,
                'limit'=>$size
            ));
        return self::conv2arr($objlist);
    }
	/**
     * 获得列表
     * @param  string  $fileds 需要获得的字段
     * @param  string/array  $where  条件
     * @param  integer $num    记录数
     * @param  integer $start  开始位置偏移
     * @param  string  $order  排序字段
     * @return array           二维数据数组
     */
    public  function getList($fileds='*',$where='',$order='id DESC',$start=0,$num=10){
        $model = static::getModel();
        $objlist=$model::find('all',
            array(
                "conditions" => $where,
                'select' => $fileds,
                'order' => $order,
                'offset'=>$start,
                'limit'=>$num,
            ));
        return self::conv2arr($objlist);
    }
     /**
     * 获得一条
     * @param  string $id     id
     * @param  string $fileds 字段
     * @return array          一维数据数组
     */
    public  function getById($id,$fileds='*',$where=''){
    	$model = static::getModel();
        $map = array(
                'select' => $fileds,
                "conditions" => $where
            );
        if($where==''){
            unset($map['conditions']);
        }
        $obj = $model::find($id,$map);        
        return $obj->to_array();
    }
	public  function getOne($fileds='*',$where=''){
        $model = static::getModel();
        $objlist=$model::find('all',
            array(
                "conditions" => $where,
                'select' => $fileds,
            ));
        $obj = array_shift($objlist);
        if(!is_object($obj)){
            return null;
        }
        return $obj->to_array();
    }
	/**
     * 添加
     * @param array $data 内容
     */
    public  function add($data=array()){
    	$model = static::getModel();
        $obj = new $model($data);
        $obj->save();
        return $obj->id;
    }
	/**
     * 删除
     * @param  string $id id
     */
    public  function delById($id){
        $model = static::getModel();
        $obj = $model::find($id);
        return $obj->delete();
    }
     /**
     * 更新
     * 必须在data中包含主键id
     * @param  array $data 数据
     */
    public  function update($data=array()){
    	$model = static::getModel();
        $obj = new $model($data,true,false,false);
        return $obj->save();
    }
    //批量删除数据
    public static function deleteAll($where){
        $model = static::getModel();
        if($model::delete_all(array('conditions'=>$where))){
            return array('code'=>1,'msg'=>'删除成功');
        }
        return array('code'=>0,'msg'=>'删除失败');
    }
    //批量更新数据
    public static function updateAll($data,$where){
        $model = static::getModel();
        if($model::update_all(array('set'=>$data,'conditions'=>$where))){
            return array('code'=>1,'msg'=>'删除成功');
        }
        return array('code'=>0,'msg'=>'删除失败');
    }
}