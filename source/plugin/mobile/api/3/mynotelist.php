<?php
/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
*      This is NOT a freeware, use is subject to license terms
*
*      $Id: mynotelist.php 34236 2013-11-21 01:13:12Z nemohou $
*/

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'space';
$_GET['do'] = 'notice';
include_once 'home.php';

class mobile_api {
	function common() {

	}

	function output() {

		global $_G;
		$noticelang = lang('notification', 'reppost_noticeauthor');
		$noticepreg = '/^'.str_replace(array('\{actor\}', '\{subject\}', '\{tid\}', '\{pid\}'), array('(.+?)', '(.+?)', '(\d+)', '(\d+)'), preg_quote($noticelang, '/')).'$/';
		$actorlang = '<a href="home.php?mod=space&uid={actoruid}">{actorusername}</a>';
		$actorpreg = '/^'.str_replace(array('\{actoruid\}', '\{actorusername\}'), array('(\d+)', '(.+?)'), preg_quote($actorlang, '/')).'$/';


		foreach($GLOBALS['list'] as $_k => $_v) {
			if(preg_match($noticepreg, $_v['note'], $_r)) {
				list(, $actor, $tid, $pid, $subject) = $_r;
				if(preg_match($actorpreg, $actor, $_r)) {
					list(, $actoruid, $actorusername) = $_r;
				}

				//取出回帖的内容
				include_once libfile('function/forum');
				require_once libfile('function/discuzcode');
				loadforum(null, $tid);
				if($pid) {
					$postlist = $this->post = get_post_by_pid($pid, 'message');
					$GLOBALS['list'][$_k]['message'] = discuzcode($postlist['message']);
				}

				$GLOBALS['list'][$_k]['dateline'] = dgmdate($GLOBALS['list'][$_k]['dateline']);
				$GLOBALS['list'][$_k]['dbdateline'] = $GLOBALS['list'][$_k]['dateline'];
				$GLOBALS['list'][$_k]['notevar'] = array(
					//'fid' => $fid,
					'tid' => $tid,
					'pid' => $pid,
					'subject' => $subject,
					'actoruid' => $actoruid,
					'actorusername' => $actorusername,
				);
			}
		}
		$variable = array(
			'hash' => md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid']),
			'list' => mobile_core::getvalues(array_values($GLOBALS['list']), array('/^\d+$/'), array('id', 'uid', 'type', 'new', 'authorid', 'author', 'note', 'dateline', 'from_id', 'from_idtype', 'from_num', 'style', 'rowid', 'notevar','message')),
			'count' => $GLOBALS['count'],
			'perpage' => $GLOBALS['perpage'],
			'page' => intval($GLOBALS['page']),

		);
		mobile_core::result(mobile_core::variable($variable));
	}
}
?>