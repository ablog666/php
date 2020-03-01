<?php

$plugin_name = "Chat Plugin";
$plugin_version = 2.20;
$plugin_type = "chat";
$plugin_desc = "This plugin installs a live chatroom on your social network and adds a link to it on your users\' menu bar. Adding a chatroom is a great way to encourage members to interact more closely and form new connections.";
$plugin_icon = "chat16.gif";
$plugin_pages_main = "Global Chat Settings<!>admin_chat.php<~!~>";
$plugin_pages_level = "";
$plugin_url_htaccess = "";

if($install == "chat") {

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

  //######### CREATE se_chatbans
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_chatbans'")) == 0) {
    $database->database_query("CREATE TABLE `se_chatbans` (
    `chatban_id` int(9) NOT NULL auto_increment,
    `chatban_user_id` int(9) NOT NULL default '0',
    `chatban_bandate` int(14) NOT NULL default '0',
    PRIMARY KEY  (`chatban_id`),
    KEY `INDEX` (`chatban_user_id`)
    )");
  }




  //######### CREATE se_chatmessages
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_chatmessages'")) == 0) {
    $database->database_query("CREATE TABLE `se_chatmessages` (
    `chatmessage_id` int(12) NOT NULL auto_increment,
    `chatmessage_time` int(14) NOT NULL default '0',
    `chatmessage_user_username` varchar(50) NOT NULL default '',
    `chatmessage_content` varchar(255) NOT NULL default '',
    PRIMARY KEY  (`chatmessage_id`)
    )");
  }



  //######### CREATE se_chatusers
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_chatusers'")) == 0) {
    $database->database_query("CREATE TABLE `se_chatusers` (
    `chatuser_id` int(9) NOT NULL auto_increment,
    `chatuser_user_id` int(9) NOT NULL default '0',
    `chatuser_user_username` varchar(50) NOT NULL default '',
    `chatuser_lastupdate` int(14) NOT NULL default '0',
    `chatuser_user_photo` varchar(10) NOT NULL default '',
    PRIMARY KEY  (`chatuser_id`),
    KEY `INDEX` (`chatuser_user_id`)
    )");
  }


  //######### ADD COLUMNS/VALUES TO SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_settings LIKE 'setting_chat_enabled'")) == 0) {
    $database->database_query("ALTER TABLE se_settings 
					ADD COLUMN `setting_chat_enabled` int(1) NOT NULL default '0',
					ADD COLUMN `setting_chat_update` int(2) NOT NULL default '0',
					ADD COLUMN `setting_chat_showphotos` int(1) NOT NULL default '0'");
    $database->database_query("UPDATE se_settings SET setting_chat_enabled='1', setting_chat_update='2', setting_chat_showphotos='1'");
  }


}  

?>