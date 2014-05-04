<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   Lunnlew <Lunnlew@gmail.com>
 */
namespace Core\Front\Advice;
use Core\AOP\AdviceContainer;
use Core\AOP\LazyAdviceException;
/**
 * 前端数据输出的切面逻辑
 */
class FrontAdvice{
	/**
	 * 控制器方法后置逻辑
	 * @param  AdviceContainer $container
	 */
	function output(AdviceContainer $container){
		//已定义常量搜集
        $custom['const'] = get_defined_constants();
        \View::assign('Koala',$custom);
		if(\FrontData::get('showpage')!==true&&is_ajax()){
			if(\Front::getState()!==\Core\Front\MessageState::COMMON){
				echo \Front::getMsg();
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
			if(\Front::getState()===\Core\Front\MessageState::COMMON){
				\View::display($tpl);
			}elseif(\Front::getState()===\Core\Front\MessageState::ERROR){
				\View::error(\Front::getMsg());
			}elseif(\FrontData::getState()===\Core\Front\MessageState::SUCCESS){
				\View::success(\Front::getMsg());
			}elseif(\FrontData::getState()===\Core\Front\MessageState::INFO){
				\View::success(\Front::getMsg());
			}
			
		}
	}
}