<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: forumupload.php 34314 2014-02-20 01:04:24Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

define('APPTYPEID', 100);
define('CURSCRIPT', 'misc');

require './source/class/class_core.php';
$discuz = C::app();
$discuz->init_cron = false;
$discuz->init_session = false;
$discuz->init();

$_G['uid'] = intval($_POST['uid']);
if((empty($_G['uid']) && $_GET['operation'] != 'upload') || $_POST['hash'] != md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid'])) {
	//mobile_core::result(array('error' => 'param error'));
	var_dump($_G['uid']);
	var_dump($_GET['operation']);
	var_dump($_POST['hash']);
	var_dump(md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid']));
	exit();
} else {
	if($_G['uid']) {
		$_G['member'] = getuserbyuid($_G['uid']);
	}
	$_G['groupid'] = $_G['member']['groupid'];
	loadcache('usergroup_'.$_G['member']['groupid']);
	$_G['group'] = $_G['cache']['usergroup_'.$_G['member']['groupid']];
}
$a = $_FILES['Filedata']['name'];
$_FILES['Filedata']['name'] = diconv(urldecode($_FILES['Filedata']['name']), 'UTF-8');
$_FILES['Filedata']['type'] = $_GET['filetype'];
code $type, $attr) = getimagesize($_FILES['Filedata']['name']);

//$_FILES['Filedata']['name'] = sprintf("%s_%s_%s",$_FILES['Filedata']['name'],$width,$height);

$b = $_FILES['Filedata']['name'];

$forumattachextensions = '';
$fid = intval($_GET['fid']);
if($fid) {
	$forum = $fid != $_G['fid'] ? C::t('forum_forum')->fetch_info_by_fid($fid) : $_G['forum'];
	if($forum['status'] == 3 && $forum['level']) {
		$levelinfo = C::t('forum_grouplevel')->fetch($forum['level']);
		if($postpolicy = $levelinfo['postpolicy']) {
			$postpolicy = dunserialize($postpolicy);
			$forumattachextensions = $postpolicy['attachextensions'];
		}
	} else {
		$forumattachextensions = $forum['attachextensions'];
	}
	if($forumattachextensions) {
		$_G['group']['attachextensions'] = $forumattachextensions;
	}
}

class forum_upload_mobile extends forum_upload {

	function uploadmsg($statusid) {
		global $a,$b;
		$variable = array('a' => $a,'b' => $b,'code' => $statusid, 'ret' => array('aId' => $this->aid, 'image' => $this->attach['isimage'] ? 1 : 2));
		mobile_core::result(mobile_core::variable($variable));
	}

}

$upload = new forum_upload_mobile();

?>