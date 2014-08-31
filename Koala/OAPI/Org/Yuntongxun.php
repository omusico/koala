<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Org;
use Koala\OAPI\Base;
/**
 * 云通讯平台REST API
 * TODO
 */
class Yuntongxun extends Base{
	protected $time;
	/**
	 * 构造函数
	 */
	final public function __construct(){
		
		$this->time = date("YmdHis");
		$this->cfg = include(__DIR__.'/Api/yuntongxun.php');
	}
	/**
	 * 魔术方法
	 * @param  string $method 方法名
	 * @param  array $args   方法参数
	 * @return mixed         返回值
	 */
	public function __call($method,$args){}
	/**
	 * 获取appid
	 * //20140805
	 * //注意请使用自己创建的应用的appid,平台提供的demo appID无效 
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppKey($str='');
	/**
	 * 获取appkey
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAppSecret($str='');
	/**
	 * 获取主AccountSid
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getAccountSid($str='');
	/**
	 * 获取主Token值
	 * @param  string $str [description]
	 * @return mixed
	 */
	abstract protected function _getToken($str='');
	/**
	 * sign
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getSign($str=''){
		// 大写的sig参数  帐户Id + 帐户taken + 时间戳。
		return  strtoupper(MD5($this->_getAccountSid().$this->_getToken().$this->time));
	}
	/**
	 * Authorization
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getAuthorization($str=''){
		// 生成授权：主帐户Id + 英文冒号 + 时间戳。
		return  base64_encode($this->_getAccountSid().':'.$this->time);
	}
	/**
	 * ContentType
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getContentType($str=''){
		if(isset($this->cfg[$this->name]['format'])&&$this->cfg[$this->name]['format']=='xml'){
			return 'application/xml;charset=utf-8';
		}else{
			return  'application/json;charset=utf-8';
		}
	}
	/**
	 * 从配置中解析出body参数
	 * @param  string $name api名
	 * @return array     	结果
	 */
	protected function _parseContentParams($name) {
		$params   = array();
		$paramCFG = $this->cfg[$name]['contentParam'];
		foreach ($paramCFG as $key => $value) {
			$params = array_merge($params, $this->_parseStr($value));
		}
		$this->cfg[$name]['contentParam'] = $params;
	}
	/**
	 * Content
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getContent($str=''){
		isset($this->cfg[$name]['contentParam'])
		? $this->_parseContentParams($name)
		: ($this->cfg[$name]['contentParam'] = array());
		$params = array_filter(array_merge($this->cfg[$this->name]['contentParam'],$this->params));
		foreach ($this->cfg[$this->name]['contentParam'] as $key => $value) {
			if(isset($params[$key]))
				$this->cfg[$this->name]['contentParam'][$key]= $params[$key];
		}
		if(isset($this->cfg[$this->name]['format'])&&$this->cfg[$this->name]['format']=='xml'){
			exit('TODO XML');
			return '';
		}else{
			if(!empty($this->cfg[$this->name]['contentParam'] ))
				return json_encode($this->cfg[$this->name]['contentParam'] );
			else
				return ;
		}
		
	}
	/**
	 * Content Length
	 * @param  string $str [description]
	 * @return mixed
	 */
	protected function _getLengthStr($str=''){
		if(empty($this->cfg[$this->name]['contentParam'] ))
			return  ($this->cfg[$this->name]['header'][] = $str.': 0');
		else
		return  ($this->cfg[$this->name]['header'][] = $str.': '.strlen(json_encode($this->cfg[$this->name]['contentParam'] )));
	}
	/**
	 * 从url侧获取数据的核心方法
	 * 
	 * 该方法以multipart/form-data方式编码数据
	 * 
	 * @param  string $name   api名
	 * @param  array  $params 请求参数
	 * @param  string $method 请求方法
	 * @return string         结果
	 */
	protected function _fetchUrl($name,$params=array(),$method='get'){

		$content = $params['content'];unset($params['content']);
		if($this->cfg[$name]['sub']){
			$urltpl = $this->cfg['api_base']['suburltpl'];
		}else{
			$urltpl = $this->cfg['api_base']['urltpl'];
		}
		foreach ($params as $key => $value) {
			$urltpl = str_replace('{'.$key.'}', $value, $urltpl);
		}

		//去除空值字段
		$params = array_filter($params);
		//有文件字段时，值必须是@开头的绝对路径
		//初始化curl
       		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt ( $ch, CURLOPT_HEADER, 0); 
		if(strtolower($method)=='get')
			curl_setopt($ch, CURLOPT_POST,0);
		else
			curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_URL, str_replace('/?', '?', $this->cfg['api_base']['url'].$urltpl));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $content ); 
		//以返回值方式
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $this->cfg[$name]['header']); 
		//执行并获取HTML文档内容
		$output = curl_exec($ch);
		//释放curl句柄
		curl_close($ch);
		return $output;
	}
}