<?php
//对于以后的可以使用多语言时，Content-Language的值就需要从language中取
if ($groupid) {
print <<<EOT
<!DOCTYPE html>
<html>
<head>
<title>{$host['name']}-{$constant['SYS_NAME']}</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<meta http-equiv="Windows-Target" contect="_top" />
<meta http-equiv="Pragma" content="no-cache" />
<meta name="Author" content="{$constant['SYS_AUTHOR']}" />
<meta name="Copyright" content="{$constant['SYS_NAME']}" />
<link rel="stylesheet" href="{$cssfile}" type="text/css" />
<script type="text/javascript" src="{$editordir}jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="{$editordir}jquery.form.js"></script>
<script type="text/javascript" src="{$editordir}xheditor-1.1.14-zh-cn.min.js"></script>
<script type="text/javascript" src="{$jsfile}"></script>
</head>
<body>
<div id="main">
 <div class="header">
  <ul>
   <li><a href="./" target="_blank" >INDEX</a></li>
EOT;
if ($groupid == 4) {
print <<<EOT

   <li><a href="admin.php?file=multisite">MULTISITE</a></li>
EOT;
}
print <<<EOT

   <li><a href="admin.php?file=login&action=logout">logout</a></li>
   <li><a>{$username}</a></li>
  </ul>
 </div>
EOT;
}
if (isset($adminitem) && $adminitem)
{
print <<<EOT

 <div class="navmenu">
  <ul>
EOT;
  foreach ($adminitem AS $link => $title)
    {
print <<<EOT

   <li><a href="admin.php?file={$link}">{$title}</a></li>
EOT;
    }
print <<<EOT

  </ul>
 </div>
EOT;
}
