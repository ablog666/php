<?

// ENSURE THIS IS BEING INCLUDED IN AN SE SCRIPT
if(!defined('SE_PAGE')) { exit(); }

// CHECK IF PLUGIN IS ENABLED
if($setting[setting_forum_enabled] == 1) {

  // INCLUDE FORUMS FUNCTION FILE AND DETECT FORUM
  if(file_exists("./include/functions_forum_".$setting[setting_forum_type].".php")) {
    include "./include/functions_forum_".$setting[setting_forum_type].".php";
    $forum_path = strrev(str_replace(strstr(strrev(str_replace("/header_forum.php", "", __FILE__)), "/"), "", strrev(str_replace("/header_forum.php", "", __FILE__))));
    if(!detect_forum($forum_path."/".$setting[setting_forum_path])) {
      $database->database_query("UPDATE se_settings SET setting_forum_enabled='0'");
      $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_settings LIMIT 1"));
    }
  }

  // CHECK IF PLUGIN IS STILL ENABLED
  if($setting[setting_forum_enabled] == 1) {

    // INCLUDE FORUMS LANGUAGE FILE
    include "./lang/lang_".$global_lang."_forum.php";

    // INCLUDE FORUMS CLASS FILE
    if(file_exists("./include/class_forum_".$setting[setting_forum_type].".php")) {
      include "./include/class_forum_".$setting[setting_forum_type].".php";

      // INITIALIZE FORUM OBJECT
      $forum = new se_forum($user);
    }

    switch($page) {
      // CODE FOR USER LOGOUT PAGE
      case "user_logout":
	if(is_object($forum)) { $forum->forum_logout(); }
	break;
    }
  }
}

?>