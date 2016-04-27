    <div class="comments">

<?php
if ($article['comments'])
{ ?>
    <span style="float:right;padding-bottom: 2px;font-size: 12px;"><?php echo $article['comments'];?>条记录</span>访客评论
<?php
  foreach($commentdb as $key => $comment)
  { ?>
     <div class="cbox">
      <a id="cm <?php echo $comment['cid']; ?>"></a>
      <p class="lesscontent" id="comm_<?php echo $comment['cid'];?>"><?php echo $comment['content'];?></p>
      <p class="lessdate">FROM <?php echo $comment['username'];?> AT <?php echo $comment['dateline'];?> <a  href="javascript:void(0);" onclick="addquote('comm_<?php echo $comment['cid'];?>','<?php echo $comment['userid']; ?>')">引用</a> <font color="#000000">#<strong><?php echo $comment['cid'];?></strong></font></p>
     </div>
<?php
  } ?>
<?php echo $multipage ?>
<?php
}
if (!$article['closed'])
{ ?>
     <h3>添加评论</h3>
     <form method="post" name="form" id="form" action="comment.php" onsubmit="return checkform();">
      <input type="hidden" name="url" value="<?php echo $article['url'];?>" />
      <div class="formbox">
<?php
if ($uid)
{ ?>
       <p>已经登陆为<b><?php echo $username;?></b>[<a href="<?php echo $logout_url;?>">注销</a>]</p>
<?php
} else
{ ?>
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
         <input type="text" name="url" id="url" value="<?php echo $comment_url;?>" tabindex="3" class="formfield" style="width: 210px;" placeholder="网址或电子邮件 (选填)" />
        </label>
        <label for="clientcode">
         <input name="clientcode" id="clientcode" value="" tabindex="4" class="formfield" size="3" maxlength="6" style="width: 150px;" placeholder="请输入图片中的后三位数字" /><img id="seccode" class="codeimg" src="captcha.php" alt="单击图片换张图片" border="0" onclick="this.src='captcha.php?update=' + Math.random()" />
        </label>
      </p>
<?php
} ?>
      <p>
       <textarea name="content" cols="84" rows="6" tabindex="5" onkeydown="ctlent(event);" class="formfield" id="content" placeholder="评论内容" ><?php echo $cmcontent;?></textarea>
      </p>
<?php if ($host['audit_comment'] && $groupid < 2) { ?>
<?php } ?>
      <p><input type="hidden" name="action" value="addcomment" /><button type="submit" name="submit" class="formbutton">提交</button></p>
      </div>
     </form>
<?php
}
else
{ ?>
      <p align="center"><strong>本文因为某种原因此时不允许访客进行评论</strong></p>
<?php
} ?>
    </div><!-- end comments -->
