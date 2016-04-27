<?php
!defined('SYS_DATA') && exit('Access Denied !');

/**
 * 配置界面输出
 */
function stat_html_view()
{
	global $DB,$hostid;
	$arr=$DB->fetch_first('SELECT * FROM '.DB_PREFIX."plugin WHERE `hostid`=$hostid AND `file`='stat'");
	$code=isset($arr['config'])?$arr['config']:'';
print <<<EOT

<form action="admin.php?file=plugin&action=setting" method="post">
<input type="hidden" value="stat" name="plugin">
    <div class="rmenu">统计代码设置</div>
    <dl class="ritem">
     <dd class="i100">统计代码:</dd>
     <dd><textarea id="stat_code" class="formarea" type="text" name="stat_code" style="width:740px;height:80px;">$code</textarea></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><input type="submit" value="提交" class="formbutton"></dd>
    </dl>
  </form>
EOT;
}
addAction('admin_plugin_setting_view','stat_html_view');

/**
 * 保存统计代码
 */
function stat_code_save()
{
	global $DB,$hostid;
	$code=$_POST['stat_code'];
	$DB->query('UPDATE '.DB_PREFIX."plugin SET `config`='$code' WHERE hostid=$hostid AND `file`='stat'");
	plugins_recache();
	redirect('统计代码已成功更新','admin.php?file=plugin&action=setting&plugin=stat');
}
addAction('admin_plugin_setting_save','stat_code_save');
