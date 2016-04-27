<?php
$imgurl = mkUrl('captcha.php','');
?>
<div class="funbox">
<h2 class="title">注册</h2>
<?php if ($host['closereg']) { ?>
<p>对不起, 目前系统禁止新用户注册. 请返回...</p>
<?php } else { ?>
  <form action="<?php echo $profile_url; ?>" method="post" onsubmit="return checkloginform();">
  <input type="hidden" name="url" value="do<?php echo $url;?>" />
 <fieldset>
  <legend>用户注册</legend>
  <div><strong>您的电子邮箱不会被公布出去,但是必须填写.</strong> 在您注册之前请先认真阅读<a href="#" title="网站服务条款">服务条款</a>.</div>
  <div>
   <label for="username">用户名</label>
   <input name="username" id="username" type="text" size="30" maxlength="20" tabindex="1" value="" class="formfield" placeholder="用户名" />
  </div>
  <div>
   <label for="usernickname">个性昵称</label>
    <input name="usernickname" id="usernickname" type="text" size="30" maxlength="30" tabindex="2" value="" class="formfield" placeholder="个性昵称" />
  </div>
  <div>
    <label for="password">密码</label>
    <input name="password" id="password" type="password" size="30" maxlength="20" tabindex="3" value="" class="formfield" placeholder="密码" />
  </div>
  <div>
    <label for="confirmpassword">确认密码</label>
    <input name="confirmpassword" id="confirmpassword" type="password" size="30" maxlength="20" tabindex="4" value="" class="formfield"  placeholder="再次输入密码" />
  </div>
  <div>
    <label for="email">电子邮箱</label>
    <input name="email" id="email" type="text" size="30" maxlength="100" tabindex="5" value="" class="formfield" placeholder="电子邮箱" />
  </div>
  <div>
    <label for="clientcode">验证码</label>
    <input name="clientcode" id="clientcode" size="6" maxlength="6" value="" tabindex="6" class="formfield" placeholder="验证码" />
    <img id="seccode" class="codeimg" src="<?php echo $imgurl;?>" alt="单击图片换张图片" border="0" onclick="this.src='<?php echo $imgurl;?>?' + Math.random()" />
  </div>
   <div>
    <label for="agreetoterms">同意服务条款</label>
    <input name="agreetoterms" id="agreetoterms" type="checkbox" value="1" tabindex="7" /> 请仔细阅读<a href="#" title="网站服务条款">服务条款</a>
   </div>
   <div class="enter">
    <label for="submit"><button name="submit" id="submit" type="submit" class="formbutton">确定</button></label>
    <button name="submit" type="reset" class="formbutton">重置</button>
   </div>
   <div><strong>在您提交注册信息时, 我们认为您已经同意了我们的服务条款.<br />这些条款随时可能在未经您同意和知晓的情况下发生改动.</strong></div>
  </fieldset>
 </form>
</div>
<?php } ?>
