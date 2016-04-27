<?php
if (!$action) $action='cache';
$cachedb=array();
$url = 'admin.php?file=maintenance';
if ($action == 'cache') $navtitle = '缓存文件管理';
if (SYS_POST)
{
	if ($action == 'cache')
	{
		filemaps_recache();
		plugins_recache();
		links_recache();
		stick_recache();
		comments_recache();
		rss_recache();
		cates_recache();
		vars_recache();
		pics_recache();
		latest_recache();
		hot_recache();
		search_recache();
		redirect('所有缓存文件已经更新', $url);
	}
	else if ($action == 'log')
	{
		include SYS_CORE.'/manager/log.php';
	}
}
else
{
	if ($action == 'log' && !in_array($do,array('login', 'search', 'dberror')))
	$do = 'login';
	if ($action == 'log')
	{
		include SYS_CORE.'/manager/log.php';
		if ($do == 'login')
		{
			$navtitle = '用户登陆日志';
		}
		elseif ($do == 'search')
		{
			$navtitle = '用户搜索日志';
		}
		elseif ($do == 'dberror')
		{
			$navtitle = '数据库错误日志';
		}
	}
	else if ($action=='cache')
	{
		$cachefile=array(
		'rss_'.$host['host']=>'RSS文件',
		'var_'.$host['host']=>'自定义模板变量',
		'pic_'.$host['host']=>'包含图片的文章',
		'hot_'.$host['host']=>'阅读排行文件',
		'tag_'.$host['host']=>'热门Tag文件',
		'map_'.$host['host']=>'映射文件',
		'stick_'.$host['host']=>'置顶文章',
		'latest_'.$host['host']=>'栏目最新文件',
		'search_'.$host['host']=>'最新搜索的100条记录',
		'comments_'.$host['host']=>'最新评论',
		'redirect_'.$host['host']=>'自动跳转设置'
		);
		foreach($cachefile as $cfile=>$desc)
		{
			$filepath = SYS_DATA.'/cache/'.$cfile.'.php';
			if (is_file($filepath))
			{
				$cachefile['name'] = $cfile.'.php';
				$cachefile['desc'] = $desc;
				$cachefile['size'] = sizecount(filesize($filepath));
				$cachefile['mtime'] = date('Y-m-d H:i',@filemtime($filepath));
				$cachedb[] = $cachefile;
			}
		}
	}
}