<?php
/*
 * 获取一个栏目中有多少文章
*/
function getArticleNum($hostid,$cateids)
{
	global $DB;
	$fetch = $DB->fetch_first('SELECT count(*) AS a FROM `'.DB_PREFIX."article` WHERE `hostid`='$hostid' AND `cateid` IN ($cateids)");
	return $fetch['a'];
}

/*
 * 检查分类名是否符合逻辑
*/
function checkname($name)
{
	if (!$name)
	{
		return '分类名不能为空<br />';
	}
	if (strlen($name) > 30)
	{
		return '分类名不能超过30个字符<br />';
	}
}

// 删除Tag函数
function removetag($item,$tagid)
{
	global $DB, $db_prefix;
	$item = addslashes($item);
	$tag = $DB->fetch_first("SELECT aids FROM `".DB_PREFIX."tags` WHERE `tag`='$item'");
	if ($tag)
	{
		$query  = $DB->query("SELECT articleid, keywords FROM `".DB_PREFIX."articles` WHERE `articleid` IN (".$tag['aids'].")");
		while ($article = $DB->fetch_array($query))
		{
			$article['keywords'] = str_replace(','.$item.',', ',', $article['keywords']);
			$article['keywords'] = str_replace(','.$item, '', $article['keywords']);
			$article['keywords'] = str_replace($item.',', '', $article['keywords']);
			$article['keywords'] = str_replace($item, '', $article['keywords']);
			$DB->unbuffered_query("UPDATE `".DB_PREFIX."articles` SET `keywords`='".addslashes($article['keywords'])."' WHERE `articleid`='".$article['articleid']."'");
		}
		$DB->unbuffered_query("DELETE FROM `".DB_PREFIX."tags` WHERE `tagid`='".intval($tagid)."'");
	}
}


function getCateOption($cateArr,$select,$self='')
{
	$re='';
	foreach($cateArr as $a=>$b)
	{
		if ($b['pid']=='0')
		{
			if ($self==$b['cid']) continue;
			$add=$select==$a?' selected':'';
			$re.='<option value="'.$a.'" '.$add.'>'.$b['name'].'</option>';
			$re.=getoption($a,$cateArr,$select,1,$self);
		}
	}
	return $re;
}

function getoption($pid,$cateArr,$select,$level,$self)
{
	$re='';
	foreach($cateArr as $a=>$b)
	{
		if ($b['pid']==$pid)
		{
			if ($self==$b['cid']) continue;
			$add=$select==$a?' selected':'';
			$pad=str_pad('', $level, '+', STR_PAD_LEFT);
			$re.='<option value="'.$a.'"'.$add.'>'.$pad.$b['name'].'</option>';
			$re.=getoption($a,$cateArr,$select,$level+1,$self);
		}
	}
	return $re;
}
function makeCate2($pid,$level,$cateArr)
{
	foreach($cateArr as $cid=>$cate)
	{
		if ($cate['pid']==$pid)
		{
			$cate['name']=str_pad('', $level, '+', STR_PAD_LEFT).$cate['name'];
			makeCate($cate);
			makeCate2($cate['cid'],$level+1,$cateArr);
		}
	}
}
/*
function getChildArr($cid,$cateArr)
{
	$childidArr[]=$cid;
	foreach($cateArr as $id=>$cateinfo)
	{
		if ($cateinfo['pid']==$cid)
		{
			$childidArr[]=getChild($id,$cateArr);
		}
	}
	return $childidArr;
}

function getChildLevel($cid,$cateArr)
{
	$level=0;
	foreach($cateArr as $id=>$cateinfo)
	{
		if ($cateinfo['pid']==$cid)
		{
			$level=$level+getChildLevel($id,$cateArr);
		}
	}
	return $level;
}

function getMaxCid($cateArr)
{
	sort($cateArr);
	$a=end($cateArr);
	return $a['cid'];
}

*/
