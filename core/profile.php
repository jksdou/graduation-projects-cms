<?php
$url = isset($_GET['url']) ? $_GET['url']  : (isset($_POST['url']) ? $_POST['url'] : '');
if (SYS_POST)
{
	if ($url == 'doregister' || $url == 'domod')
	{
		$doreg = $url == 'doregister' ? true : false;
		$confirmpassword = $_POST['confirmpassword'];
		$email = isset($_POST['email']) ? $_POST['email'] : '';
		$usersiteurl='';
		if ($doreg)
		{
			$username = trim($_POST['username']);
			$usernickname = $_POST['usernickname'];
			$password = $_POST['password'];
			doAction('profile_reg_check');

			checkUserName($username, $register_url);
			checkUserNickName($usernickname, $register_url);

			if ($host['censoruser'])
			{
				$host['censoruser'] = str_replace('，', ',', $host['censoruser']);
				$banname = explode(',',$host['censoruser']);
				foreach($banname as $value)
				{
					if (strpos($username,$value) !== false)
					{
						message('此用户名被管理员屏蔽,请选择其它用户名.', $register_url);
					}
				}
			}

			checkPassWord($password, $confirmpassword, $register_url);

			$r = $DB->fetch_first('SELECT `uid` FROM `'.DB_PREFIX."user` WHERE `username` = '$username'");
			if ($r['uid'])
			{
				message('该用户名已被注册,请返回重新选择其他用户名.', $register_url);
				unset($r);
			}

			if ($email)
			{
				if (CheckEmail($email))
				{
					$r = $DB->fetch_first("SELECT `uid` FROM `".DB_PREFIX."user` WHERE `email` = '$email'");
					if ($r['uid'])
					{
						message('该E-mail已被注册.', $register_url);
					}
					unset($r);
				}
				else message('该E-mail格式不正确.', $register_url);
			}

			$password = md5($password);

			$DB->query('INSERT INTO `'.DB_PREFIX."user` (`username`, `password`, `logincount`, `loginip`, `logintime`, `usersiteurl`, `regdateline`, `regip`, `groupid`, `hostid`, `email`) VALUES ('$username', '$password', '1', '$onlineip', '$timestamp', '$usersiteurl', '$timestamp', '$onlineip', '1',$hostid,'$email')");
			$uid = $DB->insert_id();

			$sql = 'SELECT * FROM `'.DB_PREFIX."user` WHERE `uid` = '$uid'";
			$result = $DB->fetch_first($sql);

			$sessionid = getRandStr(30,false);//生成登陆会话Session信息
			$expire = isset($_POST['rememberme']) ? $timestamp+31536000 : 0;//过期时间设置，记住我为最长时间，否则为浏览器关闭则无效
			setcookie('sessionid',$sessionid,$expire,'',SYS_HOST);
			//更新用户状态
			$DB->query('UPDATE `'.DB_PREFIX."user` SET `logincount` = `logincount` + 1,`loginip` = '$onlineip', `logintime` = '$timestamp', `sessionid`='$sessionid',`useragent`='$useragent' where uid='$uid'");
			//添加登录数据库日志
			$DB->query('INSERT INTO `'.DB_PREFIX."login` (`user`, `dateline`, `useragent`, `ip`, `content`) VALUES ('$username', '$timestamp', '$useragent', '$onlineip', '注册并登录成功')");
			//注册成功并自动登录转向到个人信息
			message('注册成功.', $profile_url);
		}
		else
		{
			//修改资料
			$password_sql = '';
			$oldpassword  = md5($_POST['oldpassword']);
			$newpassword  = $_POST['newpassword'];
			$usernickname = trim($_POST['usernickname']);
			$usersitename = trim($_POST['usersitename']);
			$usersiteurl  = trim($_POST['usersiteurl']);
			$face         = $_POST['face'];
			$email        = $_POST['email'];
			$qq           = $_POST['qq'];
			$msn          = $_POST['msn'];

			if ($email)
			{
				$result_checkmail = checkMail($email);
				if (!$result_checkmail) message('电子邮箱格式不对且长度不能大于100字节', $profile_url);
			}

			if ($newpassword)
			{
				$user = $DB->fetch_first('SELECT `password` FROM `'.DB_PREFIX."user` WHERE `uid` = '$uid'");
				if (!$user) { message('出错,请尝试重新登陆再进行此操作',$loginurl); }
				if ($oldpassword != $user['password']) { message('原密码错误，请重新输入', $profile_url); }
				checkPassWord($newpassword, $confirmpassword, $profile_url);
				if ($password_sql) { $password_sql .= ",password='".md5($newpassword)."'"; }
				else { $password_sql = "password='".md5($newpassword)."'"; }
			}

			if ($password_sql) $DB->unbuffered_query('UPDATE `'.DB_PREFIX."user` SET $password_sql WHERE `uid` = '$uid'");
			if ($newpassword)
			{
				$DB->query('UPDATE `'.DB_PREFIX."user` SET `sessionid`='x' where `uid` = '$uid'");
				message('资料已修改成功,您修改了密码,需要重新登陆.', $login_url);
			}
			elseif ($msn || $qq || $face || $usersiteurl || $usersitename || $usernickname || $email)
			{
				$DB->query('UPDATE `'.DB_PREFIX."user` SET `qq` = '$qq', `msn` = '$msn', `face` = '$face', `usersiteurl` = '$usersiteurl', `usersitename` = '$usersitename', `usernickname` = '$usernickname', `email` = '$email'");
				message('资料已修改成功.', $profile_url);
			}
		}
	}
	else if ($url=='dologin')
	{
		// 取值并过滤部分
		$username = trim($_POST['username']);
		$password = md5($_POST['password']);
		$userinfo = $DB->fetch_first("SELECT * FROM ".DB_PREFIX."user WHERE username='$username'");

		if ($userinfo)
		{
			if ($userinfo['password']==$password)
			{
				$uid=$userinfo['uid'];
				if ($userinfo['groupid']<3&&$userinfo['hostid']!=$hostid) $loginerr='不存在的用户名';
				elseif ($userinfo['groupid']>2) $loginerr='您是管理员，需要从网站后台登录';//不是创始人,只能登陆一个站点
				else
				{
					$sessionid=getRandStr(30,true);//生成那个登陆信息
					$expire=$timestamp+31536000;//过期时间设置，记住我为最长时间，否则为浏览器关闭则无效
					setcookie('sessionid',$sessionid,$expire,'',SYS_HOST);
					$DB->query('UPDATE `'.DB_PREFIX."user` SET `logincount` = `logincount` + 1,`loginip` = '$onlineip', `logintime` = '$timestamp', `sessionid` = '$sessionid', `useragent` = '$useragent' WHERE `uid` = '$uid'");
					$DB->query('INSERT INTO `'.DB_PREFIX."login` (`user`, `dateline`, `useragent`, `ip`, `content`) values ('$username', '$timestamp', '$useragent', '$onlineip', '前台登录成功')");
					message('登陆成功', $profile_url);
				}
			}
			else $loginerr='密码错误';
		}
		else $loginerr='不存在的用户名';
		message($loginerr,$login_url);
	}
}
else
{
	if (!$url)
	{
		if (!$groupid)
		{
			$url='login';
		}
		else $url='info';
	}
	$userinfo = $DB->fetch_first('SELECT * FROM `'.DB_PREFIX."user` WHERE `uid` = '$uid'");
	switch($url)
	{
		case 'clearcookies':
			clearAllCookie();
		message('清除COOKIE成功', './');
		break;
		case 'logout':
			$adminitem=array();
			$groupid=0;
			$DB->query('UPDATE `'.DB_PREFIX."user` SET `sessionid` = 'x' WHERE `uid` = '$uid'");
			ob_end_clean();
			ob_start();
			message('注销成功', './');
		break;
		case 'login':
			if ($groupid>0) message('您已经登录过了', $profile_url);
			$pagefile = 'login';
			$title='用户登陆';
			break;
		case 'register':
			if ($groupid>0) message('您已经登录过了', $profile_url);
			$pagefile='register';
			$title='注册用户';
			break;
		case 'edit':
			$pagefile = 'edit';
			$title='编辑个人信息';
			break;
		default:
			$title='用户中心';
	}
}
