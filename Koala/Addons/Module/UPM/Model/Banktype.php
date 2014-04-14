<?php
/**
 * 银行类型
 */
class UPM_Model_Banktype extends ActiveModel{
	//主表
    static $table_name = 'banktype';
    /**
     * 获得列表
     * @param  string  $fileds 需要获得的字段
     * @param  string/array  $where  条件
     * @param  integer $num    记录数
     * @param  integer $start  开始位置偏移
     * @param  string  $order  排序字段
     * @return array           二维数据数组
     */
     public  function getList($fileds='*',$where='',$num=10,$start=0,$order='id DESC'){
        $objlist=UPM_Model_Banktype::find('all',
            array(
                "conditions" => $where,
                'select' => $fileds,
                'order' => $order,
                'offset'=>$start,
                'limit'=>$num,
            ));
        return self::conv2arr($objlist);
    }
}
?>