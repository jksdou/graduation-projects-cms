<?php
if (!defined('SYS_ROOT')) exit('Access Denied');
include SYS_DATA."/themes/$theme/header.php";
?>
 <div id="container">
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
    <div id="relatedinfo">
     <h3>相关信息</h3>
     <ul id=like>
      <li>上一篇下一篇此功能需要实现哦！！！</li>
      <li>标签：
<?php
if ($singlepage['tag'])
{
  foreach($singlepage['tag'] as $tag)
  {
  $tagurl=mkUrl('tag.php',$tag);
?>
       <a href="<?php echo $tagurl; ?>"><?php echo $tag; ?></a>&nbsp;
<?php
  }
?>
      </li>
      <li>本文链接：<a href="./<?php echo $singlepage['aurl'];?>">http://<?php echo $constant['SYS_HOST'];?>/<?php echo $singlepage['aurl'];?></a></li>
      <li><b>将本文收藏到网摘：</b></li>
     </ul>
    </div>
    <div id="comments">
<?php
}

if ($singlepage['comments'])
{
?>
    <span style="float:right;padding-bottom: 2px;font-size: 12px;"><?php echo $singlepage['comments'];?>条记录</span>访客评论
<?php
  foreach($commentdb as $key => $comment)
  {
?>
     <div class="cbox">
      <a id="cm <?php echo $comment['pid']; ?>"></a>
      <p class="lesscontent" id="comm_<?php echo $comment['pid'];?>"><?php echo $comment['content'];?></p>
      <p class="lessdate">from <?php echo $comment['username'];?> on <?php echo $comment['dateline'];?> <img style="cursor: hand" onclick="addquote('comm_<?php echo $comment['pid'];?>','<?php echo $comment['userid'];?>')" src="/images/quote.gif" border="0" alt="引用此文发表评论" /> <font color="#000000">#<strong><?php echo $comment['pid'];?></strong></font></p>
     </div>
<?php
  }
?>
<?php echo $multipage ?>
<?php
}
if (!$singlepage['closed'])
{
?>
     <h3>添加评论</h3>
     <form method="post" name="form" id="form" action="comment.php" onsubmit="return checkform();">
      <input type="hidden" name="url" value="<?php echo $singlepage['url'];?>" />
      <div class="formbox">
<?php if ($uid) { ?>
       <p>已经登陆为 <b><?php echo $username;?></b> [<a href="<?php echo $logout_url;?>">注销</a>]</p>
<?php } else { ?>
       <p>
        <label for="username">
         <input name="username" id="username" type="text" value="<?php echo $comment_username;?>" tabindex="1" class="formfield" style="width: 210px;" placeholder="输入您的名称(必填)" />
       </label>
       <label for="password">
        <input name="password" id="password" type="password" value="" tabindex="2" class="formfield" style="width: 210px;" placeholder="输入密码 (访客不需要密码)" />
       </label>
       </p>
       <p>
        <label for="url">
        <input type="text" name="url" id="url" value="<?php echo $comment_url;?>" tabindex="3" class="formfield" style="width: 210px;"  placeholder="网址或电子邮件 (选填)" />
       </label>
       <label for="clientcode">
        <input name="clientcode" id="clientcode" value="" tabindex="4" class="formfield" size="3" maxlength="6" style="width: 150px;" placeholder="请输入图片中的后三位数字" /> <img id="seccode" class="codeimg" src="captcha.php" alt="单击图片换张图片" border="0" onclick="this.src='captcha.php?update=' + Math.random()" />
       </label>
      </p>
<?php } ?>
      <p>
       <textarea name="content" cols="84" rows="6" tabindex="5" onkeydown="ctlent(event);" class="formfield" id="content" placeholder="评论内容" ><?php echo $cmcontent;?></textarea>
      </p>
<?php if ($host['audit_comment'] && $groupid < 2) { ?>
<?php } ?>
      <p><input type="hidden" name="action" value="addcomment" /><button type="submit" name="submit" class="formbutton">提交</button></p>
      </div>
     </form>
<?php } else { ?>
      <p align="center"><strong>本文因为某种原因此时不允许访客进行评论</strong></p>
<?php } ?>
   </div><!-- end comments -->
  </div><!-- end page -->
 </div><!-- end container -->
<?php include SYS_DATA."/themes/$theme/footer.php"; ?>