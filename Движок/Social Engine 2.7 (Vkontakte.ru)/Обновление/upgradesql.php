<?

//######### FOR BACKWARD COMPATIBILITY AFTER V2.00
if($mysql_database == "") { $mysql_database = $database_name; }

//######### INSERT LICENSE KEY
mysql_query("UPDATE se_settings SET setting_key='$license'");






//######### BELOW ARE MODIFICATIONS SPECIFICALLY FOR V1.X ###########################################################################

//######### CHECK/MODIFY REPORTS TABLE
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_reports FROM `$mysql_database` LIKE 'report_object'")) == 1) {
  mysql_query("ALTER TABLE se_reports DROP report_object");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_reports FROM `$mysql_database` LIKE 'report_object_id'")) == 1) {
  mysql_query("ALTER TABLE se_reports DROP report_object_id");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_reports FROM `$mysql_database` LIKE 'report_url'")) != 1) {
  mysql_query("ALTER TABLE se_reports ADD report_url varchar(250) NOT NULL default ''");
}

//######### CHECK/MODIFY SETTINGS TABLE
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_permission_browse'")) == 1) {
  mysql_query("ALTER TABLE se_settings CHANGE setting_permission_browse setting_permission_invite int(1) NOT NULL default ''");
}

//######### CHECK/MODIFY FIELDS TABLE
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_fields FROM `$mysql_database` LIKE 'field_link'")) != 1) {
  mysql_query("ALTER TABLE se_fields ADD field_link varchar(250) NOT NULL default ''");
}







//######### BELOW ARE MODIFICATIONS SPECIFICALLY FOR V2.00 ##########################################################################


//######### CREATE se_ratings
if(mysql_num_rows(mysql_query("SHOW TABLES FROM `$mysql_database` LIKE 'se_ratings'")) == 0) {
mysql_query("CREATE TABLE `se_ratings` (
`id` varchar(11) NOT NULL,
`total_votes` int(11) NOT NULL default 0,
`total_value` int(11) NOT NULL default 0,
`used_ips` longtext,
PRIMARY KEY (`id`)
				)");
}
//######### CHECK/ADD ACTIONS TABLE
if(mysql_num_rows(mysql_query("SHOW TABLES FROM `$mysql_database` LIKE 'se_actions'")) == 0) {
  mysql_query("CREATE TABLE `se_actions` (
				`action_id` int(9) NOT NULL auto_increment,
				`action_actiontype_id` int(9) NOT NULL default '0',
				`action_date` int(14) NOT NULL default '0',
				`action_user_id` int(9) NOT NULL default '0',
				`action_subnet_id` int(9) NOT NULL default '0',
				`action_icon` varchar(50) NOT NULL default '',
				`action_text` text NOT NULL,
				PRIMARY KEY  (`action_id`),
				KEY `action_actiontype_id` (`action_actiontype_id`),
				KEY `action_user_id` (`action_user_id`),
				KEY `action_subnet_id` (`action_subnet_id`)
				)");
}
  
//######### CHECK/ADD ACTIONTYPES TABLE/DATA
if(mysql_num_rows(mysql_query("SHOW TABLES FROM `$mysql_database` LIKE 'se_actiontypes'")) == 0) {
  mysql_query("CREATE TABLE `se_actiontypes` (
				`actiontype_id` int(9) NOT NULL auto_increment,
				`actiontype_name` varchar(50) NOT NULL default '',
				`actiontype_icon` varchar(50) NOT NULL default '',
				`actiontype_desc` varchar(250) NOT NULL default '',
				`actiontype_enabled` int(1) NOT NULL default '0',
				`actiontype_text` text NOT NULL,
				PRIMARY KEY  (`actiontype_id`),
				UNIQUE KEY `actiontype_name` (`actiontype_name`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=8");
  mysql_query("INSERT INTO `se_actiontypes` (`actiontype_id`, `actiontype_name`, `actiontype_icon`, `actiontype_desc`, `actiontype_enabled`, `actiontype_text`) VALUES 
				(1, 'login', 'action_login.gif', 'When I log in.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; logged in.'),
				(2, 'editphoto', 'action_editphoto.gif', 'When I update my profile photo.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; updated their profile photo.&lt;div style=&#039;padding: 10px 10px 10px 20px;&#039;&gt;&lt;a href=&#039;profile.php?user=[username]&#039;&gt;&lt;img src=&#039;[photo]&#039; border=&#039;0&#039;&gt;&lt;/a&gt;&lt;/div&gt;'),
				(3, 'editprofile', 'action_editprofile.gif', 'When I update my profile.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; updated their profile.'),
				(4, 'postcomment', 'action_postcomment.gif', 'When I post a comment on someone&#039;s profile.', 1, '&lt;a href=&#039;profile.php?user=[username1]&#039;&gt;[username1]&lt;/a&gt; posted a comment on &lt;a href=&#039;profile.php?user=[username2]&#039;&gt;[username2]&lt;/a&gt;&#039;s profile:&lt;div style=&#039;padding: 10px 20px 10px 20px;&#039;&gt;[comment]&lt;/div&gt;'),
				(5, 'addfriend', 'action_addfriend.gif', 'When I add a friend.', 1, '&lt;a href=&#039;profile.php?user=[username1]&#039;&gt;[username1]&lt;/a&gt; and &lt;a href=&#039;profile.php?user=[username2]&#039;&gt;[username2]&lt;/a&gt; are now friends.'),
				(6, 'signup', 'action_signup.gif', '', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; signed up.'),
				(7, 'editstatus', 'action_editstatus.gif', 'When I update my status.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; is [status]')");
}

//######### CHECK/MODIFY ADMINS TABLE
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_admins FROM `$mysql_database` LIKE 'admin_lostpassword_code'")) != 1) {
  mysql_query("ALTER TABLE se_admins ADD admin_lostpassword_code varchar(15) NOT NULL default ''");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_admins FROM `$mysql_database` LIKE 'admin_lostpassword_time'")) != 1) {
  mysql_query("ALTER TABLE se_admins ADD admin_lostpassword_time int(14) NOT NULL default '0'");
}

//######### CHECK/ADD ADS TABLE
if(mysql_num_rows(mysql_query("SHOW TABLES FROM `$mysql_database` LIKE 'se_ads'")) == 0) {
  mysql_query("CREATE TABLE `se_ads` (
				`ad_id` int(9) NOT NULL auto_increment,
				`ad_name` varchar(250) NOT NULL default '',
				`ad_date_start` varchar(15) NOT NULL default '',
				`ad_date_end` varchar(15) NOT NULL default '',
				`ad_paused` int(1) NOT NULL default '0',
				`ad_limit_views` int(10) NOT NULL default '0',
				`ad_limit_clicks` int(10) NOT NULL default '0',
				`ad_limit_ctr` varchar(8) NOT NULL default '0',
				`ad_public` int(1) NOT NULL default '0',
				`ad_position` varchar(15) NOT NULL default '',
				`ad_levels` text NOT NULL,
				`ad_subnets` text NOT NULL,
				`ad_html` text NOT NULL,
				`ad_total_views` int(10) NOT NULL default '0',
				`ad_total_clicks` int(10) NOT NULL default '0',
				`ad_filename` varchar(20) NOT NULL default '',
				PRIMARY KEY  (`ad_id`)
				)");
}

//######### CHECK/MODIFY FIELDS TABLE
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_fields FROM `$mysql_database` LIKE 'field_html'")) != 1) {
  mysql_query("ALTER TABLE se_fields ADD field_html varchar(250) NOT NULL default ''");
}

//######### CHECK/ADD LEVELS TABLE
if(mysql_num_rows(mysql_query("SHOW TABLES FROM `$mysql_database` LIKE 'se_levels'")) == 0) {
  mysql_query("ALTER TABLE se_types RENAME se_levels");
  mysql_query("ALTER TABLE se_levels 
				CHANGE type_id level_id int(9) NOT NULL auto_increment,
				CHANGE type_message_allow level_message_allow int(1) NOT NULL default '0',
				CHANGE type_message_inbox level_message_inbox int(3) NOT NULL default '0',
				CHANGE type_message_outbox level_message_outbox int(3) NOT NULL default '0',
				CHANGE type_profile_style level_profile_style int(1) NOT NULL default '0',
				CHANGE type_profile_block level_profile_block int(1) NOT NULL default '0',
				CHANGE type_profile_search level_profile_search int(1) NOT NULL default '0',
				CHANGE type_profile_privacy level_profile_privacy varchar(10) NOT NULL default '',
				CHANGE type_profile_comments level_profile_comments varchar(10) NOT NULL default '',
				CHANGE type_profile_status level_profile_status int(1) NOT NULL default '0',
				CHANGE type_photo_allow level_photo_allow int(1) NOT NULL default '0',
				CHANGE type_photo_width level_photo_width varchar(3) NOT NULL default '',
				CHANGE type_photo_height level_photo_height varchar(3) NOT NULL default '',
				CHANGE type_photo_exts level_photo_exts varchar(50) NOT NULL default ''");
  mysql_query("ALTER TABLE se_levels 
				ADD level_name varchar(50) NOT NULL default '',
				ADD level_desc text NOT NULL,
				ADD level_default int(1) NOT NULL default '0',
				ADD level_signup int(1) NOT NULL default '0'");
  mysql_query("UPDATE se_levels SET level_name='Default', level_default='1' LIMIT 1");
}

//######### CHECK/ADD PLUGINS TABLE
if(mysql_num_rows(mysql_query("SHOW TABLES FROM `$mysql_database` LIKE 'se_plugins'")) == 0) {
  mysql_query("CREATE TABLE `se_plugins` (
				`plugin_id` int(9) NOT NULL auto_increment,
				`plugin_name` varchar(100) NOT NULL default '',
				`plugin_version` varchar(4) NOT NULL default '',
				`plugin_type` varchar(30) NOT NULL default '',
				`plugin_desc` text NOT NULL,
				`plugin_icon` varchar(50) NOT NULL default '',
				`plugin_pages_main` text NOT NULL,
				`plugin_pages_level` text NOT NULL,
				`plugin_url_htaccess` text NOT NULL,
				PRIMARY KEY  (`plugin_id`),
				UNIQUE KEY `plugin_type` (`plugin_type`))");
}

//######### CHECK/ADD PROFILESTYLES TABLE
if(mysql_num_rows(mysql_query("SHOW TABLES FROM `$mysql_database` LIKE 'se_profilestyles'")) == 0) {
  mysql_query("CREATE TABLE `se_profilestyles` (
				`profilestyle_id` int(9) NOT NULL auto_increment,
				`profilestyle_user_id` int(9) NOT NULL default '0',
				`profilestyle_css` text,
				PRIMARY KEY  (`profilestyle_id`),
				KEY `profilestyle_user_id` (`profilestyle_user_id`))");
}

//######### CHECK/MODIFY SETTINGS TABLE/DATA
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_lang_default'")) != 1) {
  mysql_query("ALTER TABLE se_settings ADD setting_lang_default varchar(50) NOT NULL default ''");
  mysql_query("UPDATE se_settings SET setting_lang_default='english'");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_lang_allow'")) != 1) {
  mysql_query("ALTER TABLE se_settings ADD setting_lang_allow int(1) NOT NULL default '0'");
  mysql_query("UPDATE se_settings SET setting_lang_allow='0'");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_plugin_blog'")) == 1) {
  mysql_query("ALTER TABLE se_settings DROP COLUMN setting_plugin_blog");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_plugin_album'")) == 1) {
  mysql_query("ALTER TABLE se_settings DROP COLUMN setting_plugin_album");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_plugin_group'")) == 1) {
  mysql_query("ALTER TABLE se_settings DROP COLUMN setting_plugin_group");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_invite_code'")) != 1) {
  mysql_query("ALTER TABLE se_settings ADD setting_invite_code int(1) NOT NULL default '0'");
  mysql_query("UPDATE se_settings SET setting_invite_code='1'");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_actions_showlength'")) != 1) {
  mysql_query("ALTER TABLE se_settings ADD setting_actions_showlength int(14) NOT NULL default '0'");
  mysql_query("UPDATE se_settings SET setting_actions_showlength='60'");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_actions_actionsperuser'")) != 1) {
  mysql_query("ALTER TABLE se_settings ADD setting_actions_actionsperuser int(2) NOT NULL default '0'");
  mysql_query("UPDATE se_settings SET setting_actions_actionsperuser='3'");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_actions_selfdelete'")) != 1) {
  mysql_query("ALTER TABLE se_settings ADD setting_actions_selfdelete int(2) NOT NULL default '0'");
  mysql_query("UPDATE se_settings SET setting_actions_selfdelete='1'");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_actions_privacy'")) != 1) {
  mysql_query("ALTER TABLE se_settings ADD setting_actions_privacy int(1) NOT NULL default '0'");
  mysql_query("UPDATE se_settings SET setting_actions_privacy='1'");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_actions_actionsonprofile'")) != 1) {
  mysql_query("ALTER TABLE se_settings ADD setting_actions_actionsonprofile int(2) NOT NULL default '0'");
  mysql_query("UPDATE se_settings SET setting_actions_actionsonprofile='7'");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_actions_actionsinlist'")) != 1) {
  mysql_query("ALTER TABLE se_settings ADD setting_actions_actionsinlist int(2) NOT NULL default '0'");
  mysql_query("UPDATE se_settings SET setting_actions_actionsinlist='15'");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_settings FROM `$mysql_database` LIKE 'setting_actions_visibility'")) != 1) {
  mysql_query("ALTER TABLE se_settings ADD setting_actions_visibility int(1) NOT NULL default '0'");
  mysql_query("UPDATE se_settings SET setting_actions_visibility='1'");
}

//######### CHECK/MODIFY STATS TABLE
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_stats FROM `$mysql_database` LIKE 'stat_groups'")) == 1) {
  mysql_query("ALTER TABLE se_stats DROP COLUMN stat_groups");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_stats FROM `$mysql_database` LIKE 'stat_blogentries'")) == 1) {
  mysql_query("ALTER TABLE se_stats DROP COLUMN stat_blogentries");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_stats FROM `$mysql_database` LIKE 'stat_albums'")) == 1) {
  mysql_query("ALTER TABLE se_stats DROP COLUMN stat_albums");
}

//######### MODIFY STATREFS TABLE
$field_info = mysql_fetch_assoc(mysql_query("SHOW COLUMNS FROM se_statrefs FROM `$mysql_database` LIKE 'statref_url'"));
if($field_info['Key'] != "UNI") {
  mysql_query("ALTER TABLE `se_statrefs` ADD UNIQUE (`statref_url`)");
}

//######### MODIFY STATS TABLE
$field_info = mysql_fetch_assoc(mysql_query("SHOW COLUMNS FROM se_stats FROM `$mysql_database` LIKE 'stat_date'"));
if($field_info['Key'] != "UNI") {
  mysql_query("DELETE t1 FROM se_stats AS t1, se_stats AS t2 WHERE t1.stat_date=t2.stat_date AND t1.stat_id<t2.stat_id");
  mysql_query("ALTER TABLE `se_stats` ADD UNIQUE (`stat_date`)");
}

//######### CHECK/DROP STYLES TABLE
if(mysql_num_rows(mysql_query("SHOW TABLES FROM `$mysql_database` LIKE 'se_styles'")) == 0) {
  mysql_query("DROP TABLE se_styles");
}

//######### CHECK/ADD URLS TABLE
if(mysql_num_rows(mysql_query("SHOW TABLES FROM `$mysql_database` LIKE 'se_urls'")) == 0) {
  mysql_query("CREATE TABLE `se_urls` (
				  `url_id` int(9) NOT NULL auto_increment,
				  `url_title` varchar(100) NOT NULL default '',
				  `url_file` varchar(50) NOT NULL default '',
				  `url_regular` varchar(200) NOT NULL default '',
				  `url_subdirectory` varchar(200) NOT NULL default '',
				  PRIMARY KEY  (`url_id`))");
}

//######### CHECK/MODIFY USERS TABLE
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_type_id'")) == 1) {
  mysql_query("ALTER TABLE se_users CHANGE user_type_id user_level_id int(9) NOT NULL default '0'");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_lostpassword_code'")) == 1) {
  mysql_query("ALTER TABLE se_users DROP COLUMN user_lostpassword_code");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_lostpassword_time'")) == 1) {
  mysql_query("ALTER TABLE se_users DROP COLUMN user_lostpassword_time");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_notify_groupinvite'")) == 1) {
  mysql_query("ALTER TABLE se_users DROP COLUMN user_notify_groupinvite");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_notify_friendrequest'")) == 1) {
  mysql_query("ALTER TABLE se_users DROP COLUMN user_notify_friendrequest");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_notify_message'")) == 1) {
  mysql_query("ALTER TABLE se_users DROP COLUMN user_notify_message");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_notify_profilecomment'")) == 1) {
  mysql_query("ALTER TABLE se_users DROP COLUMN user_notify_profilecomment");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_notify_blogcomment'")) == 1) {
  mysql_query("ALTER TABLE se_users DROP COLUMN user_notify_blogcomment");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_notify_mediacomment'")) == 1) {
  mysql_query("ALTER TABLE se_users DROP COLUMN user_notify_mediacomment");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_notify_groupcomment'")) == 1) {
  mysql_query("ALTER TABLE se_users DROP COLUMN user_notify_groupcomment");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_notify_groupmediacomment'")) == 1) {
  mysql_query("ALTER TABLE se_users DROP COLUMN user_notify_groupmediacomment");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_notify_groupmemberrequest'")) == 1) {
  mysql_query("ALTER TABLE se_users DROP COLUMN user_notify_groupmemberrequest");
}
if(mysql_num_rows(mysql_query("SHOW COLUMNS FROM se_users FROM `$mysql_database` LIKE 'user_lang'")) != 1) {
  mysql_query("ALTER TABLE se_users ADD user_lang varchar(20) NOT NULL default ''");
  mysql_query("UPDATE se_users SET user_lang='english'");
}

//######### CHECK/ADD USERSETTINGS TABLE
if(mysql_num_rows(mysql_query("SHOW TABLES FROM `$mysql_database` LIKE 'se_usersettings'")) == 0) {
  mysql_query("CREATE TABLE `se_usersettings` (
				`usersetting_id` int(9) NOT NULL auto_increment,
				`usersetting_user_id` int(9) NOT NULL default '0',
				`usersetting_lostpassword_code` varchar(15) NOT NULL default '',
				`usersetting_lostpassword_time` int(14) NOT NULL default '0',
				`usersetting_notify_friendrequest` int(1) NOT NULL default '0',
				`usersetting_notify_message` int(1) NOT NULL default '0',
				`usersetting_notify_profilecomment` int(1) NOT NULL default '0',
				`usersetting_notify_blogcomment` int(1) NOT NULL default '0',
				`usersetting_notify_mediacomment` int(1) NOT NULL default '0',
				`usersetting_notify_groupinvite` int(1) NOT NULL default '0',
				`usersetting_notify_groupcomment` int(1) NOT NULL default '0',
				`usersetting_notify_groupmediacomment` int(1) NOT NULL default '0',
				`usersetting_notify_groupmemberrequest` int(1) NOT NULL default '0',
				`usersetting_actions_dontpublish` varchar(40) NOT NULL default '',
				PRIMARY KEY  (`usersetting_id`))");
  mysql_query("INSERT INTO se_usersettings (usersetting_user_id) SELECT se_users.user_id FROM se_users");
}


//######### RENAME MYSQLCON.PHP
if(file_exists("./include/mysqlcon.php")) {
  $filename = "./include/database_config.php";
  $somecontent = "<?\n\$database_host = \"$mysql_host\";\n\$database_username = \"$mysql_username\";\n\$database_password = \"$mysql_password\";\n\$database_name = \"$mysql_database\";\n?>";
  if($handle = fopen($filename, 'w+')) {
    fwrite($handle, $somecontent);
    fclose($handle);
  }
  unlink("./include/mysqlcon.php");
}





//######### BELOW ARE MODIFICATIONS SPECIFICALLY FOR V2.10 ##########################################################################

//######### ENSURE ALL PROFILE FIELDS FOR DROPDOWN AND RADIOS ARE DEFAULT -1
$columns = mysql_query("SHOW COLUMNS FROM se_profiles");
while($column_info = mysql_fetch_assoc($columns)) {
  $field_name = $column_info['Field'];
  $field_type = $column_info['Type'];
  $field_default = $column_info['Default'];
  if($field_type == "int(2)" & $field_default != "-1") {
    mysql_query("ALTER TABLE se_profiles CHANGE $field_name $field_name $field_type NOT NULL default '-1'");
  }
}



?>