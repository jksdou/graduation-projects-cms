<?php
if (!isset($_GET['url'])) { message('未定义参数', './'); }
$cate=array();
foreach($cateArr as $ct)
{
	if ($ct['url']==$_GET['url']) $cate=$ct;
}
if (empty($cate)) { message('不存在的栏目', '/'); }

$page=isset($_GET['page'])?intval($_GET['page']):1;
$pagenums=1;
$articledb=getCateArticle($cate['child'],$page);
$total=count($articledb);
$multipage='';

$allcount=1;
if ($total>0)
{
	$arr=$DB->fetch_first("SELECT count(*) FROM ".DB_PREFIX."article WHERE hostid=$hostid and visible=1 and cateid={$cate['cid']}");
	if (!empty($arr)) { $allcount=$arr['count(*)']; }
	$pagenums = @ceil($allcount / $host['list_shownum']);
}
//现在是对数据再做处理
$title = $cate['name'];
if ($cate['keywords'])
{
	$keywords = $cate['keywords'].','.$host['keywords'];
}
else { $keywords = $host['keywords']; }//内容关键字不存在就用站点关键字
if ($cate['description'])
{
	$description = $cate['description'].'['.$host['description'].']';
}
else { $description = $host['description']; }//内容描述不存在就使用站点描述
doAction('category_before_view');