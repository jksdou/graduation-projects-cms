<?php
/**
 * 数组数据格式化成可识别的内容
 * @param unknown $article
 * @return unknown
 */
function showArticle($article)
{
	global $host,$cateArr;
	$article['month']        = date('M', $article['dateline']);
	$article['day']          = date('d', $article['dateline']);
	$article['dateline']     = date($host['time_article_format'], $article['dateline']);
	$article['lastmodified'] = $article['modified']+(isset($article['comment'])?$article['comment']:0);
	$article['modified']     = date($host['time_article_format'], $article['modified']);
	$article['aurl']         = mkUrl('article.php',$article['url'],0);
	$article['curl']         = mkUrl('category.php',$cateArr[$article['cateid']]['url'],0);
	$article['attachments']  = $article['attachments'];
//	$article['thumb']        = mkUrl('attachment.php',$article['thumb']);
	return $article;
}

/**
 * 获取友情链接$num条
 */
function getLink($num=null)
{
	global $host;
	$linkarr = array();
	$linkarray = @include SYS_DATA.'/cache/links.php';
	if ($linkarray && is_array($linkarray) && isset($linkarray[$host['host']])) $linkarr = $linkarray[$host['host']];
	if ($num>0 && count($linkarr) > $num) $linkarr = array_slice($linkarr, 0, $num); 
	return $linkarr;
}

/**
 * 获取最新$num条$cateid分类的文章
 */
function getLatestArticle($num,$cateid=0)
{
	global $host;
	$articledb=$ids=array();
	$latestarray = @include SYS_DATA.'/cache/latest_'.$host['host'].'.php';
	if (!empty($latestarray)&&isset($latestarray['cateids'][$cateid]))
	{
		$aids=$latestarray['cateids'][$cateid];
		if (!empty($aids))
		{
			if (count($aids)>$num) $aids=array_slice($aids, 0, $num); 
			foreach($aids as $aid) $articledb[]=$latestarray['article'][$aid];
		}
	}
	return $articledb;
}

/**
 * 获取设置了预览图片的文章
 */
function getPicArticle($num)
{
	global $host;
	$picarray = @include SYS_DATA.'/cache/pic_'.$host['host'].'.php';
	if (!$picarray) $picarray=array();
	if ($num>0 && count($picarray) > $num) $picarray=array_slice($picarray, 0, $num); 
	return $picarray;
}

/**
 * 获取置顶的$num条$cateid分类文章
 */
function getStickArticle($num,$cateid=null)
{
	global $host,$DB;
	$stickdata=@include SYS_DATA.'/cache/stick_'.$host['host'].'.php';
	if (!$stickdata) $stickdata=array();
	$arrdata=array();
	if ($cateid==null) {
		$arrdata = $stickdata;
	}
	else {
		foreach($stickdata as $sdata) 	{
			if ($sdata['cateid']==$cateid) $arrdata[]=$sdata;
		}
		if (count($arrdata)<$num) //少于的话还是查询一下数据库为好
		{
			$arrdata=array();
			$files= $DB->query('SELECT * FROM `'.DB_PREFIX.'article` WHERE `stick` = 1 AND `hostid` ='.$host['hid']." AND `cateid` = $cateid AND `visible` = 1 ORDER BY `aid` DESC LIMIT $num");
			while ($fs = $DB->fetch_array($files)) 
			{
				unset($fs['content']);
				$arrdata[]=showArticle($fs);
			}
		}
	}
	if (count($arrdata)>$num) 
	{
		$arrdata=array_slice($arrdata, 0, $num);
	}
	return $arrdata;
}

/**
 * 获取最新的$num条$cateid分类文章评论
 */
function getLatestComment($num,$cateid=null)
{
	global $host;
	$commentdata=@include SYS_DATA.'/cache/comment_'.$host['host'].'.php';
	if (!$commentdata) $commentdata=array();
	if (count($commentdata)>$num) $commentdata=array_slice($commentdata, 0, $num); 
	return $commentdata;
}

/**
 * 获取热门文章
 */
function getHotArticle($num,$cateid=null)
{
	global $host,$DB;
	$hotdata=@include SYS_DATA.'/cache/hot_'.$host['host'].'.php';
	if (!$hotdata) $hotdata=array();
	$arrdata=array();
	if ($cateid==null)
	{
		$arrdata=$hotdata;
	}
	else
	{
		foreach($hotdata as $sdata)
		{
			if ($sdata['cateid']==$cateid) $arrdata[]=$sdata;
		}
		if (count($arrdata)<$num) //少于的话还是查询一下数据库为好
		{	
			$arrdata=array();
			$files= $DB->query('SELECT * FROM `'.DB_PREFIX.'article` WHERE hostid='.$host['hid']." AND cateid=$cateid AND visible=1 ORDER BY views desc  LIMIT $num");
			while ($fs = $DB->fetch_array($files)) 
			{
				unset($fs['content']);
				$arrdata[]=showArticle($fs);
			}
		}
	}
	if (count($arrdata)>$num) 
	{
		$arrdata=array_slice($arrdata, 0, $num);
	}
	return $arrdata;
}

/**
 * 获取相关文章
 */
function getRelatedArticle($aid,$tagarr,$num)
{
	global $DB,$hostid,$host;
	$articledb=array();
	$tag="'".implode("','",$tagarr)."'";
	$query=$DB->query('SELECT DISTINCT `articleid` FROM `'.DB_PREFIX."tag` WHERE `tag` IN ($tag) AND `articleid` != $aid");
	$aidarr=array();
	while($aq=$DB->fetch_array($query))
	{
		$aidarr[]=$aq['articleid'];
	}
	if (!empty($aidarr))
	{
		$aids=implode_ids($aidarr);
		$query=$DB->query('SELECT * FROM `'.DB_PREFIX."article` WHERE `hostid` = $hostid AND `aid` IN ($aids) AND `visible` = 1 ORDER BY rand() LIMIT $num");
		while($article=$DB->fetch_array($query))
		{
			$articledb[]=showArticle($article);
		}
	}	
	return $articledb;
}

/**
 * 获取某个分类的文章列表
 */
function getCateArticle($cateids,$page)
{
	global $DB,$hostid,$host,$cateArr;
	$pagenum = intval($host['list_shownum']);
	$start_LIMIT = ($page - 1) * $pagenum;
	$catesql = $cateids == 0 ? '' : " and `cateid` in ($cateids)";
	$sql = 'SELECT * FROM `'.DB_PREFIX."article` WHERE `hostid` = $hostid $catesql AND `visible` = 1 ORDER BY `aid` DESC LIMIT $start_LIMIT, $pagenum";//exit($sql);
	$articledb = array();
	$query = $DB -> query($sql);
	while($article = $DB -> fetch_array($query))
	{
		$articledb[] = showArticle($article);
	}
	return $articledb;
}

/**
 * 获取符合条件的文章，包含附件
 */
function getArticle($url)
{
	global $DB,$hostid,$host;
	$sql = "SELECT * FROM `".DB_PREFIX."article` a,`".DB_PREFIX."content` c WHERE `url` = '$url' AND `visible` = '1' AND `hostid` = $hostid AND a.aid = c.articleid LIMIT 1";
	$article=$DB->fetch_first($sql);
	if (!empty($article))
	{
		$article=showArticle($article);
		$articleid=$article['aid'];
		//处理附件
		if ($article['attachments'])  {
			$attachs = getAttachById($articleid);
			if (isset($attachs[$articleid]) && is_array($attachs[$articleid])) 
			{
				$article['attachments'] = array();
				foreach($attachs[$articleid] as $aid => $attach)
				{
					$article['attachments'][$aid] = $attach;
					$article['attachments'][$aid]['downloads'] = $attach['downloads'];
					$article['attachments'][$aid]['filesize']  = (int)($attach['filesize']/1024);
					$argurl = mkUrl('attachment.php',$aid);
					if (strpos($article['content'],"[attach=$aid]") !== false)
					{
						if ($attach['isimage']) 	{
							$file="<img src='{$argurl}' alt='{$attach['filename']}'>";//不带链接
							//$file="<a href='{$argurl}' target='_blank'><img src='{$argurl}' alt='{$attach['filename']}'></a>";//带链接
						}
						else {
							$file="<a href='{$argurl}' target='_blank'>{$attach['filename']}</a>";
						}
						$article['content']=str_replace("[attach=$aid]",$file,$article['content']);
					}
					$article['attachments'][$aid]['aurl']=$argurl;
				}
			}
		}
		if (!empty($article['tag'])) $article['tag']=explode(',',$article['tag']);
	}
	return $article;
}

/**
 * 按文章的aid，当前页码和每页的条数获取符合条件的评论
 */
function getComment($aid,$page,$pagenum)
{
	global $DB,$hostid,$host;
	$start_LIMIT = ($page - 1) * $pagenum;
	$cmtorder = $host['comment_order'] ? 'ASC' : 'DESC';
	$sql="SELECT * FROM ".DB_PREFIX."comment WHERE articleid='$aid' AND visible='1' ORDER BY cid $cmtorder LIMIT $start_LIMIT,$pagenum";
	$commentdb=array();
	$query = $DB->query($sql);
	while($comment = $DB->fetch_array($query))
	{
		$comment['dateline']=date($host['time_comment_format'], $comment['dateline']);
		$commentdb[]=$comment;
	}
	return $commentdb;
}

/**
 * 获取热门评论文章
 */
function getHotComment($num,$cateid=null)
{
	global $DB,$host,$hostid;
	if ($cateid==null) $cate='';
	else $cate=' and cateid='.$cateid;
	$query=$DB->query('SELECT * FROM '.DB_PREFIX."article WHERE visible=1 and hostid=$hostid $cate order by views desc LIMIT $num");
	return getArticleByAid($query);
}

/**
 * 按id获取附件
 */
function getAttachById($aids)
{
	global $DB,$host;
	$attacharr=array();
	$downloads=$DB->query('SELECT * FROM '.DB_PREFIX."attachment WHERE articleid in (".$aids.')');
	while($dds=$DB->fetch_array($downloads))
	{
		$attacharr[$dds['articleid']][$dds['aid']]=$dds;
	}
	return $attacharr;
}

/**
 * 获取上下篇文章
 * @param unknown $aid 当前文章ID
 * @return multitype:|multitype:unknown NULL multitype:
 */
function getPreNextArticle($aid)
{
	global $DB,$host,$hostid;
	$data=array();
	$preArr=$DB->fetch_first('SELECT MAX(aid) FROM `'.DB_PREFIX."article` WHERE `aid` < $aid and hostid=$hostid LIMIT 1");
	$nextArr=$DB->fetch_first('SELECT MIN(aid) FROM `'.DB_PREFIX."article` WHERE `aid` > $aid AND hostid=$hostid LIMIT 1");
	if (empty($perArr) && empty($nextArr)) return $data;
	if (!empty($preArr))
	{
		$preid = $preArr['MAX(aid)'];
		$data['Pre'] = $DB->fetch_first('SELECT * FROM `'.DB_PREFIX."article` WHERE `aid` = $preid");
		$data['Pre'] = showArticle($data['Pre']);
	}
	if (!empty($nextArr))
	{
		$nextid = $nextArr['MIN(aid)'];
		$data['Next'] = $DB->fetch_first('SELECT * FROM `'.DB_PREFIX."article` WHERE `aid` = $nextid");
		$data['Next'] = showArticle($data['Next']);
	}
	return $data;
}

/**
 * 按aid获取文章
 */
function getArticleByAid($query)
{
	global $DB;
	$articledb=array();
	$aidarr=array();
	while($aid=$DB->fetch_array($query))
	{
		$aidarr[]=$aid['aid'];
	}
	if (count($aidarr)>0)
	{
		$aids=implode_ids($aidarr);
		$query=$DB->query('SELECT * FROM '.DB_PREFIX."article WHERE aid in ($aids)");
		while($article=$DB->fetch_array($query))
		{
			$articledb[]=showArticle($article);
		}
	}
	return $articledb;
}

/**
 * 获取最新$num条搜索的记录
 */
function getLatestSearch($num)
{
	global $host;
	$latestarray=@include SYS_DATA.'/cache/search_'.$host['host'].'.php';
	if (!empty($latestarray))
	{
		if (count($latestarray)>$num) $latestarray=array_slice($latestarray, 0, $num); 
	}
	return $latestarray;
}


/**
 * 有问题
 * @param unknown $user
 * @return unknown
 */
function showUser($user)
{
	global $udArr;
	$user['username']      = $user['username'] ;
	$user['usernickname']  = $user['usernickname'] ;
	$user['qq']            = $user['qq'] ;
	return $user;
}
/**
 * 获取用户信息
 * @param unknown $uid 用户ID
 * @return multitype:unknown string
 */
function getUserDataById($uid=1)
{
	global $DB,$uid;
	$query = $DB -> query('SELECT * FROM `'.DB_PREFIX."user` WHERE `uid` = $uid");
	$user = array();
	while($userdatadb = $DB -> fetch_array($query))
	{
		$user[] = showUser($userdatadb);
	}
	return $user;
}

