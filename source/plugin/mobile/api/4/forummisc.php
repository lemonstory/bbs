<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forummisc.php 35103 2014-11-18 10:10:29Z nemohou $
 */
echo "11111";
if (!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}


$_GET['mod'] = 'misc';
include_once 'forum.php';
class mobile_api {

	function common() {
		echo "2222";
		if($_GET['t'] == 'common') {
			$variable = array();
			mobile_core::result(mobile_core::variable($variable));
		}
	}

	function output() {
		if($_GET['t'] == 'output') {
			$variable = array();
			mobile_core::result(mobile_core::variable($variable));
		}
	}

}

?>
