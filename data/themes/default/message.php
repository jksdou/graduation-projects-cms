<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta http-equiv="Pragma" content="no-cache" />
<?php if ($returnurl) { ?>
<meta http-equiv="refresh" content="2; url=<?php echo $returnurl; ?>" />
<?php } ?>
<meta name='robots' content='noindex,follow' />
<link rel="stylesheet" href="style.css" type="text/css" media="all" />
<title>系统消息 <?php echo $host['name']; ?></title>
</head>
<body>
<div id="message">
 <h2><?php echo $host['name']; ?></h2>
 <p style="margin-bottom:20px;"><strong><?php echo $msg; ?></strong></p>
 <p>2秒后将自动跳转</p>
<?php if ($returnurl) { ?>
 <p><a href="<?php echo $returnurl; ?>">如果不想等待或浏览器没有自动跳转请点击这里跳转</a></p>
<?php } ?>
</div>
</body>
</html>
