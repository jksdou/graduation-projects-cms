<?php
print <<<EOT

<script type="text/javascript">
function really(d,m,n)
{
	if (confirm(m))
	{
		window.location.href='admin.php?file=template&action=delonetag&tag='+d+'&tagid='+n;
	}
}
</script>
 <div class="mainbody">
  <div class="l">
   <div class="lmenu">模板管理</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=template&action=template">模板管理</a></li>
     <li><a href="admin.php?file=template&action=tool">模板工具</a></li>
     <li><a href="admin.php?file=template&action=filelist">文件列表</a></li>
     <li><a href="admin.php?file=template&action=newtemplate">新建模板</a></li>
    </ul>
   </div>
   <div class="lmenu">模板变量</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=template&action=stylevar">自定义变量</a></li>
    </ul>
   </div>
  </div>
  <div class="r">
EOT;
if ($action == 'stylevar')
{
print <<<EOT

    <div class="rmenu">关于自定义模板变量</div>
   <dl class="ritem">
    <dd class="toleft"><p>设置一个变量about,内容为 &lt;b&gt;关于我&lt;/b&gt;<br />那么在前后台模板的任意地方,均可以放一个 <b>\$varArr[about]</b> 变量,模板则直接显示 <b>关于我</b></p></dd>
   </dl>
EOT;
}
if ($action == 'template')
{
print <<<EOT

    <div class="rmenu">
     <ul>
      <li class="i100">当前模板</li>
      <li class="i150">作者</li>
      <li class="i100">适用版本</li>
      <li class="i335">所在位置</li>
      <li class="toleft">描述</li>
     </ul>
    </div>
EOT;
	if ($current_template_info)
	{
print <<<EOT

   <dl class="ritem">
    <dd class="i100">$current_template_info[name]</dd>
    <dd class="i150">$current_template_info[author]</dd>
    <dd class="i100">$current_template_info[version]</dd>
    <dd class="i335"><b>$current_template_info[templatedir]</b></dd>
    <dd class="toleft">$current_template_info[description]</dd>
   </dl>
   <dl class="ritem">
    <dd class="toleft">模板预览</dd>
   </dl>
   <dl class="ritem">
    <dd class="toleft"><img alt="$current_template_info[name]" src="$current_template_info[screenshot]" border="0" class="currenttheme"/></dd>
   </dl>
EOT;
	}
	else
	{
print <<<EOT

   <dl class="ritem"><dd class="toleft">没有当前主题的相关资料</dd></dl>
EOT;
	}
print <<<EOT

    <div class="rmenu">可用模板</div>
   <dl class="ritem">
EOT;
	if ($available_template_db)
	{
		foreach($available_template_db as $id => $template)
		{
print <<<EOT

    <dd class="i335">
     <p>模板名：<b>$template[name]</b>&nbsp;<a title="设为当前站点主题" href="admin.php?file=template&action=settemplate&name=$template[dirurl]">设为当前站点主题</a><br />作者：$template[author]<br />适用版本：$template[version]<br />所在位置：<b>$template[templatedir]</b><br />描述：$template[description]</p>
     <p>点击图片查看此主题预览图片</p>
     <p><div class="availabletheme"><a href="$template[screenshot]" target="_blank"><img src="$template[screenshot]" border="0" alt="点击图片查看此主题预览图片" class="screenshot" /></a></div></p>
    </dd>
EOT;
		}
	}
	else
	{
print <<<EOT

    <dd class="i200"><b>没有可用模板</b></dd>
EOT;
	}
print <<<EOT

   </dl>
EOT;
}
elseif ($action == 'stylevar')
{
print <<<EOT

    <form action="admin.php?file=template" method="post" name="form"><input type="hidden" name="action" value="domorestylevar" />
     <div class="rmenu">
      <ul>
       <li class="i50">状态</li>
       <li class="i220">变量名</li>
       <li class="toleft">变量内容</li>
       <li class="toright">删除<input name="chkall" value="on" type="checkbox" onclick="checkall(this.form)" /></li>
      </ul>
     </div>
EOT;
	foreach($stylevardb as $stylevar)
	{
print <<<EOT

    <dl class="ritem">
     <dd class="i50"><select name="visible[$stylevar[vid]]">$stylevar[visible]</select></dd>
     <dd class="i220">\$varArr[$stylevar[title]]</dd>
     <dd class="toleft"><textarea id="varid_$stylevar[vid]" class="formarea" name="stylevar[$stylevar[vid]]" style="width:400px;height:30px;">$stylevar[value]</textarea> <b><a href="javascript:void(0);" onclick="resizeup('varid_$stylevar[vid]');">[+]</a> <a href="javascript:void(0);" onclick="resizedown('varid_$stylevar[vid]');">[-]</a></b></dd>
     <dd class="toright"><input type="checkbox" name="delete[]" value="$stylevar[vid]" /></dd>
    </dl>
EOT;
	}
print <<<EOT

     <dl class="ritem">
      <dd class="i100"><div class="records">记录:$total</div></dd>
     </dl>
     <dl class="ritem">
      <dd class="toleft"><div class="multipage">$multipage</div></dd>
     </dl>
     <dl class="ritem">
      <dd class="toleft"><input type="submit" value="更新设置" class="formbutton" /></dd>
      <dd class="toright"><input type="submit" value="删除(所选)" class="formbutton" /></dd>
     </dl>
    </form>
    <div class="rmenu">添加自定义变量</div>
    <form action="admin.php?file=template" method="post" name="form"><input type="hidden" name="action" value="addstylevar" />
     <dl class="ritem">
      <dd class="i80"><b>变量名</b></dd>
      <dd class="toleft"><input class="formfield" type="text" name="title" size="35" maxlength="50" /> 只允许英文</dd>
     </dl>
     <dl class="ritem">
      <dd class="i80"><b>变量内容</b></dd>
      <dd class="toleft"><textarea id="addvar" class="formarea" type="text" name="value" style="width:400px;height:50px;"></textarea> <b><a href="javascript:void(0);" onclick="resizeup('addvar');">[+]</a> <a href="javascript:void(0);" onclick="resizedown('addvar');">[-]</a></b></dd>
     </dl>
     <dl class="ritem"><dd class="toleft"><input type="submit" value="添加" class="formbutton" /></dd></dl>
    </form>
EOT;
}
elseif ($action == 'filelist')
{
print <<<EOT

     <div class="rmenu">
      <ul>
       <li class="i150">模板名</li>
       <li class="toleft">操作</li>
      </ul>
     </div>
EOT;
	foreach($filedb as $key => $file)
	{
print <<<EOT

    <dl class="ritem">
     <dd class="i150"><b><a href="admin.php?file=template&action=mod&path=$path&file=$file[filename]&ext=$file[extension]">$file[filename]</a></b></dd>
     <dd class="i150"><b><a href="admin.php?file=template&action=mod&path=blog&file=login&ext=php">login.php</a></b></dd>
     <dd class="toleft"><a href="admin.php?file=template&action=del&path=$path&file=$file[filename]&ext=$file[extension]">删除</a></dd>
    </dl>
EOT;
	}
print <<<EOT

    <dl class="ritem">
     <dd class="i220">共有 $i 个模板文件</dd>
    </dl>
EOT;
}
elseif ($action == 'mod')
{
print <<<EOT

    <div class="rmenu">编辑模板文件</div>
    <form action="admin.php?file=template" method="post" name="form">
     <input type="hidden" name="action" value="savefile" />
EOT;
	if (!$writeable)
	{
print <<<EOT

     <dl class="ritem">
      <dd class="i80"><b>写入状态</b></dd>
      <dd class="toleft"><span class="no"><b>当前模板文件不可写入, 请设置为 0777 权限后再编辑此文件.</b></span></dd>
     </dl>
EOT;
	}
print <<<EOT

     <dl class="ritem">
      <dd class="i80"><b>模板套系:</b></dd>
      <dd class="toleft">$path<input type="hidden" name="path" value="$path" /></dd>
     </dl>
     <dl class="ritem">
      <dd class="i80"><b>模板名称</b></dd>
      <dd class="toleft">$file<input type="hidden" name="file" value="$file" /><input type="hidden" name="ext" value="$ext" /></dd>
     </dl>
     <dl class="ritem">
      <dd class="i80"><b>模板内容:</b><br /><b><a href="javascript:void(0);" onclick="resizeup('filecontent');">[+]</a> <a href="javascript:void(0);" onclick="resizedown('filecontent');">[-]</a></b></dd>
      <dd class="toleft"><textarea id="filecontent" class="formarea" cols="100" rows="25" name="content" style="width:95%;height:400px;font:12px'Courier New';">$contents</textarea></dd>
     </dl>
     <dl class="ritem">
      <dd class="i80"><input type="submit" value="保存" class="formbutton" /></dd>
      <dd class="toleft"><input type="reset" value="重置" class="formbutton" /></dd>
     </dl>
    </form>
EOT;
}
elseif ($action == 'newtemplate')
{
print <<<EOT

    <div class="rmenu">新建模板</div>
    <form action="admin.php?file=template" method="post" name="form">
     <input type="hidden" name="action" value="donewtemplate">
     <dl class="ritem">
      <dd class="i100"><b>模板名称</b></dd>
      <dd class="toleft"><input class="formfield" type="text" name="newtemplatename" value=""> 只允许英文、数字和下划线</dd>
     </dl>
     <dl class="ritem">
      <dd class="i80"><input type="submit" value="保存" class="formbutton" /></dd>
      <dd class="toleft"><input type="reset" value="重置" class="formbutton" /></dd>
     </dl>
    </form>
EOT;
}
elseif ($action == 'del')
{
print <<<EOT

    <div class="rmenu">删除模板</div>
    <form action="admin.php?file=template" method="post" name="form">
     <dl class="ritem">
      <dd class="i100">模板套系: <a href="admin.php?file=template&action=filelist&path=$path">$path</a></dd>
      <dd class="toleft">模板文件: <a href="admin.php?file=template&action=mod&path=$path&file=$file">$file</a></dd>
     </dl>
     <dl class="ritem">
      <dd class="toleft"><b>注意: 删除模板文件将不会显示和该模板有关的一切页面，确定吗？</b></dd>
     </dl>
     <dl class="ritem">
      <dd class="i100">
      <input type="hidden" name="path" value="$path" />
      <input type="hidden" name="file" value="$file" />
      <input type="hidden" name="ext" value="$ext" />
      <input type="hidden" name="action" value="delfile" />
      <input type="submit" value="确认" class="formbutton" />
      </dd>
     </dl>
     </form>
EOT;
}
print <<<EOT

  </div>
 </div>
EOT;
