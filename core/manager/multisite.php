<?php
if (empty($action)) $action='list';
$sitedb=array();
$setting['name']=$setting['host']=$setting['host2']=$setting['hid']='';
$setting['url_ext']='php';
$files=array('index.php','category.php','article.php','attachment.php','search.php','comment.php','tag.php','profile.php','admin.php','captcha.php','rss.php','js.php','archive.php','link.php');
foreach($files as $f) $info[$f]='';
foreach($files as $f) $args[$f]='';
$hid=isset($_GET['hid'])?intval($_GET['hid']):'';
$curhostid=$hostid;
$curhost=$host;
$curmapArr=$mapArr;
$url_html1=$url_html0='';
$cmd = mkUrl('admin.php','').'?file=multisite';
if (SYS_POST)
{
	if ($action=='add'||$action=='edit')
	{
		if (!$hid) $hid=isset($_POST['setting']['hid'])?intval($_POST['setting']['hid']):'';
		$hidadd=!$hid?'':'&action=edit&hid='.$hid;
		$test=array();
		foreach($files as $k)
		{
			$postvalue=$_POST['maps'][$k];
			if (!$postvalue) redirect($k.'参数不能为空',$cmd.$hidadd);
			if (!preg_match("/^\w*?$/i",$postvalue)) redirect($k.'参数不符合条件，只能是字母或数字',$cmd.$hidadd);
			if (isset($test[$postvalue])) redirect($k.'参数和参数'.$test[$postvalue].'新文件名重复，请修改',$cmd.$hidadd);
			$test[$postvalue]=$k;
		}
		$url_html=$_POST['setting']['url_html'];
		$url_ext=$_POST['setting']['url_ext'];
		if ($url_ext&&!preg_match("/^\w*?$/i",$url_ext)) redirect('文件后缀只能是字母或数字',$cmd.$hidadd);
		if (!$url_html&&!$url_ext) redirect('当使用动态网址后，必须指定文件后缀',$cmd.$hidadd);
	}
	switch($action)
	{
		case 'add':
			if (!isset($_POST['setting'])) redirect('Setting参数不足',$cmd);
			if (!isset($_POST['maps'])) redirect('maps参数不足',$cmd);
			$hostname=$_POST['setting']['name'];
			$hosturl=$_POST['setting']['host'];
			$host2=$_POST['setting']['host2'];
			//先检查网址是否存在
			$exsits=$DB->fetch_first('SELECT * FROM `'.DB_PREFIX."host` WHERE `host`='$hosturl'");
			if ($exsits) redirect('该站点已经存在',$cmd);

			$sql="INSERT INTO `".DB_PREFIX."host` (`name`, `host`, `host2`, `keywords`, `description`) VALUES ('$hostname', '$hosturl','$host2', 'CMS,UIISC', '我的站点哈')";
			$DB->query($sql);
			$insertid=$DB->insert_id();
			foreach($files as $k)
			{
				$filename=$_POST['maps'][$k];
				$mapArr=$_POST['args'][$k];
				$DB->query('INSERT INTO `'.DB_PREFIX."filemap` (`hostid`, `original`, `filename`, `maps`) values ('$insertid','$k','$filename','$mapArr')");
			}
			$hostid=$insertid;
			$host=$DB->fetch_first('SELECT * FROM `'.DB_PREFIX."host` WHERE `hid`='$insertid'");
			$mapArr=getFiles($hostid);
			hosts_recache();
			filemaps_recache();
			cates_recache();
			plugins_recache();
			links_recache();
			rss_recache();
			latest_recache();
			vars_recache();
			stick_recache();
			comments_recache();
			pics_recache();
			hot_recache();
			search_recache();
			$host=$curhost;
			$hostid=$curhostid;
			$mapArr=$curmapArr;
			redirect('新站点添加成功',$cmd);
		break;
		case 'edit':
			if (!$hid) redirect('缺少站点Id参数',$cmd);
			if (!isset($_POST['setting'])) redirect('Setting参数不足',$cmd);
			if (!isset($_POST['maps'])) redirect('maps参数不足',$cmd);
			$result=$DB->fetch_first('SELECT * FROM `'.DB_PREFIX."host` WHERE `hid` = '$hid'");
			if (!$result) redirect('不存在的站点',$cmd);
			$hostname=$_POST['setting']['name'];
			$hosturl=$_POST['setting']['host'];
			$host2=$_POST['setting']['host2'];
			$url_html=$_POST['setting']['url_html'];
			$url_ext=$_POST['setting']['url_ext'];
			$DB->query('update '.DB_PREFIX."host set `host`='$hosturl',`host2`='$host2',`name`='$hostname',`url_html`=$url_html,`url_ext`='$url_ext' where hid=$hid");
			foreach($files as $k)
			{
				$filename=$_POST['maps'][$k];
				$mapArr=$_POST['args'][$k];
				$DB->query('UPDATE '.DB_PREFIX."filemap SET `filename`='$filename',`maps`='$mapArr' where `original`='$k' and `hostid`='$hid'");
			}
			$hostid=$hid;
			$host=$DB->fetch_first('SELECT * FROM `'.DB_PREFIX."host` WHERE `hid` = '$hid'");
			$mapArr=getFiles($hid);
			if ($curhostid==$hid)
			{
				$curhost=$host;
				$curmapArr=$mapArr;
			}
			hosts_recache();
			filemaps_recache();
			cates_recache();
			rss_recache();
			latest_recache();
			comments_recache();
			pics_recache();
			stick_recache();
			hot_recache();
			search_recache();
			if ($curhostid!=$hid)
			{
				$host=$curhost;
				$hostid=$curhostid;
				$mapArr=$curmapArr;
			}
			redirect('站点更新成功',mkUrl('admin.php','').'?file=multisite');
		break;
	}

}
else
{
	//先加载所有站点信息
	switch($action)
	{
		case "cacheall";
			$hquery=$DB->query('SELECT * FROM `'.DB_PREFIX.'host`');
			while($host=$DB->fetch_array($hquery))
			{
				$hostid=$host['hid'];
				$mapArr=getFiles($hostid);
				if ($curhostid==$hid)
				{
					$curhost=$host;
					$curmapArr=$mapArr;
				}
				vars_recache();
				pics_recache();
				latest_recache();
				redirect_recache();
				hosts_recache();
				cates_recache();
				filemaps_recache();
				plugins_recache();
				comments_recache();
				links_recache();
				rss_recache();
				search_recache();
				stick_recache();
				hot_recache();
			}
			$host=$curhost;
			$hostid=$curhostid;
			$mapArr=$curmapArr;
			redirect('更新所有站点缓存成功',mkUrl('admin.php','').'?file=multisite');
			break;
		case 'list':
			$query=$DB->query('SELECT * FROM `'.DB_PREFIX.'host`');
			while($res=$DB->fetch_array($query))
			{
				if ($res['status']) $res['status']='正常';
				else $res['status']='关闭';
				$sitedb[]=$res;
			}
			break;		
		case 'edit':
			$info=$args=array();
			if (!$hid) redirct('缺少站点Id参数');
			$setting = $DB->fetch_first('SELECT * FROM `'.DB_PREFIX.'host` WHERE `hid`='.$hid);
			${'url_html'.$setting['url_html']}='selected';
			if (empty($setting)) redirct('不存在的站点id');
			$query = $DB->query('SELECT * FROM `'.DB_PREFIX.'filemap` WHERE `hostid`='.$hid);
			while($fname = $DB->fetch_array($query))
			{
				$info[$fname['original']]=$fname['filename'];
				$args[$fname['original']]=$fname['maps'];
			}
			break;
		case 'bakup':
			break;
		case 'add':
			foreach($files as $f) $info[$f]=substr($f,0,-4);
			break;
		case 'go':
			if (!$hid) redirct('缺少站点Id参数');
			$nsessionid=urlencode($sessionid);
			$host=$DB->fetch_first('SELECT * FROM `'.DB_PREFIX.'host` WHERE `hid`='.$hid);
			$rhost=$host['host'];
			$mapArr=getFiles($hid);
			$admin_url=mkUrl('admin.php','');
			if ($host)
			{
				redirect('正在转向站点'.$host['name'],SYS_HTTP."{$rhost}/{$admin_url}?sessionid={$nsessionid}");
				break;
			}
		case 'del';
			if ($curhostid == $hid)
			{
				redirect('请转向到其它站点后台来删除本站点',$cmd);
			}
			else
			{
				$DB->query('DELETE FROM `'.DB_PREFIX."host` WHERE `hid` = '$hid'");
				/*
				中间这些需要删除站点的缓存文件，以及处理此站点内容的去留，是全部删除还是转移到其他站点，需要进一步处理
				$hostid=$insertid;
				$mapArr=getFiles($hostid);
				hosts_recache();
				filemaps_recache();
				cates_recache();
				plugins_recache();
				links_recache();
				rss_recache();
				latest_recache();
				vars_recache();
				stick_recache();
				comments_recache();
				pics_recache();
				hot_recache();
				search_recache();
				$host=$curhost;
				$hostid=$curhostid;
				$mapArr=$curmapArr;*/
				redirect('站点删除成功',$cmd);
			}
	}
}

function getFiles($hostid)
{
	global $DB,$host;
	$files= $DB->query('SELECT f.*,h.host,h.hid FROM `'.DB_PREFIX.'filemap` f,`'.DB_PREFIX.'host` h where h.hid=f.hostid and f.hostid='.$hostid);
	$arrfiles=array();
	while ($fs = $DB->fetch_array($files)) 
	{
		$args=array();
		if ($fs['maps'])
		{
			$arr=explode(',',$fs['maps']);
			foreach($arr as $arg)
			{
				$ag=explode('=',$arg);
				if (count($ag)==2&&$ag[0]&&$ag[1]) $args[$ag[0]]=$ag[1];
			}
		}
		if (!$host['url_html']) $fs['filename']=$fs['filename'].'.'.$host['url_ext'];
		$arrfiles['file'][$fs['filename']]=$fs['original'];
		$arrfiles['arg'][$fs['filename']]=$args;
	}
	return $arrfiles;
}