<?

$plugin_name = "Photo Album Plugin";
$plugin_version = 2.50;
$plugin_type = "album";
$plugin_desc = "This plugin gives your users their own personal photo albums. These albums can be configured to store photos, videos, or any other file types you choose to allow. Users can interact by commenting on each others photos and viewing their friends\' recent updates.";
$plugin_icon = "album16.gif";
$plugin_pages_main = "View Photo Albums<!>admin_viewalbums.php<~!~>Global Album Settings<!>admin_album.php<~!~>";
$plugin_pages_level = "Album Settings<!>admin_levels_albumsettings.php<~!~>";
$plugin_url_htaccess = "RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^/]+)/albums/([0-9]+)/([0-9]+)/?$ \$server_info/album_file.php?user=\$1&album_id=\$2&media_id=\$3 [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^/]+)/albums/([0-9]+)/?$ \$server_info/album.php?user=\$1&album_id=\$2 [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^/]+)/albums/([0-9]+)/([^/]+)?$ \$server_info/album.php?user=\$1&album_id=\$2\$3 [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^([^/]+)/albums/?$ \$server_info/albums.php?user=\$1 [L]";




if($install == "album") {


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



  //######### CREATE se_albums
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_albums'")) == 0) {
    $database->database_query("CREATE TABLE `se_albums` (
      `album_id` int(9) NOT NULL auto_increment,
      `album_user_id` int(9) NOT NULL default '0',
      `album_datecreated` int(14) NOT NULL default '0',
      `album_dateupdated` int(14) NOT NULL default '0',
      `album_title` varchar(50) NOT NULL default '',
      `album_desc` text NULL,
      `album_search` int(1) NOT NULL default '0',
      `album_privacy` int(1) NOT NULL default '0',
      `album_comments` int(1) NOT NULL default '0',
      `album_cover` int(9) NOT NULL default '0',
      `album_views` int(9) NOT NULL default '0',
      PRIMARY KEY  (`album_id`),
      KEY `INDEX` (`album_user_id`)
    )");
  }


  //######### CREATE se_media
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_media'")) == 0) {
    $database->database_query("CREATE TABLE `se_media` (
      `media_id` int(9) NOT NULL auto_increment,
      `media_album_id` int(9) NOT NULL default '0',
      `media_date` int(14) NOT NULL default '0',
      `media_title` varchar(50) NOT NULL default '',
      `media_desc` text NULL,
      `media_ext` varchar(8) NOT NULL default '',
      `media_filesize` int(9) NOT NULL default '0',
      PRIMARY KEY  (`media_id`),
      KEY `INDEX` (`media_album_id`)
    )");
  }


  //######### CREATE se_mediacomments
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_mediacomments'")) == 0) {
    $database->database_query("CREATE TABLE `se_mediacomments` (
      `mediacomment_id` int(9) NOT NULL auto_increment,
      `mediacomment_media_id` int(9) NOT NULL default '0',
      `mediacomment_authoruser_id` int(9) NOT NULL default '0',
      `mediacomment_date` int(14) NOT NULL default '0',
      `mediacomment_body` text NULL,
      PRIMARY KEY  (`mediacomment_id`),
      KEY `INDEX` (`mediacomment_media_id`,`mediacomment_authoruser_id`)
    )");
  }


  //######### CREATE se_albumstyles
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_albumstyles'")) == 0) {
    $database->database_query("CREATE TABLE `se_albumstyles` (
    `albumstyle_id` int(9) NOT NULL auto_increment,
    `albumstyle_user_id` int(9) NOT NULL default '0',
    `albumstyle_css` text NULL,
    PRIMARY KEY  (`albumstyle_id`),
    KEY `INDEX` (`albumstyle_user_id`)
    )");
  }

  //######### INSERT se_urls
  if($database->database_num_rows($database->database_query("SELECT url_id FROM se_urls WHERE url_file='albums'")) == 0) {
    $database->database_query("INSERT INTO se_urls (url_title, url_file, url_regular, url_subdirectory) VALUES ('Album List URL', 'albums', 'albums.php?user=\$user', '\$user/albums/')");
  }
  if($database->database_num_rows($database->database_query("SELECT url_id FROM se_urls WHERE url_file='album'")) == 0) {
    $database->database_query("INSERT INTO se_urls (url_title, url_file, url_regular, url_subdirectory) VALUES ('Album URL', 'album', 'album.php?user=\$user&album_id=\$id1', '\$user/albums/\$id1')");
  }
  if($database->database_num_rows($database->database_query("SELECT url_id FROM se_urls WHERE url_file='album_file'")) == 0) {
    $database->database_query("INSERT INTO se_urls (url_title, url_file, url_regular, url_subdirectory) VALUES ('Photo URL', 'album_file', 'album_file.php?user=\$user&album_id=\$id1&media_id=\$id2', '\$user/albums/\$id1/\$id2')");
  }


  //######### INSERT se_actiontypes
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='newalbum'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('newalbum', 'action_newalbum.gif', 'When I create a new album.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; created a new album: &lt;a href=&#039;album.php?user=[username]&amp;album_id=[id]&#039;&gt;[title]&lt;/a&gt;')");
  }
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='newmedia'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('newmedia', 'action_newmedia.gif', 'When I upload new photos.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; uploaded new photos to their album: &lt;a href=&#039;album.php?user=[username]&amp;album_id=[id]&#039;&gt;[title]&lt;/a&gt;')");
  }
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='mediacomment'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('mediacomment', 'action_postcomment.gif', 'When I post a comment about a photo.', 1, '&lt;a href=&#039;profile.php?user=[username1]&#039;&gt;[username1]&lt;/a&gt; posted a comment on &lt;a href=&#039;profile.php?user=[username2]&#039;&gt;[username2]&lt;/a&gt;&#039;s &lt;a href=&#039;album_file.php?user=[username2]&amp;album_id=[albumid]&amp;media_id=[mediaid]&#039;&gt;photo&lt;/a&gt;:&lt;div style=&#039;padding: 10px 20px 10px 20px;&#039;&gt;[comment]&lt;/div&gt;')");
  }


  //######### ADD COLUMNS/VALUES TO LEVELS TABLE IF ALBUM HAS NEVER BEEN INSTALLED
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'level_album_allow'")) == 0 AND $database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'type_album_allow'")) == 0) {
    $database->database_query("ALTER TABLE se_levels 
					ADD COLUMN `level_album_allow` int(1) NOT NULL default '0',
					ADD COLUMN `level_album_maxnum` int(3) NOT NULL default '0',
					ADD COLUMN `level_album_exts` text NOT NULL,
					ADD COLUMN `level_album_mimes` text NULL,
					ADD COLUMN `level_album_storage` bigint(11) NOT NULL default '0',
					ADD COLUMN `level_album_maxsize` bigint(11) NOT NULL default '0',
					ADD COLUMN `level_album_width` varchar(4) NOT NULL default '',
					ADD COLUMN `level_album_height` varchar(4) NOT NULL default '',
					ADD COLUMN `level_album_style` int(1) NOT NULL default '0',
					ADD COLUMN `level_album_search` int(1) NOT NULL default '0',
					ADD COLUMN `level_album_privacy` varchar(10) NOT NULL default '',
					ADD COLUMN `level_album_comments` varchar(10) NOT NULL default ''");
    $database->database_query("UPDATE se_levels SET level_album_allow='1', level_album_maxnum='10', level_album_exts='jpg,gif,jpeg,png,bmp,mp3,mpeg,avi,mpa,mov,qt,swf', level_album_mimes='image/jpeg,image/pjpeg,image/jpg,image/jpe,image/pjpg,image/x-jpeg,image/x-jpg,image/gif,image/x-gif,image/png,image/x-png,image/bmp,audio/mpeg,video/mpeg,video/x-msvideo,video/avi,video/quicktime,application/x-shockwave-flash', level_album_storage='5242880', level_album_maxsize='2048000', level_album_width='500', level_album_height='500', level_album_style='1', level_album_search='1', level_album_privacy='012345', level_album_comments='0123456'");

  //######### CHANGE COLUMNS TO LEVELS TABLE IF ALBUM HAS BEEN INSTALLED
  } elseif($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'type_album_allow'")) != 0) {
    $database->database_query("ALTER TABLE se_levels 
					CHANGE type_album_allow level_album_allow int(1) NOT NULL default '0',
					CHANGE type_album_maxnum level_album_maxnum int(3) NOT NULL default '0',
					CHANGE type_album_exts level_album_exts text NOT NULL,
					CHANGE type_album_mimes level_album_mimes text NULL,
					CHANGE type_album_storage level_album_storage bigint(11) NOT NULL default '0',
					CHANGE type_album_maxsize level_album_maxsize bigint(11) NOT NULL default '0',
					CHANGE type_album_width level_album_width varchar(4) NOT NULL default '',
					CHANGE type_album_height level_album_height varchar(4) NOT NULL default '',
					CHANGE type_album_style level_album_style int(1) NOT NULL default '0',
					CHANGE type_album_search level_album_search int(1) NOT NULL default '0',
					CHANGE type_album_privacy level_album_privacy varchar(10) NOT NULL default '',
					CHANGE type_album_comments level_album_comments varchar(10) NOT NULL default ''");
  }


  //######### ADD COLUMNS/VALUES TO SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_settings LIKE 'setting_permission_album'")) == 0) {
    $database->database_query("ALTER TABLE se_settings 
					ADD COLUMN `setting_permission_album` int(1) NOT NULL default '0',
					ADD COLUMN `setting_email_mediacomment_subject` varchar(200) NOT NULL default '',
					ADD COLUMN `setting_email_mediacomment_message` text NULL");
    $database->database_query("UPDATE se_settings SET setting_permission_album='1', setting_email_mediacomment_subject='New Media Comment', setting_email_mediacomment_message='Hello [username],\nA new comment has been posted on one of your photos by [commenter]. Please click the following link to view it:\n\n[link]\n\nBest Regards,\nSocial Network Administration'");
  }

  //######### ADD COLUMNS/VALUES TO USER SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_usersettings LIKE 'usersetting_notify_mediacomment'")) == 0) {
    $database->database_query("ALTER TABLE se_usersettings 
					ADD COLUMN `usersetting_notify_mediacomment` int(1) NOT NULL default '0'");
    $database->database_query("UPDATE se_usersettings SET usersetting_notify_mediacomment='1'");
  }


}  

?>