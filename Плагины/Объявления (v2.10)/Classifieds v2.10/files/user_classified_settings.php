<?
$page = "user_classified_settings";
include "header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }

// ENSURE classifiedS ARE ENABLED FOR THIS USER
if($user->level_info[level_classified_allow] == 0) { header("Location: user_home.php"); exit(); }

// SET VARS
$result = 0;

// SAVE NEW CSS
if($task == "dosave") {
  $style_classified = addslashes(strip_tags(htmlspecialchars_decode($_POST['style_classified'], ENT_QUOTES)));
  $usersetting_notify_classifiedcomment = $_POST['usersetting_notify_classifiedcomment'];
  $database->database_query("UPDATE se_usersettings SET usersetting_notify_classifiedcomment='$usersetting_notify_classifiedcomment' WHERE usersetting_user_id='".$user->user_info[user_id]."'");
  $user->user_lastupdate();
  $user = new se_user(Array($user->user_info[user_id]));
  $result = 1;
}

// ASSIGN USER SETTINGS
$user->user_settings();

// ASSIGN SMARTY VARIABLES AND DISPLAY classified STYLE PAGE
$smarty->assign('result', $result);
include "footer.php";
?>