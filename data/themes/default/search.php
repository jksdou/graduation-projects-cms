<?php
if (!defined('SYS_ROOT')) exit('Access Denied');
$hotcache   = getHotArticle(10);
$stickcache = getStickArticle(10);
$searchlist = getLatestSearch(100);
$commentdata= getLatestComment(10);
include SYS_DATA."/themes/{$theme}/header.php";
?>
 <section>
   <div id="maincontent">
     <div class=leftbox>
<?php if (isset($articledb) && $searchd) { ?>
      <h3>关键字&gt;&gt;<?php echo $searchd;?></h3>
<?php require SYS_DATA."/themes/{$theme}/list.php"; ?>
<?php } else { ?>
      <div class="searchform">
      <div class="searchtitle"><?php echo $host['name']; ?>搜索</div>
      <form action="<?php echo $search_url;?>" method="post" >
      <input type="text" name="keywords" id="keywords" value="" onmouseover="this.focus()" autocomplete="off" class="searchinput" placeholder="输入 回车搜索" autofocus x-webkit-speech />
      <button type="submit" id="go" class="searchbutton" >搜 索</button>
      </form>
    </div>
<?php if (!empty($searchlist)) {
	foreach($searchlist as $kv) { 	$surl=mkUrl('search.php',$kv);
		echo "<span style=\"align-content: center; margin-left: 20px;\"><a href=\"$surl\">$kv</a></span>\n";
	}
}
} ?>
    </div>
   </div><!-- end maincontent -->
 </section>
 <aside id="subcontent">
  <div class="rightbox">
   <h3>热门文章</h3>
   <ul>
<?php foreach($hotcache as $data){ ?>
    <li><a href="<?php echo $data['aurl']; ?>" title="<?php echo $data['title']; ?>"><?php echo $data['title'];;?></a></li>
<?php } ?>
   </ul>
  </div>
  <div class="rightbox">
   <h3>推荐文章</h3>
   <ul>
<?php foreach($stickcache AS $data) { ?>
    <li><a href="<?php echo $data['aurl']; ?>" title="<?php echo $data['title']; ?>"><?php echo $data['title'];;?></a></li>
<?php } ?>
   </ul>
  </div>
  <div class="rightbox">
   <h3>最新评论</h3>
   <ul>
<?php foreach($commentdata AS $data) { ?>
    <li><a href="<?php echo $data['url']; ?>"><?php echo $data['content'];?></a></li>
<?php } ?>
   </ul>
  </div>
 </aside>
<?php include SYS_DATA."/themes/{$theme}/footer.php"; ?>
