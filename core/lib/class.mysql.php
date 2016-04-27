<?php
class DB_MySQL
{
	var $querycount = 0;
	function geterrdesc()
	{
		return mysql_error();
	}
	function geterrno()
	{
		return intval(mysql_errno());
	}
	function insert_id()
	{
		$id = mysql_insert_id();
		return $id;
	}
	function connect($servername, $dbusername, $dbpassword, $dbname, $usepconnect=0)
	{
		if ($usepconnect)
		{
			if (!@mysql_pconnect($servername, $dbusername, $dbpassword))
			{
				$this->halt('数据库连接失败');
			}
		}
		else
		{
			if (!@mysql_connect($servername, $dbusername, $dbpassword))
			{
				$this->halt('数据库连接失败');
			}
		}

		if ($this->version() > '4.1')
		{
			$charset=$dbcharset='utf8';
			if (!$dbcharset && in_array(strtolower($charset), array('gbk', 'big5', 'utf-8')))
			{
				$dbcharset = str_replace('-', '', $charset);
			}
			if ($dbcharset)
			{
				//mysql_query("SET NAMES '$dbcharset'");
				mysql_query("SET character_set_connection=$dbcharset, character_set_results=$dbcharset, character_set_client=binary;");
			}
		}

		if ($this->version() > '5.0.1')
		{
			mysql_query("SET sql_mode=''");
		}
		if ($dbname)
		{
			$this->select_db($dbname);
		}
	}
	function fetch_array($query, $result_type = MYSQL_ASSOC)
	{
		return mysql_fetch_array($query, $result_type);
	}
	function query($sql, $type = '')
	{
		//遇到问题时可以开启debug用这个来检查SQL执行语句
		if (SYS_DEBUG)
		{
			echo "<div style=\"text-align: left;\">".htmlspecialchars($sql)."</div>";
			$fp = fopen(SYS_DATA.'/logs/sqlquery.log', 'a');
			flock($fp, 2);
			fwrite($fp, $sql."\n");
			fclose($fp);
		}
		$func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ? 'mysql_unbuffered_query' : 'mysql_query';
		if (!($query = $func($sql)) && $type != 'SILENT')
		{
			$this->halt('MySQL Query Error', $sql);
		}
		$this->querycount++;
		return $query;
	}
	function unbuffered_query($sql)
	{
		$query = $this->query($sql, 'UNBUFFERED');
		return $query;
	}
	function select_db($dbname)
	{
		return mysql_select_db($dbname);
	}
	function fetch_row($query)
	{
		$query = mysql_fetch_row($query);
		return $query;
	}
	function fetch_first($sql)
	{
		$result = $this->query($sql);
		$record = $this->fetch_array($result);
		return $record;
	}
	function num_rows($query)
	{
		$query = mysql_num_rows($query);
		return $query;
	}
	function num_fields($query)
	{
		return mysql_num_fields($query);
	}
	function result($query, $row)
	{
		$query = @mysql_result($query, $row);
		return $query;
	}
	function free_result($query)
	{
		$query = mysql_free_result($query);
		return $query;
	}
	function version()
	{
		return mysql_get_server_info();
	}
	function close()
	{
		return mysql_close();
	}
	function halt($msg, $sql='')
	{
		global $username,$timestamp,$onlineip;
		if ($sql)
		{
			@$fp = fopen(SYS_DATA.'/logs/dberror.log', 'a');
			@fwrite($fp, "$username\t$timestamp\t$onlineip\t".basename(SYS_FILE)."\t".htmlspecialchars($this->geterrdesc())."\t".str_replace(array("\r", "\n", "\t"), array(' ', ' ', ' '), trim(htmlspecialchars(str_replace("\t",'',$sql))))."\n");
			@fclose($fp);
		}
		$message  = "<div class=\"errormsg\">\n";
		$message .= "<p>数据库出错:</p><p><b>".htmlspecialchars($msg)."</b></p>\n";
		$message .= "<p><strong>MySQL Error Number</strong>: ".$this->geterrno()."</p>\n";
		$message .= "<p><strong>MySQL Error Description</strong>: ".htmlspecialchars($this->geterrdesc())."</p>\n";
		$message .= "<p><strong>MySQL Error SQL</strong>: ".htmlspecialchars($sql)."</p>\n";
		$message .= "<p><strong>Date</strong>: ".date("Y-m-d @ H:i")."</p>\n";
		$message .= "<p><strong>Script</strong>: http://".$_SERVER['HTTP_HOST'].getenv("REQUEST_URI")."</p>\n";
		$message .= "</div>\n";
		echo $message;
		exit;
	}
	function getMysqlVersion()
	{
		return mysql_get_server_info();
	}
}