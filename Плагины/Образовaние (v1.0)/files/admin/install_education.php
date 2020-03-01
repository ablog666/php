<?php

$plugin_name = "Education Plugin";
$plugin_version = 1.00;
$plugin_type = "education";
$plugin_desc = "This plugin allows your user to have multiple education listing on their profile.";
$plugin_icon = "education16.gif";
$plugin_pages_main = "";//"Global Education Settings<!>admin_education.php<~!~>";
$plugin_pages_level = "Education Settings<!>admin_levels_educationsettings.php<~!~>";
$plugin_url_htaccess = "";

if($install == "education") {

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
  if($database->database_num_rows($database->database_query("SHOW TABLES FROM `$database_name` LIKE 'se_educations'")) == 0) {
    $database->database_query("CREATE TABLE `se_educations` (
    `education_id` int(9) NOT NULL auto_increment,
    `education_user_id` int(9) NOT NULL default '0',
    `education_name` varchar(128) NOT NULL default '',
    `education_year` varchar(128) NOT NULL default '',
    `education_for` varchar(128) NOT NULL default '',
    `education_degree` varchar(128) NOT NULL default '',
    `education_concentration1` varchar(128) NOT NULL default '',
    `education_concentration2` varchar(128) NOT NULL default '',
    `education_concentration3` varchar(128) NOT NULL default '',
    PRIMARY KEY  (`education_id`),
    KEY `INDEX` (`education_user_id`)
    )");
  }
  
  //######### ADD COLUMNS/VALUES TO LEVELS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_levels LIKE 'level_education_allow'")) == 0) {
    $database->database_query("ALTER TABLE se_levels 
					ADD COLUMN `level_education_allow` int(1) NOT NULL default '0'");
    $database->database_query("UPDATE se_levels SET level_education_allow='1'");
  }
  
}
