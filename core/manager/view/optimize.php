<?php
print <<<EOT
 <div class="mainbody">
  <div class="l">
   <div class="lmenu">标签管理</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=optimize&action=taglist">标签管理</a></li>
     <li><a href="admin.php?file=optimize&action=tagclear">标签重建</a></li>
    </ul>
   </div>
   <div class="lmenu">网址链接</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=optimize&action=addredirect">添加跳转</a></li>
     <li><a href="admin.php?file=optimize&action=redirect">自动跳转</a></li>
    </ul>
   </div>
  </div>
  <div class="r">
   <form action="admin.php?file=optimize" method="POST">
EOT;
if ($action == 'taglist') { print <<<EOT
    <div class="rmenu">
     <ul>
      <li class="i200">Tags名称</li>
      <li class="i100">使用次数</li>
      <li class="i50">操作</li>
      <li class="i15"" nowrap><input type="hidden" name="action" value="deltag" /><input name="chkall" type="checkbox" onclick="checkall(this.form)" value="on" /></li>
     </ul>
    </div>
EOT;
foreach($tagdb as $key => $tag){print <<<EOT
    <dl class="ritem">
     <dd class="i200"><a href="admin.php?file=article&action=list&tag=$tag[url]">$tag[item]</a></dd>
     <dd class="i100">$tag[usenum]</dd>
     <dd class="i50"><a href="admin.php?file=optimize&action=modtag&tag=$tag[url]">修改</a></dd>
     <dd class="i15"><input type="checkbox" name="tag[$tag[item]]" value="$tag[item]" /></dd>
    </dl>
EOT;
} print <<<EOT
    <dl class="ritem">
     <dd class="i200"><div class="records">记录:$total</div></dd>
    </dl>
    <dl class="ritem">
     <dd><div class="multipage">$multipage</div></dd>
    </dl>
    <dl class="ritem">
     <dd><input type="submit" value="删除所选" class="formbutton" /></dd>
    </dl>
EOT;
}
elseif ($action == 'modtag') { print <<<EOT

    <input type="hidden" name="oldtag" value="$tag">
    <input type="hidden" name="action" value="modtag">
    <div class="rmenu">修改标签</div>
    <dl class="ritem">
     <dd class="i100">标签名</dd><dd class="i300"><input class="formfield" type="text" name="tag" size="35" maxlength="50" value="$tag" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100"><input type="submit" value="确认修改" class="formbutton" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">使用次数</dd><dd class="i50">$usenum</dd>
    </dl>
    <div class="rmenu">使用此标签的文章</div>
    <dl class="ritem">
     <dd>
EOT;
foreach($articledb as $key => $article) { print <<<EOT
<p><a href="admin.php?file=article&action=mod&aid=$article[aid]" title="点击修改此文章" >$article[title]</a></p>
EOT;
} print <<<EOT
</dd>
EOT;
} elseif ($action == 'modredirect'||$action == 'addredirect') { print <<<EOT
    <input type="hidden" name="action" value="$action" />
EOT;
if ($action == 'modredirect') {
$add='修改';
print <<<EOT
<input type="hidden" name="rid" value="$rid" />
EOT;
} else {
$add='添加';
} print <<<EOT
    <div class="rmenu">{$add}转向网址(通过纯正则替换产生新网址)</div>
    <dl class="ritem">
     <dd class="i50">原网址</dd>
     <dd class="i335"><input class="formfield" type="text" name="old" size="50" maxlength="50" value="{$redirectdb['old']}" /></dd>
     <dd class="i60">转向地址</dd>
     <dd class="i335"><input class="formfield" type="text" name="new" size="50" maxlength="50" value="{$redirectdb['new']}" /></dd>
     <dd class="i60">转向状态</dd>
     <dd class="i50"><select name="status"><option value="1" $selected301>301</option><option value="2" $selected302>302</option></select></dd>
    </dl>
EOT;
print <<<EOT
    <dl class="ritem">
     <dd class="i100"><input type="submit" value="确认" class="formbutton" /></dd>
    </dl>
EOT;
} elseif ($action == 'redirect') { print <<<EOT
    <input type="hidden" name="action" value="delredirect" />
    <div class="rmenu">
     <ul>
      <li class="i35">编号</li>
      <li class="i335">原网址</li>
      <li class="i335">转向地址</li>
      <li class="i60">转向方式</li>
      <li class="i50">操作</li>
      <li class="i15" nowrap><input name="chkall" type="checkbox" onclick="checkall(this.form)" value="on" /></li>
     </ul>
    </div>
EOT;
foreach($redirectdb as $key => $rdb) { print <<<EOT
    <dl class="ritem">
     <dd class="i35">$rdb[rid]</dd>
     <dd class="i335">$rdb[old]</dd>
     <dd class="i335">$rdb[new]</dd>
     <dd class="i60">$rdb[status]</dd>
     <dd class="i50"><a href="admin.php?file=optimize&action=modredirect&rid=$rdb[rid]">修改</a></dd>
     <dd class="i15" nowrap><input type="checkbox" name="rid[$rdb[rid]]" value="$rdb[rid]" /></dd>
    </dl>
EOT;
} print <<<EOT
    <dl class="ritem">
     <dd class="i100"><div class="records">记录:$total</div></dd>
    </dl>
    <dl class="ritem">
     <dd><div class="multipage">$multipage</div></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100"><input type="submit" value="删除所选" class="formbutton" /></dd>
    </dl>
EOT;
} elseif ($action == 'tagclear') { print <<<EOT
    <div class="rmenu">清理Tags</div>
    <input type="hidden" name="action" value="dotagclear">
    <dl class="ritem">
     <dd><p>当您对数据库进行批量操作后,统计信息可能会不准确，本功能是重新统计各个Tag的使用次数和清理不使用的Tag。<br />为了使Tags数据最准确，本次操作将清空Tags数据表，并读取每篇文章的关键字，重新写入Tags数据表。<p>建议定期执行。<br /><b>处理过程需要进行大量计算，故需要一定时间才能生效，请耐心等待。</p></dd>
    </dl>
    <dl class="ritem">
     <dd>每次处理文章数: <input class="formfield" type="text" name="percount" size="15" maxlength="50" value="200"></dd>
    </dl>
    <dl class="ritem">
     <dd><input type="submit" value="确认" class="formbutton" />(此功能正在开发中，暂时用不成哈。)</dd>
    </dl>
EOT;
} print <<<EOT
   </form>
  </div>
 </div>
EOT;
?>
