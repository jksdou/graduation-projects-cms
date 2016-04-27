<?php
print <<<EOT

 <div class="mainbody">
  <div class="l">
   <div class="lmenu">系统设置</div>
   <div class="litem">
    <ul>
EOT;
foreach ($settingsmenu as $key => $value)
{
print <<<EOT

     <li><a href="admin.php?file=configurate&type=$key">$value</a></li>
EOT;
}
print <<<EOT

    </ul>
   </div>
  </div>
  <div class="r">
   <form action="admin.php?file=configurate" method="post">
EOT;
if (!$type || $type == 'all' || $type=='basic')
{
print <<<EOT

    <div class="rmenu" >基本设置</div>
    <dl class="ritem">
     <dd class="lhalf"><b>网站名称</b></dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[name]" size="35" maxlength="50" value="{$settings['name']}"></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>网站访问密码</b><br />如果设置了密码,普通用户则需要要输入正确密码后才可以浏览网站</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[password]" size="35" maxlength="50" value="{$settings['password']}"></dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>关闭网站</b><br />关闭网站后任何人将不能访问网站前台，后台不受影响</dd>
    <dd class="toleft">
     <select name="setting[close]">
      <option value="1" $close_Y>是</option>
      <option value="0" $close_N>否</option>
     </select>
    </dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>关闭的原因</b><br />关闭网站的原因</dd>
    <dd class="toleft"><textarea id="close_note" class="formarea" type="text" name="setting[close_note]" style="width:300px;height:80px;">{$settings['close_note']}</textarea><b><a href="javascript:void(0);" onclick="resizeup('close_note');">[+]</a> <a href="javascript:void(0);" onclick="resizedown('close_note');">[-]</a></b></dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>页面Gzip压缩</b><br />将页面内容以 gzip 压缩后传输,可以加快传输速度，需 PHP 4.0.4 以上且支持 Zlib 模块才能使用</dd>
    <dd class="toleft">
     <select name="setting[gzipcompress]">
      <option value="1" $gzipcompress_Y>是</option>
      <option value="0" $gzipcompress_N>否</option>
     </select>
    </dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>网站关键字</b><br />网站关键词是网站所涵盖的所有信息的简要关键词，关键词可以有许多个，用户可以通过搜索引擎搜索关键词汇来搜到本网站。</dd>
    <dd class="toleft"><textarea class="formfield" type="text" name="setting[keywords]" maxlength="255" style="width:300px;height:80px;">{$settings['keywords']}</textarea></dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>网站描述</b><br />网站描述就是网站所要展示的信息的综合概述。用户可以通过描述信息来了解网站的大致功能。</dd>
    <dd class="toleft"><textarea class="formfield" type="text" name="setting[description]" maxlength="255" style="width:300px;height:80px;">{$settings['description']}</textarea></dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>信息产业部网站备案号</b></dd>
    <dd class="toleft"><input class="formfield" type="text" name="setting[icp]" size="35" maxlength="50" value="{$settings['icp']}"></dd>
   </dl>
EOT;
}
if ($type == 'all' || $type=='display')
{
print <<<EOT

    <div class="rmenu" >显示设置</div>
   <dl class="ritem">
    <dd class="lhalf"><b>列表每页显示文章的数量</b><br />默认10.</dd>
    <dd class="toleft"><input class="formfield" type="text" name="setting[list_shownum]" size="15" maxlength="50" value="{$settings['list_shownum']}"></dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>文章排列依据</b><br />文章时间可以更改,如果修改时间则可能更改文章排列，时间是根据 dateline 字段降序排列。<br />文章提交顺序不可以更改，即使修改过文章的时间也不会影响文章的排列，提交顺序是根据 articleid 主键降序排列。</dd>
    <dd class="toleft">
     <select name="setting[article_order]">
      <option value="articleid" $article_order[articleid]>按文章提交顺序</option>
      <option value="dateline" $article_order[dateline]>按文章修改时间</option>
     </select>
    </dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>文章列表标题截取字节数</b><br />因为模板的不同，如果设置过多，可能会把表格撑变形。根据界面美观设置.如果设置为0表示不截取.</dd>
    <dd class="toleft"><input class="formfield" type="text" name="setting[title_limit]" size="15" maxlength="50" value="$settings[title_limit]"></dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>标签列表每页的数量</b></dd>
    <dd class="toleft"><input class="formfield" type="text" name="setting[tags_shownum]" size="15" maxlength="50" value="$settings[tags_shownum]"></dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>栏目缓存中的最新文章数</b><br />程序会生成每个栏目及最新文章的缓存文件,方便首页或是其它栏目调用.</dd>
    <dd class="toleft"><input class="formfield" type="text" name="setting[listcachenum]" size="15" maxlength="50" value="$settings[listcachenum]"></dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>相关文章显示数量</b><br />浏览文章的时候,可以显示使用相同标签的文章，选择不显示在浏览文章的时候减少一次查询以提高程序执行效率.建议不要设置太大,建议设置10,设置为0表示不显示相关文章.</dd>
    <dd class="toleft"><input class="formfield" type="text" name="setting[related_shownum]" size="15" maxlength="50" value="$settings[related_shownum]"></dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>相关文章标题截取字数</b><br />因为模板的不同,如果设置过多,可能会把表格撑变形.根据界面美观设置.如果设置为0表示不截取.</dd>
    <dd class="toleft"><input class="formfield" type="text" name="setting[related_title_limit]" size="15" maxlength="50" value="$settings[related_title_limit]"></dd>
   </dl>
   <dl class="ritem">
    <dd class="lhalf"><b>相关文章排列依据</b></dd>
    <dd class="toleft">
     <select name="setting[related_order]">
      <option value="dateline" $related_order[dateline]>按文章添加时间</option>
      <option value="views" $related_order[views]>按文章阅读次数</option>
      <option value="comments" $related_order[comments]>按文章评论数量</option>
     </select>
    </dd>
   </dl>
EOT;
}
if ($type == 'all' || $type=='comment')
{
print <<<EOT

    <div class="rmenu" >评论设置</div>
    <dl class="ritem">
     <dd class="lhalf"><b>允许游客评论</b></dd>
     <dd class="toleft">
      <select name="setting[guest_comment]">
       <option value="1" $guest_comment_Y>是</option>
       <option value="0" $guest_comment_N>否</option>
      </select>
     </dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>评论需要审核</b><br />访客发表的评论需要管理员在后台审核过才会在前台显示</dd>
     <dd class="toleft">
      <select name="setting[audit_comment]">
       <option value="1" $audit_comment_Y>是</option>
       <option value="0" $audit_comment_N>否</option>
      </select>
     </dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>新评论排列顺序</b></dd>
     <dd class="toleft">
      <select name="setting[comment_order]">
       <option value="1" $comment_order_Y>靠后</option>
       <option value="0" $comment_order_N>靠前</option>
      </select>
     </dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>单篇文章显示评论数</b><br />如果评论特别多的话，可以设置一页显示多少条评论，设为“0”则显示全部评论</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[article_comment_num]" size="15" maxlength="50" value="$settings[article_comment_num]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>评论内容的最少字节数</b><br />两个字节是一个汉字</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[comment_min_len]" size="15" maxlength="50" value="$settings[comment_min_len]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>评论内容允许最大字数</b><br />可以有效控制游客输入内容的数据量</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[comment_max_len]" size="15" maxlength="50" value="$settings[comment_max_len]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>评论列表显示数量</b><br />评论列表每页显示的评论条数</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[commentlist_num]" size="15" maxlength="50" value="$settings[commentlist_num]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>提交评论时间间隔</b><br />可以防止他人灌水，设为“0”则不限制</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[comment_post_space]" size="15" maxlength="50" value="$settings[comment_post_space]"></dd>
    </dl>
EOT;
}
if ($type == 'all' || $type=='search')
{
print <<<EOT

    <div class="rmenu" >搜索设置</div>
    <dl class="ritem">
     <dd class="lhalf"><b>是否允许搜索内容</b><br />少量数据时可以搜索内容,一般只搜索标题即可</dd>
     <dd class="toleft"><select name="setting[allow_search_content]"><option value="1" $allow_search_content_Y>是</option><option value="0" $allow_search_content_N>否</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>搜索间隔</b><br />使用搜索功能的时间间隔，设为“0”则不限制</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[search_post_space]" size="15" maxlength="50" value="$settings[search_post_space]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>搜索关键字的最少字节数</b><br />至少输入多少个字节才可以进行搜索，设为“0”则不限制</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[search_keywords_min_len]" size="15" maxlength="50" value="$settings[search_keywords_min_len]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>指定搜索字段</b><br />默认是tag,keywords,title,excerpt</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[search_field_allow]" size="35" maxlength="100" value="$settings[search_field_allow]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>搜索结果最多显示数量</b><br />默认是0，即全部显示</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[search_max_num]" size="15" maxlength="50" value="$settings[search_max_num]"></dd>
    </dl>
EOT;
}
if ($type == 'all' || $type=='attach')
{
print <<<EOT

    <div class="rmenu" >附件设置</div>
    <dl class="ritem">
     <dd class="lhalf"><b>附件存储目录类型</b><br />选择存储附件的目录类型</dd>
     <dd class="toleft"><select name="setting[attach_save_dir]"><option value="0" $attach_save_dir[0]>全部存储同一目录</option><option value="1" $attach_save_dir[1]>按分类存储</option><option value="2" $attach_save_dir[2]>按月份存储</option><option value="3" $attach_save_dir[3]>按文件类型存储</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>附件的下载处理方式</b><br />可以设计附件页attachment.php模板，作为下载页面前台</dd>
     <dd class="toleft"><select name="setting[attach_display]"><option value="0" $attach_display[0]>直接下载文件</option><option value="1" $attach_display[1]>显示下载页面后再下载</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>是否禁止从其它网站查看附件</b><br />若选择直接下载文件，则该选项有效。若选是，则禁止从其它网站直接链接此文件</dd>
     <dd class="toleft"><select name="setting[attachments_remote_open]"><option value="1" $attachments_remote_open_Y>是</option><option value="0" $attachments_remote_open_N>否</option></select></dd>
    </dl>
EOT;
}
if ($type == 'all' || $type=='watermark')
{
print <<<EOT

    <div class="rmenu" >水印设置</div>
    <dl class="ritem">
     <dd class="lhalf"><b>是否使用图片水印功能</b><br />上传的图片中加上图片水印,水印图片位于 ./$datadir/watermark/{$host['host']}.png,您可替换此文件以实现不同的水印效果.不支持动画 GIF 格式.</dd>
     <dd class="toleft"><select name="setting[watermark]"><option value="1" $watermark_Y>是</option><option value="0" $watermark_N>否</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>添加水印的图片大小控制</b><br />只对超过程序设置的大小的附件图片才加上水印图片或文字，若留空则不作限制。例如：150x150</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[watermark_size]" size="35" maxlength="50" value="$settings[watermark_size]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>水印位置</b><br />若使用图片水印,请设定图片水印出现的位置.</dd>
     <dd class="toleft"><select name="setting[watermark_pos]"><option value="1" $watermark_pos[1]>左上</option><option value="7" $watermark_pos[7]>左下</option>  <option value="3" $watermark_pos[3]>右上</option>  <option value="9" $watermark_pos[9]>右下</option>  <option value="5" $watermark_pos[5]>中间</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>水印透明度</b><br />范围为 1~100 的整数,数值越大水印图片透明度越低.本功能需要开启水印功能后才有效.</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[watermark_trans]" size="35" maxlength="50" value="$settings[watermark_trans]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>水印边距</b><br />图片或者文字水印位于原图边缘的距离.请填入大于0的整数,不填默认为 5px.</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[watermark_padding]" size="35" maxlength="50" value="$settings[watermark_padding]"></dd>
    </dl>
EOT;
}
if ($type == 'all' || $type=='dateline')
{
print <<<EOT

    <div class="rmenu" >时间设置</div>
    <dl class="ritem">
     <dd class="lhalf"><b>服务器所在时区</b><br />网站所在的服务器是放在地球的哪个时区？</dd>
     <dd class="toleft"><select name="setting[server_timezone]"><option value="-12" $zone_012>(标准时-12:00) 日界线西</option><option value="-11" $zone_011>(标准时-11:00) 中途岛、萨摩亚群岛</option><option value="-10" $zone_010>(标准时-10:00) 夏威夷</option><option value="-9" $zone_09>(标准时-9:00) 阿拉斯加</option><option value="-8" $zone_08>(标准时-8:00) 太平洋时间(美国和加拿大)</option><option value="-7" $zone_07>(标准时-7:00) 山地时间(美国和加拿大)</option><option value="-6" $zone_06>(标准时-6:00) 中部时间(美国和加拿大)、墨西哥城</option><option value="-5" $zone_05>(标准时-5:00) 东部时间(美国和加拿大)、波哥大</option><option value="-4" $zone_04>(标准时-4:00) 大西洋时间(加拿大)、加拉加斯</option><option value="-3.5" $zone_03_5>(标准时-3:30) 纽芬兰</option><option value="-3" $zone_03>(标准时-3:00) 巴西、布宜诺斯艾利斯、乔治敦</option><option value="-2" $zone_02>(标准时-2:00) 中大西洋</option><option value="-1" $zone_01>(标准时-1:00) 亚速尔群岛、佛得角群岛</option><option value="111" $zone_111>(格林尼治标准时) 西欧时间、伦敦、卡萨布兰卡</option><option value="1" $zone_1>(标准时+1:00) 中欧时间、安哥拉、利比亚</option><option value="2" $zone_2>(标准时+2:00) 东欧时间、开罗，雅典</option><option value="3" $zone_3>(标准时+3:00) 巴格达、科威特、莫斯科</option><option value="3.5" $zone_3_5>(标准时+3:30) 德黑兰</option><option value="4" $zone_4>(标准时+4:00) 阿布扎比、马斯喀特、巴库</option><option value="4.5" $zone_4_5>(标准时+4:30) 喀布尔</option><option value="5" $zone_5>(标准时+5:00) 叶卡捷琳堡、伊斯兰堡、卡拉奇</option><option value="5.5" $zone_5_5>(标准时+5:30) 孟买、加尔各答、新德里</option><option value="6" $zone_6>(标准时+6:00) 阿拉木图、 达卡、新亚伯利亚</option><option value="7" $zone_7>(标准时+7:00) 曼谷、河内、雅加达</option><option value="8" $zone_8>(北京时间) 北京、重庆、香港、新加坡</option><option value="9" $zone_9>(标准时+9:00) 东京、汉城、大阪、雅库茨克</option><option value="9.5" $zone_9_5>(标准时+9:30) 阿德莱德、达尔文</option><option value="10" $zone_10>(标准时+10:00) 悉尼、关岛</option><option value="11" $zone_11>(标准时+11:00) 马加丹、索罗门群岛</option><option value="12" $zone_12>(标准时+12:00) 奥克兰、惠灵顿、堪察加半岛</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>文章的日期格式</b><br />Y, F j, g:i A 显示为 2005, May 10, 2:12 PM</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[time_article_format]" size="35" maxlength="50" value="$settings[time_article_format]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>评论的日期格式</b><br />Y, F j, g:i A 显示为 2005, May 10, 2:12 PM</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[time_comment_format]" size="35" maxlength="50" value="$settings[time_comment_format]"></dd>
    </dl>
EOT;
}
if ($type == 'all' || $type=='user')
{
print <<<EOT

    <div class="rmenu" >用户设置</div>
    <dl class="ritem">
     <dd class="lhalf"><b>禁止注册</b><br />选择“是”将禁止访客注册，但不影响过去已注册的用户</dd>
     <dd class="toleft"><select name="setting[closereg]"><option value="1" $closereg_Y>是</option><option value="0" $closereg_N>否</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>注册的用户名保留关键字</b><br />注册的用户名中无法使用这些关键字。每个关键字用半角逗号隔开，如 admin,test,administrator等<br /><u><b>访客同样无法使用这些关键字作为用户名发表评论。</b></u></dd>
    <dd class="toleft"><textarea id="censoruser" class="formarea" type="text" name="setting[censoruser]" style="width:300px;height:80px;">$settings[censoruser]</textarea> <b><a href="javascript:void(0);" onclick="resizeup('censoruser');">[+]</a> <a href="javascript:void(0);" onclick="resizedown('censoruser');">[-]</a></b></dd>
    </dl>
EOT;
}
if ($type == 'all' || $type=='ban')
{
print <<<EOT

    <div class="rmenu" >限制设置</div>
    <dl class="ritem">
     <dd class="lhalf"><b>Robots设置</b><br /></dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[robots]" size="45" maxlength="55" value="$settings[robots]" /></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>开启图片验证码</b></dd>
     <dd class="toleft"><select name="setting[seccode_enable]"><option value="1" $seccode_enable_Y>是</option><option value="0" $seccode_enable_N>否</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>开启IP禁止功能</b><br />选择“是”将杜绝下面设置的IP提交评论.</dd>
     <dd class="toleft"><select name="setting[banip_enable]"><option value="1" $banip_enable_Y>是</option><option value="0" $banip_enable_N>否</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>禁止IP</b><br />输入禁止发表评论的IP地址,可以使用"*"作为通配符禁止某段地址,用","格开.</dd>
     <dd class="toleft"><textarea id="ban_ip" class="formarea" type="text" name="setting[ban_ip]" style="width:300px;height:80px;">$settings[ban_ip]</textarea> <b><a href="javascript:void(0);" onclick="resizeup('ban_ip');">[+]</a> <a href="javascript:void(0);" onclick="resizedown('ban_ip');">[-]</a></b></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>开启Spam机制</b><br />Spam是指利用程序进行广播式的广告宣传的行为.这种行为给很多人的信箱、留言、评论里塞入大量无关或无用的信息.开启后以下设置才生效.</dd>
     <dd class="toleft"><select name="setting[spam_enable]"><option value="1" $spam_enable_Y>是</option><option value="0" $spam_enable_N>否</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>垃圾词语特征</b><br />开启Spam机制后,系统将用这里设置的词语匹配,不管程序还是人工发表,如果包含了则表示有可能是垃圾信息,需要人工审核.用","格开.设置的垃圾词语在开启Spam机制后,应用在评论、Trackback的内容中.</dd>
     <dd class="toleft"><textarea id="spam_words" class="formarea" type="text" name="setting[spam_words]" style="width:300px;height:80px;">$settings[spam_words]</textarea> <b><a href="javascript:void(0);" onclick="resizeup('spam_words');">[+]</a> <a href="javascript:void(0);" onclick="resizedown('spam_words');">[-]</a></b></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>评论中允许出现的链接次数</b><br />如果出现的链接数大于所设置的数量,则怀疑是垃圾信息,需要人工审核.如果设置为"0"则不限制.</dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[spam_url_num]" size="15" maxlength="50" value="$settings[spam_url_num]" /></dd>
    </dl>
EOT;
}
if ($type == 'all' || $type=='js')
{
print <<<EOT

    <div class="rmenu">JS调用设置</div>
    <dl class="ritem">
     <dd class="lhalf"><b>开启JS调用功能</b><br />JS调用可以将您的最新文章、热门文章、最新评论、统计信息等资料嵌入到您的普通网页中.</dd>
     <dd class="toleft"><select name="setting[js_enable]"><option value="1" $js_enable_Y>是</option><option value="0" $js_enable_N>否</option></select></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>JS数据缓存时间</b><br />JS调用采用动态缓存技术来实现数据的定期更新以达到减轻服务器的负担,否则直接调用将消耗较多的系统资源,默认值为3600秒机一个小时,设置为0则不缓存(极耗费系统资源)</dd>
    <dd class="toleft"><input class="formfield" type="text" name="setting[js_cache_life]" size="15" maxlength="50" value="$settings[js_cache_life]"></dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>JS来路限制</b><br />只允许列表中的域名才可以使用JS调用功能,每个域名一行,请勿包含 http:// 或其他非域名内容,留空为不限制来路,即任何网站均可调用.但是多网站调用会加重您的服务器负担.</dd>
     <dd class="toleft"><textarea id="js_lock_url" class="formarea" type="text" name="setting[js_lock_url]" style="width:300px;height:80px;">$settings[js_lock_url]</textarea><b><a href="javascript:void(0);" onclick="resizeup('js_lock_url');">[+]</a> <a href="javascript:void(0);" onclick="resizedown('js_lock_url');">[-]</a></b></dd>
    </dl>
EOT;
}
if ($type == 'all' || $type=='wap')
{
	print <<<EOT

    <div class="rmenu">WAP 设置</div>
    <dl class="ritem">
     <dd class="lhalf"><b>开启WAP站点功能:(暂时不能用，将在后期版本中添加)</b><br />开启后将允许用户以手机页面来浏览站点.</dd>
     <dd class="toleft">
      <select name="setting[wap_enable]">
       <option value="1" $wap_enable_Y>是</option>
       <option value="0" $wap_enable_N>否</option>
      </select>
     </dd>
    </dl>
EOT;
}
if ($type == 'all' || $type=='rss')
{
print <<<EOT

    <div class="rmenu">RSS订阅设置</div>
    <dl class="ritem">
     <dd class="lhalf"><b>开启RSS订阅功能</b><br />开启后将允许用户使用 RSS 客户端软件接收最新的文章.</dd>
     <dd class="toleft">
      <select name="setting[rss_enable]">
       <option value="1" $rss_enable_Y>是</option>
       <option value="0" $rss_enable_N>否</option>
      </select>
     </dd>
    </dl>
    <dl class="ritem">
     <dd class="lhalf"><b>RSS 订阅文章数量</b></dd>
     <dd class="toleft"><input class="formfield" type="text" name="setting[rss_num]" size="15" maxlength="50" value="$settings[rss_num]"></dd>
   </dl>
EOT;
}
print <<<EOT

   <dl class="ritem">
    <dd class="i80"><input type="hidden" name="action" value="updatesetting" /><input type="hidden" name="type" value="$type" /><input type="submit" value="提交" class="formbutton" /></dd>
     <dd class="toleft"><input type="reset" value="重置" class="formbutton" /></dd>
   </dl>
   </form>
  </div>
 </div>
EOT;
