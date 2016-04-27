<?php
/**
 * 检查提交Tag是否符合逻辑
 */
function checktag($tag)
{
	$tag = str_replace('，', ',', $tag);
	if (strrpos($tag, ','))
	{
		$result = '关键字中不能含有“,”或“，”字符<br />';
		return $result;
	}
	if (strlen($tag) > 15)
	{
		$result = '关键字不能超过15个字符<br />';
		return $result;
	}
}

/**
 * 修改tag
 */
function modtag($olditem,$newitem)
{
	global $hostid,$DB;
	$aids=gettagids($olditem);
	if ($aids)
	{
		$query=$DB->query('SELECT `tag`, `aid` FROM `'.DB_PREFIX."article` WHERE `aid` IN ($aids) AND `hostid` = '$hostid'");
		while($result=$DB->fetch_array($query))
		{
			$tagstr=$result['tag'];
			$aid=$result['aid'];
			if (strpos($tagstr,$olditem)!==false)
			{
				$newtagstr=$newitem;
				$oldtagarr=explode(',',$tagstr);
				foreach($oldtagarr as $oldtag) 
				{
					if ($oldtag!=$olditem) $newtagstr.=','.$oldtag;
				}
				$DB->query('UPDATE `'.DB_PREFIX."article` SET `tag` = '$newtagstr' WHERE `aid` = '$aid'");
			}
		}
	}
	$DB->query('UPDATE `'.DB_PREFIX."tag` SET `tag` = '$newitem' WHERE `tag` = '$olditem' AND `hostid` = '$hostid'");
}

/**
 * 删除Tag
 */
function removetag($tagname)
{
	global $hostid,$DB;
	$aids=gettagids($tagname);
	if ($aids)
	{
		$query=$DB->query('SELECT `tag`, `aid` FROM `'.DB_PREFIX."article` WHERE `aid` IN ($aids) AND `hostid` = '$hostid'");
		while($result=$DB->fetch_array($query))
		{
			$tagstr=$result['tag'];
			$aid=$result['aid'];	

			$newtagstr='';
			$oldtagarr=explode(',',$tagstr);
			foreach($oldtagarr as $oldtag) 
			{
				if ($oldtag!=$tagname) $newtagstr.=','.$oldtag;
			}
			if ($newtagstr) 
			{
				$newtagstr=substr($newtagstr,1);
			}
			$DB->query('UPDATE `'.DB_PREFIX."article` SET `tag` = '$newtagstr' WHERE `aid` = '$aid'");
		}
	}
	$DB->query('DELETE FROM `'.DB_PREFIX."tag` WHERE `tag` = '$tagname' AND `hostid` = '$hostid'");
}

/**
 * 获取tagID
 */
function gettagids($tagname)
{
	global $hostid,$DB;
	$tagsql='SELECT `articleid` FROM `'.DB_PREFIX."tag` WHERE `tag` = '$tagname' AND `hostid` = '$hostid'";
	$tagquery=$DB->query($tagsql);
	$aidarr=array();
	while($taginfo=$DB->fetch_array($tagquery))
	{
		$aidarr[]=$taginfo['articleid'];
	}
	$aids='';
	if (!empty($aidarr))
	{
		$aids=implode(',',$aidarr);
	}
	return $aids;
}