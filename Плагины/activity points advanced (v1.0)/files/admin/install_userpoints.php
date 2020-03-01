<?

$plugin_name = "Activity Points Advanced";
$plugin_version = "1.00";
$plugin_type = "userpoints";
$plugin_desc = "The plugin allows assigning user points for various activities.";
$plugin_icon = "userpoints16.png";
$plugin_pages_main = "Settings<!>admin_userpoints.php<~!~>Users<!>admin_userpoints_viewusers.php<~!~>Point Ranks<!>admin_userpoints_pointranks.php<~!~>Give Points<!>admin_userpoints_give.php<~!~>Assign Activity Points<!>admin_userpoints_assign.php<~!~>Activity Charging<!>admin_userpoints_charging.php<~!~>Offers<!>admin_userpoints_offers.php<~!~>Shop<!>admin_userpoints_shop.php<~!~>Transactions<!>admin_userpoints_transactions.php<~!~>";
$plugin_pages_level = "Points Settings<!>admin_levels_userpointssettings.php<~!~>";
$plugin_url_htaccess = "";

if(!function_exists('chain_sql')) {
  function chain_sql( $sql ) {
	global $database;
	
	$rows = explode( ';', $sql);
	foreach($rows as $row) {
	  $row = trim($row);
	  if(empty($row))
		continue;
	  $database->database_query( $row );
	}
	  
  }
}

if($install == "userpoints") {

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


  //######### CREATE DATABASE STRUCTURE
  
  chain_sql(
<<<EOC

# se_semods_actionpoints

CREATE TABLE `se_semods_actionpoints` (
  `action_id` int(11) NOT NULL auto_increment,
  `action_type` varchar(50) NOT NULL,
  `action_enabled` tinyint(1) NOT NULL default '1',
  `action_name` varchar(255) NOT NULL,
  `action_points` int(11) NOT NULL,
  `action_pointsmax` int(11) NOT NULL default '0',
  `action_rolloverperiod` int(11) NOT NULL default '0',
  `action_requiredplugin` varchar(100) default NULL,
  `action_group` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`action_id`),
  KEY `action_type` (`action_type`)
);

# CUSTOM ACTIONS
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (1, 'transferpoints', 1, 'Transfer Points', 1, 0, 0, NULL, 0);

# GENERAL ACTIONS
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (101, 'invite', 1, 'Invite Friends (for each invited friend)', 1, 0, 0, NULL, 8);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (102, 'refer', 1, 'Refer friends (actual signup)', 100, 0, 0, NULL, 8);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (103, 'signup', 1, 'Signup Bonus', 500, 0, 0, NULL, 8);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (104, 'addfriend', 1, 'Add a friend', 1, 10, 86400, NULL, 7);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (106, 'editphoto', 1, 'Upload profile photo', 100, 200, 86400, NULL, 7);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (107, 'editprofile', 1, 'Edit / Update profile', 10, 100, 86400, NULL, 7);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (108, 'editstatus', 1, 'Update status', 1, 50, 86400, NULL, 7);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (109, 'login', 1, 'Login to site (requires logout)', 1, 10, 86400, NULL, 7);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (110, 'adclick', 1, 'Clicking on an ad', 100, 1000, 86400, NULL, 7);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (111, 'newevent', 1, 'Create new event', 100, 0, 0, 'SocialEngine Events plugin', 3);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (112, 'attendevent', 1, 'RSVP to Event', 1, 0, 0, 'SocialEngine Events plugin', 3);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (113, 'eventcomment', 1, 'Comment on event', 10, 0, 0, 'SocialEngine Events plugin', 3);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (114, 'eventmediacomment', 1, 'Comment on event photo', 10, 0, 0, 'SocialEngine Events plugin', 3);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (115, 'postblog', 1, 'Post a blog', 1, 0, 0, 'SocialEngine Blogs plugin', 5);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (116, 'blogcomment', 1, 'Comment on Blog', 1, 0, 0, 'SocialEngine Blogs plugin', 5);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (117, 'postclassified', 1, 'Create a classified', 100, 1000, 86400, 'SocialEngine Classifieds plugin', 4);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (118, 'classifiedcomment', 1, 'Comment on classified', 10, 100, 86400, 'SocialEngine Classifieds plugin', 4);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (119, 'newalbum', 1, 'Upload an album', 100, 1000, 86400, 'SocialEngine Photos plugin', 6);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (120, 'newmedia', 1, 'Upload new photo / media to album', 100, 1000, 86400, 'SocialEngine Photos plugin', 6);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (121, 'mediacomment', 1, 'Comment on photo / media', 10, 100, 86400, 'SocialEngine Photos plugin', 6);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (122, 'newgroup', 1, 'Create new group', 100, 500, 86400, 'SocialEngine Groups plugin', 1);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (123, 'joingroup', 1, 'Join a group', 50, 200, 86400, 'SocialEngine Groups plugin', 1);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (124, 'leavegroup', 1, 'Leave a group', 0, 0, 86400, 'SocialEngine Groups plugin', 1);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (125, 'groupcomment', 1, 'Comment on group', 10, 100, 86400, 'SocialEngine Groups plugin', 1);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (126, 'groupmediacomment', 1, 'Comment on group photo', 10, 100, 86400, 'SocialEngine Groups plugin', 1);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (127, 'newpoll', 1, 'Create a poll', 0, 0, 0, 'SocialEngine Polls plugin', 2);
INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (128, 'votepoll', 1, 'Participate in poll', 200, 0, 0, 'SocialEngine Polls plugin', 2);


CREATE TABLE `se_semods_userpointcounters` (
  `userpointcounters_user_id` int(11) NOT NULL,
  `userpointcounters_action_id` int(11) NOT NULL,
  `userpointcounters_lastrollover` int(4) NOT NULL default '0',
  `userpointcounters_amount` int(11) NOT NULL default '0',
  PRIMARY KEY  (`userpointcounters_user_id`,`userpointcounters_action_id`)
);



CREATE TABLE `se_userpointearnercomments` (
  `userpointearnercomment_id` int(9) NOT NULL auto_increment,
  `userpointearnercomment_userpointearner_id` int(9) NOT NULL default '0',
  `userpointearnercomment_authoruser_id` int(9) NOT NULL default '0',
  `userpointearnercomment_date` int(14) NOT NULL default '0',
  `userpointearnercomment_body` text,
  PRIMARY KEY  (`userpointearnercomment_id`),
  KEY `INDEX` (`userpointearnercomment_userpointearner_id`,`userpointearnercomment_authoruser_id`)
);

CREATE TABLE `se_userpointspendercomments` (
  `userpointspendercomment_id` int(9) NOT NULL auto_increment,
  `userpointspendercomment_userpointspender_id` int(9) NOT NULL default '0',
  `userpointspendercomment_authoruser_id` int(9) NOT NULL default '0',
  `userpointspendercomment_date` int(14) NOT NULL default '0',
  `userpointspendercomment_body` text,
  PRIMARY KEY  (`userpointspendercomment_id`),
  KEY `INDEX` (`userpointspendercomment_userpointspender_id`,`userpointspendercomment_authoruser_id`)
);


CREATE TABLE `se_semods_uptransactions` (
  `uptransaction_id` int(11) NOT NULL auto_increment,
  `uptransaction_user_id` int(11) NOT NULL,
  `uptransaction_type` int(11) NOT NULL,
  `uptransaction_cat` int(11) NOT NULL default '0',
  `uptransaction_state` tinyint(4) NOT NULL,
  `uptransaction_text` text,
  `uptransaction_date` int(11) NOT NULL,
  `uptransaction_amount` int(11) NOT NULL,
  PRIMARY KEY  (`uptransaction_id`)
);


CREATE TABLE `se_semods_userpointearnertypes` (
  `userpointearnertype_id` int(11) NOT NULL auto_increment,
  `userpointearnertype_type` int(11) NOT NULL,
  `userpointearnertype_typename` varchar(50) NOT NULL,
  `userpointearnertype_name` varchar(20) NOT NULL,
  `userpointearnertype_title` varchar(255) NOT NULL,
  PRIMARY KEY  (`userpointearnertype_id`)
);

INSERT INTO `se_semods_userpointearnertypes` (`userpointearnertype_type`, `userpointearnertype_typename`, `userpointearnertype_name`, `userpointearnertype_title`) VALUES (100, 'Affiliate', 'affiliate', 'Affiliate');
INSERT INTO `se_semods_userpointearnertypes` (`userpointearnertype_type`, `userpointearnertype_typename`, `userpointearnertype_name`, `userpointearnertype_title`) VALUES (300, 'Poll vote', 'votepoll', 'Poll vote');
INSERT INTO `se_semods_userpointearnertypes` (`userpointearnertype_type`, `userpointearnertype_typename`, `userpointearnertype_name`, `userpointearnertype_title`) VALUES (400, 'Generic', 'generic', 'Generic');



CREATE TABLE `se_semods_userpointranks` (
  `userpointrank_id` int(11) NOT NULL auto_increment,
  `userpointrank_amount` int(11) NOT NULL,
  `userpointrank_text` varchar(100) NOT NULL,
  PRIMARY KEY  (`userpointrank_id`)
);

INSERT INTO `se_semods_userpointranks` (`userpointrank_id`, `userpointrank_amount`, `userpointrank_text`) VALUES (1, 0, 'Rookie');
INSERT INTO `se_semods_userpointranks` (`userpointrank_id`, `userpointrank_amount`, `userpointrank_text`) VALUES (2, 500, 'Lieutenant');
INSERT INTO `se_semods_userpointranks` (`userpointrank_id`, `userpointrank_amount`, `userpointrank_text`) VALUES (3, 1000, 'Member');
INSERT INTO `se_semods_userpointranks` (`userpointrank_id`, `userpointrank_amount`, `userpointrank_text`) VALUES (4, 2000, 'Advanced Member');
INSERT INTO `se_semods_userpointranks` (`userpointrank_id`, `userpointrank_amount`, `userpointrank_text`) VALUES (5, 10000, 'King');
INSERT INTO `se_semods_userpointranks` (`userpointrank_id`, `userpointrank_amount`, `userpointrank_text`) VALUES (6, 100000, 'Impossible');


CREATE TABLE `se_semods_userpoints` (
  `userpoints_user_id` int(11) NOT NULL,
  `userpoints_count` int(11) NOT NULL default '0',
  `userpoints_totalearned` int(11) NOT NULL default '0',
  `userpoints_totalspent` int(11) NOT NULL default '0',
  PRIMARY KEY  (`userpoints_user_id`),
  KEY `userpoints_totalearned` (`userpoints_totalearned`)
);






CREATE TABLE `se_semods_userpointspendertypes` (
  `userpointspendertype_id` int(11) NOT NULL auto_increment,
  `userpointspendertype_type` int(11) NOT NULL,
  `userpointspendertype_typename` varchar(50) NOT NULL,
  `userpointspendertype_name` varchar(20) NOT NULL,
  `userpointspendertype_title` varchar(255) NOT NULL,
  PRIMARY KEY  (`userpointspendertype_id`),
  KEY `userpointspendertype_type` (`userpointspendertype_type`)
);

INSERT INTO `se_semods_userpointspendertypes` (`userpointspendertype_type`, `userpointspendertype_typename`, `userpointspendertype_name`, `userpointspendertype_title`) VALUES (1, 'Post a Classified listing', 'charge', 'Posting a Classified listing');
INSERT INTO `se_semods_userpointspendertypes` (`userpointspendertype_type`, `userpointspendertype_typename`, `userpointspendertype_name`, `userpointspendertype_title`) VALUES (2, 'Create an Event', 'charge', 'Creating an Event');
INSERT INTO `se_semods_userpointspendertypes` (`userpointspendertype_type`, `userpointspendertype_typename`, `userpointspendertype_name`, `userpointspendertype_title`) VALUES (3, 'Create a Group', 'charge', 'Creating a Group');
INSERT INTO `se_semods_userpointspendertypes` (`userpointspendertype_type`, `userpointspendertype_typename`, `userpointspendertype_name`, `userpointspendertype_title`) VALUES (4, 'Create a Poll', 'charge', 'Creating a Poll');
INSERT INTO `se_semods_userpointspendertypes` (`userpointspendertype_type`, `userpointspendertype_typename`, `userpointspendertype_name`, `userpointspendertype_title`) VALUES (100, 'Profile Promotion', 'promote', 'Promote a Profile');
INSERT INTO `se_semods_userpointspendertypes` (`userpointspendertype_type`, `userpointspendertype_typename`, `userpointspendertype_name`, `userpointspendertype_title`) VALUES (101, 'Classified Promotion', 'promote', 'Promote a Classified');
INSERT INTO `se_semods_userpointspendertypes` (`userpointspendertype_type`, `userpointspendertype_typename`, `userpointspendertype_name`, `userpointspendertype_title`) VALUES (102, 'Event Promotion', 'promote', 'Promote an Event');
INSERT INTO `se_semods_userpointspendertypes` (`userpointspendertype_type`, `userpointspendertype_typename`, `userpointspendertype_name`, `userpointspendertype_title`) VALUES (103, 'Group Promotion', 'promote', 'Promote a Group');
INSERT INTO `se_semods_userpointspendertypes` (`userpointspendertype_type`, `userpointspendertype_typename`, `userpointspendertype_name`, `userpointspendertype_title`) VALUES (104, 'Poll Promotion', 'promote', 'Promote a Poll');
INSERT INTO `se_semods_userpointspendertypes` (`userpointspendertype_type`, `userpointspendertype_typename`, `userpointspendertype_name`, `userpointspendertype_title`) VALUES (200, 'Level Upgrade', 'levelupgrade', 'Level Upgrade');
INSERT INTO `se_semods_userpointspendertypes` (`userpointspendertype_type`, `userpointspendertype_typename`, `userpointspendertype_name`, `userpointspendertype_title`) VALUES (400, 'Generic', 'generic', 'Generic');



CREATE TABLE `se_semods_userpointspender` (
  `userpointspender_id` int(11) NOT NULL auto_increment,
  `userpointspender_type` int(4) NOT NULL default '0',
  `userpointspender_name` varchar(100) NOT NULL,
  `userpointspender_title` varchar(255) NOT NULL,
  `userpointspender_body` text NOT NULL,
  `userpointspender_date` int(4) NOT NULL default '0',
  `userpointspender_photo` varchar(10) default NULL,
  `userpointspender_cost` int(11) NOT NULL default '0',
  `userpointspender_views` int(11) NOT NULL default '0',
  `userpointspender_comments` int(11) NOT NULL default '0',
  `userpointspender_comments_allowed` tinyint(1) NOT NULL default '1',
  `userpointspender_enabled` tinyint(1) NOT NULL default '1',
  `userpointspender_transact_state` int(11) NOT NULL default '0',
  `userpointspender_metadata` text NOT NULL,
  `userpointspender_redirect_on_buy` varchar(255) default NULL,
  `userpointspender_tags` varchar(255) default NULL,
  `userpointspender_engagements` int(11) NOT NULL default '0',
  `userpointspender_levels` text,
  `userpointspender_subnets` text,
  PRIMARY KEY  (`userpointspender_id`),
  KEY `userpointspender_type` (`userpointspender_type`)
);


INSERT INTO `se_semods_userpointspender` (`userpointspender_id`, `userpointspender_type`, `userpointspender_name`, `userpointspender_title`, `userpointspender_body`, `userpointspender_date`, `userpointspender_photo`, `userpointspender_cost`, `userpointspender_views`, `userpointspender_comments`, `userpointspender_comments_allowed`, `userpointspender_enabled`, `userpointspender_transact_state`, `userpointspender_metadata`, `userpointspender_redirect_on_buy`, `userpointspender_tags`, `userpointspender_engagements`, `userpointspender_levels`, `userpointspender_subnets`) VALUES (1, 1, '', 'Post a Classified listing', 'Post a Classified listing', 0, '', 1, 0, 0, 1, 1, 0, '', NULL, NULL, 0, NULL, NULL);
INSERT INTO `se_semods_userpointspender` (`userpointspender_id`, `userpointspender_type`, `userpointspender_name`, `userpointspender_title`, `userpointspender_body`, `userpointspender_date`, `userpointspender_photo`, `userpointspender_cost`, `userpointspender_views`, `userpointspender_comments`, `userpointspender_comments_allowed`, `userpointspender_enabled`, `userpointspender_transact_state`, `userpointspender_metadata`, `userpointspender_redirect_on_buy`, `userpointspender_tags`, `userpointspender_engagements`, `userpointspender_levels`, `userpointspender_subnets`) VALUES (2, 2, '', 'Create an Event', 'Create an Event', 0, '', 1, 0, 0, 1, 1, 0, '', NULL, NULL, 0, NULL, NULL);
INSERT INTO `se_semods_userpointspender` (`userpointspender_id`, `userpointspender_type`, `userpointspender_name`, `userpointspender_title`, `userpointspender_body`, `userpointspender_date`, `userpointspender_photo`, `userpointspender_cost`, `userpointspender_views`, `userpointspender_comments`, `userpointspender_comments_allowed`, `userpointspender_enabled`, `userpointspender_transact_state`, `userpointspender_metadata`, `userpointspender_redirect_on_buy`, `userpointspender_tags`, `userpointspender_engagements`, `userpointspender_levels`, `userpointspender_subnets`) VALUES (3, 3, '', 'Create a Group', 'Create a Group', 0, '', 1, 0, 0, 1, 1, 0, '', NULL, NULL, 0, NULL, NULL);
INSERT INTO `se_semods_userpointspender` (`userpointspender_id`, `userpointspender_type`, `userpointspender_name`, `userpointspender_title`, `userpointspender_body`, `userpointspender_date`, `userpointspender_photo`, `userpointspender_cost`, `userpointspender_views`, `userpointspender_comments`, `userpointspender_comments_allowed`, `userpointspender_enabled`, `userpointspender_transact_state`, `userpointspender_metadata`, `userpointspender_redirect_on_buy`, `userpointspender_tags`, `userpointspender_engagements`, `userpointspender_levels`, `userpointspender_subnets`) VALUES (4, 4, '', 'Create a Poll', 'Create a Poll', 0, '', 1, 0, 0, 1, 1, 0, '', NULL, NULL, 0, NULL, NULL);






CREATE TABLE `se_semods_userpointearner` (
  `userpointearner_id` int(11) NOT NULL auto_increment,
  `userpointearner_type` int(4) NOT NULL default '0',
  `userpointearner_name` varchar(100) NOT NULL,
  `userpointearner_title` varchar(255) NOT NULL,
  `userpointearner_body` text NOT NULL,
  `userpointearner_date` int(4) NOT NULL default '0',
  `userpointearner_photo` varchar(10) default NULL,
  `userpointearner_cost` int(11) NOT NULL default '0',
  `userpointearner_views` int(11) NOT NULL default '0',
  `userpointearner_comments` int(11) NOT NULL default '0',
  `userpointearner_comments_allowed` tinyint(1) NOT NULL default '1',
  `userpointearner_enabled` tinyint(1) NOT NULL default '1',
  `userpointearner_transact_state` int(11) NOT NULL default '0',
  `userpointearner_metadata` text NOT NULL,
  `userpointearner_redirect_on_buy` varchar(255) default NULL,
  `userpointearner_tags` varchar(255) default NULL,
  `userpointearner_field1` int(11) NOT NULL default '0',
  `userpointearner_engagements` int(11) NOT NULL default '0',
  `userpointearner_levels` text NOT NULL,
  `userpointearner_subnets` text NOT NULL,
  PRIMARY KEY  (`userpointearner_id`),
  KEY `userpointearner_field1` (`userpointearner_field1`)
);


# ALTER SE_ADS ENLARGE ad_name 

ALTER TABLE `se_ads` CHANGE `ad_name` `ad_name` VARCHAR( 500 ) NOT NULL;


# PROMOTION TEMPLATE

INSERT INTO `se_ads` (`ad_name`, `ad_date_start`, `ad_date_end`, `ad_paused`, `ad_limit_views`, `ad_limit_clicks`, `ad_limit_ctr`, `ad_public`, `ad_position`, `ad_levels`, `ad_subnets`, `ad_html`, `ad_total_views`, `ad_total_clicks`, `ad_filename`) VALUES ('PROMOTION TEMPLATE FOR PROFILE ON PAGETOP', '1199232000', '0', 1, 0, 0, '0', 1, 'top', ',1,', ',0,', 'HTML Template is specified on the offer edit page.', 0, 0, '');


# SYNC USERS TO POINTS TABLE
INSERT IGNORE INTO se_semods_userpoints (userpoints_user_id) (SELECT user_id FROM se_users);


ALTER TABLE `se_users` ADD `user_userpoints_allowed` BOOL NOT NULL DEFAULT '1';


ALTER TABLE se_levels
  ADD`level_userpoints_allow` tinyint(1) NOT NULL default '1',
  ADD`level_userpoints_allow_transfer` tinyint(1) NOT NULL default '1',
  ADD`level_userpoints_max_transfer` int(11) NOT NULL default '0';


EOC
);

$database->database_query("INSERT INTO `se_semods_userpointearner` (`userpointearner_type`, `userpointearner_name`, `userpointearner_title`, `userpointearner_body`, `userpointearner_date`, `userpointearner_photo`, `userpointearner_cost`, `userpointearner_views`, `userpointearner_comments`, `userpointearner_comments_allowed`, `userpointearner_enabled`, `userpointearner_transact_state`, `userpointearner_metadata`, `userpointearner_redirect_on_buy`, `userpointearner_tags`, `userpointearner_field1`, `userpointearner_engagements`, `userpointearner_levels`, `userpointearner_subnets`) VALUES (100, '', 'Visit SocialEngineMods', 'Visit SocialEngineMods Site for fun and profit.', 1212589472, NULL, 1000, 0, 0, 1, 1, 1, 'a:1:{s:3:\"url\";s:56:\"http://demo.socialenginemods.net/?custom=[transactionid]\";}', NULL, 'affiliate', 0, 1, '', '')");
$database->database_query("INSERT INTO `se_semods_actionpoints` (`action_id`, `action_type`, `action_enabled`, `action_name`, `action_points`, `action_pointsmax`, `action_rolloverperiod`, `action_requiredplugin`, `action_group`) VALUES (105, 'postcomment', 1, 'Comment on someone&#039;s profile', 10, 100, 86400, NULL, 7)");




  //######### CREATE se_semods_settings
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_semods_settings'")) == 0) {
	
    $database->database_query("CREATE TABLE `se_semods_settings` (
		`setting_userpoints_charge_postclassified` tinyint(1) NOT NULL default '0',
		`setting_userpoints_charge_newevent` tinyint(1) NOT NULL default '0',
		`setting_userpoints_charge_newgroup` tinyint(1) NOT NULL default '0',
		`setting_userpoints_charge_newpoll` tinyint(1) NOT NULL default '0',
		`setting_userpoints_enable_activitypoints` tinyint(1) NOT NULL default '1',
		`setting_userpoints_enable_topusers` tinyint(1) NOT NULL default '1',
		`setting_userpoints_enable_pointrank` tinyint(1) NOT NULL default '1',
		`setting_userpoints_exchange_rate` int(11) NOT NULL default '1000'
	  )
	");

    $database->database_query("INSERT INTO `se_semods_settings` (`setting_userpoints_enable_activitypoints`) VALUES (1)");
	
  } else {
	
    $database->database_query("ALTER TABLE `se_semods_settings`
		 ADD `setting_userpoints_charge_postclassified` tinyint(1) NOT NULL default '0',
		 ADD `setting_userpoints_charge_newevent` tinyint(1) NOT NULL default '0',
		 ADD `setting_userpoints_charge_newgroup` tinyint(1) NOT NULL default '0',
		 ADD `setting_userpoints_charge_newpoll` tinyint(1) NOT NULL default '0',
		 ADD `setting_userpoints_enable_activitypoints` tinyint(1) NOT NULL default '1',
		 ADD `setting_userpoints_enable_topusers` tinyint(1) NOT NULL default '1',
		 ADD `setting_userpoints_enable_pointrank` tinyint(1) NOT NULL default '1',
		 ADD `setting_userpoints_exchange_rate` int(11) NOT NULL default '1000'
	");
	
  }

}

?>
