<?php
print <<<EOT

 <div class="mainbody">
  <div class="l">
   <div class="lmenu">插件管理</div>
   <div class="litem">
    <ul>
     <li><a href="$urllink&action=list">插件列表</a></li>
     <li><a href="$urllink&action=install">安装插件</a></li>
    </ul>
   </div>
   <div class="lmenu">插件菜单</div>
EOT;
if (count($pluginitem)>0)
{
print <<<EOT

   <div class="litem">
    <ul>
EOT;
foreach($pluginitem as $itemk=>$itemv)
{
print <<<EOT

     <li><a href="$urllink&action=setting&plugin=$itemv">$itemk</a></li>
EOT;
}
print <<<EOT

    </ul>
   </div>
EOT;
}
print <<<EOT

  </div>
  <div class="r">
EOT;
if ($action == 'list')
{
print <<<EOT

    <div class="rmenu">
     <ul>
      <li class="i150">插件名称</li>
      <li class="i60">状态</li>
      <li class="i60">版本</li>
      <li class="i100">作者</li>
      <li class="i400">描述</li>
      <li class="i50">操作</li>
     </ul>
    </div>
EOT;
	foreach($plugindb as $key => $plugin)
	{
print <<<EOT

    <dl class="ritem">
     <dd class="i150">$plugin[name]</dd>
     <dd class="i60"><a href="$urllink&action=active&active=$plugin[active]&pid=$plugin[pid]">
EOT;
	$stats = $plugin['active'] ? '已启用' : '已禁用';
print <<<EOT

	$stats</a></dd>
     <dd class="i60">$plugin[version]</dd>
     <dd class="i100"><a href="$plugin[url]" target="_blank" title="访问作者主页">$plugin[author]</a></dd>
     <dd class="i400">$plugin[description]</dd>
     <dd class="i50"><a href="$urllink&action=delete&pid=$plugin[pid]">删除</a></dd>
    </dl>
EOT;
	}
}
else if ($action=='install')
{
print <<<EOT

    <div class="rmenu">上传新插件</div>
    <dl class="ritem">
     <dd><p>请上传一个zip压缩格式的插件安装包。 <a href="./" target="_blank">获得更多插件</a></p></dd>
    </dl>
    <form action="$urllink" method="post" enctype="multipart/form-data">
     <input type="hidden" name="action" value="upload" />
     <dl class="ritem">
      <dd class="i100">插件压缩包:</dd><dd class="i300"><input class="formfield" type="file" name="pluzip"></dd>
     </dl>
     <dl class="ritem">
      <dd class="i100"><input type="submit" class="formbutton" value="上传" /></dd>
     </dl>
    </form>
EOT;
}
else if ($action == 'setting')
{
doAction('admin_plugin_setting_view');
}
print <<<EOT

  </div>
 </div>
EOT;
