<?php
print <<<EOT

 <div class="mainbody">
  <div class="l">
   <div class="lmenu">站点管理</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=multisite&action=list">站点列表</a></li>
     <li><a href="admin.php?file=multisite&action=add">添加站点</a></li>
     <li><a href="admin.php?file=multisite&action=cacheall">更新缓存文件</a></li>
    </ul>
   </div>
  </div>
  <div class="r">
   <form action="admin.php?file=multisite" method="post"><input type="hidden" name="action" value="{$action}" />
EOT;
if ($action=='add'||$action=='edit')
{
print <<<EOT

   <div class="rmenu">基本设置</div>
   <input type="hidden" name="setting[hid]" value="{$setting['hid']}" />
    <dl class="ritem">
      <dd class="i200"><b>网站名称</b></dd>
      <dd class="toleft"><input class="formfield" type="text" name="setting[name]" size="35" maxlength="50" value="{$setting['name']}" /></dd>
    </dl>
    <dl class="ritem">
      <dd class="i200"><b>网站域名</b></dd>
      <dd class="toleft"><input class="formfield" type="text" name="setting[host]" size="35" maxlength="50" value="{$setting['host']}" />&nbsp;示例如&nbsp;www.testdomain.com</dd>
    </dl>
    <dl class="ritem">
      <dd class="i200"><b>网站别名</b></dd>
      <dd class="toleft"><input class="formfield" type="text" name="setting[host2]" size="35" maxlength="50" value="{$setting['host2']}" />&nbsp;多个域名间以,号分隔</dd>
    </dl>
    <dl class="ritem">
     <dd class="i200"><b>网址格式</b></dd>
     <dd class="toleft">
      <select name="setting[url_html]">
       <option value="0" $url_html0>纯动态网址</option>
       <option value="1" $url_html1>目录伪静态</option>
      </select>&nbsp;目录伪静态形如/categroy/test/p1.三个参数分别是分类标识，分类友好名称，p1是第一页，p2是第二页
     </dd>
    </dl>
    <dl class="ritem">
     <dd class="i200"><b>文件后缀</b></dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[url_ext]" size="35" maxlength="50" value="{$setting['url_ext']}" />当使用纯动态或是目录伪静态加文件后缀时，即使用该后缀，如php</dd>
    </dl>
EOT;
print <<<EOT

    <div class="rmenu">
     <ul>
      <li class="i200">文件映射</li>
      <li class="i230">原文件名</li>
      <li class="toleft">新文件名，参数映射(新值=旧值,如id=aid)</li>
     </ul>
    </div>
    <dl class="ritem">
     <dd class="i200">管理页[admin.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[admin.php]" size="35" maxlength="50" value="{$info['admin.php']}" /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[admin.php]" size="35" maxlength="200" value="{$args['admin.php']}" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">存档页[archive.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[archive.php]" size="35" maxlength="50" value="{$info['archive.php']}" /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[archive.php]" size="35" maxlength="200" value="{$args['archive.php']}" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">文章页[article.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[article.php]" size="35" maxlength="50" value="{$info['article.php']}" /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[article.php]" size="35" maxlength="200" value="{$args['article.php']}" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">附件页[attachment.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[attachment.php]" size="35" maxlength="50" value="{$info['attachment.php']}" /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[attachment.php]" size="35" maxlength="200" value="{$args['attachment.php']}" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">列表页[category.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[category.php]" size="35" maxlength="50" value="{$info['category.php']}" /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[category.php]" size="35" maxlength="200" value="{$args['category.php']}" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">验证码页[captcha.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[captcha.php]" size="35" maxlength="50" value="{$info['captcha.php']}" /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[captcha.php]" size="35" maxlength="200" value="{$args['captcha.php']}" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">评论页[comment.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[comment.php]" size="35" maxlength="50" value="{$info['comment.php']}" /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[comment.php]" size="35" maxlength="200" value="{$args['comment.php']}" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">首页[index.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[index.php]" size="35" maxlength="50" value="{$info['index.php']}" /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[index.php]" size="35" maxlength="200" value="{$args['index.php']}" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">JS页[js.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[js.php]" size="35" maxlength="50" value="{$info['js.php']}" /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[js.php]" size="35" maxlength="200" value="{$args['js.php']}" /></dd>
    </dl>
    <dl class="ritem">
    <dd class="i200">友情链接页[link.php]</dd>
    <dd class="i230"><input class="formfield" type="text" name="maps[link.php]" size="35" maxlength="50" value="{$info['link.php']}" /></dd>
    <dd class="toleft"><input class="formfield" type="text" name="args[link.php]" size="35" maxlength="200" value="{$args['link.php']}" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">用户页[profile.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[profile.php]" size="35" maxlength="50" value="{$info['profile.php']}" /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[profile.php]" size="35" maxlength="200" value="{$args['profile.php']}" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">RSS页[rss.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[rss.php]" size="35" maxlength="50" value="{$info['rss.php']}"></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[rss.php]" size="35" maxlength="200" value="{$args['rss.php']}"></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">搜索页[search.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[search.php]" size="35" maxlength="50" value="{$info['search.php']}" /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[search.php]" size="35" maxlength="200" value="{$args['search.php']}" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i200">TAG页[tag.php]</dd>
     <dd class="i230"><input class="formfield" type="text" name="maps[tag.php]" size="35" maxlength="50" value="{$info['tag.php']}" /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="args[tag.php]" size="35" maxlength="200" value="{$args['tag.php']}" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="i80"><input type="submit" value="提交" class="formbutton" /></dd>
     <dd class="toleft"><input type="reset" value="重置" class="formbutton" /></dd>
    </dl>
   </form>
EOT;
}
else if ($action=='list')
{
print <<<EOT

    <div class="rmenu">
     <ul>
      <li class="i35">ID</li>
      <li class="i130">网站名称</li>
      <li class="i150">网站域名</li>
      <li class="i50">状态</li>
      <li class="i50">编辑</li>
      <li class="i50">切换</li>
      <li class="i50"><input name="chkall" type="checkbox" onclick="checkall(this.form)" value="on" /></li>
     </ul>
    </div>
EOT;
	foreach($sitedb as $site)
	{
print <<<EOT

    <dl class="ritem">
      <dd class="i35">{$site['hid']}</dd>
      <dd class="i130">{$site['name']}</dd>
      <dd class="i150"><a href="http://{$site['host']}" target='_blank'>{$site['host']}</a></dd>
      <dd class="i50">{$site['status']}</dd>
      <dd class="i50"><a href="admin.php?file=multisite&action=edit&hid={$site['hid']}">编辑</a></dd>
      <dd class="i50"><a href="admin.php?file=multisite&action=go&hid={$site['hid']}">转到</a></dd>
      <dd class="i50"><input type="checkbox" name="hids" value="{$site['hid']}"></dd>
      <dd class="i50"><a href="admin.php?file=multisite&action=del&hid={$site['hid']}">删除</a></dd>
    </dl>
EOT;
	}
}
print <<<EOT

  </form>
  </div>
 </div>
EOT;
