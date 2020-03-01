<?

$plugin_name = "Group Plugin";
$plugin_version = 2.40;
$plugin_type = "group";
$plugin_desc = "This plugin lets your users create their own groups. These groups encourage interactivity between users based on mutual interests and characteristics. Users can become leaders, create private groups, invite members, browse each other\'s memberships, and much more.";
$plugin_icon = "group16.gif";
$plugin_pages_main = "View User Groups<!>admin_viewgroups.php<~!~>Global Group Settings<!>admin_group.php<~!~>";
$plugin_pages_level = "Group Settings<!>admin_levels_groupsettings.php<~!~>";
$plugin_url_htaccess = "";


if($install == "group") {

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



  //######### CREATE se_groupalbums
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_groupalbums'")) == 0) {
    $database->database_query("CREATE TABLE `se_groupalbums` (
    `groupalbum_id` int(9) NOT NULL auto_increment,
    `groupalbum_group_id` int(9) NOT NULL default '0',
    `groupalbum_datecreated` int(14) NOT NULL default '0',
    `groupalbum_dateupdated` int(14) NOT NULL default '0',
    `groupalbum_title` varchar(50) NOT NULL default '',
    `groupalbum_desc` text NULL,
    `groupalbum_search` int(1) NOT NULL default '0',
    `groupalbum_privacy` int(1) NOT NULL default '0',
    `groupalbum_comments` int(1) NOT NULL default '0',
    `groupalbum_cover` int(9) NOT NULL default '0',
    `groupalbum_views` int(9) NOT NULL default '0',
    PRIMARY KEY  (`groupalbum_id`),
    KEY `INDEX` (`groupalbum_group_id`)
    )");
  }
  



  //######### CREATE se_groupcats
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_groupcats'")) == 0) {
    $database->database_query("CREATE TABLE `se_groupcats` (
    `groupcat_id` int(9) NOT NULL auto_increment,
    `groupcat_dependency` int(9) NOT NULL default '0',
    `groupcat_title` varchar(100) NOT NULL default '',
    PRIMARY KEY  (`groupcat_id`)
    )");
  }




  //######### CREATE se_groupcomments
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_groupcomments'")) == 0) {
    $database->database_query("CREATE TABLE `se_groupcomments` (
    `groupcomment_id` int(9) NOT NULL auto_increment,
    `groupcomment_group_id` int(9) NOT NULL default '0',
    `groupcomment_authoruser_id` int(9) NOT NULL default '0',
    `groupcomment_date` int(14) NOT NULL default '0',
    `groupcomment_body` text NULL,
    PRIMARY KEY  (`groupcomment_id`),
    KEY `INDEX` (`groupcomment_group_id`,`groupcomment_authoruser_id`)
    )");
  }




  //######### CREATE se_groupfields
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_groupfields'")) == 0) {
    $database->database_query("CREATE TABLE `se_groupfields` (
    `groupfield_id` int(9) NOT NULL auto_increment,
    `groupfield_order` int(3) NOT NULL default '0',
    `groupfield_dependency` int(9) NOT NULL default '0',
    `groupfield_title` varchar(100) NOT NULL default '',
    `groupfield_desc` text NULL,
    `groupfield_error` varchar(250) NOT NULL default '',
    `groupfield_type` int(1) NOT NULL default '0',
    `groupfield_style` varchar(200) NOT NULL default '',
    `groupfield_maxlength` int(3) NOT NULL default '0',
    `groupfield_options` text NULL,
    `groupfield_required` int(1) NOT NULL default '0',
    `groupfield_regex` varchar(250) NOT NULL default '',
    PRIMARY KEY  (`groupfield_id`)
    )");
  }




  //######### CREATE se_groupmedia
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_groupmedia'")) == 0) {
    $database->database_query("CREATE TABLE `se_groupmedia` (
    `groupmedia_id` int(9) NOT NULL auto_increment,
    `groupmedia_groupalbum_id` int(9) NOT NULL default '0',
    `groupmedia_date` int(14) NOT NULL default '0',
    `groupmedia_title` varchar(50) NOT NULL default '',
    `groupmedia_desc` text NULL,
    `groupmedia_ext` varchar(8) NOT NULL default '',
    `groupmedia_filesize` int(9) NOT NULL default '0',
    PRIMARY KEY  (`groupmedia_id`),
    KEY `INDEX` (`groupmedia_groupalbum_id`)
    )");
  }




  //######### CREATE se_groupmediacomments
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_groupmediacomments'")) == 0) {
    $database->database_query("CREATE TABLE `se_groupmediacomments` (
    `groupmediacomment_id` int(9) NOT NULL auto_increment,
    `groupmediacomment_groupmedia_id` int(9) NOT NULL default '0',
    `groupmediacomment_authoruser_id` int(9) NOT NULL default '0',
    `groupmediacomment_date` int(14) NOT NULL default '0',
    `groupmediacomment_body` text NULL,
    PRIMARY KEY  (`groupmediacomment_id`),
    KEY `INDEX` (`groupmediacomment_groupmedia_id`,`groupmediacomment_authoruser_id`)
    )");
  }




  //######### CREATE se_groupmembers
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_groupmembers'")) == 0) {
    $database->database_query("CREATE TABLE `se_groupmembers` (
    `groupmember_id` int(9) NOT NULL auto_increment,
    `groupmember_user_id` int(9) NOT NULL default '0',
    `groupmember_group_id` int(9) NOT NULL default '0',
    `groupmember_status` int(1) NOT NULL default '0',
    `groupmember_approved` int(1) NOT NULL default '0',
    `groupmember_rank` int(1) NOT NULL default '0',
    `groupmember_title` varchar(50) NOT NULL default '',
    PRIMARY KEY  (`groupmember_id`),
    KEY `INDEX` (`groupmember_user_id`,`groupmember_group_id`)
    )");
  }



  //######### CREATE se_groupposts
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_groupposts'")) == 0) {
    $database->database_query("CREATE TABLE `se_groupposts` (
    `grouppost_id` int(9) NOT NULL auto_increment,
    `grouppost_grouptopic_id` int(9) NOT NULL default '0',
    `grouppost_authoruser_id` int(9) NOT NULL default '0',
    `grouppost_date` int(14) NOT NULL default '0',
    `grouppost_body` text NULL,
    PRIMARY KEY  (`grouppost_id`),
    KEY `INDEX` (`grouppost_grouptopic_id`,`grouppost_authoruser_id`)
    )");
  }



  //######### CREATE se_groups
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_groups'")) == 0) {
    $database->database_query("CREATE TABLE `se_groups` (
    `group_id` int(9) NOT NULL auto_increment,
    `group_user_id` int(9) NOT NULL default '0',
    `group_groupcat_id` int(9) NOT NULL default '0',
    `group_datecreated` int(14) NOT NULL default '0',
    `group_dateupdated` int(14) NOT NULL default '0',
    `group_views` int(9) NOT NULL default '0',
    `group_title` varchar(100) NOT NULL default '',
    `group_desc` text NULL,
    `group_photo` varchar(10) NOT NULL default '',
    `group_search` int(1) NOT NULL default '0',
    `group_privacy` int(1) NOT NULL default '0',
    `group_comments` int(1) NOT NULL default '0',
    `group_approval` int(1) NOT NULL default '0',
    PRIMARY KEY  (`group_id`),
    KEY `INDEX` (`group_user_id`)
    )");
  }

  //######### ADD DISCUSSION BOARD COLUMNS/VALUES TO GROUPS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_groups LIKE 'group_discussion'")) == 0) {
    $database->database_query("ALTER TABLE se_groups ADD COLUMN `group_discussion` int(1) NOT NULL default '0'");
    $database->database_query("UPDATE se_groups SET group_discussion='0'");
  }


  //######### CREATE se_groupstyles
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_groupstyles'")) == 0) {
    $database->database_query("CREATE TABLE `se_groupstyles` (
    `groupstyle_id` int(9) NOT NULL auto_increment,
    `groupstyle_group_id` int(9) NOT NULL default '0',
    `groupstyle_css` text NULL,
    PRIMARY KEY  (`groupstyle_id`),
    KEY `INDEX` (`groupstyle_group_id`)
    )");
  }



  //######### CREATE se_grouptopics
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_grouptopics'")) == 0) {
    $database->database_query("CREATE TABLE `se_grouptopics` (
    `grouptopic_id` int(9) NOT NULL auto_increment,
    `grouptopic_group_id` int(9) NOT NULL default '0',
    `grouptopic_date` int(14) NOT NULL default '0',
    `grouptopic_subject` varchar(50) NOT NULL default '',
    `grouptopic_views` int(9) NOT NULL default '0',
    PRIMARY KEY  (`grouptopic_id`),
    KEY `INDEX` (`grouptopic_group_id`)
    )");
  }


  //######### CREATE se_groupvalues
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_groupvalues'")) == 0) {
    $database->database_query("CREATE TABLE `se_groupvalues` (
    `groupvalue_id` int(9) NOT NULL auto_increment,
    `groupvalue_group_id` int(9) NOT NULL default '0',
    PRIMARY KEY  (`groupvalue_id`),
    KEY `groupvalue_group_id` (`groupvalue_group_id`)
    )");
  }


  //######### INSERT se_actiontypes
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='newgroup'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('newgroup', 'action_newgroup.gif', 'When I create a group.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; created a new group: &lt;a href=&#039;group.php?group_id=[id]&#039;&gt;[title]&lt;/a&gt;')");
  }
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='joingroup'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('joingroup', 'action_joingroup.gif', 'When I join a group.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; joined a group: &lt;a href=&#039;group.php?group_id=[id]&#039;&gt;[title]&lt;/a&gt;')");
  }
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='leavegroup'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('leavegroup', 'action_leavegroup.gif', 'When I leave a group.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; left a group: &lt;a href=&#039;group.php?group_id=[id]&#039;&gt;[title]&lt;/a&gt;')");
  }
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='groupcomment'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('groupcomment', 'action_postcomment.gif', 'When I post a comment about a group.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; posted a comment on the group &lt;a href=&#039;group.php?group_id=[id]&#039;&gt;[title]&lt;/a&gt;:&lt;div style=&#039;padding: 10px 20px 10px 20px;&#039;&gt;[comment]&lt;/div&gt;')");
  }
  if($database->database_num_rows($database->database_query("SELECT actiontype_id FROM se_actiontypes WHERE actiontype_name='groupmediacomment'")) == 0) {
    $database->database_query("INSERT INTO se_actiontypes (actiontype_name, actiontype_icon, actiontype_desc, actiontype_enabled, actiontype_text) VALUES ('groupmediacomment', 'action_postcomment.gif', 'When I post a comment about a group photo.', 1, '&lt;a href=&#039;profile.php?user=[username]&#039;&gt;[username]&lt;/a&gt; posted a comment on the group &lt;a href=&#039;group.php?group_id=[id]&#039;&gt;[title]&lt;/a&gt;&#039;s &lt;a href=&#039;group_album_file.php?group_id=[id]&amp;groupmedia_id=[id2]&#039;&gt;photo&lt;/a&gt;:&lt;div style=&#039;padding: 10px 20px 10px 20px;&#039;&gt;[comment]&lt;/div&gt;')");
  }


  //######### ADD COLUMNS/VALUES TO LEVELS TABLE IF GROUPS HAVE NEVER BEEN INSTALLED
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'level_group_allow'")) == 0 AND $database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'type_group_allow'")) == 0) {
    $database->database_query("ALTER TABLE se_levels 
					ADD COLUMN `level_group_allow` int(1) NOT NULL default '0',
					ADD COLUMN `level_group_photo` int(1) NOT NULL default '0',
					ADD COLUMN `level_group_photo_width` varchar(3) NOT NULL default '',
					ADD COLUMN `level_group_photo_height` varchar(3) NOT NULL default '',
					ADD COLUMN `level_group_photo_exts` varchar(50) NOT NULL default '',
					ADD COLUMN `level_group_titles` int(1) NOT NULL default '0',
					ADD COLUMN `level_group_officers` int(1) NOT NULL default '0',
					ADD COLUMN `level_group_approval` int(1) NOT NULL default '0',
					ADD COLUMN `level_group_style` int(1) NOT NULL default '0',
					ADD COLUMN `level_group_album_exts` text NULL,
					ADD COLUMN `level_group_album_mimes` text NULL,
					ADD COLUMN `level_group_album_storage` bigint(11) NOT NULL default '0',
					ADD COLUMN `level_group_album_maxsize` bigint(11) NOT NULL default '0',
					ADD COLUMN `level_group_album_width` varchar(4) NOT NULL default '',
					ADD COLUMN `level_group_album_height` varchar(4) NOT NULL default '',
					ADD COLUMN `level_group_maxnum` int(3) NOT NULL default '0',
					ADD COLUMN `level_group_search` int(1) NOT NULL default '0',
					ADD COLUMN `level_group_privacy` varchar(10) NOT NULL default '',
					ADD COLUMN `level_group_comments` varchar(10) NOT NULL default ''");
    $database->database_query("UPDATE se_levels SET level_group_allow='1', level_group_photo='1', level_group_photo_width='200', level_group_photo_height='200', level_group_photo_exts='jpeg,jpg,gif,png', level_group_titles='1', level_group_officers='1', level_group_approval='1', level_group_style='1', level_group_album_exts='jpg,gif,jpeg,png,bmp,mp3,mpeg,avi,mpa,mov,qt,swf', level_group_album_mimes='image/jpeg,image/pjpeg,image/jpg,image/jpe,image/pjpg,image/x-jpeg,image/x-jpg,image/gif,image/x-gif,image/png,image/x-png,image/bmp,audio/mpeg,video/mpeg,video/x-msvideo,video/avi,video/quicktime,application/x-shockwave-flash', level_group_album_storage='5242880', level_group_album_maxsize='2048000', level_group_album_width='500', level_group_album_height='500', level_group_maxnum='10', level_group_search='1', level_group_privacy='012345', level_group_comments='01234567'");

  //######### CHANGE COLUMNS TO LEVELS TABLE IF GROUPS HAVE BEEN INSTALLED
  } elseif($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'type_group_allow'")) != 0) {
    $database->database_query("ALTER TABLE se_levels 
					CHANGE type_group_allow level_group_allow int(1) NOT NULL default '0',
					CHANGE type_group_photo level_group_photo int(1) NOT NULL default '0',
					CHANGE type_group_photo_width level_group_photo_width varchar(3) NOT NULL default '',
					CHANGE type_group_photo_height level_group_photo_height varchar(3) NOT NULL default '',
					CHANGE type_group_photo_exts level_group_photo_exts varchar(50) NOT NULL default '',
					CHANGE type_group_titles level_group_titles int(1) NOT NULL default '0',
					CHANGE type_group_officers level_group_officers int(1) NOT NULL default '0',
					CHANGE type_group_approval level_group_approval int(1) NOT NULL default '0',
					CHANGE type_group_style level_group_style int(1) NOT NULL default '0',
					CHANGE type_group_album_exts level_group_album_exts text NULL,
					CHANGE type_group_album_mimes level_group_album_mimes text NULL,
					CHANGE type_group_album_storage level_group_album_storage bigint(11) NOT NULL default '0',
					CHANGE type_group_album_maxsize level_group_album_maxsize bigint(11) NOT NULL default '0',
					CHANGE type_group_album_width level_group_album_width varchar(4) NOT NULL default '',
					CHANGE type_group_album_height level_group_album_height varchar(4) NOT NULL default '',
					CHANGE type_group_maxnum level_group_maxnum int(3) NOT NULL default '0',
					CHANGE type_group_search level_group_search int(1) NOT NULL default '0',
					CHANGE type_group_privacy level_group_privacy varchar(10) NOT NULL default '',
					CHANGE type_group_comments level_group_comments varchar(10) NOT NULL default ''");
  }

  //######### ADD DISCUSSION BOARD COLUMNS/VALUES TO LEVELS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'level_group_discussion'")) == 0) {
    $database->database_query("ALTER TABLE se_levels ADD COLUMN `level_group_discussion` varchar(10) NOT NULL default ''");
    $database->database_query("UPDATE se_levels SET level_group_discussion='01234567'");
  }

  //######### ADD COLUMNS/VALUES TO SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_settings LIKE 'setting_permission_group'")) == 0) {
    $database->database_query("ALTER TABLE se_settings 
					ADD COLUMN `setting_permission_group` int(1) NOT NULL default '0',
					ADD COLUMN `setting_email_groupinvite_subject` varchar(200) NOT NULL default '',
					ADD COLUMN `setting_email_groupinvite_message` text NULL,
					ADD COLUMN `setting_email_groupcomment_subject` varchar(200) NOT NULL default '',
					ADD COLUMN `setting_email_groupcomment_message` text NULL,
					ADD COLUMN `setting_email_groupmediacomment_subject` varchar(200) NOT NULL default '',
					ADD COLUMN `setting_email_groupmediacomment_message` text NULL,
					ADD COLUMN `setting_email_groupmemberrequest_subject` varchar(200) NOT NULL default '',
					ADD COLUMN `setting_email_groupmemberrequest_message` text NULL");
    $database->database_query("UPDATE se_settings SET setting_permission_group='1', setting_email_groupinvite_subject='You have been invited to join [groupname].', setting_email_groupinvite_message='Hello [username],\n\nYou have been invited to join a group named [groupname]. Please click the following link to login:\n\n[link]\n\nBest Regards,\nSocial Network Administration', setting_email_groupcomment_subject='New Group Comment', setting_email_groupcomment_message='Hello [username],\n\nA new comment has been posted by [commenter] about the group &quot;[groupname]&quot;. Please click the following link to view it:\n\n[link]\n\nBest Regards,\nSocial Network Administration', setting_email_groupmediacomment_subject='New Group Photo Comment', setting_email_groupmediacomment_message='Hello [username],\n\nA new comment has been posted by [commenter] on one of the photos in the group &quot;[groupname]&quot;. Please click the following link to view it:\n\n[link]\n\nBest Regards,\nSocial Network Administration', setting_email_groupmemberrequest_subject='New Group Membership Request', setting_email_groupmemberrequest_message='Hello [username],\n\n[requester] would like to join your group &quot;[groupname]&quot;. Please click the following link to login and confirm their membership:\n\n[link]\n\nBest Regards,\nSocial Network Administration'");
  }

  //######### ADD DISCUSSION BOARD COLUMNS/VALUES TO SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_settings LIKE 'setting_group_discussion_code'")) == 0) {
    $database->database_query("ALTER TABLE se_settings ADD COLUMN `setting_group_discussion_code` int(1) NOT NULL default '0'");
    $database->database_query("UPDATE se_settings SET setting_group_discussion_code='1'");
  }

  //######### ADD COLUMNS/VALUES TO USER SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_usersettings LIKE 'usersetting_notify_groupinvite'")) == 0) {
    $database->database_query("ALTER TABLE se_usersettings 
					ADD COLUMN `usersetting_notify_groupinvite` int(1) NOT NULL default '0',
					ADD COLUMN `usersetting_notify_groupcomment` int(1) NOT NULL default '0',
					ADD COLUMN `usersetting_notify_groupmediacomment` int(1) NOT NULL default '0',
					ADD COLUMN `usersetting_notify_groupmemberrequest` int(1) NOT NULL default '0'");
    $database->database_query("UPDATE se_usersettings SET usersetting_notify_groupinvite='1', usersetting_notify_groupcomment='1', usersetting_notify_groupmediacomment='1', usersetting_notify_groupmemberrequest='1'");
  }

}  

?>
