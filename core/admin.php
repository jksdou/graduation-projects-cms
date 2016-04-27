<?php
$tempView  = $coreView;
$coredir   = basename(SYS_CORE);//系统目录
$datadir   = basename(SYS_DATA);//数据目录
$viewdir   = $coredir.'/manager/view/';//后台管理视图目录
$editordir = $coredir.'/manager/editor/';//后台编辑器目录
$uploadfile= 'admin.php?file=upload';//编辑器文件上传
$cssfile   = 'admin.php?file=css';//后台管理的css文件
$jsfile    = 'admin.php?file=js';//后台管理的自定义js文件
$page      = isset($_GET['page']) ? intval($_GET['page']) : '';
$do        = isset($_POST['do']) ? $_POST['do'] : '';
$incfile   = !empty($_GET['file']) ? $_GET['file'] : 'main';//进入后台没有操作url即默认使用main
$action    = !empty($_GET['action']) ? $_GET['action'] : (!empty($_POST['action']) ? $_POST['action'] : '');
if (!$do) { $do = isset($_GET['do']) ? $_GET['do'] : ''; }
if ($incfile != 'css' && $incfile != 'js' && $groupid < 2) { $incfile = 'login'; }
include SYS_CORE.'/lib/func.image.php';
include SYS_CORE.'/lib/func.admin.php';
$onlines = array();//在线用户
//根据用户所属用户组ID设定其操作选项
$adminitem = array();
switch($groupid)
{
	case 2:
		$adminitem = array(
		'main'    => '控制面板',
		'article' => '文章管理',
		'page'    => '页面管理',
		);
	break;
	case 3:
		$adminitem = array(
		'main'       => '控制面板',
		'article'    => '文章管理',
		'page'       => '页面管理',
		'comment'    => '评论管理',
		'attachment' => '附件管理',
		'category'   => '分类管理',
		'user'       => '用户管理',
		'template'   => '模板管理',
		'link'       => '友情链接',
		'optimize'   => '网站优化',
		'maintenance'=> '系统维护',
		'configurate'=> '系统设置',
		);
	break;
	case 4:
		$adminitem = array(
		'main'       => '控制面板',
		'article'    => '文章管理',
		'page'       => '页面管理',
		'comment'    => '评论管理',
		'attachment' => '附件管理',
		'category'   => '分类管理',
		'user'       => '用户管理',
		'template'   => '模板管理',
		'link'       => '友情链接',
		'plugin'     => '插件管理',
		'optimize'   => '网站优化',
		'maintenance'=> '系统维护',
		'configurate'=> '系统设置',
		);
	break;
}
//除以上显示的可操作项，在某些操作中会用到以下操作项
$otheritem = array('css', 'js', 'login', 'multisite', 'xmlrpc', 'database', 'upload');
doAction('change_admin_item');

//特殊权限设定
if (!in_array($incfile,$otheritem) && !array_key_exists($incfile,$adminitem)) { redirect('未定义操作','admin.php?file=main'); }
if ($groupid  < 3 && $incfile == 'tag') { redirect('您无权限编辑tag设置','admin.php?file=main'); }
if ($groupid != 4 && $incfile == 'database') { redirect('您无权限操作数据库设置','admin.php?file=main'); }
if ($groupid != 4 && $incfile == 'multisite') { redirect('您无权限访问多站点设置','admin.php?file=main'); }

//加载输出后台管理界面,$groupid>1是为了确保用户具有管理权限
if ($groupid  > 1 && $incfile !='css' && $incfile !='js') { include SYS_CORE.'/manager/view/header.php'; }
include SYS_CORE.'/manager/'.$incfile.'.php';
include SYS_CORE.'/manager/view/'.$incfile.'.php';
if ($groupid  > 1 && $incfile !='css' && $incfile !='js') { include SYS_CORE.'/manager/view/footer.php'; }
