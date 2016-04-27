<?php
if (SYS_POST)
{
	if ($action == 'addlink')
	{
		$name    = trim($_POST['name']);
		$url     = trim($_POST['url']);
		$note    = trim($_POST['note']);
		$bak     = trim($_POST['bak']);
		$type    = intval($_POST['type']);
		$cateid  = trim($_POST['cateid']);
		$visible = intval($_POST['visible']);
		$result  = checkSiteName($name);
		$result .= checkUrl($url,0);
		$result .= checkSiteNote($note);
		if ($result) { redirect($result); }
		$name    = char_cv($name);
		$url     = char_cv($url);
		$note    = char_cv($note);
		$rs = $DB->fetch_first('SELECT count(*) AS `links` FROM `'.DB_PREFIX."link` WHERE `name` = '$name' AND `url` = '$url' AND `hostid` = '$hostid'");
		if ($rs['links']) {
			redirect('数据库中已存在此链接', 'admin.php?file=link');
		}
		$DB->query('INSERT INTO `'.DB_PREFIX."link` (`name`, `url`, `note`, `visible`, `hostid`, `bak`, `type`, `cateid`) VALUES ('$name', '$url', '$note', '$visible', '$hostid', '$bak', '$type', '$cateid')");
		links_recache();
		redirect('添加链接成功', 'admin.php?file=link');
	}
	else if ($action=='domorelink') {
		if (isset($_POST['delete'])&&$ids = implode_ids($_POST['delete'])) {
			$DB->query('DELETE FROM	`'.DB_PREFIX."link` WHERE `lid` IN ($ids) AND `hostid` = '$hostid'");
		}
		if (is_array($_POST['name'])) {
			foreach($_POST['name'] as $linkid => $value) {
				$DB->unbuffered_query("UPDATE `".DB_PREFIX."link` SET `displayorder` = '".intval($_POST['displayorder'][$linkid])."', `name` = '".char_cv(trim($_POST['name'][$linkid]))."', `url` = '".char_cv(trim($_POST['url'][$linkid]))."', `note` = '".char_cv(trim($_POST['note'][$linkid]))."', `type` = '".intval($_POST['type'][$linkid])."', `cateid` = '".intval($_POST['cateid'][$linkid])."', `visible` = '".intval($_POST['visible'][$linkid])."', `bak` = '".$_POST['bak'][$linkid]."' WHERE `lid` = '".intval($linkid)."' AND `hostid` = '$hostid'");
			}
		}
		links_recache();
		redirect('链接已成功更新', 'admin.php?file=link');
	}
}

if (!$action) { $action = 'list'; }
if ($action == 'add') { $subnav = '添加链接'; }
if ($action == 'list') {
	$query = $DB -> query('SELECT * FROM `'.DB_PREFIX."link` WHERE `hostid` = '$hostid' ORDER BY `displayorder`");
	$linkdb = array();
	while ($link = $DB -> fetch_array($query)) {
		if ($link['visible'] == '1') {
			$link['visible'] = '<option value="1" selected>显示</option><option value="0">隐藏</option>';
		}
		else {
			$link['visible'] = '<option value="1">显示</option><option value="0" selected>隐藏</option>';
		}
		if ($link['type'] == '1') {
			$link['type'] = '<option value="1" selected>首页链接</option><option value="0">友情链接</option>';
		}
		else {
			$link['type'] = '<option value="1">首页链接</option><option value="0" selected>友情链接</option>';
		}
		$linkdb[] = $link;
	}
	unset($link);
	$DB->free_result($query);
	$subnav = '编辑链接';
}