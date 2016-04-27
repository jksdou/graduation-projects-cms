<?php
//系统配置
define('SYS_NAME','UIISCMS');//系统名称
define('SYS_VERSION','1.4');//系统版本
define('SYS_RELEASE','20130305');//系统发行版本
define('SYS_AUTHOR','doudoudzj');//系统作者
define('SYS_WEBSITE','http://uiisc.com');//系统网站
define('SYS_EMAIL','admin@uiisc.com');//系统联系邮箱
define('SYS_HOST',$_SERVER['HTTP_HOST']);
define('SYS_POST',$_SERVER['REQUEST_METHOD'] == 'GET' ? false : true);
define('SYS_HTTP',(isset($_SERVER['HTTPS']) && strcasecmp($_SERVER['HTTPS'],'off') != 0) ? 'https://' : 'http://');//http协议判断
define('SYS_ISIE',isset($_SERVER['HTTP_USER_AGENT']) && strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'));//客户端判断
define('SYS_CACHE',TRUE);//对内容页是否启用自动缓存。
define('SYS_DEBUG',0);//TRUE是否开启调试模式,开启时页面会显示调试信息、错误信息，部分信息会记录到/logs/sqlquery.log

//加载类库和配置
include SYS_DATA.'/dbconfig.php';//数据库配置
include SYS_CORE.'/lib/class.mysql.php';
include SYS_CORE.'/lib/func.base.php';//基础
include SYS_CORE.'/lib/func.cache.php';//缓存处理
include SYS_CORE.'/lib/func.data.php';//数据处理

//禁止自动转反斜杠
/*
if (get_magic_quotes_runtime()) {
	set_magic_quotes_runtime(false);
	doStripslashes();
}*/
//错误提示设置和参数过滤
if (SYS_DEBUG) {
	error_reporting(E_ALL);
	set_error_handler("debug");
}
else error_reporting(0);

//获取请求的网址，处理部分服务器对重写的网址没有GET参数的解决办法,使用的是iirf中的U参数将请求网址保存在HTTP_X_REWRITE_URL
if (isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'],'IIS')!==false)//IIS,如 Microsoft-IIS/6.0是HTTP_X_REWRITE_URL，7.5是REQUEST_URI
{
	if (!isset($_SERVER['HTTP_X_REWRITE_URL'])) exit('This IIS Server is not support our SYSTEM !');
	$HTTP_X_REWRITE_URL = $_SERVER['HTTP_X_REWRITE_URL'];

	define('REQUEST_URI',substr($HTTP_X_REWRITE_URL,1));
	if (empty($_GET)&&strpos($HTTP_X_REWRITE_URL,'?'))
	{
		$_GET = getGetArr($HTTP_X_REWRITE_URL);
		define('QUERY_URL',$HTTP_X_REWRITE_URL);
	}
}
else if (isset($_SERVER['SERVER_SOFTWARE']) && strpos($_SERVER['SERVER_SOFTWARE'],'nginx')!==false)//nginx
{
	if (!isset($_SERVER['REQUEST_URI'])) exit('This NGINX Server is not support our SYSTEM !');
	define('REQUEST_URI',substr($_SERVER['REQUEST_URI'],1));
	define('QUERY_URL',$_SERVER['HTTP_X_REWRITE_URL']);
}
else
{
	foreach(array('REDIRECT_REDIRECT_SCRIPT_URL','REDIRECT_SCRIPT_URL','SCRIPT_URL','REDIRECT_URL','HTTP_X_REWRITE_URL','REQUEST_URI','SCRIPT_NAME') as $scriptfile)
	{
		if (isset($_SERVER[$scriptfile]))
		{
			define('REQUEST_URI',substr($_SERVER[$scriptfile],1));
			define('QUERY_URL',$_SERVER['REQUEST_URI']);
			break;
		}
	}
	if (!defined('REQUEST_URI')) exit('This HTTP Server is not support our SYSTEM !');
	if (empty($_GET)&&strpos($_SERVER['REQUEST_URI'],'?')>1) { $_GET = getGetArr($_SERVER['REQUEST_URI']); }
}

if (empty($_POST) && isset($HTTP_RAW_POST_DATA)) { $_POST = $HTTP_RAW_POST_DATA; }
ob_start();
$onlineip = getIp();//当前用户IP地址
$useragent = isset($_SERVER['HTTP_USER_AGENT']) ? addslashesDeep($_SERVER['HTTP_USER_AGENT']) : '';//User-Agent
date_default_timezone_set('Asia/Shanghai');//默认时区
$timestamp = time();//当前服务器时间
$constant = get_defined_constants();//所有定义的常量以及对应值

//读取缓存数据,加载插件，注意，大写开头的变量是所有站点可用，小写开头的变量是当前站点可用
$pluginConfigArr = array();//插件的配置数据
$pluginArr = array();//插件文件数组
$hookArr = array();//当前站点的插件数据
$HostArr = array();//所有站点数组,如果为多个,则需要判断是否存在的站点
$mapArr = array();//文件数组,需要寻找对应的文件并包含
$cateArr = array();//当前站点的分类数据
$varArr = array();//当前站点的变量数据,建议插件的缓存也加入
//加载所有站点信息
$HostArr = @include SYS_DATA.'/cache/hosts.php';
if ($HostArr && is_array($HostArr) && isset($HostArr[SYS_HOST]))
{
	$host = $HostArr[SYS_HOST];//站点数组
}

//数据库实例化
$DB = new DB_MySQL();
$DB -> connect(DB_HOST,DB_USER,DB_PASSWORD,DB_DATABASE,0);

//没找到任何站点时，403或是安装
if (!isset($host))
{
	if (is_array($HostArr) && count($HostArr) > 0) { include_once SYS_CORE.'/404.php'; }//存在站点数组缓存则不允许安装
	else if (REQUEST_URI!='install.php') { exit('<a href = "./install.php">INSTALL SYSTEM</a>'); }
	else include_once SYS_CORE.'/install.php';
	exit();
}

$hostid   = $host['hid'];
$theme    = $host['theme'];
$mapArr   = @include SYS_DATA.'/cache/map_'.$host['host'].'.php';
$varArr   = @include SYS_DATA.'/cache/var_'.$host['host'].'.php';
$cateArr  = @include SYS_DATA.'/cache/cate_'.$host['host'].'.php';
$pluginArr= @include SYS_DATA.'/cache/plugins.php';
if (!$cateArr) { $cateArr = array(); }
if (isset($pluginArr) && !empty($pluginArr))
{
	foreach($pluginArr as $pluginHost => $pluginNameValue)
	{
		if ($host['host'] == $pluginHost)
		{
			$pluginArr = $pluginArr[$pluginHost];break;
		}
	}
}

//是否动态网址
$isDynamic = !$host['url_html'];

if (REQUEST_URI == '' || REQUEST_URI == '?' || substr(REQUEST_URI,0,1) == '?')
{
	define('SYS_FILE','index'.($isDynamic ? '.'.$host['url_ext'] : ''));
}
else
{
	//动态网址
	if ($isDynamic)
	{
		define('SYS_FILE',ltrim(strpos(REQUEST_URI,'?')>1 ? substr(REQUEST_URI,0,strpos(REQUEST_URI,'?')) : REQUEST_URI,'/'));
	}
	//静态网址
	else
	{
		$urlstring = REQUEST_URI;
		$urlext = !$host['url_ext'] ? '' : ('.'.$host['url_ext']);
		if ($urlext && substr(REQUEST_URI,0-strlen($urlext)) == $urlext)
		{
			$urlstring = substr(REQUEST_URI,0,strlen(REQUEST_URI)-strlen($urlext));
		}
		else if ($urlext)//如果是管理页面，使用不同的处理方式
		{
			$tempfile = ltrim(strpos(REQUEST_URI,'?')>1 ? substr(REQUEST_URI,0,strpos(REQUEST_URI,'?')) : REQUEST_URI,'/');
			if (substr($tempfile,0-strlen($urlext))==$urlext) { $tempfile = substr($tempfile,0,strlen($tempfile)-strlen($urlext)); }
			if (isset($mapArr['file'][$tempfile]) && $mapArr['file'][$tempfile] == 'admin.php') { define('SYS_FILE',$tempfile); }
			$urlstring = '';
		}

		if ($urlstring)
		{
			$urlstring = trim($urlstring,'/');
			$urlargs = explode('/',$urlstring);

			define('SYS_FILE',$urlargs[0]);
			$_GET['url'] = count($urlargs) > 1 ? $urlargs[1] : '';
			if (count($urlargs)>2) { $_GET['page'] = $urlargs[2]; }
			if (count($urlargs)>3) { $_GET['more'] = $urlargs[3]; } 
		}
		else if (!defined('SYS_FILE')) { define('SYS_FILE',''); }
	}
}

//设置运行的文件
$username = '';
$groupid = $uid = 0;
$sessionid = isset($_COOKIE['sessionid']) ? $_COOKIE['sessionid'] : '';
if (isset($_GET['sessionid']))
{
	$sessionid = $_GET['sessionid'];//在多站点切换时,使用这个sessionid来保持登陆状态
}
if (!empty($sessionid) && strlen($sessionid) == 30)
{
	$userinfo = $DB->fetch_first('SELECT * FROM `'.DB_PREFIX."user` WHERE `sessionid` = '$sessionid' AND (`groupid` = '4' or `hostid` = '$hostid')");//创始人可以登陆每个站点,其他人(包括站点管理员级别的)受限
	if ($userinfo)
	{
		$nowips = explode('.',$onlineip);
		$oldips = explode('.',$userinfo['loginip']);
		$diffip = array_diff_assoc($nowips,$oldips);
		if (count($diffip) < 2 && !isset($diffip[2]) && $useragent == $userinfo['useragent'])//当最后一位不同时认为是同一地点
		{
			$uid = $userinfo['uid'];
			$username = $userinfo['username'];
			$groupid = $userinfo['groupid'];//0访客,1注册会员,2编辑,3站点管理员,4系统管理员
		}
		if (!isset($_COOKIE['sessionid']) || $_COOKIE['sessionid'] != $sessionid)
		{
			if (isset($_COOKIE['sessionid']) && $_COOKIE['sessionid'] != $sessionid)
			{
				setcookie('sessionid','');
				if (!SYS_ISIE)
				{
					setcookie('sessionid','',-1,'/','.'.$host['host']);//使用泛域名解析后，需要删除.domain.com这样的cookie的域
				}
				message('站点切换成功','admin.php?sessionid='.$sessionid);
			}
			else
			{
				setcookie('sessionid',$sessionid);
			}
		}
	}
}

//参数重写,根据$mapArr数组将网址转为固定的网址格式，如article.php在网页上显示为read.php,该功能是将read.php转换成article.php
argRewrite();

if (!isset($theme)) { $theme = 'default'; }

//加载执行文件和模板
$views = isset($mapArr['file'][SYS_FILE]) ? $mapArr['file'][SYS_FILE] : "404.php";
if ((SYS_FILE == 'index.php' || SYS_FILE == 'index')) { $views = 'index.php'; }
if ($host['close'] && isset($mapArr['file'][SYS_FILE]) && $mapArr['file'][SYS_FILE] != 'admin.php') { exit($host['close_note']); }
$coreView = SYS_CORE.'/'.$views;//执行文件
$tempView = SYS_DATA.'/themes/'.$theme.'/'.$views;//模板执行文件
$contentType = 'Content-Type: text/html; charset = utf-8';//字符编码

//加载插件，插件目录和插件主文件名应保持一致
if ($pluginArr && is_array($pluginArr)) {
	foreach($pluginArr as $pluginName => $pluginData) 	{
		if (file_exists(SYS_DATA.'/plugins/'.$pluginName.'/'.$pluginName.'.php')) {
			include SYS_DATA.'/plugins/'.$pluginName.'/'.$pluginName.'.php';
		}
	}
}

//部分特殊网址的处理
$host_url = SYS_HTTP.SYS_HOST;
$query_url = SYS_HTTP.SYS_HOST.QUERY_URL;
$refer_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$admin_url = mkUrl('admin.php','');
$login_url = mkUrl('profile.php','login');
$logout_url = mkUrl('profile.php','logout');
$register_url = mkUrl('profile.php','register');
$comment_url = mkUrl('comment.php','');
$profile_url = mkUrl('profile.php','');
$search_url = mkUrl('search.php','');
$page_url = mkUrl('page.php','');
$rss_url = mkUrl('rss.php','');
$tag_url = mkUrl('tag.php','');

doAction('before_router');
include_once $coreView;
include_once $tempView;

//输出前处理,输出ContentType,网址重写，插件处理，网页压缩
header($contentType);
header('Cache-Control:max-age = 0');//缓存的处理http://blog.csdn.net/nashuiliang/article/details/7854633
$output = ob_get_contents();
ob_end_clean();
$output = adminRewrite($output);

doAction('before_output');
if ($host['gzipcompress'] && function_exists('ob_gzhandler'))
{
	ob_start('ob_gzhandler');
}
else
{
	ob_start();
}
echo $output;
ob_flush();
