<?php
print <<<EOT
function checkform()
{
	if ($("#title").val()=='') { alert("请输入标题"); return false; }
	if ($("#cid").val()==0) { alert("请选择分类"); return false; }
	if ($("#content").val()==0) { alert("内容不得为空"); return false; }
	return true;
}
function checkall(form)
{
	for (var i=0;i<form.elements.length;i++)
	{
		var e = form.elements[i];
		if (e.name != 'chkall')
		e.checked = form.chkall.checked;
	}
}
$(document).ready(
 function()
 {
  $('#cid').change(
   function()
   {
    var upurl="{$uploadfile}&cid="+$(this).children('option:selected').val(); 
    editor.settings.upImgUrl=upurl;
    editor.settings.upFlashUrl=upurl;
    editor.settings.upMediaUrl=upurl;
   }
  );
 }
)
var editor;
$(pageInit);
function pageInit()
{
	var allPlugin={
	Code:{c:'btnCode',t:'插入代码',h:1,e:function()
	{
		var _this=this;
		var htmlCode='<div><select id="xheCodeType"><option value="html">HTML/XML</option><option value="js">Javascript</option><option value="css">CSS</option><option value="php">PHP</option><option value="java">Java</option><option value="py">Python</option><option value="pl">Perl</option><option value="rb">Ruby</option><option value="cs">C#</option><option value="c">C++/C</option><option value="vb">VB/ASP</option><option value="">其它</option></select></div><div><textarea id="xheCodeValue" wrap="soft" spellcheck="false" style="width:300px;height:100px;" /></div><div style="text-align:right;"><input type="button" id="xheSave" value="确定" /></div>';
		var jCode=$(htmlCode),jType=$('#xheCodeType',jCode),jValue=$('#xheCodeValue',jCode),jSave=$('#xheSave',jCode);
		jSave.click(function()
		{
			_this.loadBookmark();
			_this.pasteHTML('<pre class="prettyprint lang-'+jType.val()+'">'+_this.domEncode(jValue.val())+'</pre>');
			_this.hidePanel();
			return false;
		});
		_this.saveBookmark();
		_this.showDialog(jCode);
	}}
	};
	editor=$('#content').xheditor({plugins:allPlugin,tools:'Cut,Copy,Paste,Pastetext,Blocktag,Fontface,FontSize,Bold,Italic,Underline,Strikethrough,FontColor,BackColor,SelectAll,Removeformat,Align,List,Outdent,Indent,Link,Unlink,Anchor,Img,Flash,Media,Hr,Table,Code,|,Source,Preview,Print,Fullscreen,About',upLinkExt:"zip,rar,txt",upImgUrl:"{$uploadfile}",upImgExt:"jpg,jpeg,gif,png",upFlashUrl:"{$uploadfile}",upFlashExt:"swf",upMediaUrl:"{$uploadfile}",upMediaExt:"avi,rmvb,mkv,mp4,wmv,wma,mid"});
}
EOT;
