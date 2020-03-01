<?
include "./include/database_config.php";
include "./include/functions_general.php";
include "./include/class_database.php";

// INITIATE DATABASE CONNECTION
$database = new se_database($database_host, $database_username, $database_password, $database_name);

//######### CREATE se_ratings
if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_myguests'")) == 0) {
  $database->database_query("CREATE TABLE `se_myguests` (
  `oid` int(11) NOT NULL default '0',
  `uid` int(11) NOT NULL default '0',
  `date` varchar(20) NOT NULL default '',
  `time` int(25) NOT NULL default '0',
  `p_views` tinyint(4) NOT NULL default '0',
  `f_views` tinyint(4) NOT NULL default '0',
  `b_views` tinyint(4) NOT NULL default '0'
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;");
}



if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_myguests'")) == 1) {
  echo "
  <html>
  <head>
  <title>My Guests Installation</title>
  <style type='text/css'>
  body, td, div {
	font-family: \"Trebuchet MS\", tahoma, verdana, arial, serif;
	font-size: 10pt;
	color: #333333;
	line-height: 16pt;
  }
  h1 {
	font-size: 16pt;
	margin-bottom: 4px;
  }
  h2 {
	font-size: 12pt;
	margin-bottom: 4px;
  }
  .box {
	padding: 10px 13px 10px 13px; 
	border: 1px dashed #BBBBBB;
  }
  ul {
	margin-top: 2px;
	margin-bottom: 2px;
  }
  input.text {
	font-family: \"Trebuchet MS\", tahoma, verdana, arial, serif;
  }
  input.button {
	background: #EEEEEE;
	font-weight: bold;
	padding: 2px;
	font-family: \"Trebuchet MS\", tahoma, verdana, arial, serif;
  }
  form {
	margin: 0px;
  }
  a:link { color: #2078C8; text-decoration: none; }
  a:visited { color: #2078C8; text-decoration: none; }
  a:hover { color: #3FA4FF; text-decoration: underline; }
  </style>
  </head>
  <body>
  <h1>My Guests Installation</h1>
  Установка таблиц завершена. Пожалуйста удалите файл (install_myguests.php)
  в целях безопасности.
  

  <br /><br />
  ©2008 Passtor
  </body>
  </html>
  ";
}


?>