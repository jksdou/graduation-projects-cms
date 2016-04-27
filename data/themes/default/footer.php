<?php
$clearurl = mkUrl('profile.php','clearcookies');
?>
 <footer>
  <div id="generator">
   <p>&nbsp;2012-2014 &copy; <a href="http://www.crogram.org/">CROGRAM</a></p>
   <p>&nbsp;Powered by <a href="<?php echo $constant['SYS_WEBSITE']; ?>" target="_blank"><strong><?php echo $constant['SYS_NAME']; ?></strong></a> <?php echo $constant['SYS_VERSION']; ?></p>
  </div>
  <div id="copyright">
   <p><a href="<?php echo $clearurl; ?>">清除COOKIES</a>&nbsp;</p>
   <p>
    <a href="http://<?php echo $constant['SYS_HOST']; ?>"><strong><?php echo $host['name']; ?></strong></a> All Rights Reserved.&nbsp;
<?php if ($host['icp']) { ?>
    <a href="http://www.miibeian.gov.cn/" target="_blank" title="信息产业部网站备案号"><?php echo $host['icp']; ?></a>&nbsp;
<?php } ?>
   </p>
  </div>
 </footer>
</div>
</body>
</html>
