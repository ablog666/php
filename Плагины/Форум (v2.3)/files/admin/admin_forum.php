<?
$page = "admin_forum";
include "admin_header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }


// SET RESULT VARIABLE
$result = 0;


// ATTEMPT TO DETECT FORUM BASED ON SETTINGS
$forum_detected = 0;
if($task == "dosave") { $setting_forum_type = $_POST['setting_forum_type']; } else { $setting_forum_type = $setting[setting_forum_type]; }
if($task == "dosave") { $setting_forum_path = $_POST['setting_forum_path']; } else { $setting_forum_path = $setting[setting_forum_path]; }
if($setting_forum_type != "0") {
  if((require_once("../include/functions_forum_".$setting_forum_type.".php"))) {
    if(detect_forum($setting_forum_path)) { $forum_detected = 1; }
  }
}


// SAVE CHANGES
if($task == "dosave") {
  $database->database_query("UPDATE se_settings SET 
			setting_forum_enabled='$forum_detected',
			setting_forum_path='$setting_forum_path',
			setting_forum_type='$setting_forum_type'");

  $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_settings LIMIT 1"));
  $result = 1;
}


// ASSIGN VARIABLES AND SHOW GENERAL SETTINGS PAGE
$smarty->assign('result', $result);
$smarty->assign('forum_detected', $forum_detected);
$smarty->assign('setting_forum_path', $setting[setting_forum_path]);
$smarty->assign('setting_forum_type', $setting[setting_forum_type]);
$smarty->display("$page.tpl");
exit();
?>