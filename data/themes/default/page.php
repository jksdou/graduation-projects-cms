<?php
include SYS_DATA."/themes/$theme/header.php";
?>
  <div id="page">
    <div class="boxnav">
     <h3><a href="<?php echo $singlepage['curl'];?>"><?php echo $singlepage['cname'];?></a>&raquo;<?php echo $singlepage['title'];?>
     </h3>&nbsp;
     <a href="javascript:void(0);" onClick="printcontent()">打印文章</a>
    </div>
     <!--start printcontent-->
     <h2><?php echo $singlepage['title']; ?></h2>
    <div id="contentmeta">
     <p>时间:<?php echo $singlepage['dateline'];?>&nbsp;类别:<?php echo $singlepage['cname'];?>&nbsp;编辑:<?php echo $singlepage['userid'];?>&nbsp;来源:<?php echo $singlepage['source'];?>&nbsp;浏览:<?php echo $singlepage['views']; ?></p>
    </div>
    <div id="contents">
<?php
if (!$singlepage['allowread'])
{
?>
     <div class="needpwd">
      <form action="<?php echo $singlepage['aurl'];?>" method="post">
       <p>这篇日志被加密了。请输入密码后查看。</p>
       <input class="formfield" type="password" name="readpassword" style="margin-right:5px;" />
       <button class="formbutton" type="submit">提交</button>
      </form>
     </div>
<?php
}
else
{
	echo $singlepage['content'];
	if ($multipage)
	{
?>
	<div id="flip"><?php echo $multipage;?></div>
<?php
	}
	if ($singlepage['attachments'])
	{
		foreach($singlepage['attachments'] as $image)
		{
			if ($image['isimage'])
			{
?>
      <p class="attach">
       <?php echo $image['filename'];?><br />
       <a href="<?php echo $image['aurl'];?>" target="_blank"><img src="<?php echo $image['aurl'];?>" border="0" alt="大小: <?php echo $image['filesize'];?>KB&#13;浏览: <?php echo $image['downloads'];?> 次" /></a>
      </p>
<?php
			}
		}
		foreach($singlepage['attachments'] as $attach)
		{
			if (!$attach['isimage'])
			{
?>
      <p class="attach">
       <strong>附件: </strong><a href="<?php echo $image['aurl'];?>" target="_blank"><?php echo $attach['filename'];?></a> (<?php echo $attach['filesize'];?>KB, 下载次数:<?php echo $attach['downloads'];?>)
      </p>
<?php
			}
		}
	}
}
?>
    </div><!--end content-->
    <!--end printcontent-->

  </div><!-- end page -->
<?php include SYS_DATA."/themes/$theme/footer.php"; ?>
