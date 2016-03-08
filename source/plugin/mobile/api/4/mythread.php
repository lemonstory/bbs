<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: mythread.php 34314 2014-02-20 01:04:24Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'guide';
$_GET['view'] = 'my';
include_once 'forum.php';

class mobile_api {

	function common() {

		//修改:可以查看别人(或自己)的主贴
		global $_G;
		if(!empty($_GET['uid'])) {
			$_G['uid'] = $_GET['uid'];
		}
	}

	function output() {
		global $_G;

		$data['forumnames'] = $GLOBALS['data']['my']['forumnames'];
                $data['threadcount'] = $GLOBALS['data']['my']['threadcount'];
                $data['threadlist'] = $GLOBALS['data']['my']['threadlist'];
		
		$variable = array(
			'globals'=>$GLOBALS['data'],
			'data' => $data,
			'perpage' => $GLOBALS['perpage'],
		);
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>
