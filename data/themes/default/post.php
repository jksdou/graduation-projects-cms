<?php
$coredir = basename(SYS_CORE);//core目录
$cssfile = 'admin.php?file=css';//管理后台的css文件
$action=!empty($_GET['action'])?$_GET['action']:(!empty($_POST['action'])?$_POST['action']:'');
$editordir='/'.$coredir.'/manager/editor/';
include SYS_DATA."/themes/$theme/header.php";
print <<<EOT
<script type="text/javascript" src="/js/jquery-1.4.3.min.js"></script>
<script type="text/javascript" src="{$editordir}xheditor-1.1.14-zh-cn.min.js"></script>

<style type="text/css">
<!--
.btnCode {
	background:transparent url({$editordir}/xheditor_plugins/prettify/code.gif) no-repeat 16px 16px;
	background-position:2px 2px;
}
-->
</style>

<script type="text/javascript">
function checkform()
{
	if ($("#title").val()=='') 
	{
		alert("请输入标题");
		return false;
	}
	if ($("#cid").val()==0)	
	{
		alert("请选择分类");
		return false;
	}
	if ($("#content").val()==0)	
	{
		alert("内容不得为空");
		return false;
	}
	return true;
}

var editor;
$(pageInit);
function pageInit()
{
	var allPlugin={
	Code:{c:'btnCode',t:'插入代码',h:1,e:function(){
		var _this=this;
		var htmlCode='<div><select id="xheCodeType"><option value="html">HTML/XML</option><option value="js">Javascript</option><option value="css">CSS</option><option value="php">PHP</option><option value="java">Java</option><option value="py">Python</option><option value="pl">Perl</option><option value="rb">Ruby</option><option value="cs">C#</option><option value="c">C++/C</option><option value="vb">VB/ASP</option><option value="">其它</option></select></div><div><textarea id="xheCodeValue" wrap="soft" spellcheck="false" style="width:300px;height:100px;" /></div><div style="text-align:right;"><input type="button" id="xheSave" value="确定" /></div>';			var jCode=$(htmlCode),jType=$('#xheCodeType',jCode),jValue=$('#xheCodeValue',jCode),jSave=$('#xheSave',jCode);
		jSave.click(function(){
			_this.loadBookmark();
			_this.pasteHTML('<pre class="prettyprint lang-'+jType.val()+'">'+_this.domEncode(jValue.val())+'</pre>');
			_this.hidePanel();
			return false;	
		});
		_this.saveBookmark();
		_this.showDialog(jCode);
	}}
	};
	editor=$('#content').xheditor({plugins:allPlugin,tools:'Cut,Copy,Paste,Pastetext,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Align,List,Outdent,Indent,Link,Unlink,Anchor,Img,Flash,Media,Hr,Table,Code,|,Source,Preview,Print,Fullscreen,About',upLinkExt:"zip,rar,txt",upImgUrl:"{$uploadurl}",upImgExt:"jpg,jpeg,gif,png",upFlashUrl:"{$uploadurl}",upFlashExt:"swf",upMediaUrl:"{$uploadurl}",upMediaExt:"avi,rmvb,mkv,mp4,wmv,wma,mid"});
}

$(document).ready(function(){
    $('#cid').change(function(){
		var upurl="admin.php?file=upload&cid="+$(this).children('option:selected').val(); 
        editor.settings.upImgUrl=upurl;
		editor.settings.upFlashUrl=upurl;
		editor.settings.upMediaUrl=upurl;
    });
})

</script>
<script type="text/javascript" src="/js/linkage.js"></script>
<script type="text/javascript" src="/post.php?action=area"></script>
<link rel="stylesheet" href="/css/linkage.css" />
<script>
	$(function(){
		$("#demo").linkage({
			data:districtData,
			return_dom:"linkage",
			{$areainfo}
		});		
	})

</script>
<div class="mainbody">
  <table border="0"  cellspacing="0" cellpadding="0" style="width:100%;">
    <tr>
      <td valign="top" style="width:150px;"><div class="tableborder">
        <div class="tableheader">文章管理</div>
        <div class="leftmenubody">
          <div class="leftmenuitem">&#8226; <a href="post.php?action=add">添加文章</a></div>
          <div class="leftmenuitem">&#8226; <a href="post.php?action=list">编辑文章</a></div>
		  <div class="leftmenuitem">&#8226; <a href="post.php?action=list&view=hidden">未发布($hiddenCount)</a></div>
        </div>
      </div>
	  <div class="tableborder">
        <div class="tableheader">文章分类</div>
        <div class="leftmenubody">
		  <div class="leftmenuitem">&#8226; <a href="post.php?action=list&view=stick">置顶文章</a></div>
EOT;
foreach($cateArr as $key => $cate){print <<<EOT
          <div class="leftmenuitem">&#8226; <a href="post.php?action=list&cid={$cate['cid']}">{$cate['name']}</a></div>
EOT;
}print <<<EOT
        </div>
      </div></td>
      <td valign="top" style="width:20px;"></td>
      <td valign="top">
	  <form action="post.php?action=$action" enctype="multipart/form-data" method="POST" name="form1""><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
	  <tr><td class="rightmainbody"><table width="100%" align="center" border="0" cellspacing="0" cellpadding="0">
EOT;
if ($action == 'list'){print <<<EOT
    <tr class="tdbheader">
      <td width="40%">标题</td>
   	  <td width="12%" nowrap>时间</td>
	  <td width="10%" nowrap>分类</td>
      <td>行业</td>
	  <td>操作</td>
    </tr>
EOT;
foreach($articledb as $key => $article){print <<<EOT
    <tr class="tablecell">
      <td><a href="post.php?action=mod&aid=$article[aid]">$article[title]</a></td>
	  <td nowrap>$article[dateline]</td>
      <td nowrap><a href="post.php?action=list&cid=$article[cateid]">$article[cname]</a></td>
      <td nowrap>$article[areaid]</td>
	  <td nowrap>$article[ope]</td>
	  </tr>
EOT;
}print <<<EOT
        <tr class="tablecell">
          <td colspan="8" nowrap="nowrap"><div class="records">记录:$total</div>
                  <div class="multipage">$multipage</div></td>
        </tr>
EOT;
} 
else if (in_array($action, array('add', 'mod'))) {
$option=getCateOption($cateArr,$article['cateid'],'');
print <<<EOT
    <tr class="tdbheader">
      <td colspan="2">$navtitle</td>
    </tr>
    <tr class="tablecell">
      <td>文章标题:</td>
      <td><input class="formfield" type="text" name="title" id="title" size="50" value="$article[title]"></td>
    </tr>
    <tr class="tablecell">
      <td valign="top">行业分类:</td>
      <td><select name="cid" id="cid">$option</select>
	  </td>
    </tr>
    <tr class="tablecell">
      <td>选择地区:</td>
      <td><div id="demo"></div></td>
    </tr>
    <tr class="tablecell">
      <td valign="top">文章内容:<br /><br />手动分页符<br /><a href="javascript:void(0);" onClick="editor.pasteHTML('[page]');">[page]</a></td>
      <td><textarea name="content" id="content" style="width:100%; height:400px;">{$article['content']}</textarea></td>
    </tr>
EOT;
print <<<EOT
    <input type="hidden" name="action" value="$action">
    <input type="hidden" name="aid" value="$aid">
    <input type="hidden" name="oldtags" value="$article[keywords]">
    <tr class="tablecell">
      <td colspan="2" align="center"><input type="submit" name="submit" id="submit" value="提交" class="formbutton" onclick="return checkform();">
        <input type="reset" value="重置" class="formbutton"></td>
    </tr>
EOT;
} elseif ($do == 'move') {print <<<EOT
    <tr class="tdbheader">
      <td colspan="1"><a name="移动文章"></a>移动文章</td>
    </tr>
    <tr>
      <td class="alertbox">
	  <p><ol>
        <br>
EOT;
foreach($articledb as $key => $article){print <<<EOT
        <li><a href="post.php?action=mod&aid=$article[aid]">$article[title]</a><input type="hidden" name="aids[]" value="$article[aid]"></li>
EOT;
}print <<<EOT
      </ol></p>
	  <p>将以上文章移动到
        <select name="cid">
            <option value="" selected>选择分类</option>
EOT;
foreach($cateArr as $key => $cate){print <<<EOT
            <option value="{$cate['cid']}">{$cate['name']}</option>
EOT;
}print <<<EOT
          </select>
      </p>
      <p><input type="submit" name="submit" id="submit" value="确认" class="formbutton"></p>
      <input type="hidden" name="action" value="domore">
	  <input type="hidden" name="do" value="domove">
	  </td>
    </tr>
EOT;
} elseif ($do == 'delete') {print <<<EOT
    <tr class="alertheader">
      <td colspan="1"><a name="删除文章"></a>删除文章</td>
    </tr>
    <tr>
      <td class="alertbox">
	  <p><ol>
EOT;
foreach($articledb as $key => $article){print <<<EOT
        <li><a href="post.php?action=mod&aid=$article[aid]">$article[title]</a><input type="hidden" name="aids[]" value="$article[aid]"></li>
EOT;
}print <<<EOT
      </ol></p>
	  <p><b>注意: 删除以上文章将会连同相关评论、附件一起删除，确定吗？</b></p>
      <p><input type="submit" name="submit" id="submit" value="确认" class="formbutton"></p>
      <input type="hidden" name="action" value="domore">
	  	  <input type="hidden" name="do" value="dodelete">
		  <input type="hidden" name="view" value="$view">
	  </td>
    </tr>
EOT;
} elseif ($action == 'search') {print <<<EOT
    <tr class="tdbheader">
	  <td colspan="2">搜索文章</td>
    </tr>
    <tr class="tablecell">
      <td valign="top"><b>搜索分类:</b></td>
      <td><select name="cateid">
          <option value="">== 全部分类 ==</option>
EOT;
$i=0;
foreach($cateArr as $key => $cate){
$i++;
$selected = ($cate['cid'] == $article['cid']) ? 'selected' : '';
print <<<EOT
          <option value="$cate[cid]" $selected>$i. $cate[name]</option>
EOT;
}print <<<EOT
        </select></td>
    </tr>
    <tr class="tablecell">
	  <td><b>标题、作者、描述、内容内的关键字:</b></td>
	  <td><input class="formfield" type="text" name="keywords" size="35" maxlength="50" value=""></td>
    </tr>
    <tr class="tablecell">
	  <td><b>添加时间早于:</b><br />
	  yyyy-mm-dd</td>
	  <td><input class="formfield" type="text" name="startdate" size="35" maxlength="50" value=""></td>
    </tr>
    <tr class="tablecell">
	  <td><b>添加时间晚于:</b><br />
	  yyyy-mm-dd</td>
	  <td><input class="formfield" type="text" name="enddate" size="35" maxlength="255" value=""></td>
    </tr>
    <input type="hidden" name="action" value="list">
    <input type="hidden" name="do" value="search">
    <tr class="tablecell">
      <td colspan="2" align="center" class="tablecell"><input type="submit" name="submit" id="submit" value="提交" class="formbutton">
        <input type="reset" value="重置" class="formbutton"></td>
    </tr>
EOT;
}print <<<EOT
    <tr>
      <td class="tablebottom" colspan="8"></td>
    </tr>
      </table></td>
    </tr>
  </table>
EOT;
print <<<EOT
</form></td>
    </tr>
  </table>
</div>
EOT;
?>
<?php
include SYS_DATA."/themes/$theme/footer.php";
?>
