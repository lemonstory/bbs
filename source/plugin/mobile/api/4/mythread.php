<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: mythread.php 34314 2014-02-20 01:04:24Z nemohou $
 */
error_reporting(E_ALL);

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'guide';
$_GET['view'] = 'my';
$_GET['filter'] = 'common';
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

		//帖子列表增加图片 -start
		require_once libfile('function/discuzcode');
		foreach($GLOBALS['data']['my']['threadlist'] as $k => $thread) {
			$post = C::t('forum_post')->fetch_threadpost_by_tid_invisible($GLOBALS['data']['my']['threadlist'][$k]['tid'],0);
			$attachment[$post['pid']] = array();
			$GLOBALS['data']['my']['threadlist'][$k]['pid'] = $post['pid'];
			//TODO:下面的代码直接调用discuzcode时,会报错
			//./source/plugin/mobile/template/discuzcode.htm 文件不存在
			//cp ./source/plugin/mobile/template/mobile/discuzcode.htm ./source/plugin/mobile/template/
			//拷贝一份就可以了,原因未查明
			$GLOBALS['data']['my']['threadlist'][$k]['message'] = discuzcode($post['message']);
			//附件,0无附件 1普通附件 2有图片附件
			if(!empty($post['attachment']) && intval($post['attachment']) == 2) {
				$GLOBALS['data']['my']['threadlist'][$k]['attachments'] = array();
				$GLOBALS['data']['my']['threadlist'][$k]['imagelist'] = array();
				require_once libfile('function/attachment');
				$_G['tid'] = $post['tid'];
				parseattach(array_keys($attachment),array(),$attachment);
				$GLOBALS['data']['my']['threadlist'][$k]['attachments'] = $attachment[$post['pid']]['attachments'];
				$GLOBALS['data']['my']['threadlist'][$k]['imagelist'] = $attachment[$post['pid']]['imagelist'];
				unset($_G['tid']);
			}
		}
		//帖子列表增加图片 -end
		$data['forumnames'] = $GLOBALS['data']['my']['forumnames'];
        $data['threadcount'] = $GLOBALS['data']['my']['threadcount'];
        $data['threadlist'] = array_values($GLOBALS['data']['my']['threadlist']);

		$variable = array(
			//'globals'=>$GLOBALS['data'],
			'data' => $data,
			'perpage' => $GLOBALS['perpage'],
		);
		mobile_core::result(mobile_core::variable($variable));
	}
}

?>
