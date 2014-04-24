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
				echo \FrontData::toJosn();
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
			\View::display($tpl);
		}
	}
}