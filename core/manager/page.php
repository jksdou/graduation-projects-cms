<?php
if (!$action) { $action='list'; }
$urllink = 'admin.php?file=page';
$uquery = '';
if ($groupid < 3) { $uquery = " AND a.userid='$uid'"; }
$hidden=$DB->fetch_first('SELECT count(*) AS ct FROM `'.DB_PREFIX."page` a WHERE a.visible=0 AND a.hostid = $hostid".$uquery);
$hiddenCount=$hidden['ct'];
if (SYS_POST)
{
	$action=isset($_GET['action'])?$_GET['action']:'';
	if (in_array($action,array('add','mod')))
	{
		$title    = trim($_POST['title']);
		$url      = $_POST['url'];
		$excerpt  = $_POST['excerpt'];
		$content  = $_POST['content'];
		$keywords = trim($_POST['keywords']);
		$tag      = trim($_POST['tag']);
		$visible  = isset($_POST['visible'])?intval($_POST['visible']):0;
		$dateline = isset($_POST['edittime'])?getDateLine():time();

		if(empty($title)) redirect('标题不得为空',"$urllink&action=$action");
		if(empty($content)) redirect('内容不得为空',"$urllink&action=$action");
		if(empty($url)) redirect('网址不得为空',"$urllink&action=$action");
	}
	switch($action)
	{
		case 'add':
			$DB->query('INSERT INTO `'.DB_PREFIX."page` (`hostid`,`userid`,`username`,`title`,`tag`, keywords`,`url`,`excerpt`,`content`,`dateline`,`modified`,`visible`) VALUES ('$hostid','$userid','$username','$title','$keywords','$url','$excerpt','$content','$timestamp','$timestamp','1')");
			redirect('单页添加成功',$urllink);
		break;
		case 'mod':
			$pid=intval($_POST['pid']);
			$old=$DB->fetch_first('SELECT * FROM '.DB_PREFIX."page WHERE pid=$pid AND hostid=$hostid");
			if (!$old) redirect('不存在的记录',$urllink);
			if ($old['userid']!=$uid&&$groupid<3) redirect('您无权修改别人的文章',$urllink);
			if(empty($title)) redirect('标题不得为空',"$urllink&action=$action&pid=$pid");
			if(empty($content)) redirect('内容不得为空',"$urllink&action=$action&pid=$pid");
			if(empty($url)) redirect('网址不得为空',"$urllink&action=$action&pid=$pid");
			$DB->query('UPDATE `'.DB_PREFIX."page` SET `hostid` = '$hostid', `userid` = '$userid',`username` = '$username',`title`='$title',`tag` = '$tag', `keywords`='$keywords',`url`='$url',`excerpt`='$excerpt',`content`='$content',`dateline`='$timestamp',`modified`='$timestamp',`visible`=1 WHERE pid=$pid");
			redirect('单页编辑成功',$urllink);
		break;
		case 'del':
			redirect('单页删除成功',$urllink);
		break;
		default:
		redirect('未定义操作',$urllink);
	}
}
else
{
	if ($action=='add' || $action=='mod')
	{
		$article['title']=$article['keywords']=$article['tag']=$article['url']=$article['excerpt']=$article['content']=$article['pid']='';
		if ($action=='mod')
		{
			$navtitle='修改单页';
			if (!isset($_GET['pid'])) redirect('缺少pid参数',$urllink);
			$article=$DB->fetch_first('SELECT * FROM `'.DB_PREFIX."page` WHERE `hostid` = $hostid AND `pid` = ".intval($_GET['pid']));
			if (empty($article))  redirect('找不到文章',$urllink);
		}
		if ($action=='add')
		{
			$navtitle='添加单页';
		}
		$visible_check='checked';
	}
	else if ($action=='list')
	{
		$pagedbs = array();
		$navtitle = '单页列表';
		$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
		$rs = $DB->fetch_first('SELECT count(*) AS `pages` FROM `'.DB_PREFIX."page` WHERE `hostid` = $hostid");
		$total = $rs['pages'];
		$multipage = multi($total, 30, $page, $urllink);
		$start = ($page-1)*30;
		$query = $DB->query('SELECT * FROM `'.DB_PREFIX."page` WHERE `hostid` = $hostid LIMIT $start,30");
		while($pagedb=$DB->fetch_array($query))
		{
			$pagedb['dateline'] = date('Y-m-d H:i',$pagedb['dateline']);
			$pagedb['visible'] = $pagedb['visible'] ? '是' : '否';
			$pagedbs[] = $pagedb;
		}
	}
}