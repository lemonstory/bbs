<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('forumdisplay');?><?php include template('common/header'); ?><!-- header start -->
<header class="header">
<a href="forum.php?forumlist=1" class="back icon"></a>
<a class="y post icon" href="forum.php?mod=post&amp;action=newthread&amp;fid=<?php echo $_G['fid'];?>"></a>
    <?php if($subexists && $_G['page'] == 1) { ?>
        <span class="display name" href="#subname_list"> <?php echo strip_tags($_G['forum']['name']) ? strip_tags($_G['forum']['name']) : $_G['forum']['name'];?></span>
        <div id="subname_list" class="subname_list" display="true" style="display:none;">
            <ul>
            <?php if(is_array($sublist)) foreach($sublist as $sub) { ?>            <li>
                <a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $sub['fid'];?>"><?php echo $sub['name'];?></a>
            </li>
            <?php } ?>
            </ul>
        </div>
    <?php } else { ?>
        <span class="name"><?php echo strip_tags($_G['forum']['name']) ? strip_tags($_G['forum']['name']) : $_G['forum']['name'];?></span>
    <?php } ?>
</header>
<!-- header end -->

<?php if(!empty($_G['setting']['pluginhooks']['forumdisplay_top_mobile'])) echo $_G['setting']['pluginhooks']['forumdisplay_top_mobile'];?>

<?php if(!$subforumonly) { ?>
    <div class="threadlist">
        <ul>
            <?php if($_G['forum_threadcount']) { ?>
                <?php if(is_array($_G['forum_threadlist'])) foreach($_G['forum_threadlist'] as $key => $thread) { ?>                    <?php if(!$_G['setting']['mobile']['mobiledisplayorder3'] && $thread['displayorder'] > 0) { ?>
                        <?php continue;?>                    <?php } ?>
                    <?php if($thread['displayorder'] > 0 && !$displayorder_thread) { ?>
                        <?php $displayorder_thread = 1;?>                    <?php } ?>
                    <?php if($thread['moved']) { ?>
                        <?php $thread[tid]=$thread[closed];?>                    <?php } ?>
                    <li>
                    	<a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;extra=<?php echo $extra;?>" <?php echo $thread['highlight'];?> >
                    		<?php if(!empty($_G['setting']['pluginhooks']['forumdisplay_thread_mobile'][$key])) echo $_G['setting']['pluginhooks']['forumdisplay_thread_mobile'][$key];?>
                    		<div class="td-tit">
                            	<i class="icon <?php if(in_array($thread['displayorder'], array(1, 2, 3, 4))) { ?>icon_top<?php } elseif($thread['digest'] > 0) { ?>icon_digest<?php } elseif($thread['attachment'] == 2 && $_G['setting']['mobile']['mobilesimpletype'] == 0) { ?>icon_tu<?php } else { ?>icon_floder<?php } ?>"></i>
                            	<?php echo $thread['subject'];?>
                            </div>
                    		<div class="td-info cl">
                            	<span class="z"><?php echo $thread['author'];?>&nbsp;-&nbsp;<?php echo $thread['dateline'];?></span>
                                <span class="y"><?php echo $thread['replies'];?>&nbsp;/&nbsp;<?php echo $thread['views'];?></span>
                            </div>
                    	</a>
                    </li>
                <?php } ?>
            <?php } else { ?>
                <li class="no">本版块或指定的范围内尚无主题</li>
            <?php } ?>
        </ul>
    </div>
    <?php echo $multipage;?>
<?php } ?>

<?php if(!empty($_G['setting']['pluginhooks']['forumdisplay_bottom_mobile'])) echo $_G['setting']['pluginhooks']['forumdisplay_bottom_mobile'];?>
<div class="pullrefresh" style="display:none;"></div><?php include template('common/footer'); ?>