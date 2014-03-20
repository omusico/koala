<?php
class Engine_Smarty{
	public static function factory($option){
		foreach ($option as $key => $value) {
			if(is_string($value)){
				preg_match_all('/(?<=\[)([^\]]*?)(?=\])/',$value, $res);
		        foreach ($res[0] as $v) {
					$option[$key] = str_replace("[$v]",constant($v),$option[$key]);
		        }
		    }
		}
		$smarty =new Smarty();
		if(isset($option['TemplateDir']))
			$smarty->addTemplateDir($option['TemplateDir'],0);
		if(isset($option['CompileDir']))
			$smarty->setCompileDir($option['CompileDir']);
		if(isset($option['PluginDir']))
			$smarty->addPluginsDir($option['PluginDir'],0);
		if(isset($option['ConfigDir']))
			$smarty->setConfigDir($option['ConfigDir'],0);
		if(isset($option['debugging']))
			$smarty->debugging = $option['debugging'];
		if(isset($option['caching']))
			$smarty->caching = $option['caching'];
		else $smarty->caching = false;
		if(isset($option['cache_lifetime']))
			$smarty->cache_lifetime = $option['cache_lifetime'];
		if(isset($option['left_delimiter']))
			$smarty->left_delimiter = $option['left_delimiter'];
		if(isset($option['right_delimiter']))
			$smarty->right_delimiter = $option['right_delimiter'];
		if(isset($option['compile_locking']))
			$smarty->compile_locking = $option['compile_locking'];
		if(isset($option['plugins'])){
			if(isset($option['plugins']['function'])){
				foreach ($option['plugins']['function'] as $key => $value) {
					 $smarty->registerPlugin('function',$key,$value);
				}
			}
		}
		return $smarty;
	}
}
?>