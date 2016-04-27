<?php
$hotcache   = getHotArticle(10);
$picscache  = getPicArticle(5);//图片文章5篇
$stickcache = getStickArticle(10);
$top10cache = getLatestArticle(10);//热门文章10篇
$commentdata= getLatestComment(10);
$linkarr    = getLink();//获取首页友情链接
include SYS_DATA."/themes/$theme/header.php";
?>
 <section>
  <!-- start maincontent -->
  <div id="maincontent">
   <div class="picslide">
    <div class="sub_nav">
     <div class="sub_no" id="picslideno">
      <ul>
<?php foreach($picscache as $k=>$v) { ?>
       <li><?php echo $k+1; ?></li>
<?php } ?>
      </ul>
     </div>
    </div>
    <div id="bd1lfimg">
     <div>
      <dl></dl>
<?php foreach($picscache as $k=>$v) { ?>
      <dl><dt><a href="<?php echo $v['aurl']; ?>" target="_self"><img src="attachment.php?url=<?php echo $v['aid']; ?>"></a></dt><dd><tt><?php echo $v['title']; ?></tt></dd></dl>
<?php } ?>
     </div>
    </div>
    <script type="text/javascript">movec();</script>
   </div>
   <div id="focist">
    <ul>
<?php foreach($top10cache AS $data) { ?>
     <li><a href="<?php echo $data['aurl']; ?>" title="<?php echo $data['title']; ?>"><?php echo $data['title']; ?></a></li>
<?php } ?>
    </ul>
   </div>
<?php foreach($cateArr as $cateid=>$cname) {
	if(isset($listcache[$cateid])) {
		/*隐藏的栏目不显示*/ ?>
   <div class=box>
    <h3><a href="<?php echo $cname['curl']; ?>"><?php echo $cname['name']; ?></a></h3>
    <ul>
<?php
		$value=$listcache[$cateid];
		if(!empty($value)) {
			foreach($value AS $k=>$v) {
				$data=$latestarray['article'][$v];?>
     <li><a href="<?php echo $data['aurl']; ?>" title="<?php echo $data['title']; ?>"><?php echo $data['title'];;?></a></li>
<?php
			}
		}
?>
    </ul>
   </div>
<?php
	}
}
?>
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
<?php if ($linkarr) { ?>
 <div class="links">
  <h3>友情链接:</h3>
  <ul>
<?php foreach($linkarr AS $link) { ?>
   <li><a href="<?php echo $link['url'];?>" target="_blank" title="<?php echo $link['note'];?>"><?php echo $link['name'];?></a></li>
<?php } ?>
  </ul>
 </div>
<?php } ?>
<?php include SYS_DATA."/themes/$theme/footer.php"; ?>
