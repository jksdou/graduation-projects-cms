<?php
$tempView=$coreView;
$contentType='Content-Type: text/css; charset=utf-8';
$csstime=strtotime(date("y-m-d"));
doAction('admin_addcss');
cacheControl($csstime);
