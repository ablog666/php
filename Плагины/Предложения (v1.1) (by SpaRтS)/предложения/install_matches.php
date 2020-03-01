<?
include "./include/database_config.php";
include "./include/functions_general.php";
include "./include/class_database.php";

// INITIATE DATABASE CONNECTION
$database = new se_database($database_host, $database_username, $database_password, $database_name);


//######### CREATE se_matches
if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_matches'")) == 0) {

  $database->database_query("CREATE TABLE `se_matches` (
  `matches_id` int(10) NOT NULL auto_increment,
  `matches_user_id` int(10) NOT NULL default '0',
  `matches_body` text NOT NULL,
  `matches_date` int(20) NOT NULL default '0',
  `matches_act` varchar(50) NOT NULL default '1',
  UNIQUE KEY `id` (`matches_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;");
}



//######### CREATE se_matches_sent
if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_matches_sent'")) == 0) {

  $database->database_query("CREATE TABLE `se_matches_sent` (
  `sent_id` int(10) NOT NULL auto_increment,
  `sent_user_id` int(10) NOT NULL default '0',
  `sent_autheruser_id` int(10) NOT NULL default '0',
  `sent_date` int(20) NOT NULL default '0',
  `sent_view` varchar(50) NOT NULL default '1',
  UNIQUE KEY `id` (`sent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;");
}





if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_matches_sent'")) == 1) {
  echo "
  <html>
  <head>
  <title>Karma Installation</title>
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
  <h1>Mathes Installation</h1>
  Установка таблиц завершена. Пожалуйста удалите файл (install_matches.php)
  в целях безопасности.
  <br /><br />
  </body>
  </html>
  ";
}


?>