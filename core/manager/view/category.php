<?php
print <<<EOT

 <div class="mainbody">
  <div class="l">
   <div class="lmenu">分类管理</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=category&action=add">添加分类</a></li>
     <li><a href="admin.php?file=category&action=list">分类管理</a></li>
    </ul>
   </div>
   <div class="lmenu">导航菜单</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=category&action=tagclear">标签整理</a></li>
     <li><a href="#">未完成哈</a></li>
    </ul>
   </div>
  </div>
  <div class="r">
   <form action="admin.php?file=category" method="POST">
EOT;
if ($action == 'list')
{
print <<<EOT

    <div class="rmenu">
     <ul>
      <li class="i100">排序</li>
      <li class="i200">名称</li>
      <li class="i200">友好网址</li>
      <li class="i100">文章数</li>
      <li class="i300">操作</li>
     </ul>
    </div>
EOT;
  function makeCate($cate)
  {
print <<<EOT

    <dl class="ritem">
     <dd class="i100"><input class="formfield" style="text-align: center;font-size: 11px;" type="text" value="{$cate['displayorder']}" name="displayorder[{$cate['cid']}]" size="1"></dd>
     <dd class="i200"><b>{$cate['name']}</b></dd>
     <dd class="i200"><b>{$cate['url']}</b></dd>
     <dd class="i100">{$cate['articles']}</dd>
     <dd class="i300"><a href="admin.php?file=category&action=add&pid={$cate['cid']}">添加分类</a> - <a href="admin.php?file=article&action=add&cid={$cate['cid']}">添加文章</a> - <a href="admin.php?file=category&action=mod&cid={$cate['cid']}">编辑</a> - <a href="admin.php?file=category&action=del&cid={$cate['cid']}">删除</a></dd>
   </dl>
EOT;
  }
  foreach($cateArr as $cid=>$cate)
  {
	  if ($cate['pid']=='0')
	  {
		  makeCate($cate);
		  makeCate2($cate['cid'],1,$cateArr);
	  }
  }
print <<<EOT

    <dl class="ritem">
     <dd class="i100"><input type="hidden" name="action" value="updatedisplayorder"><input type="submit" value="更新排序" class="formbutton"></dd>
    </dl>
EOT;
}
elseif (in_array($action, array('add', 'mod')))
{
  $self=$action=='add'?'':$cate['cid'];
  $option=getCateOption($cateArr,$cate['pid'],$self);
  $add=$action=='mod'&&$cate['pid']=='0'?' selected':'';
  $option='<option value="0"'.$add.'>顶级分类</option>'.$option;
print <<<EOT

    <input type="hidden" name="action" value="do{$action}">
    <input type="hidden" name="cid" value="$cate[cid]">
   <div class="rmenu">$subnav</div>
   <dl class="ritem">
    <dd class="i100">排序:</dd>
    <dd class="toleft"><input class="formfield" type="text" name="displayorder" size="4" maxlength="50" value="$cate[displayorder]"></td>
   </dl>
   <dl class="ritem">
    <dd class="i100">上级分类:</dd>
    <dd class="toleft"><select name="pid">$option</select></dd>
   </dl>
   <dl class="ritem">
    <dd class="i100">分类名称:</dd>
    <dd class="toleft"><input class="formfield" type="text" name="name" size="35" maxlength="50" value="$cate[name]"></dd>
   </dl>
   <dl class="ritem">
    <dd class="i100">友好网址:</dd>
    <dd class="toleft"><input class="formfield" type="text" name="url" size="35" maxlength="50" value="$cate[url]"></dd>
   </dl>
   <dl class="ritem">
    <dd class="i100">分类关键词:</dd>
    <dd class="toleft"><input class="formfield" type="text" name="keywords" size="35" maxlength="50" value="$cate[keywords]"></dd>
   </dl>
   <dl class="ritem">
    <dd class="i100">分类描述:</dd>
    <dd class="toleft"><input class="formfield" type="text" name="description" size="35" maxlength="50" value="$cate[description]"></dd>
   </dl>
   <dl class="ritem">
    <dd class="i100"><input type="submit" value="确定" class="formbutton"></dd>
   </dl>
EOT;
}
elseif ($action == 'del')
{
print <<<EOT

   <div class="rmenu">$subnav</div>
   <dl class="ritem">
    <dd><p>您确定要删除【$cate[name]】分类吗?<br /><b>本操作不可恢复，并会删除该分类中的所有文章、附件、评论</b></p></dd>
    </dl>
   <dl class="ritem">
    <dd class="i100"><input type="hidden" name="cid" value="$cate[cid]" /><input type="hidden" name="action" value="dodel" /><input type="submit" value="确定" class="formbutton" /></dd>
   </dl>
EOT;
}
print <<<EOT

</form>
  </div>
 </div>
EOT;
