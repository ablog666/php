<?
$page = "admin_giftsset";
include "admin_header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }


// SET RESULT VARIABLE
$result = 0;


// SAVE CHANGES
if($task == "dosave") {
  $setting_email_gifts_subject = $_POST['setting_email_gifts_subject'];
  $setting_email_gifts_message = $_POST['setting_email_gifts_message'];

  $database->database_query("UPDATE se_settings SET 
			setting_email_gifts_subject='$setting_email_gifts_subject',
			setting_email_gifts_message='$setting_email_gifts_message'");

  $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_settings LIMIT 1"));
  $result = 1;
}


// ASSIGN VARIABLES AND SHOW GENERAL SETTINGS PAGE
$smarty->assign('result', $result);
$smarty->assign('setting_email_gifts_subject', $setting[setting_email_gifts_subject]);
$smarty->assign('setting_email_gifts_message', $setting[setting_email_gifts_message]);
$smarty->display("$page.tpl");
exit();
?>