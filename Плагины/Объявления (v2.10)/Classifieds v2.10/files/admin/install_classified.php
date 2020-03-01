<?

$plugin_name = "Classified Plugin";
$plugin_version = 2.00;
$plugin_type = "classified";
$plugin_desc = "This plugin allows your users to post classified listings. As the admin, you create the categories (like \"For Sale\", \"Jobs\", \"Personals\", etc.) and your users can post relevant listings. Your users will also be able to search for other listings via a \"browse marketplace\" area, and each users\' listings will appear on their profile.";
$plugin_icon = "classified16.gif";
$plugin_pages_main = "View Classified Entries<!>admin_viewclassifieds.php<~!~>Global Classified Settings<!>admin_classified.php<~!~>";
$plugin_pages_level = "Classified Settings<!>admin_levels_classifiedsettings.php<~!~>";
$plugin_url_htaccess = "RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^/]+)/classifieds/([0-9]+)/?$ \$server_info/classified.php?user=\$1&classified_id=\$2 [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^/]+)/classifieds/([0-9]+)/([^/]+)?$ \$server_info/classified.php?user=\$1&classified_id=\$2\$3 [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^/]+)/classifieds/?$ \$server_info/classifieds.php?user=\$1 [L]";

if($install == "classified") {

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

  //######### CREATE se_classifiedalbums
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_classifiedalbums'")) == 0) {
    $database->database_query("CREATE TABLE `se_classifiedalbums` (
    `classifiedalbum_id` int(9) NOT NULL auto_increment,
    `classifiedalbum_classified_id` int(9) NOT NULL default '0',
    `classifiedalbum_datecreated` int(14) NOT NULL default '0',
    `classifiedalbum_dateupdated` int(14) NOT NULL default '0',
    `classifiedalbum_title` varchar(50) NOT NULL default '',
    `classifiedalbum_desc` text NULL,
    `classifiedalbum_search` int(1) NOT NULL default '0',
    `classifiedalbum_privacy` int(1) NOT NULL default '0',
    `classifiedalbum_comments` int(1) NOT NULL default '0',
    `classifiedalbum_cover` int(9) NOT NULL default '0',
    `classifiedalbum_views` int(9) NOT NULL default '0',
    PRIMARY KEY  (`classifiedalbum_id`),
    KEY `INDEX` (`classifiedalbum_classified_id`)
    )");
  }


  //######### CREATE se_classifiedcats
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_classifiedcats'")) == 0) {
    $database->database_query("CREATE TABLE `se_classifiedcats` (
    `classifiedcat_id` int(9) NOT NULL auto_increment,
    `classifiedcat_dependency` int(9) NOT NULL default '0',
    `classifiedcat_title` varchar(100) NOT NULL default '',
    PRIMARY KEY  (`classifiedcat_id`)
    )");
  }

  //######### CREATE se_classifiedcomments
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_classifiedcomments'")) == 0) {
    $database->database_query("CREATE TABLE `se_classifiedcomments` (
    `classifiedcomment_id` int(9) NOT NULL auto_increment,
    `classifiedcomment_classified_id` int(9) NOT NULL default '0',
    `classifiedcomment_authoruser_id` int(9) NOT NULL default '0',
    `classifiedcomment_date` int(14) NOT NULL default '0',
    `classifiedcomment_body` text NULL,
    PRIMARY KEY  (`classifiedcomment_id`),
    KEY `INDEX` (`classifiedcomment_classified_id`,`classifiedcomment_authoruser_id`)
    )");
  }



  //######### CREATE se_classifiedfields
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_classifiedfields'")) == 0) {
    $database->database_query("CREATE TABLE `se_classifiedfields` (
    `classifiedfield_id` int(9) NOT NULL auto_increment,
    `classifiedfield_classifiedcat_id` int(9) NOT NULL default '0',
    `classifiedfield_order` int(3) NOT NULL default '0',
    `classifiedfield_dependency` int(9) NOT NULL default '0',
    `classifiedfield_title` varchar(100) NOT NULL default '',
    `classifiedfield_desc` text NULL,
    `classifiedfield_error` varchar(250) NOT NULL default '',
    `classifiedfield_type` int(1) NOT NULL default '0',
    `classifiedfield_style` varchar(200) NOT NULL default '',
    `classifiedfield_maxlength` int(3) NOT NULL default '0',
    `classifiedfield_link` varchar(250) NOT NULL default '',
    `classifiedfield_options` text NULL,
    `classifiedfield_required` int(1) NOT NULL default '0',
    `classifiedfield_regex` varchar(250) NOT NULL default '',
    `classifiedfield_html` varchar(250) NOT NULL default '',
    `classifiedfield_search` int(1) NOT NULL default '0',
    PRIMARY KEY  (`classifiedfield_id`),
    KEY `INDEX` (`classifiedfield_classifiedcat_id`,`classifiedfield_dependency`)
    )");
  }



  //######### CREATE se_classifiedmedia
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_classifiedmedia'")) == 0) {
    $database->database_query("CREATE TABLE `se_classifiedmedia` (
    `classifiedmedia_id` int(9) NOT NULL auto_increment,
    `classifiedmedia_classifiedalbum_id` int(9) NOT NULL default '0',
    `classifiedmedia_date` int(14) NOT NULL default '0',
    `classifiedmedia_title` varchar(50) NOT NULL default '',
    `classifiedmedia_desc` text NULL,
    `classifiedmedia_ext` varchar(8) NOT NULL default '',
    `classifiedmedia_filesize` int(9) NOT NULL default '0',
    PRIMARY KEY  (`classifiedmedia_id`),
    KEY `INDEX` (`classifiedmedia_classifiedalbum_id`)
    )");
  }

  //######### CREATE se_classifieds
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_classifieds'")) == 0) {
    $database->database_query("CREATE TABLE `se_classifieds` (
    `classified_id` int(9) NOT NULL auto_increment,
    `classified_user_id` int(9) NOT NULL default '0',
    `classified_classifiedcat_id` int(9) NOT NULL default '0',
    `classified_date` int(14) NOT NULL default '0',
    `classified_dateupdated` int(14) NOT NULL default '0',
    `classified_views` int(9) NOT NULL default '0',
    `classified_title` varchar(100) NOT NULL default '',
    `classified_body` text NULL,
    `classified_photo` varchar(10) NOT NULL default '',
    `classified_search` int(1) NOT NULL default '0',
    `classified_privacy` int(1) NOT NULL default '0',
    `classified_comments` int(1) NOT NULL default '0',
    PRIMARY KEY  (`classified_id`),
    KEY `INDEX` (`classified_user_id`, `classified_classifiedcat_id`)
    )");
  }


  //######### CREATE se_classifiedvalues
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_classifiedvalues'")) == 0) {
    $database->database_query("CREATE TABLE `se_classifiedvalues` (
    `classifiedvalue_id` int(9) NOT NULL auto_increment,
    `classifiedvalue_classified_id` int(9) NOT NULL default '0',
    PRIMARY KEY  (`classifiedvalue_id`),
    KEY `INDEX` (`classifiedvalue_classified_id`)
    )");
  }



  //######### INSERT se_urls
  if($database->database_num_rows($database->database_query("SELECT url_id FROM se_urls WHERE url_file='classifieds'")) == 0) {
    $database->database_query("INSERT INTO se_urls (url_title, url_file, url_regular, url_subdirectory) VALUES ('Classifieds URL', 'classifieds', 'classifieds.php?user=\$user', '\$user/classifieds/')");
  }
  if($database->database_num_rows($database->database_query("SELECT url_id FROM se_urls WHERE url_file='classified'")) == 0) {
    $database->database_query("INSERT INTO se_urls (url_title, url_file, url_regular, url_subdirectory) VALUES ('Classified Listing URL', 'classified', 'classified.php?user=\$user&classified_id=\$id1', '\$user/classifieds/\$id1/')");
  }


  //######### INSERT se_actiontypes
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='postclassified'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('postclassified', 'action_postclassified.gif', 'When I post a classified listing.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; posted a classified listing: &lt;a href=&#039;classified.php?user=[username]&amp;classified_id=[id]&#039;&gt;[title]&lt;/a&gt;')");
  }
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='classifiedcomment'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('classifiedcomment', 'action_postcomment.gif', 'When I post a comment about a classified listing.', 1, '&lt;a href=&#039;profile.php?user=[username1]&#039;&gt;[username1]&lt;/a&gt; posted a comment on &lt;a href=&#039;profile.php?user=[username2]&#039;&gt;[username2]&lt;/a&gt;&#039;s &lt;a href=&#039;classified.php?user=[username2]&amp;classified_id=[id]&#039;&gt;classified listing&lt;/a&gt;:&lt;div style=&#039;padding: 10px 20px 10px 20px;&#039;&gt;[comment]&lt;/div&gt;')");
  }


  //######### ADD COLUMNS/VALUES TO LEVELS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'level_classified_allow'")) == 0) {
    $database->database_query("ALTER TABLE se_levels 
					ADD COLUMN `level_classified_allow` int(1) NOT NULL default '0',
					ADD COLUMN `level_classified_entries` int(3) NOT NULL default '0',
					ADD COLUMN `level_classified_search` int(1) NOT NULL default '0',
					ADD COLUMN `level_classified_privacy` varchar(10) NOT NULL default '',
					ADD COLUMN `level_classified_comments` varchar(10) NOT NULL default '',
					ADD COLUMN `level_classified_photo` int(1) NOT NULL default '0',
					ADD COLUMN `level_classified_photo_width` varchar(3) NOT NULL default '',
					ADD COLUMN `level_classified_photo_height` varchar(3) NOT NULL default '',
					ADD COLUMN `level_classified_photo_exts` varchar(50) NOT NULL default '',
					ADD COLUMN `level_classified_album_exts` text NULL,
					ADD COLUMN `level_classified_album_mimes` text NULL,
					ADD COLUMN `level_classified_album_storage` bigint(14) NOT NULL default '0',
					ADD COLUMN `level_classified_album_maxsize` bigint(14) NOT NULL default '0',
					ADD COLUMN `level_classified_album_width` varchar(4) NOT NULL default '',
					ADD COLUMN `level_classified_album_height` varchar(4) NOT NULL default ''");
    $database->database_query("UPDATE se_levels SET level_classified_allow='1', level_classified_entries='50', level_classified_search='1', level_classified_privacy='012345', level_classified_comments='0123456', level_classified_photo='1', level_classified_photo_width='200', level_classified_photo_height='200', level_classified_photo_exts='jpg,jpeg,gif,png', level_classified_album_exts='jpg,gif,jpeg,png,bmp,mp3,mpeg,avi,mpa,mov,qt,swf', level_classified_album_mimes='image/jpeg,image/pjpeg,image/jpg,image/jpe,image/pjpg,image/x-jpeg,x-jpg,image/gif,image/x-gif,image/png,image/x-png,image/bmp,audio/mpeg,video/mpeg,video/x-msvideo,video/quicktime,application/x-shockwave-flash', level_classified_album_storage='5242880', level_classified_album_maxsize='2048000', level_classified_album_width='500', level_classified_album_height='500'");

  }


  //######### ADD COLUMNS/VALUES TO SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_settings LIKE 'setting_permission_classified'")) == 0) {
    $database->database_query("ALTER TABLE se_settings 
					ADD COLUMN `setting_permission_classified` int(1) NOT NULL default '0',
					ADD COLUMN `setting_email_classifiedcomment_subject` varchar(200) NOT NULL default '',
					ADD COLUMN `setting_email_classifiedcomment_message` text NULL");
    $database->database_query("UPDATE se_settings SET setting_permission_classified='1', setting_email_classifiedcomment_subject='New Classified Listing Comment', setting_email_classifiedcomment_message='Hello [username],\n\nA new comment has been posted on one of your classified listings by [commenter]. Please click the following link to view it:\n\n[link]\n\nBest Regards,\nSocial Network Administration'");
  }

  //######### ADD COLUMNS/VALUES TO USER SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_usersettings LIKE 'usersetting_notify_classifiedcomment'")) == 0) {
    $database->database_query("ALTER TABLE se_usersettings 
					ADD COLUMN `usersetting_notify_classifiedcomment` int(1) NOT NULL default '0'");
    $database->database_query("UPDATE se_usersettings SET usersetting_notify_classifiedcomment='1'");
  }

}  

?>