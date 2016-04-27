<?php
$listcache = array();
$latestarray = @include SYS_DATA.'/cache/latest_'.$host['host'].'.php';//得到最新的所有栏目的文章id
if ($latestarray) {
	unset($latestarray['cateids'][0]);
	$listcache = $latestarray['cateids'];
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $title; ?>-<?php echo $host['name']; ?></title>
<meta name="title" content="<?php echo $title; ?>" />
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="description" content="<?php echo $description; ?>" />
<meta name="copyright" content="<?php echo $constant['SYS_NAME']; ?>" />
<meta name="generator" content="<?php echo $constant['SYS_NAME']; ?> <?php echo $constant['SYS_VERSION']; ?>" />
<meta name="author" content="<?php echo $constant['SYS_AUTHOR']; ?>" />
<meta name="robots" content="<?php echo $host['robots']; ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta http-equiv="Windows-Target" content="_top" />
<meta http-equiv="Cache-Control" content="no-cache, no-transform" />
<meta http-equiv="Pragma" content="no-cache" />
<base href="<?php echo $host_url; ?>" />
<link href="<?php echo $host_url; ?>" type="application/vnd.wap.xhtml+xml" title="<?php echo $host['name']; ?> monile site" media="handheld" rel="alternate" />
<link href="<?php echo $rss_url; ?>" type="application/rss+xml" title="<?php echo $host['name']; ?> RSS Feed" rel="alternate" />
<link href="./style.css" type="text/css" rel="stylesheet" />
<link href="./favicon.ico" type="image/x-icon" rel="icon" />
<link href="./favicon.ico" type="image/x-icon" rel="bookmark" />
<link href="./favicon.ico" type="image/x-icon" rel="shortcut icon" />
<!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>< ![endif]-->
<script type="text/javascript" src="js/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="js/common.js"></script>
</head>
<body>
<div id="container">
 <header>
  <div class="crest">
   <div class="welcome">Welcome to <?php echo $host['name']; ?> !</div>
  <div class="crestmenu">
   <ul>
     <!--这里的内容可以通过链接管理来添加，如添加数组top_links来获得在后台添加的相应链接 -->
    <li><a href="http://www.crogram.org/" target="_blank">crogram</a></li>
    <li><a href="http://labs.crogram.org/" target="_blank">研究中心</a></li>
    <li><a href="./<?php echo $rss_url; ?>" target="_blank">RSS订阅</a></li>
   </ul>
  </div>
  </div>
  <div>
   <hgroup id="logo"><?php echo $host['name'];?></hgroup>
   <div class="manage">
<?php if ($uid) { ?>
     <a href="<?php echo $profile_url; ?>">个人中心</a>
     <a href="<?php echo $logout_url; ?>">注销登录</a>
<?php if ($groupid == 3 || $groupid == 4) { ?>
     <a href="<?php echo $admin_url; ?>" target="_blank">后台管理</a>
<?php if ($groupid == 2) { ?>
     <a href="<?php echo $admin_url; ?>?file=article" target="_blank">内容管理</a>
<?php } ?>
<?php 	}
}
else { if(!$host['closereg']) { ?>
     <a href="<?php echo $register_url; ?>">注册</a>
<?php } ?>
     <a href="<?php echo $login_url; ?>">登陆</a>
<?php } ?>
   </div>
  </div>
 </header>
  <nav id="navigation">
   <ul class="menav">
    <li class="meitem"><a href="<?php echo $host_url; ?>">首页</a></li>
    <li class="meitem"><a href="<?php echo $search_url; ?>">搜索</a></li>
    <li class="meitem"><a href="<?php echo $tag_url; ?>">标签</a></li>
    <li class="meitem"><a href="<?php echo $comment_url; ?>">评论</a></li>
    <li class="meitem"><a>所有分类</a>
     <ul class="menav">
<?php foreach($cateArr as $cateid => $cname)
{
	if(isset($listcache[$cateid]))
	{ ?>
     <li class="meitem"><a href="<?php echo $cname['curl']; ?>"><?php echo $cname['name']; ?></a></li>
<?php
	}
} ?>
     </ul>
    </li>
   </ul>
  </nav>
