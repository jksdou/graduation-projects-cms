<?php
$stickcache=getStickArticle(10);//置顶文章
$hotcache=getHotArticle(10,$cate['cid']);
$rss_url=mkUrl('rss.php',$cate['url']);
include SYS_DATA."/themes/$theme/header.php";
$multipage = pagination($allcount,$host['list_shownum'],$page,'category.php',$cate['url']);
?>
 <section>
  <div id="maincontent">
   <div class="leftbox">
    <h3>当前位置&raquo;<a href="<?php echo $cate['curl'];?>"><?php echo $cate['name'];?></a></h3>
<?php include SYS_DATA."/themes/$theme/list.php"; ?>
   </div>
  </div>
 </section>
 <aside id="subcontent">
  <div class="rightbox">
   <h3>推荐文章</h3>
   <ul>
<?php foreach($stickcache AS $data) { ?>
    <li><a href="<?php echo $data['aurl'];?>" title="<?php echo $data['title'];?>"><?php echo $data['title'];?></a></li>
<?php } ?>
   </ul>
  </div>
  <div class="rightbox">
   <h3>热门文章</h3>
   <ul>
<?php foreach($hotcache AS $data) { ?>
    <li><a href="<?php echo $data['aurl'];?>" title="<?php echo $data['title'];?>,浏览<?php echo $data['views'];?>"><?php echo $data['title'];?></a></li>
<?php } ?>
   </ul>
  </div>
 </aside>
<?php include SYS_DATA."/themes/$theme/footer.php"; ?>
