<?php
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
/**
 * 用于支持云环境 写操作而继承覆盖的类
 */

class AEStreamHandler extends StreamHandler {
	/**
	 * @param string  $stream
	 * @param integer $level  The minimum logging level at which this handler will be triggered
	 * @param Boolean $bubble Whether the messages that are handled can bubble up the stack or not
	 */
	public function __construct($stream, $level = Logger::DEBUG, $bubble = true) {
		parent::__construct($stream, $level, $bubble);
	}
	protected function write(array $record) {

		if (null === $this->stream) {
			if (!$this->url) {
				throw new \LogicException('Missing stream url, the stream can not be opened. This may be caused by a premature call to close().');
			}
			$this->errorMessage = null;
			set_error_handler(array($this, 'customErrorHandler'));
			switch (RUN_ENGINE) {
				case 'SAE':
					sae_set_display_errors(false);//关闭信息输出
					sae_debug((string) $record['formatted']);//记录日志
					sae_set_display_errors(true);
					break;
				default:
					//使用Storage只是测试,日志不合适使用Storage
					Koala\Server\Storage::factory()->setArea(LOG_PATH);
					if (!Koala\Server\Storage::factory()->write($this->url, (string) $record['formatted'], FILE_APPEND)) {
						exit('日志写入失败![msg=' . (string) $record['formatted'] . ']');
					}
					break;
			}
			restore_error_handler();
		}
	}
	private function customErrorHandler($code, $msg) {
		$this->errorMessage = preg_replace('{^fopen\(.*?\): }', '', $msg);
	}
}