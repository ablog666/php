<?php

$plugin_name = "Employment Plugin";
$plugin_version = 1.00;
$plugin_type = "employment";
$plugin_desc = "This plugin allows your user to have multiple employment listing on their profile.";
$plugin_icon = "employment16.gif";
$plugin_pages_main = "";//"Global Education Settings<!>admin_employment.php<~!~>";
$plugin_pages_level = "Employment Settings<!>admin_levels_employmentsettings.php<~!~>";
$plugin_url_htaccess = "";

if($install == "employment") {

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
  
  
  //######### CREATE TABLES
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_employments'")) == 0) {
    $database->database_query("CREATE TABLE `se_employments` (
    `employment_id` int(9) NOT NULL auto_increment,
    `employment_user_id` int(9) NOT NULL default '0',
    `employment_employer` varchar(128) NOT NULL default '',
    `employment_position` varchar(128) NOT NULL default '',
    `employment_description` text NOT NULL default '',
    `employment_location` varchar(128) NOT NULL default '',
    `employment_is_current` int(1) NOT NULL default '0',
    `employment_from_month` int(9) NOT NULL default '0',
    `employment_from_year` int(9) NOT NULL default '0',
    `employment_to_month` int(9) NOT NULL default '0',
    `employment_to_year` int(9) NOT NULL default '0',
    PRIMARY KEY  (`employment_id`),
    KEY `INDEX` (`employment_user_id`)
    )");
  }

  //######### ADD COLUMNS/VALUES TO LEVELS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'level_employment_allow'")) == 0) {
    $database->database_query("ALTER TABLE se_levels 
					ADD COLUMN `level_employment_allow` int(1) NOT NULL default '0'");
    $database->database_query("UPDATE se_levels SET level_employment_allow='1'");
  }  
  
}
