<?php
$lockfile = SYS_DATA.'/install.lock';
$sqlfile = SYS_CORE.'/resource/install.sql';
$cms_name = SYS_NAME;
$cms_coredir = basename(SYS_CORE);
$cms_datadir = basename(SYS_DATA);
$cms_version = SYS_VERSION;
$dbcharset = 'utf-8';
function runquery($sql)
{
	global $dbcharset, $DB, $tablenum;
	$sql = str_replace("\r", "\n", str_replace('u_', DB_PREFIX, $sql));
	$ret = explode(";\n", trim($sql));
	unset($sql);
	foreach($ret as $query) {
		$query = trim($query);
		if($query) {
			if(substr($query, 0, 12) == 'CREATE TABLE') {
				$name = preg_replace("/CREATE TABLE `([a-z0-9_]+)` \(.*/is", "\\1", $query);
				$DB -> query($query);
				echo '创建表 '.$name.' <font color="#0000EE">成功</font><br />';
				$tablenum++;
			}
			else {
				$DB -> query($query);
			}
		}
	}
}

function TestWrite($d) {
	$tfile = '_test.txt';
	$fp = @fopen($d.'/'.$tfile,'w');
	if(!$fp) return false;
	else {
		fclose($fp);
		$rs = @unlink($d.'/'.$tfile);
		if($rs) return true;
		else return false;
	}
}
echo <<<EOT
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>$cms_name-$cms_version 安装脚本</title>
<link href="$cms_coredir/resource/install.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="$cms_coredir/manager/editor/jquery-1.4.4.min.js"></script>
<script type="text/javascript">
function checkNull() {
	var str="";
	if($("#username").val()=='') {
		alert("用户名不能为空!");
		return false;
	}
	$("input[type$='password']").each(function(n) {
		if($(this).val()=="") {
			alert($(this).attr("title")+"不能为空!");
			return false;
		}
	});
	if($("#password").val()!==$("#comfirpassword").val()) {
		alert("两次输入的密码必须一样!");
		return false;
	}
	return true;
}
</script>
</head>
<body>
<div id="main">
EOT;
if(file_exists($lockfile)) 
{
	echo "<p>您已经安装过版本为$cms_version的系统,如果需要重新安装,请删除{$cms_datadir}目录下的install.lock文件并刷新本页面</p>";
}
else
{
	$cacheDir = SYS_DATA.'/cache/';
	if(TestWrite($cacheDir))
	{
		$sql = file_get_contents($sqlfile);
		if(!empty($_POST))
		{
			$username = $_POST['username'];
			$password = $_POST['password'];
			$comfirpassword = $_POST['comfirpassword'];
			if(empty($username)) exit('用户名不得为空');
			if(empty($password)) exit('密码不得为空');
			if($password != $comfirpassword) exit('两次输入的密码必须一样!');
			$password = md5($password);
			$tablenum = 0;
			runquery($sql);
			echo "成功创建{$tablenum}个表<br />";
			$DB -> query("INSERT INTO `".DB_PREFIX."user` (`hostid`,`username`,`password`,`groupid`,`regdateline`,`regip`) VALUES ('1','$username','$password','4','$timestamp','$onlineip')");
			echo "成功添加超级管理员{$username}<br />";
			file_put_contents($lockfile,md5(SYS_HOST));
			$DB -> query("UPDATE `".DB_PREFIX."host` SET `host`='".SYS_HOST."'");
			$DB -> query("INSERT INTO `".DB_PREFIX."category` (`cid`,`hostid`,`name`,`keywords`,`description`,`url`) VALUES (NULL,'1','UIISC','UIISC','UIISC','helloworld')");
			$DB -> query("INSERT INTO `".DB_PREFIX."article` (`aid`,`hostid`,`cateid`,`userid`,`title`,`keywords`,`tag`,`url`,`dateline`,`modified`) VALUES (NULL,'1','1','1','Hello World !','Hello World','Hello World','helloworld','$timestamp','$timestamp')");
			$DB -> query("INSERT INTO `".DB_PREFIX."content` (`articleid`,`content`) VALUES ('1','欢迎使用UIISCMS')");
			hosts_recache();
			$hosts = include SYS_DATA.'/cache/hosts.php';
			$host = $hosts[SYS_HOST];
			$hostid = 1;
			filemaps_recache();
			plugins_recache();
			links_recache();
			cates_recache();
			vars_recache();
			$mapArr = @include SYS_DATA.'/cache/map_'.$host['host'].'.php';
			$cateArr = @include SYS_DATA.'/cache/cate_'.$host['host'].'.php';
			rss_recache();
			stick_recache();
			pics_recache();
			latest_recache();
			comments_recache();
			redirect_recache();
			hot_recache();
			search_recache();
			echo "成功更新系统缓存<br />安装完毕<br />点击这里进入<a href='admin.php'>管理后台</a>";
		}
		else
		{
			if(!file_exists($sqlfile))
			{
				echo "安装文件install.sql丢失.请检查安装文件是否存在和完好";
			}
			else
			{
				preg_match_all("/CREATE TABLE `([a-z0-9_]+)`/",$sql,$dataarr);
				$dbarrs = $dataarr[1];
				$tables = $DB -> query("show tables");
				$dbtables = array();
				while($dbs = $DB -> fetch_array($tables))
				{
					$temp = array_values($dbs);
					$dbtables[] = $temp[0];
				}
				$same = array_intersect($dbarrs,$dbtables);
				$info = '';
				if(count($same) > 0)
				{
					$info='<font color=\'red\'>程序检测到数据库中已经安装过本系统(或其它版本),如果继续,原来的数据将会被全部清空,请慎重操作!</font>';
				}
echo <<<EOT

 <form method="post" action="install.php">
  <p class="title">设置超级管理员</p>
  <hr noshade="noshade" />
  <p>{$info}</p>
  <table width="100%" border="0" cellspacing="0" cellpadding="4">
   <tr>
    <td width="30%" nowrap>超级管理员:</td>
    <td><input type="text" value="" name="username" id="username" class="formfield" style="width:150px" title="用户名"></td>
   </tr>
   <tr>
    <td width="30%" nowrap>密码:</td>
    <td><input type="password" value="" name="password" id="password" class="formfield" style="width:150px" title="密码"></td>
   </tr>
   <tr>
    <td width="30%" nowrap>确认密码:</td>
    <td><input type="password" value="" name="comfirpassword" id="comfirpassword" class="formfield" style="width:150px" title="确认密码"></td>
   </tr>
  </table>
  <p>&nbsp;</p>
  <hr noshade="noshade" />
  <p align="right">
  <input type="hidden" name="step" value="4" />
  <input class="formbutton" type="submit" value="安装" onclick="return checkNull()"/>
  </p>
 </form>
EOT;
			}
		}
	}
	else { echo "您的网站缓存目录{$cms_datadir}/cache不可写,请修改其权限为777"; }
}
echo <<<EOT

</div>
<strong>2010-2014 V$cms_version &copy CROGRAM</strong>
</body>
</html>
EOT;

exit();
