<?php
!defined('SYS_DATA') && exit('Access Denied !');
/**
 * 配置界面输出
 */
function toolbar_html_view()
{
	global $DB,$hostid;
	$arr = $DB->fetch_first('SELECT * FROM `'.DB_PREFIX."plugin` WHERE `hostid`=$hostid AND `file` = 'toolbar'");
	$code = isset($arr['config']) ? $arr['config'] : '';
print <<<EOT

<form action="admin.php?file=plugin&action=setting" method="post">
<input type="hidden" value="toolbar" name="plugin">
    <div class="rmenu">导航代码设置</div>
    <dl class="ritem">
     <dd class="i100">导航代码:</dd>
     <dd><textarea id="toolbar_code" class="formarea" type="text" name="toolbar_code" style="width:740px;height:80px;">$code</textarea></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><input type="submit" value="提交" class="formbutton"></dd>
    </dl>
  </form>
EOT;
}
addAction('admin_plugin_setting_view','toolbar_html_view');

/**
 * 保存配置函数
 */
function toolbar_code_save()
{
	global $DB,$hostid;
	$code=$_POST['toolbar_code'];
	$DB->query('UPDATE `'.DB_PREFIX."plugin` SET `config` = '$code' WHERE `hostid` = $hostid AND `file` = 'toolbar'");
	plugins_recache();
	redirect('工具栏代码已成功更新','admin.php?file=plugin&action=setting&plugin=toolbar');
}
addAction('admin_plugin_setting_save','toolbar_code_save');