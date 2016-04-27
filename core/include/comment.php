<?php
/**
 * 添加评论
 * @param int $aid 文章ID
 * @param string $content  评论内容
 * @param string $username 用户名
 * @param ind $uid 用户ID
 */
function SaveComment($aid,$content,$username,$uid)
{
	global $DB,$timestamp,$onlineip,$hostid;
	$sql='INSERT INTO `'.DB_PREFIX."comment` (`hostid`,`articleid`,`userid`,`username`,`dateline`,`content`,`ipaddress`) VALUES ('$hostid', '$aid', '$uid', '$username', '$timestamp', '$content', '$onlineip')";
	$DB->query($sql);
	$DB->query('UPDATE `'.DB_PREFIX."article` SET `comments` = comments + 1, `dateline` = dateline+1 WHERE `aid` = $aid AND `hostid` = $hostid");
	$DB->query('UPDATE `'.DB_PREFIX."user` SET `lastpost` = $timestamp WHERE `uid` = $uid AND `hostid` = $hostid");//更新最后发表评论时间
}

/**
 * 获取评论
 * @param unknown $page 
 * @return multitype:unknown
 */
function getAllComment($page)
{
	global $hostid,$host,$DB;
	$pagenum = $host['article_comment_num'];
	$start_limit = ($page - 1) * $pagenum;
	$cmtorder = $host['comment_order'] ? 'ASC' : 'DESC';
	$sql = 'SELECT c.dateline as commentdate ,c.username,c.userid,c.content,a.* FROM `'.DB_PREFIX."comment` c,".DB_PREFIX."article a WHERE c.visible='1' AND c.articleid=a.aid AND a.hostid = $hostid ORDER BY `cid` DESC LIMIT $start_limit,$pagenum";
	$commentdb =array();
	$query=$DB->query($sql);
	while($comment=$DB->fetch_array($query))
	{
		$comment['commentdate']=date($host['time_comment_format'], $comment['commentdate']);
		$comment=showArticle($comment);
		$commentdb[]=$comment;
	}
	return $commentdb;
}
/*
 * 针对单独页面的评论,后续功能，一定要加上
 */

