<?php
print <<<EOT
<!DOCTYPE html>
<html>
 <head>
  <title>{$constant['SYS_NAME']}</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="zh-CN" />
  <meta http-equiv="Windows-Target" contect="_top" />
  <meta http-equiv="Pragma" content="no-cache" />
 </head>
 <body>
  <form method="post" action="admin.php?file=login" style="width: 258px; margin: 50px auto; background: gainsboro; font-size: 12px;">
   <input type="hidden" name="action" value="login">
   <div style="font-size: 14px;text-align: center;">请输入帐号和密码</div>
   <div><input class="formfield" name="username" value="" style="width:90px" placeholder="USERNAME" />&nbsp;<input class="formfield" type="password" name="password" value="" style="width:155px" placeholder="PASSWORD" /></div>
   <div>&nbsp;&copy;&nbsp;<a href="{$constant['SYS_WEBSITE']}" target="_blank">{$constant['SYS_NAME']}</a>&nbsp;&nbsp;&nbsp;<input type="submit" class="formbutton" value="LOGIN" /></div>
   <div>{$loginerr}</div>
  </form>
 </body>
</html>
EOT;

