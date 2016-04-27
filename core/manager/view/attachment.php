<?php
print <<<EOT

 <div class="mainbody">
  <div class="l">
   <div class="lmenu">附件查看</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=attachment&action=list&view=image">图片附件</a></li>
     <li><a href="admin.php?file=attachment&action=list&view=file">文件附件</a></li>
     <li><a href="admin.php?file=attachment&action=list&view=hot">热门附件</a></li>
     <li><a href="admin.php?file=attachment&action=list&view=big">最大附件</a></li>
    </ul>
   </div>
   <div class="lmenu">附件管理</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=attachment&action=repair">附件修复</a></li>
     <li><a href="admin.php?file=attachment&action=clear">附件清理</a></li>
    </ul>
   </div>
  </div>
  <div class="r">
EOT;
if ($action == 'list')
{
	if (!$aid)
	{
print <<<EOT

   <div class="rmenu" >附件概要信息</div>
   <dl class="ritem">
    <dd class="lhalf">附件数量:</dd><dd class="toleft">$stats[count] 个</dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf">数据库记录全部附件大小:</dd><dd class="toleft">$stats[sum]</dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf">当前附件存放路径:</dd><dd class="toleft">$a_dir$warning</dd>
   </dl>
    <dl class="ritem">
    <dd class="lhalf">附件目录内子目录数量:</dd><dd class="toleft">$dircount 个</dd>
   </dl>
EOT;
	}
	else
	{
print <<<EOT

  <form action="admin.php?file=attachment" method="post" enctype="multipart/form-data">
  <input type="hidden" name="action" value="addattachtoarticle" />
  <input type="hidden" name="aid" value="$aid" />
  <div class="rmenu">上传新附件到该文章</div>
   <dl class="ritem">
    <dd><p>图片超过2M缩略图和水印均不生效.如果上传大于2M的图片请自行处理.</p></dd>
   </dl>
   <dl class="ritem"><dd class="i50">附件:</dd></dl>
   <dl class="ritem">
    <dd><input class="formfield" type="file" name="attach[0]"><input class="formfield" type="file" name="attach[1]"><input class="formfield" type="file" name="attach[2]"><input class="formfield" type="file" name="attach[3]">
  </dl>
   <dl class="ritem">
    <dd class="lhalf"><input type="submit" class="formbutton" value="上传" /></dd>
  </dl>
  </form>
EOT;
	}
print <<<EOT

   <form action="admin.php?file=attachment"  method="post">
    <input type="hidden" name="action" value="delattachments" />
    <input type="hidden" name="aid" value="$aid" />
    <div class="rmenu">$subnav</div>
    <dl class="ritemenu">
      <dd class="i335">附件名</dd>
      <dd class="i220">附件信息</dd>
      <dd class="i100">所在目录</dd>
      <dd class="i130">上传时间</dd>
      <dd class="i70">下载次数</dd>
      <dd class="i30">查看</dd>
      <dd class="i15"><input name="chkall" value="on" type="checkbox" onclick="checkall(this.form)" /></dd>
    </dl>
EOT;
	foreach($attachdb as $key => $attach)
	{
		$atturl=mkUrl('attachment.php',$attach['aid']);
		$arturl='admin.php?file=article&action=mod&aid='.$attach['articleid'];
print <<<EOT

    <dl class="ritem">
     <dd class="i335"><a href="{$atturl}" target="_blank" title="$attach[filepath]">$attach[filename]</a></dd>
     <dd class="i220">类型:$attach[filetype]&nbsp;大小:$attach[filesize]</dd>
     <dd class="i100">$attach[subdir]</dd>
     <dd class="i130">$attach[dateline]</dd>
     <dd class="i70">$attach[downloads]</dd>
     <dd class="i30"><a title="$attach[article]" href="{$arturl}" target="_blank">查看</a></dd>
     <dd class="i15"><input type="checkbox" name="attachment[]" value="$attach[aid]" /></dd>
    </dl>
EOT;
	}
print <<<EOT

    <dl class="ritem"><dd><div class="records">记录:$total</div></dd></dl>
    <dl class="ritem"><dd><div class="multipage">$multipage</div></dd></dl>
    <dl class="ritem"><dd><input type="submit" class="formbutton" value="删除所选附件" /></dd></dl>
   </form>
EOT;
}
elseif ($action == 'repair')
{
print <<<EOT
   <div class="rmenu">$navtitle</div>
   <dl class="ritem">
    <dd class="toleft">本功能清除数据库那存在附件记录而没有附件文件的冗余数据，文章中的附件记录也将同时更新。<br />如果附件较多，过程会比较久，请耐心等候。<br />建议定期执行。</dd>
   </dl>
   <dl class="ritem">
    <dd class="i80">
    <form action="admin.php?file=attachment" method="post">
     <input type="hidden" name="action" value="dorepair" /><input type="submit" value="确认" class="formbutton" />
    </form>
    </dd>
   </dl>
EOT;
}
elseif ($action == 'clear')
{
print <<<EOT

   <div class="rmenu">$navtitle</div>
   <form action="admin.php?file=attachment" method="post">
    <dl class="ritem">
     <dd class="toleft"><p>本功能删除数据库中没有记录而实际存在的附件，可有效清理冗余附件。</p></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">循环处理数量: <input class="formfield" type="text" name="percount" value="500" size="5" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i80"><input type="hidden" name="action" value="doclear" /><input type="submit" value="确认" class="formbutton" /></dd>
    </dl>
   </form>
EOT;
}
print <<<EOT

  </div>
 </div>
EOT;
