<?php
$hotdata = getHotArticle(10,$article['cateid']);
if (is_array($article['tag'])) $likedata = getRelatedArticle($article['aid'],$article['tag'],10);
$user =getUserDataById($article['userid']);//有问题
include SYS_DATA."/themes/$theme/header.php";
?>
 <section>
  <div id="maincontent">
   <div class="leftbox">
    <div class="boxnav">
     <h3><a href="<?php echo $article['curl'];?>"><?php echo $article['cname'];?></a>&raquo;<?php echo $article['title'];?></h3>
    </div>
     <!--start printcontent-->
     <h2><?php echo $article['title']; ?></h2>
    <div id="contentmeta">
     <div>
     <span>
      <a href="javascript:;" class="add_bookmark" onclick="bookmarksite(document.title, window.location.href);">收藏</a>
      &nbsp;类别:<?php echo $article['cname'];?>
      &nbsp;来源:<?php echo $article['source'];?>
      &nbsp;浏览:<?php echo $article['views']; ?>
      &nbsp;<a href="javascript:void(0);" onClick="printcontent()">打印</a>
     </span>
      发布者：<?php echo $user['username'];?>
     </div>
     <div>
      <span>
       <a href="javascript:;" class="report" onclick="report(574);">举报</a>
      </span>
       时间:<?php echo $article['dateline']; ?>
     </div>
    </div>
    <div id="contents">
<?php if (!$article['allowread']) { ?>
     <div class="needpwd">
      <form action="<?php echo $article['aurl'];?>" method="post">
       <p>这篇日志被加密了。请输入密码后查看。</p>
       <input class="formfield" type="password" name="readpassword" style="margin-right:5px;" />
       <button class="formbutton" type="submit">提交</button>
      </form>
     </div>
<?php } else { echo $article['content']; if ($articleflip) { ?>
	<div class="flip"><?php echo $articleflip; ?></div>
<?php } if ($article['attachments']) { ?>
    <div class="attach">
    <span>所有附件</span>
<?php foreach($article['attachments'] as $image) { if ($image['isimage']) { ?>
     <div><strong>图片: </strong><a href="<?php echo $image['aurl'];?>" target="_blank"><?php echo $image['filename'];?></a>
     (大小：<?php echo $image['filesize']; ?>KB, 下载次数:<?php echo $image['downloads']; ?>)</div>
<?php } } foreach($article['attachments'] as $attach) { if (!$attach['isimage']) { ?>
     <div><strong>文件: </strong><a href="<?php echo $attach['aurl']; ?>" target="_blank"><?php echo $attach['filename'];?></a>
     (大小：<?php echo $attach['filesize']; ?>KB, 下载次数:<?php echo $attach['downloads']; ?>)</div>
<?php } } ?>
    </div>
<?php } } ?>
    </div><!--end content-->
    <!--end printcontent-->
    <div id="relatedinfo">
     <h3>相关信息</h3>
     <ul id=like>
      <li>
       上一篇:<a href="./<?php echo $article['aurl'];?>"><?php echo $article['cname'];?></a>
       下一篇:<a href="./<?php echo $article['aurl'];?>"><?php echo $article['cname'];?></a>
      </li>
<?php if ($article['tag']) { ?>
      <li>标签：
<?php foreach($article['tag'] as $tag) { $tagurl = mkUrl('tag.php',$tag); ?>
       <a href="<?php echo $tagurl; ?>"><?php echo $tag; ?></a>&nbsp;
<?php } ?>
      </li>
<?php } ?>
      <li>链接：<a href="./<?php echo $article['aurl'];?>">http://<?php echo $constant['SYS_HOST'];?>/<?php echo $article['aurl'];?></a></li>
      <li><b>收藏到网摘：</b></li>
     </ul>
    </div><!--end relatedinfo-->
<?php include SYS_DATA."/themes/$theme/comments.php"; ?>
   </div><!-- end leftbox -->
  </div><!-- end maincontent -->
 </section>
  <aside id="subcontent">
   <div class="rightbox">
    <h3>同类文章</h3>
     <ul>
<?php foreach($hotdata as $data){ ?>
      <li><a href="<?php echo $data['aurl']; ?>" title="<?php echo $data['title']; ?>"><?php echo $data['title'];;?></a></li>
<?php } ?>
    </ul>
   </div><!-- end rightbox -->
  </aside>
<?php include SYS_DATA."/themes/$theme/footer.php"; ?>