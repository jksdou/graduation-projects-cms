<?php
/**
 * 执行结果消息并转向相应链接
 * @param string $msg 提示信息
 * @param string $url 返回地址
 * @param string $min 等待时间(单位秒)
 */
function redirect($msg, $url='javascript:history.go(-1);', $min='2')
{
	global $cssfile,$jsfile;
	ob_end_clean();
	ob_start();
	include SYS_CORE.'/manager/view/redirect.php';//消息界面文件
	$output = ob_get_contents();
	$output = adminRewrite($output);
	@ob_end_clean();
	exit($output);
}

/**
 * 分页函数
 */
function multi($num, $perpage, $curpage, $mpurl)
{
	$multipage = '';
	$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
	if ($num > $perpage)
	{
		$page = 10;
		$offset = 5;
		$pages = @ceil($num / $perpage);
		if ($page > $pages)
		{
			$from = 1;
			$to = $pages;
		}
		else
		{
			$from = $curpage - $offset;
			$to = $curpage + $page - $offset - 1;
			if ($from < 1)
			{
				$to = $curpage + 1 - $from;
				$from = 1;
				if (($to - $from) < $page && ($to - $from) < $pages)
				{
					$to = $page;
				}
			}
			elseif ($to > $pages)
			{
				$from = $curpage - $pages + $to;
				$to = $pages;
				if (($to - $from) < $page && ($to - $from) < $pages)
				{
					$from = $pages - $page + 1;
				}
			}
		}

		$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'page=1">第一页</a> ' : '').($curpage > 1 ? '<a href="'.$mpurl.'page='.($curpage - 1).'">上一页</a> ' : '');
		for($i = $from; $i <= $to; $i++)
		{
			$multipage .= $i == $curpage ? $i.' ' : '<a href="'.$mpurl.'page='.$i.'">['.$i.']</a> ';
		}
		$multipage .= ($curpage < $pages ? '<a href="'.$mpurl.'page='.($curpage + 1).'">下一页</a>' : '').($to < $pages ? ' <a href="'.$mpurl.'page='.$pages.'">最后一页</a>' : '');
		$multipage = $multipage ? '页: '.$multipage : '';
	}
	return $multipage;
}

/**
 * 目录的实际大小
 */
function dirsize($dir)
{ 
	$dh = @opendir($dir);
	$size = 0;
	while($file = @readdir($dh))
	{
		if ($file != '.' && $file != '..')
		{
			$path = $dir.'/'.$file;
			if (@is_dir($path))
			{
				$size += dirsize($path);
			}
			else
			{
				$size += @filesize($path);
			}
		}
	}
	@closedir($dh);
	return $size;
}

/**
 * 目录个数
 */
function dircount($dir)
{ 
	$dh = @opendir($dir);
	$count = 0;
	while($file = @readdir($dh))
	{
		if ($file != '.' && $file != '..')
		{
			$path = $dir.'/'.$file;
			if (@is_dir($path))
			{
				$count++;
			}
		}
	}
	@closedir($dh);
	return $count;
}

/**
 * 文件大小
 */
function sizecount($filesize)
{
	if ($filesize >= 1073741824)
	{
		$filesize = round($filesize / 1073741824 * 100) / 100 . ' GB';
	}
	elseif ($filesize >= 1048576)
	{
		$filesize = round($filesize / 1048576 * 100) / 100 . ' MB';
	}
	elseif ($filesize >= 1024)
	{
		$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
	}
	else
	{
		$filesize = $filesize . ' Byte';
	}
	return $filesize;
}

/**
 * 解压zip
 */
function UnZipFile ($zipfile, $path, $type = 'tpl')
{
	if (class_exists('ZipArchive', FALSE))
	{
		$zip = new ZipArchive();
		if (@$zip->open($zipfile) === TRUE)
		{
			$r = explode('/', $zip->getNameIndex(0), 2);
			$dir = isset($r[0]) ? $r[0].'/' : '';
			switch ($type)
			{
				case 'tpl':
					$re = $zip->getFromName($dir.'header.php');
					if (false === $re)
					return -2;
					break;
				case 'plugin':
					$plugin_name = substr($dir, 0, -1);
					$re = $zip->getFromName($dir.$plugin_name.'.php');
					if (false === $re)
						return '安装失败，插件安装包不符合标准';
					break;
			}
			if (true === $zip->extractTo($path))
			{
				$zip->close();
				return true;
			}
			else
			{
				return '只支持zip压缩格式的插件包';
			}
		}
		else
		{
			return '只支持zip压缩格式的插件包';
		}
	}
	else
	{
		return "服务器不支持zip模块，请按照提示手动安装插件";
	}
}