<?php
print <<<EOT
 <div class="mainbody">
  <div class="l">
   <div class="lmenu">用户管理</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=user&action=add">添加用户</a></li>
    </ul>
   </div>
   <div class="lmenu">降序排列</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=user&action=list&order=username">用户名</a></li>
     <li><a href="admin.php?file=user&action=list&order=logincount">登陆次数</a></li>
     <li><a href="admin.php?file=user&action=list&order=regdateline">注册时间</a></li>
    </ul>
   </div>
   <div class="lmenu">发表与否</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=user&action=list&lastpost=already">发表过评论</a></li>
     <li><a href="admin.php?file=user&action=list&lastpost=never">从未发表过评论</a></li>
    </ul>
   </div>
   <div class="lmenu">用户组</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=user&action=list&groupid=3">管理员组</a></li>
     <li><a href="admin.php?file=user&action=list&groupid=2">编辑员组</a></li>
     <li><a href="admin.php?file=user&action=list&groupid=1">注册组</a></li>
    </ul>
   </div>
  </div>
  <div class="r">
   <div class="rmenu">搜索用户</div>
   <form method="post" action="admin.php?file=user&action=list">
    <dl class="ritem">
		<dd class="i200"><input class="formfield" type="text" size="25" name="srhname" value="" placeholder="输入用户名" /></dd>
		<dd class="i100"><input class="formbutton" type="submit" value="搜索" /></dd>
	</dl>
   </form>
   <form action="admin.php?file=user" method="POST">
EOT;
if ($action == 'list')
{
print <<<EOT

    <div class="rmenu">$subnav</div>
    <dl class="ritemenu">
      <dd class="i100">用户名</dd>
      <dd class="i70">用户组</dd>
      <dd class="i80">电子邮箱</dd>
      <dd class="i150">个人网站</dd>
      <dd class="i80">注册时间</dd>
      <dd class="i60">登陆次数</dd>
      <dd class="i100">最后登陆IP</dd>
      <dd class="i130">最后登陆时间</dd>
      <dd class="i100">最后评论时间</dd>
      <dd class="i15"><input name="chkall" value="on" type="checkbox" onclick="checkall(this.form)" /></dd>
    </dl>
EOT;
	foreach($userdb as $key => $user)
	{
print <<<EOT

    <dl class="ritem">
     <dd class="i100"><a href="admin.php?file=user&action=mod&userid=$user[uid]" title="编辑用户资料">$user[username]</a></dd>
     <dd class="i70">$user[group]</dd>
     <dd class="i80">$user[email]</dd>
     <dd class="i150">$user[usersitename]</dd>
     <dd class="i80">$user[regdateline]</dd>
     <dd class="i60">$user[logincount]</dd>
     <dd class="i100"><a href="admin.php?file=user&action=list&ip=$user[loginip]">$user[loginip]</a></dd>
     <dd class="i130">$user[logintime]</dd>
     <dd class="i100">$user[lastpost]</dd>
     <dd class="i15"><input type="checkbox" name="user[]" value="$user[uid]" $user[disabled] /></dd>
    </dl>
EOT;
	}
print <<<EOT

    <dl class="ritem"><dd class="i150">记录:$total</dd></dl>
    <dl class="ritem"><dd><div class="multipage">$multipage</div></dd></dl>
    <dl class="ritem">
      <dd class="i100"><input type="hidden" name="action" value="del" /><input type="submit" class="formbutton" value="删除所选用户" /></dd>
    </dl>
EOT;
}
elseif (in_array($action, array('add', 'mod')))
{
print <<<EOT

    <div class="rmenu">$navtitle</div>
    <dl class="ritemenu"><dd>必填资料</dd></dl>
    <dl class="ritem">
     <dd class="i100">登陆名</dd>
     <dd class="i240"><input class="formfield" type="text" name="username" size="35" value="$info[username]" $readonly placeholder="登陆后台的登陆名" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">新密码</dd>
     <dd class="i240"><input class="formfield" type="password" name="newpassword" size="35" value="" placeholder="不修改请留空" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">确认新密码</dd>
     <dd class="i240"><input class="formfield" type="password" name="comfirpassword" size="35" value="" placeholder="请再输入一次密码，不修改请留空" /></dd>
    </dl>
EOT;
//这个判断估计有问题
if ($userid != 1 && $groupid < 3)
{
print <<<EOT

    <dl class="ritem">
     <dd class="i100">所属站点</dd>
     <dd class="i240"><input class="formfield" type="text" name="hostid" size="35" value="$info[hostid]" placeholder="用户所属站点" /></dd>
    </dl>
EOT;
}
print <<<EOT

    <dl class="ritem">
     <dd class="i100">用户组</dd>
     <dd class="i240">
      <select name="groupid">
EOT;
if ($showgid != $groupid)
{
print <<<EOT

       <option value="1" $groupselect[1]>注册组</option>
EOT;
}
if ($showgid < $groupid && $groupid > 2 || $showgid == 2 && $groupid == 2)
{
print <<<EOT

       <option value="2" $groupselect[2]>撰写组</option>
EOT;
}
if ($showgid < $groupid && $groupid > 3 || $showgid == 3 && $groupid == 3)
{
print <<<EOT

       <option value="3" $groupselect[3]>管理组</option>
EOT;
}
if ($showgid == 4 && $groupid == 4)
{
print <<<EOT

       <option value="4" $groupselect[4]>创始人</option>
EOT;
}
print <<<EOT

      </select>
     </dd>
    </dl>
    <dl class="ritemenu"><dd>备用资料</dd></dl>
    <dl class="ritem">
     <dd class="i100">个性昵称</dd>
     <dd class="i240"><input class="formfield" type="text" name="usernickname" size="35" value="$info[usernickname]" placeholder="个性昵称" /></dd>
    </dl>
    </dl>
    <dl class="ritem">
     <dd class="i100">电子邮箱</dd>
     <dd class="i240"><input class="formfield" type="text" name="email" size="35" value="$info[email]" placeholder="电子邮箱" /></dd>
    </dl>
    </dl>
    <dl class="ritem">
     <dd class="i100">个人主页</dd>
     <dd class="i240"><input class="formfield" type="text" name="usersitename" size="35" value="$info[usersitename]" placeholder="个人主页名称" /></dd>
     <dd class="i240"><input class="formfield" type="text" name="usersiteurl" size="35" value="$info[usersiteurl]" placeholder="个人主页地址" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">腾讯QQ</dd>
     <dd class="i240"><input class="formfield" type="text" name="qq" size="35" value="$info[qq]" placeholder="腾讯QQ" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">MSN</dd>
     <dd class="i240"><input class="formfield" type="text" name="msn" size="35" value="$info[msn]" placeholder="MSN" ></dd>
    </dl>
    <dl class="ritem">
     <input type="hidden" name="userid" value="$info[uid]" /><input type="hidden" name="action" value="$do" />
     <dd class="i100"><input type="submit" value="提交" class="formbutton" /></dd>
     <dd class="i100"><input type="reset" value="重置" class="formbutton" /></dd>
    </dl>
EOT;
}
elseif ($action == 'del')
{
print <<<EOT

    <div class="rmenu">删除用户</div>
    <dl class="ritem">
     <dd class="toleft"><b>注意:<br />创始人和管理员不能删除,要删除其他管理员请先把用户组改成其他组.<br />删除用户并不会删除用户发表过的评论.</b></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">当前操作用户</dd>
EOT;
foreach($userdb as $user)
{
print <<<EOT

     <dd class="i100"><a href="admin.php?file=user&action=mod&userid=$user[uid]">$user[username]</a><input type="hidden" name="user[]" value="$user[uid]"></dd>
EOT;
}
print <<<EOT

    </dl>
    <dl class="ritem">
     <dd class="toleft"><b>你确实要删除以上用户吗? 此操作一旦执行, 将无法撤销!</b><br />如果有撰写组的用户,删除其所发表的文章:<select name="deluserarticle"><option value="1">是</option><option value="0" selected>否</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="i50">
      <input type="submit" name="submit" id="submit" value="确认" class="formbutton"></p><input type="hidden" name="action" value="delusers">
     </dd>
    </dl>
EOT;
}
print <<<EOT

   </form>
  </div>
 </div>
EOT;
