<?php
$syshost = SYS_HOST;
$sysport = $_SERVER['SERVER_PORT'];
if (empty($host))
{
	header("http/1.1 403 Forbidden");
print <<<EOT
<!doctype html>
<html>
<head>
<title>403 Forbidden</title>
</head>
<body>
<h1>Forbidden</h1>
<p>You are forbidden to visit on this server.</p>
<hr />
<address>Web Server at {$syshost} Port {$sysport}</address>
</body>
</html>
EOT;
exit();
}

//Robots文件
if (SYS_FILE == 'robots.txt')
{
	header('Content-Type: text/plain; charset=utf-8');
	header('HTTP/1.0 200 OK');
	exit("User-agent: *\r\nAllow: /");
}

$notfind = substr(REQUEST_URI,1);

//先检查文件是否存在,然后检查缓存文件
$cachefile = SYS_DATA.'/cache/file_'.$host['host'].'.php';
$themefiles =@include $cachefile;
$fileext = strtolower(substr(REQUEST_URI,-3));
if (!$themefiles && !file_exists($cachefile)) writeCache('file_'.$host['host'],array());
if (!is_array($themefiles)) $themefiles=array();
$themefile = SYS_DATA."/themes/$theme/".REQUEST_URI;
doAction('404_before_output');
if (file_exists($themefile) && $fileext != 'php')
{
	if (!array_key_exists(REQUEST_URI,$themefiles))
	{
		$modified = filectime($themefile);
		$themefiles[REQUEST_URI] = gmdate('D, d M Y H:i:s', $modified). ' GMT';
		writeCache('file_'.$host['host'],$themefiles);
	}
	//时间判断
	if (array_key_exists('HTTP_IF_MODIFIED_SINCE',$_SERVER))
	{
		if ($_SERVER['HTTP_IF_MODIFIED_SINCE'] == $themefiles[REQUEST_URI])
		{
			header('HTTP/1.0 304 Not Modified');
			exit;
		}
	}
	ob_end_clean();
	header("Cache-Control: max-age=259200");
	$contentType='Content-Type: text/html; charset=utf-8';
	if ($fileext == 'css') $contentType='Content-Type: text/css; charset=utf-8';
	if ($fileext == 'js') $contentType='Content-Type: text/javascript; charset=utf-8';
	if (in_array($fileext,array('jpg','png','gif'))) $contentType='Content-Type: image/jpeg';
	header($contentType);
	header("Last-Modified: ".$themefiles[REQUEST_URI]);
	readfile(SYS_DATA."/themes/$theme/".REQUEST_URI);
	exit();
}

//加载所有站点的跳转文件检查网址跳转
$redirects=@include SYS_DATA.'/cache/redirect_'.$host['host'].'.php';
if (count($redirects)>0)
{
	$request_url=ltrim($_SERVER['REQUEST_URI'],'/');
	foreach($redirects as $rds=>$ns)
	{
		if (preg_match("/^$rds$/i", $request_url, $matches))
		{
			$rurl='';
			if (strpos($ns[0],'$')===false)
			{
				$rurl=$ns[0];
			}
			else 
			{
				$rurl=preg_replace("/^$rds$/i",$ns[0],$request_url);
			}
			if (strncasecmp($rurl,"http",4)!=0) { $rurl = SYS_HTTP.$host['host'].'/'.$rurl; }
			if ($ns[1]=='1') { header("HTTP/1.1 301 Moved Permanently"); }
			header("Location: $rurl");
			exit();
		}
	}
}

header('HTTP/1.1 404 Not Found');
if (!file_exists($tempView))
{
print <<<EOT
<!doctype html>
<html>
<head>
<title>404 Not Found</title>
</head>
<body>
<h1>Not Found</h1>
<p>The Requested URL http://{$syshost}{$_SERVER['REQUEST_URI']} was not found on this server.</p>
<hr />
<address>Web Server at {$syshost} Port {$sysport}</address>
</body>
</html>
EOT;
	exit();
}