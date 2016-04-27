<?php
print <<<EOT

 <div class="mainbody">
  <div class="l">
   <div class="lmenu">数据管理</div>
   <div class="litem">
    <ul>
     <li><a href="admin.php?file=database&action=dbinfo">数据库信息</a></li>
     <li><a href="admin.php?file=database&action=backup">数据库备份</a></li>
     <li><a href="admin.php?file=database&action=tools">数据库维护</a></li>
     <li><a href="admin.php?file=database&action=filelist">已备份文件</a></li>
     <li><a href="admin.php?file=database&action=import">导入其它数据</a></li>
    </ul>
   </div>
  </div>
  <div class="r">
EOT;
if ($action == 'filelist' || $action == 'import')
{
print <<<EOT

   <div class="rmenu">恢复数据说明</div>
   <dl class="ritem">
    <dd>1. 恢复的数据必须是使用本系统备份的文件, 或与本系统兼容的文件.<br />2. 恢复的数据库文件表前缀必须和当前的一致.</dd>
   </dl>
EOT;
}
print <<<EOT

    <form action="admin.php?file=database" enctype="multipart/form-data" method="POST" name="form">
EOT;
if (in_array($action, array('backup', 'tools')))
{
	if ($action == 'backup')
	{
print <<<EOT

   <div class="rmenu">$subnav</div>
   <dl class="ritem">
    <dd class="i150">备份文件名</dd>
    <dd class="toleft"><input class="formfield" type="text" name="filename" size="40" maxlength="40" value="$backuppath">.sql</dd>
   </dl>
   <dl class="ritem">
    <dd class="i150">备份位置</dd>
    <dd class="toleft"><input type="radio" checked="checked" value="local" name="bakplace"/>下载到本地<input type="radio" value="server" name="bakplace"/>服务器</dd>
   </dl>
   <dl class="ritem">
    <dd><b>如果数据较多可以使用数据库管理工具来备份</b></dd>
   </dl>
EOT;
	}
	else
	{
print <<<EOT

   <div class="rmenu">$subnav</div>
   <dl class="ritem">
    <dd class="i100">检查表</dd>
    <dd class="i25"><input type="checkbox" name="do[]" value="check" checked /></dd>
   </dl>
   <dl class="ritem">
    <dd class="i100">修复表</dd>
    <dd class="i25"><input type="checkbox" name="do[]" value="repair" checked /></dd>
   </dl>
   <dl class="ritem">
    <dd class="i100">分析表</dd>
    <dd class="i25"><input type="checkbox" name="do[]" value="analyze" checked /></dd>
   </dl>
   <dl class="ritem">
    <dd class="i100">优化表</dd>
    <dd class="i25"><input type="checkbox" name="do[]" value="optimize" checked /></dd>
   </dl>
EOT;
	}
print <<<EOT

    <dl class="ritem">
     <dd class="i100"><input type="hidden" name="action" value="$act"><input type="submit" value="提交" class="formbutton"></dd>
     <dd class="i100"><input type="reset" name="" value="重置" class="formbutton"></dd>
    </dl>
   </form>
EOT;
}
elseif ($action == 'filelist')
{
print <<<EOT

   <div class="rmenu">$subnav</div>
    <dl class="ritemenu">
      <dd class="i200">文件名</dd>
      <dd class="i150">备份时间</dd>
      <dd class="i150">修改时间</dd>
      <dd class="i100">文件大小</dd>
      <dd class="i50">操作</dd>
      <dd class="i25"><input type="hidden" name="action" value="deldbfile"><input name="chkall" value="on" type="checkbox" onclick="checkall(this.form)"></dd>
    </dl>
EOT;
if ($noexists)
{
print <<<EOT

    <dl class="ritem">
      <dd>目录不存在或无法访问, 请检查 $backupdir 目录.</dd>
    </dl>
EOT;
}
else
{
	foreach($dbfiles as $key => $dbfile)
	{
print <<<EOT

    <dl class="ritem">
      <dd class="i200"><a href="admin.php?file=database&action=downsql&sqlfile=$dbfile[filename]" title="右键另存为保存该文件">$dbfile[filename]</a></dd>
      <dd class="i150">$dbfile[bktime]</dd>
      <dd class="i150">$dbfile[mtime]</dd>
      <dd class="i100">$dbfile[filesize]</dd>
      <dd class="i50"><a href="admin.php?file=database&action=checkresume&sqlfile=$dbfile[filepath]">恢复</a></dd>
      <dd class="i25"><input type="checkbox" name="sqlfiles[$dbfile[filename]]" value="1"></dd>
    </dl>
EOT;
	}
}
print <<<EOT

    <dl class="ritem">
      <dd class="i200"><b>共有{$file_i}个备份文件</b></dd>
    </dl>
    <dl class="ritem">
      <dd class="i150"><input type="submit" value="删除所选文件" class="formbutton"></dd>
    </dl>
   </form>
EOT;
}
elseif ($action == 'dbinfo')
{
print <<<EOT

   <div class="rmenu">$subnav</div>
   <dl class="ritem">
    <dd class="i200">数据库版本:</dd>
    <dd class="toleft">$mysql_version</dd>
   </dl>
   <dl class="ritem">
     <dd class="i200">数据库运行时间:</dd>
     <dd class="toleft">$mysql_runtime</dd>
   </dl>
    <div class="rmenu">系统数据库信息</div>
    <dl class="ritemenu">
      <dd class="i200">系统数据表</dd>
      <dd class="i60">记录数</dd>
      <dd class="i100">数据</dd>
      <dd class="i100">索引</dd>
      <dd class="i100">碎片</dd>
      <dd class="i150">创建时间</dd>
      <dd class="i150">最后更新时间</dd>
    </dl>
EOT;
	foreach($system_table as $sys_table)
	{
print <<<EOT

   <dl class="ritem">
     <dd class="i200">$sys_table[Name]</dd>
     <dd class="i60">$sys_table[Rows]</dd>
     <dd class="i100">$sys_table[Data_length]</dd>
     <dd class="i100">$sys_table[Index_length]</dd>
     <dd class="i100">$sys_table[Data_free]</dd>
     <dd class="i150">$sys_table[Create_time]</dd>
     <dd class="i150">$sys_table[Update_time]</dd>
   </dl>
EOT;
	}
print <<<EOT

    <dl class="ritem records">
      <dd class="i200">共计:{$system_table_num}个数据表</dd>
      <dd class="i60">$system_table_rows</dd>
      <dd class="i100">$system_data_size</dd>
      <dd class="i100">$system_index_size</dd>
      <dd class="i100">$system_free_size</dd>
    </dl>
    <div class="rmenu">其他数据库信息</div>
    <dl class="ritemenu">
      <dd class="i200">数据表</dd>
      <dd class="i60">记录数</dd>
      <dd class="i100">数据</dd>
      <dd class="i100">索引</dd>
      <dd class="i100">碎片</dd>
      <dd class="i150">创建时间</dd>
      <dd class="i150">最后更新时间</dd>
    </dl>
EOT;
	foreach($other_table as $other)
	{
print <<<EOT

   <dl class="ritem">
     <dd class="i200">$other[Name]</dd>
     <dd class="i60">$other[Rows]</dd>
     <dd class="i100">$other[Data_length]</dd>
     <dd class="i100">$other[Index_length]</dd>
     <dd class="i100">$other[Data_free]</dd>
     <dd class="i150">$other[Create_time]</dd>
     <dd class="i150">$other[Update_time]</dd>
   </dl>
EOT;
	}
print <<<EOT

    <dl class="ritem records">
      <dd class="i200">共计:{$other_table_num}个数据表</dd>
      <dd class="i60">$other_table_rows</dd>
      <dd class="i100">$other_data_size</dd>
      <dd class="i100">$other_index_size</dd>
      <dd class="i100">$other_free_size</dd>
    </dl>
EOT;
}
elseif ($action == 'dotools')
{
	foreach ($dodb AS $do)
	{
print <<<EOT

    <div class="rmenu">$do[name]表</div>
EOT;
		foreach($tabledb as $table)
		{
			if ($table['do'] == $do['do'])
			{
print <<<EOT

    <dl class="ritem">
     <dd class="i200">$table[table]</dd>
     <dd class="i10">$table[result]</dd>
    </dl>
EOT;
			}
		}
	}
}
elseif ($action == 'checkresume')
{
print <<<EOT

   <div class="rmenu">导入备份数据</div>
    <div class="alertmsg">
     <p>导入文件:$sqlfile</p>
     <p><b>恢复功能将覆盖原来的数据,您确认要导入备份数据?</b></p>
     <p><input type="hidden" name="action" value="resume"><input type="hidden" name="sqlfile" value="$sqlfile"><input type="submit" value="确认" class="formbutton"></p>
    </div>
   </form>
EOT;
}
elseif ($action == 'import')
{
print <<<EOT

   <div class="rmenu">导入RSS数据</div>
    <dl class="ritem">
     <dd class="i100">选择目标分类:</dd>
     <dd class="toleft">
      <select name="cid" id="cid">
       <option value="" selected>选择分类</option>
EOT;
	$i=0;
	foreach($cateArr as $key => $cate)
	{
print <<<EOT

       <option value="{$cate['cid']}">{$cate['name']}</option>
EOT;
	}
print <<<EOT

      </select>
     </dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">选择文章作者:</dd>
     <dd class="toleft">
      <select name="uid" id="uid">
       <option value="" selected>选择作者</option>
EOT;
	$i=0;
	foreach($userArr as $key => $user)
	{
print <<<EOT

       <option value="{$user['userid']}">{$user['username']}</option>
EOT;
	}
print <<<EOT

      </select>
     </dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">选择.xml文件</dd>
     <dd class="toleft"><input class="formfield" type="file" name="xmlfile"> 仅允许.xml类型文件</dd>
    </dl>
   <div class="rmenu">导入其它程序数据</div>
    <dl class="ritem">
     <dd>此功能开发中。。。。</dd>
    </dl>
    <dl class="ritem">
     <dd class="i100">
      <input type="hidden" name="action" value="importrss"><input type="submit" value="确定" class="formbutton">
     </dd>
    </dl>
   </form>
EOT;
}
print <<<EOT

  </div>
 </div>
EOT;
