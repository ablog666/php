<?

$plugin_name = "Подарки";
$plugin_version = 1.1;
$plugin_type = "gifts";
$plugin_desc = "Этот плагин дает пользователям возможность создавать отправлять подарки друг другу.";
$plugin_icon = "gifts.gif";
$plugin_pages_main = "Управление подарками<!>admin_gifts.php<~!~>Подаренные<!>admin_viewgifts.php<~!~>Настройки<!>admin_giftsset.php<~!~>";
$plugin_pages_level = "";
$plugin_url_htaccess = "";




if($install == "gifts") {


  //######### INSERT ROW INTO se_plugins
  if($database->database_num_rows($database->database_query("SELECT plugin_id FROM se_plugins WHERE plugin_type='$plugin_type'")) == 0) {
    $database->database_query("INSERT INTO se_plugins (plugin_name,
					plugin_version,
					plugin_type,
					plugin_desc,
					plugin_icon,
					plugin_pages_main,
					plugin_pages_level,
					plugin_url_htaccess
					) VALUES (
					'$plugin_name',
					'$plugin_version',
					'$plugin_type',
					'$plugin_desc',
					'$plugin_icon',
					'$plugin_pages_main',
					'$plugin_pages_level',
					'$plugin_url_htaccess')");


  //######### UPDATE PLUGIN VERSION IN se_plugins
  } else {
    $database->database_query("UPDATE se_plugins SET plugin_name='$plugin_name',
					plugin_version='$plugin_version',
					plugin_desc='$plugin_desc',
					plugin_icon='$plugin_icon',
					plugin_pages_main='$plugin_pages_main',
					plugin_pages_level='$plugin_pages_level',
					plugin_url_htaccess='$plugin_url_htaccess' WHERE plugin_type='$plugin_type'");

  }



  //######### CREATE se_gifts
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_gifts'")) == 0) {
    $database->database_query("CREATE TABLE `se_gifts` (
  `gifts_id` int(10) NOT NULL auto_increment,
  `gifts_category` int(10) NOT NULL default '0',
  `gifts_price` int(20) NOT NULL default '0',
  UNIQUE KEY `id` (`gifts_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;");
  }


  //######### CREATE se_gifts_cat
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_gifts_cat'")) == 0) {
    $database->database_query("CREATE TABLE `se_gifts_cat` (
  `gifts_cat_id` int(11) NOT NULL auto_increment,
  `gifts_cat_name` varchar(100) NOT NULL default '',
  UNIQUE KEY `gifts_cat_id` (`gifts_cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=6 ;");
  }


  //######### CREATE se_gifts_point
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_gifts_point'")) == 0) {
    $database->database_query("CREATE TABLE `se_gifts_point` (
  `point_id` int(20) NOT NULL auto_increment,
  `point_user_id` int(20) NOT NULL default '0',
  `type` int(1) NOT NULL default '0',
  `point_sum` int(20) NOT NULL default '0',
  `point_who` varchar(100) NOT NULL default '',
  UNIQUE KEY `point_id` (`point_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;");
  }


  //######### CREATE se_gifts_user
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_gifts_user'")) == 0) {
    $database->database_query("CREATE TABLE `se_gifts_user` (
  `gifts_user_id` int(11) NOT NULL auto_increment,
  `gifts_id` int(100) NOT NULL default '0',
  `gifts_fuser_id` int(100) NOT NULL default '0',
  `gifts_tuser_id` int(100) NOT NULL default '0',
  `gifts_comment` varchar(255) NOT NULL default '',
  `gifts_type` int(100) NOT NULL default '0',
  UNIQUE KEY `gifts_user_id` (`gifts_user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=cp1251 AUTO_INCREMENT=1 ;");
  }

  if($database->database_num_rows($database->database_query("SELECT url_id FROM se_urls WHERE url_file='video_file'")) == 0) {
    $database->database_query("INSERT INTO se_urls (url_title, url_file, url_regular, url_subdirectory) VALUES ('Photo URL', 'video_file', 'video_file.php?user=\$user&video_id=\$id1&video_media_id=\$id2', '\$user/videos/\$id1/\$id2')");
  }





  //######### ADD COLUMNS/VALUES TO USER SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_users LIKE 'user_points'")) == 0) {
    $database->database_query("ALTER TABLE se_users 
					ADD COLUMN `user_points` int(20) NOT NULL default '0'");
    $database->database_query("UPDATE se_users SET user_points='0'");
  }
$database->database_query("INSERT INTO `se_gifts_cat` VALUES (1, 'Test');");
$database->database_query("INSERT INTO `se_gifts` VALUES (1, 1, 20);");
$database->database_query("INSERT INTO `se_gifts` VALUES (2, 1, 10);");
$database->database_query("INSERT INTO `se_gifts` VALUES (3, 1, 10);");

}  


  //######### ADD COLUMNS/VALUES TO SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_settings LIKE 'setting_email_gifts_message'")) == 0) {
    $database->database_query("ALTER TABLE se_settings 
					ADD COLUMN `setting_email_gifts_subject` varchar(200) NOT NULL default '',
					ADD COLUMN `setting_email_gifts_message` text NULL");
    $database->database_query("UPDATE se_settings SET setting_email_gifts_subject='Новый подарок', setting_email_gifts_message='Здраствуйте [username],\nВам сделали новый подарок\n[link]\n'");
  }

?>