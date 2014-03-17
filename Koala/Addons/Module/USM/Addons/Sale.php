<?php
/**
 * 销量业务逻辑
 */
class USM_Addons_Sale extends Base_Addons{
	
	public function before(){
		return array('code'=>1,'msg'=>'完成销量业务处理');
	}
	public function after(){
		return;
		//获取数据
		$data =USM_Biz::getRet('USM_Addons_CartData->before');
		$sale = $data['ext']['sale'];
		//更新销量
        foreach ($sale as $type => $value) {
            foreach ($value as $id => $data) {
                $pro['id']=$id;
                switch ($type) {
                    case 'baseliquor':
                        $res= \USM_Logic_Baseliquor::getById($pro['id']);
                        $pro['sellnum'] = $res['sellnum']+$data['num'];
                        $status=\USM_Logic_Baseliquor::update($pro);
                        break;
                    default:
                        $res= \USM_Logic_Product::getById($pro['id']);
                        $pro['sellnum'] = $res['sellnum']+$data['num'];
                        $status=\USM_Logic_Product::update($pro);
                        break;
                }
            }
        }
		return array('code'=>1,'msg'=>'完成销量业务处理');
	}
}