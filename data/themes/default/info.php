<div class="mainbox">
个人资料<br />
用户ID：<?php echo $userinfo['uid'];?><br />
用户名：<?php echo $userinfo['username'];?><br />
昵称：<?php echo $userinfo['usernickname'];?><br />
电子邮箱：<?php echo $userinfo['email'];?><br />
腾讯QQ：<?php echo $userinfo['qq'];?><br />
MSN：<?php echo $userinfo['msn'];?><br />
头像：<?php echo $userinfo['face'];?><br />
发表文章数：<?php echo $userinfo['articles'];?><br />
个人站点：<a href="<?php echo $userinfo['usersiteurl'];?>" target="_blank"><?php echo $userinfo['usersitename'];?></a><br />
注册时间：<?php echo $userinfo['regdateline'];?><br />
注册IP：<?php echo $userinfo['regip'];?><br />
登录次数：<?php echo $userinfo['logincount'];?><br />
最后登录IP：<?php echo $userinfo['loginip'];?><br />
最后登录时间：<?php echo $userinfo['logintime'];?><br />
最后发表评论：<?php echo $userinfo['lastpost'];?><br />
</div>