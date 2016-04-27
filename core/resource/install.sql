DROP TABLE IF EXISTS u_article;
CREATE TABLE `u_article` (
  `aid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章ID',
  `hostid` smallint(8) NOT NULL COMMENT '站点ID',
  `cateid` smallint(8) unsigned NOT NULL COMMENT '分类ID',
  `userid` smallint(8) unsigned NOT NULL COMMENT '用户ID',
  `title` varchar(100) NOT NULL COMMENT '标题',
  `keywords` varchar(120) NOT NULL DEFAULT '' COMMENT '关键词',
  `tag` varchar(100) NOT NULL COMMENT 'tag',
  `url` varchar(255) NOT NULL COMMENT '友好网址',
  `thumb` varchar(255) NOT NULL DEFAULT '' COMMENT '缩略图地址',
  `source` varchar(255) NOT NULL DEFAULT '' COMMENT '来源',
  `excerpt` varchar(255) NOT NULL DEFAULT '' COMMENT '摘要',
  `search` varchar(1500) NOT NULL COMMENT '相关搜索词',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `modified` int(10) NOT NULL COMMENT '修改时间',
  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '访问量',
  `comments` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '评论数量',
  `attachments` smallint(5) unsigned NOT NULL DEFAULT '0' COMMENT '附件数量',
  `closed` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁止评论',
  `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `stick` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否置顶',
  `score` smallint(5) NOT NULL DEFAULT '0' COMMENT '查看需要积分',
  `password` varchar(20) NOT NULL COMMENT '访问密码',
  `ban` tinyint(1) NOT NULL DEFAULT '0' COMMENT '禁止访问，预留给bbs用的',
  PRIMARY KEY (`aid`),
  KEY `article` (`hostid`,`cateid`,`userid`,`url`,`dateline`,`visible`,`views`,`modified`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS u_attachment;
CREATE TABLE `u_attachment` (
  `aid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '附件ID',
  `hostid` smallint(8) NOT NULL COMMENT '站点ID',
  `articleid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文章ID',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '上传时间',
  `filename` varchar(100) NOT NULL DEFAULT '' COMMENT '文件名',
  `filetype` varchar(50) NOT NULL DEFAULT '' COMMENT '文件类型',
  `filesize` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '文件大小',
  `downloads` mediumint(8) NOT NULL DEFAULT '0' COMMENT '下载量',
  `filepath` varchar(255) NOT NULL DEFAULT '' COMMENT '文件地址',
  `isimage` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '是否为图片',
  `score` smallint(5) NOT NULL DEFAULT '0' COMMENT '查看需要积分',
  `modified` int(10) NOT NULL COMMENT '最后修改时间',
  `tag` smallint(5) NOT NULL DEFAULT '0' COMMENT '标签',
  PRIMARY KEY (`aid`),
  KEY `attachment` (`hostid`,`articleid`,`isimage`,`dateline`,`modified`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS u_category;
CREATE TABLE `u_category` (
  `cid` smallint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '栏目ID',
  `hostid` smallint(8) NOT NULL DEFAULT '0' COMMENT '站点ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '栏目名称',
  `url` char(60) NOT NULL DEFAULT '' COMMENT '栏目友好网址',
  `pid` smallint(8) NOT NULL DEFAULT '0' COMMENT '父级栏目ID',
  `style` varchar(20) NOT NULL DEFAULT '' COMMENT '栏目模板风格',
  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '栏目关键字',
  `description` varchar(300) NOT NULL DEFAULT '' COMMENT '栏目描述',
  `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `displayorder` smallint(5) NOT NULL DEFAULT '0' COMMENT '显示次序',
  PRIMARY KEY (`cid`),
  KEY `category` (`hostid`,`url`,`visible`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS u_comment;
CREATE TABLE `u_comment` (
  `cid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '评论ID',
  `hostid` smallint(8) NOT NULL COMMENT '站点ID',
  `articleid` mediumint(8) unsigned NOT NULL DEFAULT '0' COMMENT '文章ID',
  `userid` smallint(8) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '发布时间',
  `content` mediumtext NOT NULL COMMENT '评论内容',
  `url` char(60) NOT NULL COMMENT '用户链接',
  `email` char(60) NOT NULL COMMENT '用户邮箱',
  `ipaddress` varchar(16) NOT NULL DEFAULT '' COMMENT '用户IP地址',
  `score` smallint(5) NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `ban` tinyint(1) NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `comment` (`hostid`,`articleid`,`dateline`,`ipaddress`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS u_content;
CREATE TABLE `u_content` (
  `cid` mediumint(8) NOT NULL AUTO_INCREMENT COMMENT '内容ID',
  `articleid` mediumint(8) DEFAULT NULL COMMENT '对应文章ID',
  `pageid` mediumint(8) DEFAULT NULL COMMENT '对应页面ID',
  `content` mediumtext COMMENT '内容',
  UNIQUE KEY `cid` (`cid`),
  UNIQUE KEY `articleid` (`articleid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS u_filemap;
CREATE TABLE `u_filemap` (
  `hostid` smallint(8) NOT NULL COMMENT '站点ID',
  `original` varchar(15) NOT NULL,
  `filename` varchar(15) NOT NULL,
  `maps` varchar(1000) NOT NULL,
  KEY `hostid` (`hostid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO u_filemap VALUES ('1','index.php','index','');
INSERT INTO u_filemap VALUES ('1','admin.php','admin','');
INSERT INTO u_filemap VALUES ('1','article.php','article','');
INSERT INTO u_filemap VALUES ('1','archive.php','archive','');
INSERT INTO u_filemap VALUES ('1','attachment.php','attachment','');
INSERT INTO u_filemap VALUES ('1','category.php','category','');
INSERT INTO u_filemap VALUES ('1','captcha.php','captcha','');
INSERT INTO u_filemap VALUES ('1','comment.php','comment','');
INSERT INTO u_filemap VALUES ('1','page.php','page','');
INSERT INTO u_filemap VALUES ('1','profile.php','profile','');
INSERT INTO u_filemap VALUES ('1','rss.php','rss','');
INSERT INTO u_filemap VALUES ('1','search.php','search','');
INSERT INTO u_filemap VALUES ('1','tag.php','tag','');
INSERT INTO u_filemap VALUES ('1','js.php','js','');
INSERT INTO u_filemap VALUES ('1','link.php','link','');

DROP TABLE IF EXISTS u_host;
CREATE TABLE `u_host` (
  `hid` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '站点ID',
  `name` varchar(50) NOT NULL COMMENT '站点名称',
  `host` varchar(50) NOT NULL COMMENT '站点域名',
  `host2` varchar(100) NOT NULL COMMENT '副域名',
  `gzipcompress` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Gzip压缩',
  `theme` varchar(15) NOT NULL DEFAULT 'default' COMMENT '主题',
  `password` varchar(10) NOT NULL DEFAULT '' COMMENT '访问密码',
  `keywords` varchar(80) NOT NULL DEFAULT 'uiisc,crogram' COMMENT '关键词',
  `description` varchar(255) NOT NULL DEFAULT 'uiisc,crogram' COMMENT '描述',
  `icp` varchar(30) NOT NULL DEFAULT '0000000000' COMMENT '工信部ICP备案号',
  `close` tinyint(1) NOT NULL DEFAULT '0' COMMENT '关闭站点',
  `close_note` varchar(500) NOT NULL DEFAULT '服务器检修中,稍后开放' COMMENT '关闭站点说明',
  `list_shownum` tinyint(3) NOT NULL DEFAULT '10' COMMENT '列表显示数量',
  `article_order` varchar(10) NOT NULL DEFAULT 'articleid',
  `friend_url` varchar(10) NOT NULL DEFAULT 'aid' COMMENT '友好URL',
  `title_limit` tinyint(3) NOT NULL DEFAULT '0',
  `tags_shownum` smallint(4) NOT NULL DEFAULT '10',
  `listcachenum` tinyint(3) NOT NULL DEFAULT '20',
  `related_shownum` tinyint(3) NOT NULL DEFAULT '10',
  `related_title_limit` tinyint(3) NOT NULL DEFAULT '0',
  `related_order` varchar(10) NOT NULL DEFAULT 'dateline',
  `guest_comment` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否允许访客评论',
  `audit_comment` tinyint(1) NOT NULL DEFAULT '1' COMMENT '审核评论',
  `comment_order` tinyint(1) NOT NULL DEFAULT '0' COMMENT '评论排序方式',
  `article_comment_num` tinyint(3) NOT NULL DEFAULT '10' COMMENT '文章显示评论数',
  `comment_min_len` tinyint(3) NOT NULL DEFAULT '10' COMMENT '评论最小字长',
  `comment_max_len` smallint(5) NOT NULL DEFAULT '3000' COMMENT '评论最大字长',
  `commentlist_num` tinyint(3) NOT NULL DEFAULT '20',
  `comment_post_space` smallint(5) NOT NULL DEFAULT '10',
  `allow_search_content` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否允许搜索',
  `search_post_space` smallint(5) NOT NULL DEFAULT '10' COMMENT '搜索时间间隔',
  `search_keywords_min_len` tinyint(2) NOT NULL DEFAULT '2' COMMENT '关键词最小字长',
  `search_field_allow` varchar(100) NOT NULL DEFAULT 'tag,keywords,title,excerpt' COMMENT '允许搜索范围',
  `search_max_num` mediumint(8) NOT NULL DEFAULT '0',
  `attach_save_dir` tinyint(1) NOT NULL DEFAULT '2',
  `attach_thumbs` tinyint(3) NOT NULL DEFAULT '0',
  `attach_display` tinyint(1) NOT NULL DEFAULT '2',
  `attach_thumbs_size` varchar(10) NOT NULL DEFAULT '200x200',
  `attachments_remote_open` tinyint(1) NOT NULL DEFAULT '1',
  `watermark` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用图片水印',
  `watermark_size` varchar(15) NOT NULL DEFAULT '150' COMMENT '水印尺寸',
  `watermark_pos` tinyint(1) NOT NULL DEFAULT '1',
  `watermark_trans` tinyint(3) NOT NULL DEFAULT '10',
  `watermark_padding` tinyint(3) NOT NULL DEFAULT '5',
  `server_timezone` varchar(3) NOT NULL DEFAULT '8' COMMENT '时区',
  `time_article_format` varchar(50) NOT NULL DEFAULT 'Y-m-d',
  `time_comment_format` varchar(50) NOT NULL DEFAULT 'Y-m-d',
  `closereg` tinyint(1) NOT NULL DEFAULT '1' COMMENT '禁止用户注册',
  `robots` varchar(255) NOT NULL DEFAULT 'all' COMMENT 'Robots设置',
  `censoruser` varchar(2000) NOT NULL DEFAULT 'root,admin,test,administrator,user,password,uiisc,uiiscms' COMMENT '保留字段',
  `banip_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '允许IP',
  `ban_ip` text NOT NULL DEFAULT '' COMMENT '禁止IP',
  `spam_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用垃圾信息检测',
  `spam_words` text NOT NULL COMMENT 'Spam词语' COMMENT '垃圾词语特征',
  `spam_url_num` tinyint(3) NOT NULL DEFAULT '0' COMMENT '评论中允许出现的链接次数',
  `js_enable` tinyint(3) NOT NULL DEFAULT '0' COMMENT '是否启用js调用',
  `js_cache_life` smallint(5) NOT NULL DEFAULT '3600' COMMENT 'JS数据缓存时间',
  `js_lock_url` varchar(1000) NOT NULL DEFAULT '' COMMENT 'JS来路限制',
  `rss_enable` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否启用RSS',
  `rss_num` tinyint(3) NOT NULL DEFAULT '20' COMMENT 'RSS更新数量',
  `rss_ttl` smallint(5) NOT NULL DEFAULT '3600' COMMENT 'RSS更新频率',
  `wap_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用WAP',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `url_html` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否伪静态',
  `url_ext` varchar(6) NOT NULL DEFAULT 'php' COMMENT 'URL后缀',
  `seccode_enable` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用图片验证码',
  PRIMARY KEY (`hid`),
  KEY `host` (`host`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `u_host` (`hid`, `name`, `host`, `host2`, `keywords`, `description` ) VALUES ('1','UIISC','uiisc.com','www.uiisc.com','CROGRAM,UIISC,小雅辰辰','其实,程序员并不是木讷,而是单纯;并不是无情,而是痴情.真正深厚的情感,是只可意会不可言传的.如果说感情是水,那么程序员的感情,就如一潭深水,平静而深沉.');

DROP TABLE IF EXISTS u_link;
CREATE TABLE `u_link` (
  `lid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `hostid` smallint(8) NOT NULL COMMENT '站点id',
  `cateid` smallint(8) NOT NULL COMMENT '连接分类(在后续功能中添加导航页面使用)',
  `displayorder` smallint(5) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '链接名称',
  `url` varchar(200) NOT NULL DEFAULT '' COMMENT '链接地址',
  `note` varchar(200) NOT NULL DEFAULT '' COMMENT '站点描述',
  `bak` varchar(200) NOT NULL DEFAULT '' COMMENT '站点备注信息',
  `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否显示',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '链接类型，1首页链接0导航页面链接',
  PRIMARY KEY (`lid`),
  KEY `link` (`hostid`,`displayorder`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `u_link` (`lid`, `hostid`, `displayorder`, `name`, `url`, `note`, `visible`) VALUES (NULL, '1', '0', 'UIISC', 'http://uiisc.com', 'UIISC', '1');
INSERT INTO `u_link` (`lid`, `hostid`, `displayorder`, `name`, `url`, `note`, `visible`) VALUES (NULL, '1', '0', 'CROGRAM', 'http://www.crogram.org', 'Technical Support', '1');

DROP TABLE IF EXISTS u_login;
CREATE TABLE `u_login` (
  `lid` int(10) NOT NULL AUTO_INCREMENT,
  `hostid` smallint(8) NOT NULL COMMENT '站点ID',
  `user` varchar(12) NOT NULL DEFAULT 'Unknown' COMMENT '登录用户名',
  `dateline` int(10) NOT NULL COMMENT '登录时间',
  `useragent` varchar(200) NOT NULL COMMENT '登录浏览器类型',
  `ip` varchar(16) NOT NULL COMMENT '登录IP',
  `content` text NOT NULL COMMENT '登录结果',
  PRIMARY KEY (`lid`),
  KEY `login` (`hostid`,`user`,`ip`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS u_page;
CREATE TABLE `u_page` (
  `pid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `hostid` tinyint(3) NOT NULL,
  `userid` smallint(5) unsigned NOT NULL,
  `username` varchar(50) NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '',
  `tag` varchar(120) NOT NULL DEFAULT '' COMMENT '标签',
  `keywords` varchar(120) NOT NULL DEFAULT '',
  `url` char(60) NOT NULL,
  `excerpt` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
  `modified` int(10) NOT NULL,
  `views` int(10) unsigned NOT NULL DEFAULT '0',
  `visible` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`pid`),
  KEY `hostid` (`hostid`),
  KEY `userid` (`userid`),
  KEY `url` (`url`),
  KEY `dateline` (`dateline`),
  KEY `visible` (`visible`),
  KEY `modified` (`modified`),
  KEY `views` (`views`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS u_plugin;
CREATE TABLE `u_plugin` (
  `pid` smallint(5) NOT NULL AUTO_INCREMENT COMMENT '插件ID',
  `hostid` smallint(8) NOT NULL COMMENT '站点ID',
  `file` varchar(50) DEFAULT NULL COMMENT '文件',
  `name` varchar(50) NOT NULL COMMENT '插件名称',
  `author` varchar(50) NOT NULL COMMENT '插件作者',
  `version` varchar(50) NOT NULL COMMENT '插件版本',
  `description` varchar(255) NOT NULL COMMENT '插件描述说明',
  `url` varchar(50) DEFAULT NULL COMMENT '插件主页',
  `active` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否激活插件',
  `config` text NOT NULL COMMENT '插件配置',
  PRIMARY KEY (`pid`),
  KEY `plugin` (`hostid`,`file`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS u_redirect;
CREATE TABLE `u_redirect` (
  `rid` mediumint(5) NOT NULL AUTO_INCREMENT,
  `hostid` smallint(8) DEFAULT NULL COMMENT '站点ID',
  `old` varchar(255) DEFAULT NULL,
  `new` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`rid`),
  KEY `hostid` (`hostid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS u_search;
CREATE TABLE `u_search` (
  `sid` int(10) NOT NULL AUTO_INCREMENT COMMENT '搜索ID',
  `hostid` smallint(8) DEFAULT '0' COMMENT '站点ID',
  `user` varchar(12) NOT NULL DEFAULT 'Unknown' COMMENT '用户名，如果存在',
  `keywords` varchar(50) DEFAULT '' COMMENT '搜索词语',
  `ip` varchar(15) DEFAULT '' COMMENT '来源IP',
  `useragent` varchar(200) NOT NULL COMMENT '客户端',
  `dateline` int(10) DEFAULT '0' COMMENT '搜索时间',
  PRIMARY KEY (`sid`),
  KEY `search` (`hostid`,`ip`,`dateline`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS u_tag;
CREATE TABLE `u_tag` (
  `tid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '标签ID',
  `tag` varchar(20) NOT NULL DEFAULT '' COMMENT '标签名',
  `hostid` smallint(8) NOT NULL COMMENT '站点ID',
  `articleid` mediumint(8) NOT NULL COMMENT '对应文章ID',
  `pageid` mediumint(8) NOT NULL COMMENT '对应文章ID，此功能暂不能用',
  PRIMARY KEY (`tid`),
  KEY `tag` (`hostid`,`articleid`,`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS u_user;
CREATE TABLE `u_user` (
  `uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户ID',
  `hostid` smallint(8) NOT NULL COMMENT '站点ID',
  `username` varchar(20) NOT NULL DEFAULT '' COMMENT '用户名',
  `usernickname` varchar(100) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `password` varchar(32) NOT NULL DEFAULT '' COMMENT '密码',
  `groupid` smallint(5) NOT NULL COMMENT '用户组',
  `email` varchar(100) NOT NULL DEFAULT '' COMMENT '邮箱',
  `qq` bigint(13) NOT NULL DEFAULT '0' COMMENT '腾讯QQ',
  `msn` varchar(50) NOT NULL DEFAULT '' COMMENT '微软MSN',
  `face` varchar(100) NOT NULL DEFAULT '' COMMENT '用户头像，暂不能用',
  `usersiteurl` varchar(255) NOT NULL COMMENT '用户站点',
  `usersitename` varchar(100) NOT NULL COMMENT '用户站点名',
  `articles` mediumint(8) NOT NULL DEFAULT '0' COMMENT '用户文章',
  `regdateline` int(10) NOT NULL COMMENT '注册时间',
  `regip` varchar(16) NOT NULL COMMENT '注册IP',
  `logincount` mediumint(9) NOT NULL COMMENT '登录次数',
  `loginip` varchar(15) NOT NULL COMMENT '登录IP',
  `logintime` int(11) NOT NULL COMMENT '登录时间',
  `useragent` varchar(200) NOT NULL COMMENT '客户端',
  `lastpost` int(10) NOT NULL COMMENT '最后发表',
  `sessionid` varchar(30) DEFAULT NULL COMMENT '会话ID',
  `disabled` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '禁止',
  PRIMARY KEY (`uid`),
  KEY `hostid` (`hostid`,`username`,`sessionid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS u_var;
CREATE TABLE `u_var` (
  `vid` smallint(5) NOT NULL AUTO_INCREMENT,
  `hostid` smallint(8) NOT NULL COMMENT '站点ID',
  `title` varchar(200) NOT NULL COMMENT '变量名',
  `value` text NOT NULL COMMENT '变量值',
  `visible` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否有效',
  PRIMARY KEY (`vid`),
  KEY `var` (`hostid`,`visible`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO u_var VALUES('1','1','demoar','这是一个测试变量','1');

