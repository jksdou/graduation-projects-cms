<?php
print <<<EOT

 <div class="mainbody">
  <div class="l">
   <div class="lmenu">评论管理</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=comment">所有评论</a></li>
     <li><a href="admin.php?file=comment&action=list&kind=display">已审评论</a></li>
     <li><a href="admin.php?file=comment&action=list&kind=hidden"><font color="#FF0000">待审评论</font></a></li>
    </ul>
   </div>
  </div>
  <div class="r">
    <form action="admin.php?file=comment" method="POST" name="form">
EOT;
if ($action == 'list')
{
print <<<EOT

   <div class="rmenu">$subnav</div>
    <dl class="ritemenu">
      <dd class="i15"><input name="chkall" value="on" type="checkbox" onClick="checkall(this.form)" /></dd>
      <dd class="i35">状态</dd>
      <dd class="i100">作者</dd>
      <dd class="i80">网站地址</dd>
      <dd class="i80">电子邮箱</dd>
      <dd class="i100">IP</dd>
      <dd class="i130">时间</dd>
      <dd class="i380">内容</dd>

    </dl>
EOT;
	foreach($commentdb as $key => $comment)
	{
print <<<EOT

    <dl class="ritem">
     <dd class="i15"><input type="checkbox" name="comment[]" value="$comment[cid]"></dd>
     <dd class="i35"><a href="admin.php?file=comment&action=cmvisible&cid=$comment[cid]">$comment[visible]</a></dd>
     <dd class="i100">$comment[author]</dd>
     <dd class="i80">$comment[url]</dd>
     <dd class="i80">$comment[email]</dd>
     <dd class="i100"><a href="admin.php?file=comment&action=list&ip=$comment[ipaddress]" title="查看此IP同一时段发表的评论" >$comment[ipaddress]</a></dd>
     <dd class="i130">$comment[dateline]</dd>
     <dd class="i380"><a href="admin.php?file=comment&action=mod&cid=$comment[cid]" title="编辑此评论">$comment[content]</a></dd>

    </dl>
EOT;
	}
print <<<EOT

    <dl class="ritem">
     <dd><div class="records">记录:$total</div></dd>
    </dl>
    <dl class="ritem">
     <dd><div class="multipage">$multipage</div></dd>
    </dl>
EOT;
}
elseif ($action == 'mod')
{
print <<<EOT

    <div class="rmenu">$subnav</div>
    <dl class="ritem">
     <dd class="i100">所在文章:</dd>
     <dd><a href="admin.php?file=article&action=mod&aid=$comment[articleid]" title="点击编辑此文章" >$comment[title]</a></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">评论作者:</dd>
     <dd><input class="formfield" type="text" name="username" size="50" value="$comment[username]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">电子邮件:</dd>
     <dd><input class="formfield" type="text" name="email" size="50" value="$comment[email]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">网站地址:</dd>
     <dd><input class="formfield" type="text" name="url" size="50" value="$comment[url]"></dd>
    </dl>
    <dl class="ritem">
     <dd>评论内容:</dd>
    </dl>
    <dl class="ritem">
     <dd><textarea class="formarea" type="text" name="content" cols="75" rows="20">$comment[content]</textarea></dd>
    </dl>
    <dl class="ritem">
     <dd>
      <input type="hidden" name="cid" value="$comment[cid]">
      <input type="hidden" name="aid" value="$comment[articleid]">
      <input type="hidden" name="userid" value="$comment[userid]">
      <input type="hidden" name="action" value="domodcm">
      <input type="submit" value="提交" class="formbutton">
      <input type="reset" value="重置" class="formbutton">
     </dd>
    </dl>
EOT;
}
if (in_array($action, array('list')))
{
print <<<EOT

    <dl class="ritem">
     <dd class="lhalf">
      <select name="do">
       <option value="">管理操作</option>
EOT;
	if ($action == 'list' || $action == 'tblist')
	{
print <<<EOT

       <option value="hidden">隐藏选定</option>
       <option value="display">显示选定</option>
EOT;
	}
print <<<EOT

       <option value="del">删除选定</option>
      </select>
     </dd>
     <dd class="lhalf">
      <input type="submit" value="确定" class="formbutton"><input type="hidden" name="action" value="domore{$action}">
     </dd>
    </dl>
EOT;
}
print <<<EOT

   </form>
  </div>
 </div>
EOT;
