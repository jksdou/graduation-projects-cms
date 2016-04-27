<?php
print <<<EOT

 <div class="mainbody">
  <div class="l">
   <div class="lmenu">链接管理</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=link&action=add">添加链接</a></li>
     <li><a href="admin.php?file=link&action=list">链接列表</a></li>
    </ul>
   </div>
  </div>
  <div class="r">
   <form action="admin.php?file=link" method="POST" name="form">
EOT;
if ($action == 'add')
{
print <<<EOT

    <div class="rmenu">$subnav</div>
    <input type="hidden" name="action" value="addlink">
    <dl class="ritem">
     <dd class="i100"><div class="records">状态</div></dd>
     <dd class="i200"><select name="visible"><option value="1" selected>显示</option><option value="0">隐藏</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">名称</dd>
     <dd class="i200"><input class="formfield" name="name" type="text" value="" size="18" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">地址</dd>
     <dd class="i200"><input class="formfield" name="url" type="url" value="" size="35" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">描述</dd>
     <dd class="i200"><input class="formfield" name="note" type="text" value="" size="35" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">位置</dd>
     <dd class="i200"><select name="type"><option value="0" selected>友情链接</option><option value="1">首页链接</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">备注</dd>
     <dd class="i200"><input class="formfield" name="bak" type="text" value="" size="35" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100"><input type="submit" value="提交" class="formbutton" /><input type="reset" value="重置" class="formbutton" /></dd>
    </dl>
EOT;
}
elseif ($action == 'list')
{
print <<<EOT

    <div class="rmenu">
     <ul>
      <li class="i35">排序</li>
      <li class="i50">状态</li>
      <li class="i120">名称</li>
      <li class="i200">地址</li>
      <li class="i200">描述</li>
      <li class="i150">备注</li>
      <li class="i80">位置</li>
      <li class="i15"><input type="hidden" name="action" value="domorelink"><input name="chkall" value="on" type="checkbox" onclick="checkall(this.form)"></li>
     </ul>
    </div>
EOT;
foreach($linkdb as $key => $link)
{
print <<<EOT

    <dl class="ritem">
     <dd class="i35"><input class="formfield" style="text-align:center;font-size:11px;" type="text" value="$link[displayorder]" name="displayorder[$link[lid]]" size="1"></dd>
     <dd class="i50"><select name="visible[$link[lid]]">$link[visible]</select></dd>
     <dd class="i120"><input class="formfield" name="name[$link[lid]]" type="text" value="$link[name]" size="15"></dd>
     <dd class="i200"><input class="formfield" name="url[$link[lid]]" type="text" value="$link[url]" size="28"></dd>
     <dd class="i200"><input class="formfield" name="note[$link[lid]]" type="text" value="$link[note]" size="28"></dd>
     <dd class="i150"><input class="formfield" name="bak[$link[lid]]" type="text" value="$link[bak]" size="19"></dd>
     <dd class="i80"><select name="type[$link[lid]]">$link[type]</select></dd>
     <dd class="i15" nowrap><input type="checkbox" name="delete[]" value="$link[lid]"></dd>
    </dl>
EOT;
}
print <<<EOT

    <dl class="ritem">
     <dd class="i100"><input type="submit" value="更新 / 删除(所选)" class="formbutton"></dd>
    </dl>
EOT;
}
print <<<EOT

   </form>
  </div>
 </div>
EOT;
