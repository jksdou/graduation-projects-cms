<?php
include SYS_DATA."/themes/{$theme}/header.php";
?>
<div id="container">
 <div class="fullbox">
<?php if ($groupid) { ?>
 <div class="sidebar1">
<div><strong>个人中心</strong></div>
   <ul>
    <li><a href="<?php echo $profile_url; ?>?url=mycommont">我的评论</a></li>
    <li><a href="<?php echo $profile_url; ?>?url=info">查看我的资料</a></li>
    <li><a href="<?php echo $profile_url; ?>?url=mod">修改资料</a></li>
    <li><a href="<?php echo $profile_url; ?>?url=feedback">反馈信息</a></li>
   </ul>
</div>
<?php }
if ($url=='register') { include SYS_DATA."/themes/{$theme}/reg.php"; }
if ($url=='login') { include SYS_DATA."/themes/{$theme}/login.php"; }
if ($url=='info') { include SYS_DATA."/themes/{$theme}/info.php"; }
if ($url=='mod') { include SYS_DATA."/themes/{$theme}/mod.php"; }
?>
 </div>
</div>
<?php include SYS_DATA."/themes/{$theme}/footer.php"; ?>
