<?php
print <<<EOT
<!doctype html>
<html>
<head>
<title>SYSTEM MESSAGE</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="{$cssfile}" type="text/css">
<meta http-equiv="refresh" content="$min;url=$url">
<style type="text/css">
.alert { color: darkblue; font-size: 16px; margin: 30px 0px; height: 39px; line-height: 25px; }
.box { border: #B1B6D2 1px solid; width: 500px; margin: 100px auto; background-color: #EEEAFF; padding: 30px; }
</style>
</head>
<body style="text-align:center; background: floralwhite;">
<div class="box">
  <div class="alert">$msg</div>
  <div class="alertmsg">
   <a href="$url">如果你不想等待或浏览器没有自动跳转请点击这里跳转</a>
  </div>
</div>
</body>
</html>
EOT;
