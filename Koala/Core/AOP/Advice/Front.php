<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Core\AOP\Advice;
use Core\AOP\AdviceContainer;
use Core\AOP\LazyAdviceException;
/**
 * 前端数据输出
 */
class Front{
	function output(AdviceContainer $container){
		$rq = new \Request();
		if($rq->isAjax()){
			if(\FrontData::getAlert()!==-1){
				echo \FrontData::getMsg();
			}else{
				echo \FrontData::toJson();
			}
		}else{
			$data = \FrontData::getAll();
			$tpl='';
			if(isset($data['tpl'])){
				$tpl = $data['tpl'];
			}
			foreach ($data as $key => $value) {
				\View::assign($key,$value);
			}
			if(\FrontData::getAlert()===-1){
				\View::display($tpl);
			}elseif(\FrontData::getAlert()===0){
				\View::error(\FrontData::getMsg());
			}elseif(\FrontData::getAlert()===1){
				\View::success(\FrontData::getMsg());
			}elseif(\FrontData::getAlert()===3){
				\View::success(\FrontData::getMsg());
			}
			
		}
	}
}