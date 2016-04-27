<?php
if (!defined('SYS_ROOT')) { exit('Access Denied'); }
$hotcache = getHotArticle(10);

include SYS_DATA."/themes/$theme/header.php";
?>
 <section>
<div id="maincontent">
<div class=leftbox>
<h3>标签</h3>
<div id=contents>
<?php if ($articledb) { require SYS_DATA."/themes/{$theme}/list.php"; }
else if ($tagdb) { foreach($tagdb as $key => $tag) { $tagurl=mkUrl('tag.php',$tag['url']); ?>
<span style="line-height:160%;font-size:$tag[fontsize]px;margin-right:10px;"><a href="<?php echo $tagurl;?>" title="使用次数: <?php echo $tag['usenum'];?>"><?php echo $tag['item'];?></a></span>
<?php } } echo $multipage ?>
</div>
</div></div>
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
  <div class=rightbox>
   <h3>XXX</h3>
   <ul>
    <li><a href="#" title="">test</a></li>
   </ul>
  </div>
  <div class=rightbox>
   <h3>XXX</h3>
   <ul>
    <li><a href="#" title="">test</a></li>
   </ul>
  </div>
 </aside>
<?php include SYS_DATA."/themes/$theme/footer.php"; ?>
