<?php
//模块逻辑基类
//TODO remove
class Base_Logic{
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
     * 获得列表
     * @param  string  $fields 需要获得的字段
     * @param  string/array  $where  条件
     * @param  integer $num    记录数
     * @param  integer $start  开始位置偏移
     * @param  string  $order  排序字段
     * @return array           二维数据数组
     */
    public static function getList($fields='*',$where='',$order='id desc',$start=0,$num=10){
    	$model = static::getModel();
    	$obj = new $model();
        return $obj->getList($fields,$where,$order,$start,$num);
    }
	//数据行
	public static function getOne($fields='*',$where=''){
		$model = static::getModel();
        $obj = new $model();
        return $obj->getOne($fields,$where);
    }
    public static function getById($id,$fields='*'){
		$model = static::getModel();
        $obj = new $model();
        return $obj->getById($id,$fields);
    }
	//更新单个数据组
    public static function update($data=array()){
    	$model = static::getModel();
    	$obj = new $model();
    	if($obj->update($data)){
    		return array('code'=>1,'msg'=>'更新成功');
    	}
    	return array('code'=>1,'msg'=>'更新失败');
    }
    //添加单个数据组
    public static function add($data=array()){
    	$model = static::getModel();
    	$obj = new $model();
		if($id = $obj->add($data)){
			return array('code'=>1,'msg'=>'添加成功','ext'=>array('id'=>$id));
		}
		return array('code'=>0,'msg'=>'添加失败');
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
            return array('code'=>1,'msg'=>'更新成功');
        }
        return array('code'=>0,'msg'=>'更新失败');
	}
}