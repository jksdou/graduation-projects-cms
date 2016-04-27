<?php
$imgurl = mkUrl('captcha.php','');
?>
  <div class="mainbox">
  <form action="<?php echo $profile_url; ?>" method="post" onsubmit="return checkloginform();">
  <input type="hidden" name="url" value="do<?php echo $url;?>" />
  <p>
   <label for="oldpassword">原始密码：<br />
    <input name="oldpassword" id="oldpassword" type="password" size="30" tabindex="1" value="" class="formfield" placeholder="旧密码" />
   </label>
  </p>
  <p>
   <label for="newpassword">新密码：<br />
    <input name="newpassword" id="newpassword" type="password" size="30" tabindex="2" value="" class="formfield" placeholder="新密码" />
   </label>
  </p>
  <p>
    <label for="confirmpassword">确认新密码：<br />
     <input name="confirmpassword" id="confirmpassword" type="password" size="30" tabindex="3" value="" class="formfield" placeholder="再次输入新密码" />
    </label>
  </p>
  <p>
   <label for="email">E-mail:<br />
    <input name="email" id="email" type="email" size="30" tabindex="4" value="<?php echo $userinfo['email'];?>" class="formfield" placeholder="电子邮箱" />
   </label>
  </p>
  <p>
   <label for="usernickname">个性昵称:<br />
    <input name="usernickname" id="usernickname" type="text" size="30" tabindex="4" value="<?php echo $userinfo['usernickname'];?>" class="formfield" placeholder="个性昵称" />
   </label>
  </p>
  <p>
   <label for="qq">腾讯QQ:<br />
    <input name="qq" id="qq" type="text" size="30" tabindex="5" value="<?php echo $userinfo['qq'];?>" class="formfield" placeholder="腾讯QQ" />
   </label>
  </p>
  <p>
   <label for="msn">微软MSN:<br />
    <input name="msn" id="msn" type="text" size="30" tabindex="6" value="<?php echo $userinfo['msn'];?>" class="formfield" placeholder="微软MSN" />
   </label>
  </p>
  <p>
   <label for="face">头像:<br />
    <input name="face" id="face" type="text" size="30" tabindex="7" value="<?php echo $userinfo['face'];?>" class="formfield" placeholder="头像" />
   </label>
  </p>
  <p>
   <label for="usersiteurl">个人站点:<br />
    地址<input name="usersiteurl" id="usersiteurl" type="text" size="30" tabindex="8" value="<?php echo $userinfo['usersiteurl'];?>" class="formfield" placeholder="站点地址" />
   </label>
   <label for="usersitename">
   名称<input name="usersitename" id="usersitename" type="text" size="30" tabindex="9" value="<?php echo $userinfo['usersitename'];?>" class="formfield" placeholder="站点名" />
   </label>
  </p>
<?php if ($host['seccode_enable']) { ?>
  <p>
    <label for="clientcode">验证码(*):<br />
    <input name="clientcode" id="clientcode" size="6" maxlength="6" tabindex="10" value="" class="formfield" placeholder="验证码"/>
    <img id="seccode" class="codeimg" src="<?php echo $imgurl;?>" alt="单击图片换张图片" border="0" onclick="this.src='<?php echo $imgurl;?>?' + Math.random()" /></label>(请将后三位数字倒序输入)
  </p>
<?php } ?>
  <p>
    <label for="submit">
    <button name="submit" id="submit" type="submit" class="formbutton">确定</button>
    </label>
  </p>
  </form>
</div>
