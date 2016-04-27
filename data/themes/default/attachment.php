<?php
$top10cache = getLatestArticle(10);
include SYS_DATA."/themes/$theme/header.php";
?>
 <section>
  <div id=maincontent>
   <div class=leftbox>
    <h3>当前位置&raquo;附件详情</h3>
    <h2><?php echo $attachinfo['filename']; ?></h2>
    <p>点击这里下载文件：<a href="<?php echo $query_url; ?>"><?php echo $attachinfo['filename']; ?></a></p>
    <p>文件名：<?php echo $attachinfo['filename']; ?></p>
    <p>上传时间：<?php echo date("Y-m-d H:i",$attachinfo['dateline']); ?></p>
    <p>文件大小：<?php echo changeFileSize($attachinfo['filesize']); ?></p>
   </div>
  </div>
 </section>
 <aside id="subcontent">
  <div class=rightbox>
   <h3>热门文章</h3>
   <ul>
<?php foreach($top10cache AS $data) { ?>
    <li><a href="<?php echo $data['aurl'];?>" title="<?php echo $data['title'];?>,浏览<?php echo $data['views'];?>"><?php echo $data['title'];?></a></li>
<?php } ?>
   </ul>
  </div>
 </aside>
<?php include SYS_DATA."/themes/$theme/footer.php"; ?>