<?php
/**
 * KoalaCMS - A PHP CMS System In Koala FrameWork
 *
 * @package  KoalaCMS
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Controller;

class Member extends PublicController {
	public function indexAction($id, $title) {
		print_r(func_get_args());
		exit('indexAction');
	}
}