<?

// ENSURE THIS IS BEING INCLUDED IN AN SE SCRIPT
if(!defined('SE_PAGE')) { exit(); }

// INCLUDE FORUMS LANGUAGE FILE
include "../lang/lang_".$global_lang."_forum.php";

// CHECK IF PLUGIN IS ENABLED
if($setting[setting_forum_enabled] == 1) {

  // RESET SETTING FORUM PATH FOR THIS SECTION
  $setting_forum_path = $setting[setting_forum_path];

  if(substr($setting_forum_path, 0, 2) == "./") {
    $setting[setting_forum_path] = ".".$setting_forum_path;
  } else {
    $setting[setting_forum_path] = "../".$setting_forum_path;
  }

  // INCLUDE FORUMS FUNCTION FILE
  if($page != "admin_forum" && file_exists("../include/functions_forum_".$setting[setting_forum_type].".php")) { require_once("../include/functions_forum_".$setting[setting_forum_type].".php"); }

  // SET FORUM PATH BACK TO WHAT IT WAS
  $setting[setting_forum_path] = $setting_forum_path;

}
?>