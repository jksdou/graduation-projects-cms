<?php
print <<<EOT

 <div class="mainbody">
  <div class="l">
   <div class="lmenu">快捷链接</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=article&action=add">添加文章</a></li>
     <li><a href="admin.php?file=article&action=list">列出文章</a></li>
     <li><a href="admin.php?file=article&action=search">搜索文章</a></li>
     <li><a href="admin.php?file=page&action=add">添加页面</a></li>
     <li><a href="admin.php?file=page&action=list">列出页面</a></li>
EOT;
if ($groupid>2)
{
print <<<EOT

     <li><a href="admin.php?file=category&action=addcate">添加分类</a></li>
     <li><a href="admin.php?file=link&action=add">添加链接</a></li>
     <li><a href="admin.php?file=attachment&action=repair">附件修复</a></li>
     <li><a href="admin.php?file=attachment&action=clear">附件清理</a></li>
EOT;
}
if ($groupid==4)
{
print <<<EOT

     <li><a href="admin.php?file=cache&action=rebuild">重建数据</a></li>
     <li><a href="admin.php?file=database&action=backup">数据库备份</a></li>
     <li><a href="admin.php?file=database&action=tools">数据库维护</a></li>
     <li><a href="admin.php?file=multisite">多站点管理</a></li>
EOT;
}
print <<<EOT

    </ul>
   </div>
  </div>
  <div class="r">
   <div class="rmenu">服务器系统信息</div>
   <dl class="ritem"><dd class="lhalf">服务器时间:</dd><dd class="rhalf">$server[datetime]</dd></dl>
   <dl class="ritem"><dd class="lhalf">服务器引擎:</dd><dd class="rhalf">$server[software]</dd></dl>
   <dl class="ritem"><dd class="lhalf">MySql版本:</dd><dd class="rhalf">$server[mysql]</dd></dl>
   <dl class="ritem"><dd class="lhalf">文件上传:</dd><dd class="rhalf">$fileupload</dd></dl>
   <dl class="ritem"><dd class="lhalf">全局变量 register_globals:</dd><dd class="rhalf">$globals</dd></dl>
   <dl class="ritem"><dd class="lhalf">PHP安全模式 safe_mode:</dd><dd class="rhalf">$safemode</dd></dl>
   <dl class="ritem"><dd class="lhalf">图形处理 GD ddbrary:</dd><dd class="rhalf">$gd_version</dd></dl>
EOT;
if ($server['memory_info'])
{
print <<<EOT

   <dl class="ritem"><dd class="lhalf">内存占用:</dd><dd class="rhalf">$server[memory_info]</dd></dl>
EOT;
}
print <<<EOT

   <div class="rmenu">程序数据统计</div>
   <dl class="ritem"><dd class="lhalf">站点名称:</dd><dd class="rhalf">{$host['name']}</dd></dl>
   <dl class="ritem"><dd class="lhalf">文章数量:</dd><dd class="rhalf">{$server['article']}</dd></dl>
   <dl class="ritem"><dd class="lhalf">评论数量:</dd><dd class="rhalf">{$server['comment']}</dd></dl>
   <dl class="ritem"><dd class="lhalf">附件数量:</dd><dd class="rhalf">{$server['attach']}</dd></dl>
   <div class="rmenu">程序相关信息</div>
   <dl class="ritem"><dd class="lhalf">当前版本:</dd><dd class="rhalf">{$constant['SYS_VERSION']} Build {$constant['SYS_RELEASE']}</dd></dl>
   <dl class="ritem"><dd class="lhalf">最新版本:</dd><dd class="rhalf"><span id="newest_version">此功能还没有完善</span></dd></dl>
   <dl class="ritem"><dd class="lhalf">开发人员:</dd><dd class="rhalf"><a href="mailto:{$constant['SYS_EMAIL']}" target="_blank">{$constant['SYS_AUTHOR']}</a></dd></dl>
   <dl class="ritem"><dd class="lhalf">官方主页:</dd><dd class="rhalf"><a href="{$constant['SYS_WEBSITE']}" target="_blank">{$constant['SYS_WEBSITE']}</a></dd></dl>
  </div>
 </div>
EOT;
