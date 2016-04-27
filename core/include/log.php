<?php
/**
 * 后台管理记录
 */
function getlog()
{
	global $timestamp, $onlineip, $sax_user;
	if ($_POST['action'])
	{
		$action = $_POST['action'];
		$script = str_replace('job=', '', $_SERVER['QUERY_STRING']);
		writeLog(SYS_DATA.'/logs/admin.log', "<?PHP exit('Access Denied'); ?>\t$timestamp\t".htmlspecialchars($sax_user)."\t$onlineip\t".htmlspecialchars(trim($action))."\t".htmlspecialchars(trim($script))."\n");
	}
}
