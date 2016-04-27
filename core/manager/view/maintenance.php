<?php
print <<<EOT

 <div class="mainbody">
  <div class="l">
   <div class="lmenu">系统维护</div>
    <div class="litem">
    <ul>
     <li><a href="admin.php?file=maintenance&action=cache">缓存文件管理</a></li>
    </ul>
   </div>
   <div class="lmenu">日志管理</div>
    <div class="litem">
    <ul>
     <li><a href="admin.php?file=maintenance&action=log&do=login">用户登陆日志</a></li>
     <li><a href="admin.php?file=maintenance&action=log&do=search">用户搜索日志</a></li>
EOT;
if ($groupid==4)
{
print <<<EOT

      <li><a href="admin.php?file=maintenance&action=log&do=dberror">数据库错误日志</a></li>
EOT;
}
print <<<EOT

    </ul>
   </div>
  </div>
EOT;
print <<<EOT

  <div class="r">
EOT;
if (!$action || $action == 'cache')
{
print <<<EOT

    <div class="rmenu">$navtitle</div>
    <dl class="ritemenu">
     <dd class="i150">生成时间</dd>
     <dd class="i80">缓存大小</dd>
     <dd class="i150">文件说明</dd>
     <dd class="toleft">缓存文件</dd>
    </dl>
EOT;
foreach($cachedb as $key => $cache)
{
print <<<EOT

     <dl class="ritem">
      <dd class="i150">$cache[mtime]</dd>
      <dd class="i80">$cache[size]</dd>
      <dd class="i150">$cache[desc]</dd>
      <dd class="toleft"><b>$cache[name]</b></dd>
     </dl>
EOT;
}
print <<<EOT

    <dl class="ritem">
     <dd class="i100">
     <form action="admin.php?file=maintenance"  method="POST">
      <input type="hidden" name="action" value="cache" /><input type="submit" value="更新所有缓存" class="formbutton" />
     </form>
     </dd>
    </dl>
EOT;
}
if ($action == 'log')
{
print <<<EOT

    <div class="rmenu">$navtitle</div>
    <dl class="ritemenu">
     <dd class="i130">时间</dd>
     <dd class="i80">IP地址</dd>
     <dd class="i400">$browser</dd>
     <dd class="i200">$result</dd>
     <dd class="i100">用户名</dd>
   </dl>
EOT;
	foreach($searchdb as $key => $search)
	{
		if ($do=='search')//临时想法
		{
			$search[content] = $search[keywords];//Unknown error type: [8] Use of undefined constant content - assumed 'content'
		}
print <<<EOT

    <dl class="ritem">
      <dd class="i130">$search[dateline]</dd>
      <dd class="i80">$search[ip]</dd>
      <dd class="i400">$search[useragent]</dd>
      <dd class="i200">$search[content]</dd>
      <dd class="i100">$search[user]</dd>
	</dl>
EOT;
	}
print <<<EOT

    <dl class="ritem">
     <dd class="i150"><div class="records">记录:$total</div></dd>
    </dl>
    <dl class="ritem">
     <dd><div class="multipage">$multipage</div></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf">
      <form action="admin.php?file=maintenance"  method="POST">
       <input type="hidden" name="action" value="log">
       <input type="hidden" name="do" value="$do">
       <input type="submit" value="保留最新500条日志记录" class="formbutton">
      </form>
     </dd>
    </dl>
EOT;
}
print <<<EOT

  </div>
 </div>
EOT;
