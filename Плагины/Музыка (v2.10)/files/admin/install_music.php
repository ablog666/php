<?php
$plugin_name = "Music Plugin";
$plugin_version = 2.10;
$plugin_type = "music";
$plugin_desc = "This plugin gives each of your users the ability to upload audio files, which can then be played via a Flash player on their profiles. This is a great way to increase profile customizability and personal expression.";
$plugin_icon = "music16.gif";
$plugin_pages_main = "View Music<!>admin_viewmusic.php<~!~>";
$plugin_pages_level = "Music Settings<!>admin_levels_musicsettings.php<~!~>";

if($install == "music"){

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
					
  $database->database_query("INSERT INTO `se_actiontypes` (`actiontype_name`,
  		 `actiontype_icon`,
  		 `actiontype_desc`,
  		 `actiontype_enabled`,
  		 `actiontype_text`
  		 ) VALUES (
  		 'newmusic',
  		 'action_editstatus.gif',
  		 'When I add new music',
  		 1,
  		 '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; added a new song')");


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

  //######### CREATE se_music
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_music'")) == 0) {
    $database->database_query("CREATE TABLE `se_music` (
	  `music_id` int(9) NOT NULL auto_increment,
	  `music_user_id` int(9) NOT NULL default '0',
	  `music_track_num` int(9) NOT NULL default '0',
	  `music_date` int(14) NOT NULL default '0',
	  `music_title` varchar(50) NOT NULL default '',
	  `music_ext` varchar(8) NOT NULL default '',
	  `music_filesize` int(9) NOT NULL default '0',
	  PRIMARY KEY  (`music_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
  }
  
  //######### CREATE se_music_skins
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_music_skins'")) == 0) {
    $database->database_query("CREATE TABLE `se_music_skins` (
	  `se_music_skins_id` int(11) NOT NULL auto_increment,
	  `se_music_skins_title` varchar(255) NOT NULL default '',
	  `se_music_skins_height` varchar(255) NOT NULL default '',
	  `se_music_skins_width` varchar(255) NOT NULL default '',
	  `se_music_skins_version` varchar(255) NOT NULL default '',
	  PRIMARY KEY  (`se_music_skins_id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;");
	$database->database_query("INSERT INTO `se_music_skins` (`se_music_skins_id`, `se_music_skins_title`, `se_music_skins_height`, `se_music_skins_width`, `se_music_skins_version`) VALUES
(1, 'Default', '50', '200', '2.00'),
(2, 'Cassette', '200', '304', '2'),
(3, 'BasicPlaylist', '170', '200', '2.00');");
  }
  
  //######### ADD COLUMNS/VALUES TO LEVELS TABLE 
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'level_music_allow'")) == 0) {
  	$database->database_query("ALTER TABLE se_levels 
  	  ADD COLUMN `level_music_allow` int(1) NOT NULL default '1',
	  ADD COLUMN `level_music_maxnum` int(3) NOT NULL default '5',
	  ADD COLUMN `level_music_exts` text NOT NULL,
	  ADD COLUMN `level_music_mimes` text,
	  ADD COLUMN `level_music_storage` bigint(11) NOT NULL default '104857600',
	  ADD COLUMN `level_music_maxsize` bigint(11) NOT NULL default '15728640',
	  ADD COLUMN `level_music_allow_skins` bigint(11) NOT NULL default '1',
	  ADD COLUMN `level_music_skin_default` int(11) NOT NULL default '3'");
    $database->database_query("UPDATE se_levels SET level_music_exts='mp3,mp4', level_music_mimes='audio/mpeg,audio/x-wav,application/octet-stream,audio/x-mp3,audio/mpeg3,audio/x-mpeg-3,video/mpeg,video/x-mpeg,audio/x-mpeg,audio/mp3,audio/x-mpeg3,audio/mpg,audio/x-mpg,audio/x-mpegaudio,content/unknown'");
  }

  //######### ADD COLUMNS/VALUES TO USER SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_usersettings LIKE 'music_profile_autoplay'")) == 0) {
    $database->database_query("ALTER TABLE se_usersettings 
		ADD COLUMN `usersetting_music_profile_autoplay` int(11) NOT NULL default '1',
 		ADD COLUMN `usersetting_music_site_autoplay` int(11) NOT NULL default '1',
  		ADD COLUMN `usersetting_music_skin_id` int(11) NOT NULL default '1'");
  }
	
}

?>
