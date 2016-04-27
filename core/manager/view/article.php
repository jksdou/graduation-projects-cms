<?php
print <<<EOT

 <div class="mainbody">
  <div class="l">
   <div class="lmenu">文章管理</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=article&action=add">添加文章</a></li>
     <li><a href="admin.php?file=article&action=list">所有文章</a></li>
     <li><a href="admin.php?file=article&action=search">搜索文章</a></li>
     <li><a href="admin.php?file=article&action=list&view=hidden">草稿箱($hiddenCount)</a></li>
    </ul>
   </div>
   <div class="lmenu">文章分类</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=article&action=list&view=stick">置顶文章</a></li>
EOT;
foreach($cateArr as $key => $cate)
{
print <<<EOT

     <li><a href="admin.php?file=article&action=list&cid={$cate['cid']}">{$cate['name']}</a></li>
EOT;
}
print <<<EOT

    </ul>
   </div>
  </div>
  <div class="r">
   <form action="admin.php?file=article" enctype="multipart/form-data" method="POST" name="form1"">
EOT;
if ($action == 'list')
{
print <<<EOT

    <div class="rmenu">$navtitle</div>
    <div class="ritemenu">
     <ul>
      <li class="i400">标题</li>
      <li class="i130">时间</li>
      <li class="i100">分类</li>
      <li class="i50">查看</li>
      <li class="i50">回复</li>
      <li class="i70">附件</li>
      <li class="i90">作者</li>
      <li class="i15"><input name="chkall" value="on" type="checkbox" onclick="checkall(this.form)" /></li>
     </ul>
    </div>
EOT;
  foreach($articledb as $key => $article)
  {
print <<<EOT

    <dl class="ritem">
     <dd class="i400"><a href="admin.php?file=article&action=mod&aid=$article[aid]">$article[title]</a></dd>
     <dd class="i130">$article[dateline]</dd>
     <dd class="i100"><a href="admin.php?file=article&action=list&cid=$article[cateid]">$article[cname]</a></dd>
     <dd class="i50">$article[views]</dd>
     <dd class="i50">$article[comments]</dd>
     <dd class="i70">$article[attachment]</dd>
     <dd class="i90">$article[userid]</dd>
     <dd class="i15"><input type="checkbox" name="aids[]" value="$article[aid]" /></dd>
    </dl>
EOT;
  }
print <<<EOT

    <dl class="ritem">
     <dd class="records">记录:$total</dd>
    </dl>
    <dl class="ritem">
     <dd class="multipage"><div >$multipage</div></dd>
    </dl>
EOT;
}
elseif (in_array($action, array('add', 'mod')))
{
print <<<EOT

   <div class="rmenu">$navtitle</div>
    <dl class="ritem">
     <dd class="i80">文章标题</dd>
     <dd class="toleft"><input class="formfield" type="text" name="title" id="title" size="70" value="$article[title]" placeholder="文章标题" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">选择分类</dd>
     <dd class="toleft">
      <select name="cid" id="cid">
       <option value="">== 选择分类 ==</option>
EOT;
  $i=0;
  foreach($cateArr as $key => $cate)
  {
  $i++;
  $selected = ($cate['cid'] == $article['cateid']) ? "selected" : "";
print <<<EOT

       <option value="{$cate['cid']}" $selected>$i. {$cate['name']}</option>
EOT;
  }
print <<<EOT

      </select>
     </dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">标签(Tag)</dd>
     <dd class="toleft"><input class="formfield" type="text" name="tag" size="80" maxlength="10000" value="$article[tag]" placeholder="标签(Tag)" />&nbsp;多个Tag用,分隔</dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">关键字</dd>
     <dd class="toleft"><input class="formfield" type="text" name="keywords" size="80" maxlength="10000" value="$article[keywords]" placeholder="关键字" />&nbsp;多个关键字用,分隔</dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">文章描述</dd>
     <dd class="toleft"><textarea name="excerpt" style="width:740px; height:100px;" placeholder="文章描述，摘要" />{$article['excerpt']}</textarea></dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">文章内容<br /><br />手动分页符<br /><a href="javascript:void(0);" onClick="editor.pasteHTML('[page]');">[page]</a></dd>
     <dd class="toleft"><textarea name="content" id="content" style="width:100%; height:400px;" />{$article['content']}</textarea></dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">友好网址</dd>
     <dd class="toleft"><input class="formfield" type="text" name="url" size="50" maxlength="255" value="$article[url]" placeholder="自定义链接名称" />&nbsp;255个字符以内</dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">缩略图片</dd>
     <dd class="toleft"><input class="formfield" type="text" name="thumb" size="50" maxlength="255" value="$article[thumb]" placeholder="缩略图片" />&nbsp;255个字符以内<input class="formbutton" type="button" onclick="alert('非常抱歉！此功能暂未实现\\nMARK下，以待后续更新\\n2013年12月10日 星期二 00时04分35秒 ');" value="选择图片"></dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">发布选项</dd>
     <dd class="i200"><input name="visible" type="checkbox" value="1" $visible_check />发布[不选则保存为草稿]</dd>
     <dd class="i80"><input name="stick" type="checkbox" value="1" $stick_check />置顶本文</dd>
     <dd class="i80"><input name="closed" type="checkbox" value="1" $closecomment_check /><input class="formfield" type="hidden" name="password" size="50" maxlength="20" value="$article[password]" />禁止评论</dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">发布时间</dd>
     <dd class="i70"><input name='edittime' type="checkbox" value="1" />修改时间</dd>
     <dd class="toleft">
       <input class="formfield" name="newyear" type="text" value="$newyear" maxlength="4" style="width:35px" />年<input class="formfield" name="newmonth" type="text" value="$newmonth" maxlength="2" style="width:20px" />月<input class="formfield" name="newday" type="text" value="$newday" maxlength="2" style="width:20px" />日<input class="formfield" name="newhour" type="text" value="$newhour" maxlength="2" style="width:20px" />时<input class="formfield" name="newmin" type="text" value="$newmin" maxlength="2" style="width:20px" />分<input class="formfield" name="newsec" type="text" value="$newsec" maxlength="2" style="width:20px" />秒
       <input class="formbutton" type="button" onclick="alert('有效的时间戳典型范围是从格林威治时间 1901 年 12 月 13 日 星期五 20:45:54 到 2038年 1 月 19 日 星期二 03:14:07\\n该日期根据 32 位有符号整数的最小值和最大值而来\\n取值说明: 日取 01 到 30 之间, 时取 0 到 24 之间, 分和秒取 0 到 60 之间!\\n系统会自动检查时间有效性,如果不在有效范围内,将不会执行更改时间操作\\n注意:如果系统是按照时间而不是提交次序排列文章,修改时间可以改变文章的顺序\\n\\n此功能可以通过js弹出选项点选时间，MARK下\\n2013年12月10日 星期二 00时04分05秒 .');" value="时间说明">
     </dd>
    </dl>
EOT;
  if (count($attachdb) > 0)
  {
print <<<EOT

    <dl class="ritem">
     <dd class="i80">已上传的附件</dd>
    </dl>
    <dl class="ritem">
     <dd class="i80">是否保留</dd>
     <dd class="i220">附件名</dd>
     <dd class="i80">时间</dd>
     <dd class="i80">大小</dd>
     <dd class="i80">操作</dd>
    </dl>
EOT;
    foreach($attachdb as $key => $attach)
    {
    $atturl=mkUrl('attachment.php',$attach['aid']);
print <<<EOT

      <dl class="ritem">
       <dd class="i80"><input type="checkbox" name="keep[]" value="{$attach['aid']}" checked /></dd>
       <dd class="i220"><a href="$atturl" target="_blank">$attach[filename]</a></dd>
       <dd class="i80">$attach[dateline]</dd>
       <dd class="i80">$attach[filesize]</dd>
       <dd class="i80"><a href="javascript:void(0);" onClick="editor.pasteHTML('[attach={$attach['aid']}]');">插入文章</a></dd>
      </dl>
EOT;
    }
  }
print <<<EOT

    <dl class="ritem">
     <dd class="i80">上传新附件</dd>
    </dl>
    <dl class="ritem">
     <dd class="toleft">
      <input type="file" name="attach[0]" class="formfield"/><a href="javascript:void(0);" onClick="editor.pasteHTML('[localfile=0]');">插入文章</a><input type="file" name="attach[1]" class="formfield"/><a href="javascript:void(0);" onClick="editor.pasteHTML('[localfile=1]');">插入文章</a><input type="file" name="attach[2]" class="formfield"/><a href="javascript:void(0);" onClick="editor.pasteHTML('[localfile=2]');">插入文章</a><input type="file" name="attach[3]" class="formfield"/><a href="javascript:void(0);" onClick="editor.pasteHTML('[localfile=3]');">插入文章</a>
     </dd>
    </dl>
    <dl class="ritem">
     <dd class="i50"><input type="hidden" name="action" value="$action" /><input type="hidden" name="aid" value="$aid" /><input type="hidden" name="oldtags" value="$article[keywords]" /><input type="submit" name="submit" id="submit" value="提交" class="formbutton" onclick="return checkform();" /></dd>
     <dd class="toleft"><input type="reset" value="重置" class="formbutton" /></dd>
    </dl>
EOT;
}
elseif ($do == 'move')
{
print <<<EOT

    <div class="rmenu"><a name="移动文章"></a>移动文章</div>
EOT;
  foreach($articledb as $key => $article)
    {
print <<<EOT

    <dl class="ritem"><dd><a href="admin.php?file=article&action=mod&aid=$article[aid]">$article[title]</a><input type="hidden" name="aids[]" value="$article[aid]" /></dd></dl>
EOT;
    }
print <<<EOT

    <dl class="ritem">
     <dd class="i200">将以上文章移动到</dd>
     <dd class="toleft"><select name="cid"><option value="" selected>==-选择分类-==</option>
EOT;
  foreach($cateArr as $key => $cate)
  {
print <<<EOT

<option value="{$cate['cid']}">{$cate['name']}</option>
EOT;
  }
print <<<EOT

</select></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100"><input type="submit" name="submit" id="submit" value="确认" class="formbutton" /><input type="hidden" name="action" value="domore" /><input type="hidden" name="do" value="domove" /></dd>
    </dl>
EOT;
}
elseif ($do == 'delete')
{
print <<<EOT

    <div class="rmenu">删除文章</div>
EOT;
  foreach($articledb as $key => $article)
  {
print <<<EOT

    <dl class="ritem"><dd><a href="admin.php?file=article&action=mod&aid=$article[aid]">$article[title]</a><input type="hidden" name="aids[]" value="$article[aid]"></dd></dl>
EOT;
  }
print <<<EOT

    <dl class="ritem">
    <dd><b>注意: 删除以上文章将会连同相关评论、附件一起删除，确定吗？</b></dd>
    </dl>
    <dl class="ritem">
     <dd class="i100"><input type="hidden" name="action" value="domore" /><input type="hidden" name="do" value="dodelete" /><input type="hidden" name="view" value="$view" /><input type="submit" name="submit" id="submit" value="确认" class="formbutton" /></dd>
    </dl>
EOT;
}
elseif ($action == 'search')
{
print <<<EOT

    <div class="rmenu">搜索文章</div>
    <dl class="ritem">
     <dd class="i220">搜索分类</dd>
     <dd class="toleft"><select name="cateid"><option value="">== 全部分类 ==</option>
EOT;
  $i=0;
  foreach($cateArr as $key => $cate)
  {
    $i++;
    $selected = ($cate['cid'] == $article['cid']) ? 'selected' : '';
print <<<EOT

<option value="$cate[cid]" $selected>$i. $cate[name]</option>
EOT;
  }
print <<<EOT

</select></dd>
    </dl>
    <dl class="ritem">
     <dd class="i220">标题、作者、描述、内容内的关键字</dd>
     <dd class="toleft"><input class="formfield" type="text" name="keywords" size="35" maxlength="50" value="" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i220">添加时间早于[yyyy-mm-dd]</dd>
     <dd class="toleft"><input class="formfield" type="text" name="startdate" size="35" maxlength="50" value="" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i220">添加时间晚于[yyyy-mm-dd]</dd>
     <dd class="toleft"><input class="formfield" type="text" name="enddate" size="35" maxlength="255" value="" /></dd>
    </dl>
    <dl class="ritem">
     <input type="hidden" name="action" value="list">
     <input type="hidden" name="do" value="search">
     <dd class="i50"><input type="submit" name="submit" id="submit" value="提交" class="formbutton" /></dd>
     <dd class="toleft"><input type="reset" value="重置" class="formbutton" /></dd>
    </dl>
EOT;
}
if ($action == 'list')
{
print <<<EOT

    <dl class="ritem">
     <dd class="toright">
      <select name="do">
        <option value="">= 管理操作 =</option>
        <option value="delete">删除</option>
        <option value="move">移动</option>
      </select>
     </dd>
    </dl>
    <dl class="ritem">
     <dd class="toleft">
     <input type="hidden" name="view" value="$view" /><input type="submit" name="submit" id="submit" value="确定" class="formbutton" /><input type="hidden" name="action" value="domore" />
     </dd>
    </dl>
EOT;
}
print <<<EOT

   </form>
  </div>
 </div>
EOT;
