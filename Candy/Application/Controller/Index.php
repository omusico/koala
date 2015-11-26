<?php
/**
 * KoalaCMS - A PHP CMS System In Koala FrameWork
 *
 * @package  KoalaCMS
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Controller;
use Koala\Server\Controller\Base as ControllerBase;

class Index extends ControllerBase {
	public function index() {
		echo '<a href="index.php?s=Oapi-qqLogin">qq_login</a><br>';
		echo '<a href="index.php?s=Oapi-weiboLogin">weibo_login</a><br>';
		echo '<a href="index.php?s=Oapi-txweiboLogin">tx_weibo_login</a><br>';
		exit;
	}
}