<?php
namespace Server;
interface Interf{
	/**
	 * 获取服务类名
	 * @param  string $type 服务类型(小写)
	 * @return string       服务驱动类名
	 */
    static function getServerName($type);
}