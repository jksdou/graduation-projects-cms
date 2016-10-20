<?php
define('SYS_ROOT',dirname(__file__)); // 本文件所在目录
define('SYS_CORE',SYS_ROOT.'/core');  // 系统核心目录
define('SYS_DATA',SYS_ROOT.'/data');  // 系统数据目录
include SYS_CORE.'/initrd.php';       // 系统初始化
