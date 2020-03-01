<?

// ENSURE THIS IS BEING INCLUDED IN AN SE SCRIPT
if(!defined('SE_PAGE')) { exit(); }

$plugin_name = "Forum Plugin";
$plugin_version = 2.30;
$plugin_type = "forum";
$plugin_desc = "This plugin integrates a newly-installed vBulletin or phpBB forum with SocialEngine. After installation, be sure to visit the Global Forum Settings to input the path to your message board.";
$plugin_icon = "forum16.gif";
$plugin_pages_main = "Global Forum Settings<!>admin_forum.php<~!~>";
$plugin_pages_level = "";
$plugin_url_htaccess = "";

if($install == "forum") {

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


  //######### ADD COLUMNS/VALUES TO SETTINGS TABLE
  if($database->database_num_rows($database->database_query("SHOW COLUMNS FROM ".$database_name.".se_settings LIKE 'setting_forum_enabled'")) == 0) {
    $database->database_query("ALTER TABLE se_settings 
					ADD COLUMN `setting_forum_enabled` int(1) NOT NULL default '0',
					ADD COLUMN `setting_forum_path` varchar(100) NOT NULL default '',
					ADD COLUMN `setting_forum_type` varchar(100) NOT NULL default '0'");
  }


}  

?>