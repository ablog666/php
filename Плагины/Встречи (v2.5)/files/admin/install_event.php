<?

$plugin_name = "Event Plugin";
$plugin_version = 2.20;
$plugin_type = "event";
$plugin_desc = "This plugin lets your users create events. Users can create private or public events, invite their friends, RSVP, browse each other\'s calendars, and much more. Events encourage users to expand their personal networks by establishing new connections.";
$plugin_icon = "event16.gif";
$plugin_pages_main = "View Events<!>admin_viewevents.php<~!~>Global Event Settings<!>admin_event.php<~!~>";
$plugin_pages_level = "Event Settings<!>admin_levels_eventsettings.php<~!~>";
$plugin_url_htaccess = "";


if($install == "event") {

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



  //######### CREATE se_eventalbums
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_eventalbums'")) == 0) {
    $database->database_query("CREATE TABLE `se_eventalbums` (
    `eventalbum_id` int(9) NOT NULL auto_increment,
    `eventalbum_event_id` int(9) NOT NULL default '0',
    `eventalbum_datecreated` int(14) NOT NULL default '0',
    `eventalbum_dateupdated` int(14) NOT NULL default '0',
    `eventalbum_title` varchar(50) NOT NULL default '',
    `eventalbum_desc` text NULL,
    `eventalbum_search` int(1) NOT NULL default '0',
    `eventalbum_privacy` int(1) NOT NULL default '0',
    `eventalbum_comments` int(1) NOT NULL default '0',
    `eventalbum_cover` int(9) NOT NULL default '0',
    `eventalbum_views` int(9) NOT NULL default '0',
    PRIMARY KEY  (`eventalbum_id`),
    KEY `INDEX` (`eventalbum_event_id`)
    )");
  }
  



  //######### CREATE se_eventcats
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_eventcats'")) == 0) {
    $database->database_query("CREATE TABLE `se_eventcats` (
    `eventcat_id` int(9) NOT NULL auto_increment,
    `eventcat_dependency` int(9) NOT NULL default '0',
    `eventcat_title` varchar(100) NOT NULL default '',
    PRIMARY KEY  (`eventcat_id`)
    )");
  }




  //######### CREATE se_eventcomments
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_eventcomments'")) == 0) {
    $database->database_query("CREATE TABLE `se_eventcomments` (
    `eventcomment_id` int(9) NOT NULL auto_increment,
    `eventcomment_event_id` int(9) NOT NULL default '0',
    `eventcomment_authoruser_id` int(9) NOT NULL default '0',
    `eventcomment_date` int(14) NOT NULL default '0',
    `eventcomment_body` text NULL,
    PRIMARY KEY  (`eventcomment_id`),
    KEY `INDEX` (`eventcomment_event_id`,`eventcomment_authoruser_id`)
    )");
  }




  //######### CREATE se_eventmedia
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_eventmedia'")) == 0) {
    $database->database_query("CREATE TABLE `se_eventmedia` (
    `eventmedia_id` int(9) NOT NULL auto_increment,
    `eventmedia_eventalbum_id` int(9) NOT NULL default '0',
    `eventmedia_date` int(14) NOT NULL default '0',
    `eventmedia_title` varchar(50) NOT NULL default '',
    `eventmedia_desc` text NULL,
    `eventmedia_ext` varchar(8) NOT NULL default '',
    `eventmedia_filesize` int(9) NOT NULL default '0',
    PRIMARY KEY  (`eventmedia_id`),
    KEY `INDEX` (`eventmedia_eventalbum_id`)
    )");
  }




  //######### CREATE se_eventmediacomments
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_eventmediacomments'")) == 0) {
    $database->database_query("CREATE TABLE `se_eventmediacomments` (
    `eventmediacomment_id` int(9) NOT NULL auto_increment,
    `eventmediacomment_eventmedia_id` int(9) NOT NULL default '0',
    `eventmediacomment_authoruser_id` int(9) NOT NULL default '0',
    `eventmediacomment_date` int(14) NOT NULL default '0',
    `eventmediacomment_body` text NULL,
    PRIMARY KEY  (`eventmediacomment_id`),
    KEY `INDEX` (`eventmediacomment_eventmedia_id`,`eventmediacomment_authoruser_id`)
    )");
  }




  //######### CREATE se_eventmembers
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_eventmembers'")) == 0) {
    $database->database_query("CREATE TABLE `se_eventmembers` (
    `eventmember_id` int(9) NOT NULL auto_increment,
    `eventmember_user_id` int(9) NOT NULL default '0',
    `eventmember_event_id` int(9) NOT NULL default '0',
    `eventmember_status` int(1) NOT NULL default '0',
    PRIMARY KEY  (`eventmember_id`),
    KEY `INDEX` (`eventmember_user_id`,`eventmember_event_id`)
    )");
  }




  //######### CREATE se_events
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_events'")) == 0) {
    $database->database_query("CREATE TABLE `se_events` (
    `event_id` int(9) NOT NULL auto_increment,
    `event_user_id` int(9) NOT NULL default '0',
    `event_eventcat_id` int(9) NOT NULL default '0',
    `event_dateupdated` int(14) NOT NULL default '0',
    `event_views` int(9) NOT NULL default '0',
    `event_title` varchar(100) NOT NULL default '',
    `event_desc` text NULL,
    `event_date_start` int(14) NOT NULL default '0',
    `event_date_end` int(14) NOT NULL default '0',
    `event_host` varchar(250) NOT NULL default '',
    `event_location` text NULL,
    `event_photo` varchar(10) NOT NULL default '',
    `event_search` int(1) NOT NULL default '0',
    `event_privacy` int(1) NOT NULL default '0',
    `event_comments` int(1) NOT NULL default '0',
    `event_inviteonly` int(1) NOT NULL default '0',
    PRIMARY KEY  (`event_id`),
    KEY `INDEX` (`event_user_id`)
    )");
  }


  //######### CREATE se_eventstyles
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_eventstyles'")) == 0) {
    $database->database_query("CREATE TABLE `se_eventstyles` (
    `eventstyle_id` int(9) NOT NULL auto_increment,
    `eventstyle_event_id` int(9) NOT NULL default '0',
    `eventstyle_css` text NULL,
    PRIMARY KEY  (`eventstyle_id`),
    KEY `INDEX` (`eventstyle_event_id`)
    )");
  }


  //######### INSERT se_actiontypes
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='newevent'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('newevent', 'action_newevent.gif', 'When I create an event.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; created a new event: &lt;a href=&#039;event.php?event_id=[id]&#039;&gt;[title]&lt;/a&gt;')");
  }
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='attendevent'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('attendevent', 'action_attendevent.gif', 'When I RSVP \"yes\" to an event.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; is attending an event: &lt;a href=&#039;event.php?event_id=[id]&#039;&gt;[title]&lt;/a&gt;')");
  }
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='eventcomment'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('eventcomment', 'action_postcomment.gif', 'When I post a comment about an event.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; posted a comment on the event &lt;a href=&#039;event.php?event_id=[id]&#039;&gt;[title]&lt;/a&gt;:&lt;div style=&#039;padding: 10px 20px 10px 20px;&#039;&gt;[comment]&lt;/div&gt;')");
  }
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='eventmediacomment'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('eventmediacomment', 'action_postcomment.gif', 'When I post a comment about an event photo.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; posted a comment on the event &lt;a href=&#039;event.php?event_id=[id]&#039;&gt;[title]&lt;/a&gt;&#039;s &lt;a href=&#039;event_album_file.php?event_id=[id]&amp;eventmedia_id=[id2]&#039;&gt;photo&lt;/a&gt;:&lt;div style=&#039;padding: 10px 20px 10px 20px;&#039;&gt;[comment]&lt;/div&gt;')");
  }


  //######### ADD COLUMNS/VALUES TO LEVELS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'level_event_allow'")) == 0) {
    $database->database_query("ALTER TABLE se_levels 
					ADD COLUMN `level_event_allow` int(1) NOT NULL default '0',
					ADD COLUMN `level_event_photo` int(1) NOT NULL default '0',
					ADD COLUMN `level_event_photo_width` varchar(3) NOT NULL default '',
					ADD COLUMN `level_event_photo_height` varchar(3) NOT NULL default '',
					ADD COLUMN `level_event_photo_exts` varchar(50) NOT NULL default '',
					ADD COLUMN `level_event_inviteonly` int(1) NOT NULL default '0',
					ADD COLUMN `level_event_style` int(1) NOT NULL default '0',
					ADD COLUMN `level_event_album_exts` text NULL,
					ADD COLUMN `level_event_album_mimes` text NULL,
					ADD COLUMN `level_event_album_storage` bigint(11) NOT NULL default '0',
					ADD COLUMN `level_event_album_maxsize` bigint(11) NOT NULL default '0',
					ADD COLUMN `level_event_album_width` varchar(4) NOT NULL default '',
					ADD COLUMN `level_event_album_height` varchar(4) NOT NULL default '',
					ADD COLUMN `level_event_search` int(1) NOT NULL default '0',
					ADD COLUMN `level_event_privacy` varchar(10) NOT NULL default '',
					ADD COLUMN `level_event_comments` varchar(10) NOT NULL default ''");
    $database->database_query("UPDATE se_levels SET level_event_allow='1', level_event_photo='1', level_event_photo_width='200', level_event_photo_height='200', level_event_photo_exts='jpeg,jpg,gif,png', level_event_inviteonly='1', level_event_style='1', level_event_album_exts='jpg,gif,jpeg,png,bmp,mp3,mpeg,avi,mpa,mov,qt,swf', level_event_album_mimes='image/jpeg,image/pjpeg,image/jpg,image/jpe,image/pjpg,image/x-jpeg,x-jpg,image/gif,image/x-gif,image/png,image/x-png,image/bmp,audio/mpeg,video/mpeg,video/x-msvideo,video/quicktime,application/x-shockwave-flash', level_event_album_storage='5242880', level_event_album_maxsize='2048000', level_event_album_width='500', level_event_album_height='500', level_event_search='1', level_event_privacy='012345', level_event_comments='01234567'");
  }


  //######### ADD COLUMNS/VALUES TO SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_settings LIKE 'setting_permission_event'")) == 0) {
    $database->database_query("ALTER TABLE se_settings 
					ADD COLUMN `setting_permission_event` int(1) NOT NULL default '0',
					ADD COLUMN `setting_email_eventinvite_subject` varchar(200) NOT NULL default '',
					ADD COLUMN `setting_email_eventinvite_message` text NULL,
					ADD COLUMN `setting_email_eventcomment_subject` varchar(200) NOT NULL default '',
					ADD COLUMN `setting_email_eventcomment_message` text NULL,
					ADD COLUMN `setting_email_eventmediacomment_subject` varchar(200) NOT NULL default '',
					ADD COLUMN `setting_email_eventmediacomment_message` text NULL,
					ADD COLUMN `setting_email_eventmemberrequest_subject` varchar(200) NOT NULL default '',
					ADD COLUMN `setting_email_eventmemberrequest_message` text NULL");
    $database->database_query("UPDATE se_settings SET setting_permission_event='1', setting_email_eventinvite_subject='You have been invited to attend [eventname].', setting_email_eventinvite_message='Hello [username],\n\nYou have been invited to attend an event: [eventname]. Please click the following link to login:\n\n[link]\n\nBest Regards,\nSocial Network Administration', setting_email_eventcomment_subject='New Event Comment', setting_email_eventcomment_message='Hello [username],\n\nA new comment has been posted by [commenter] about the event &quot;[eventname]&quot;. Please click the following link to view it:\n\n[link]\n\nBest Regards,\nSocial Network Administration', setting_email_eventmediacomment_subject='New Event Photo Comment', setting_email_eventmediacomment_message='Hello [username],\n\nA new comment has been posted by [commenter] on one of the photos in the event &quot;[eventname]&quot;. Please click the following link to view it:\n\n[link]\n\nBest Regards,\nSocial Network Administration', setting_email_eventmemberrequest_subject='New Event Invitation Request', setting_email_eventmemberrequest_message='Hello [username],\n\n[requester] has requested an invitation to your event &quot;[eventname]&quot;. Please click the following link to login and send them an invitation:\n\n[link]\n\nBest Regards,\nSocial Network Administration'");
  }

  //######### ADD COLUMNS/VALUES TO USER SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_usersettings LIKE 'usersetting_notify_eventinvite'")) == 0) {
    $database->database_query("ALTER TABLE se_usersettings 
					ADD COLUMN `usersetting_notify_eventinvite` int(1) NOT NULL default '0',
					ADD COLUMN `usersetting_notify_eventcomment` int(1) NOT NULL default '0',
					ADD COLUMN `usersetting_notify_eventmediacomment` int(1) NOT NULL default '0',
					ADD COLUMN `usersetting_notify_eventmemberrequest` int(1) NOT NULL default '0'");
    $database->database_query("UPDATE se_usersettings SET usersetting_notify_eventinvite='1', usersetting_notify_eventcomment='1', usersetting_notify_eventmediacomment='1', usersetting_notify_eventmemberrequest='1'");
  }

}  

?>
