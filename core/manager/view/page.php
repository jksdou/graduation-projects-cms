<?php
print <<<EOT

 <div class="mainbody">
  <div class="l">
   <div class="lmenu">独立页面管理</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=page&action=list">所有独立页面</a></li>
     <li><a href="admin.php?file=page&action=add">添加独立页面</a></li>
     <li><a href="admin.php?file=page&action=search">搜索页面</a></li>
     <li><a href="admin.php?file=page&action=list&view=hidden">草稿箱($hiddenCount)</a></li>
    </ul>
   </div>
  </div>
  <div class="r">
EOT;
if ($action=='add' || $action=='mod')
{
print <<<EOT

   <form action="$urllink&action=$action" method="post">
    <input type="hidden" value="$article[pid]" name="pid">
    <div class="rmenu">$navtitle</div>
    <dl class="ritem">
     <dd class="i80">页面标题</dd>
     <dd class="toleft"><input class="formfield" type="text" name="title" id="title" size="80" maxlength="100" value="$article[title]" placeholder="页面标题" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">标签</dd>
     <dd class="toleft"><input class="formfield" type="text" name="tag" size="80" maxlength="120" value="$article[tag]" placeholder="标签(Tag)" />&nbsp;多个Tag用,分隔</dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">关键字</dd>
     <dd class="toleft"><input class="formfield" type="text" name="keywords" size="80" maxlength="120" value="$article[keywords]" placeholder="关键字" />&nbsp;多个关键字用,分隔</dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">页面描述</dd>
     <dd class="toleft"><textarea name="excerpt" style="width:740px; height:100px;" placeholder="页面描述，摘要内容">$article[excerpt]</textarea></dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">页面内容</dd>
     <dd class="toleft"><textarea name="content" id="content" style="width:100%; height:400px;">$article[content]</textarea></dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">友好网址[必填]</dd>
     <dd class="toleft"><input class="formfield" type="text" name="url" size="80" maxlength="255" value="$article[url]" placeholder="友好网址" />&nbsp;20个字符以内</td>
    </dl>
    <dl class="ritem">
     <dd class="i80">发布选项</dd>
     <dd class="i200"><input name="visible" type="checkbox" value="1" $visible_check>不选则隐藏页面</dd>
    </dl>
    <dl class="ritem">
     <dd class="i100"><input type="submit" value="提交" class="formbutton"></dd>
    </dl>
   </form>
EOT;
}
else if ($action=='list')
{
	print <<<EOT

   <div class="rmenu">$navtitle</div>
    <div class="ritemenu">
     <ul>
      <li class="i400">标题</li>
      <li class="i130">时间</li>
      <li class="i100">网址</li>
      <li class="i50">查看</li>
      <li class="i90">作者</li>
      <li class="i50">显示</li>
      <li class="i15"><input name="chkall" value="on" type="checkbox" onclick="checkall(this.form)"></li>
     </ul>
   </div>
EOT;
	foreach($pagedbs as $key => $pagedb)
	{
print <<<EOT

    <dl class="ritem">
     <dd class="i400"><a href="$urllink&action=mod&pid={$pagedb['pid']}">$pagedb[title]</a></dd>
     <dd class="i130">$pagedb[dateline]</dd>
     <dd class="i100">$pagedb[url]</dd>
     <dd class="i50">$pagedb[views]</dd>
     <dd class="i90">$pagedb[username]</dd>
     <dd class="i50">$pagedb[visible]</dd>
     <dd class="i15"><input type="checkbox" name="pids[]" value="$article[pid]" />
    </dl>
EOT;
	}
print <<<EOT

   <dl class="ritem">
    <dd class="records">记录 $total</dd>
   </dl>
   <dl class="ritem">
    <dd><div class="multipage">$multipage</div></dd>
   </dl>
EOT;
}
print <<<EOT

  </div>
 </div>
EOT;
