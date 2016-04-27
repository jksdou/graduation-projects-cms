<?php
$imgurl = mkUrl('captcha.php','');
?>
<div class="funbox">
<h2 class="title">登陆</h2>
<form action="<?php echo $profile_url; ?>" method="post" onsubmit="return checkloginform();">
 <input type="hidden" name="action" value="dologin" />
 <input type="hidden" name="url" value="do<?php echo $url;?>" />
 <fieldset>
  <legend>用户登录</legend>
  <div>登陆后, 可以使用您的专署名字发表评论,系统在您发表评论时自动填写个人信息.</div>
  <div>
   <label for="username">用户名</label>
   <input name="username" id="username" type="text" size="30" tabindex="1" maxlength="20" value="<?php echo $username; ?>" class="formfield" />
  </div>
  <div>
   <label for="password">密码</label>
   <input name="password" id="password" type="password" size="30" tabindex="2" maxlength="20" value="" class="formfield" />
  </div>
<?php if ($host['seccode_enable']) { ?>
  <div>
   <label for="clientcode">验证码</label>
   <input name="clientcode" id="clientcode" value="" tabindex="3" class="formfield" size="6" maxlength="6" />
   <img id="seccode" class="codeimg" src="<?php echo $imgurl; ?>" alt="单击图片换张图片" border="0" onclick="this.src='<?php echo $imgurl; ?>?' + Math.random()" />
  </div>
<?php } ?>
  <div><label for="submit"><button name="submit" id="submit" type="submit" class="formbutton">确定</button></label></div>
  <div class="forgotpass"><a href="#">忘记密码了？</a></div>
  </fieldset>
</form>
</div>
