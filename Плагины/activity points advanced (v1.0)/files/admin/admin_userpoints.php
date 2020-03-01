<?
$page = "admin_userpoints";
include "admin_header.php";

$task = semods::getpost('task', 'main');


// SET RESULT VARIABLE
$result = 0;

// SAVE CHANGES
if($task == "dosave") {

  $setting_userpoints_enable_activitypoints = semods::post('setting_userpoints_enable_activitypoints', 0);
  $setting_userpoints_enable_topusers = semods::post('setting_userpoints_enable_topusers', 0);
  
  $database->database_query("UPDATE se_semods_settings SET 
			setting_userpoints_enable_activitypoints = $setting_userpoints_enable_activitypoints,
            setting_userpoints_enable_topusers = $setting_userpoints_enable_topusers
			");

  $result = 1;

}


// ASSIGN VARIABLES AND SHOW GENERAL SETTINGS PAGE
$smarty->assign('result', $result);
$smarty->assign('error', $error);

$smarty->assign('setting_userpoints_enable_activitypoints', semods::get_setting('userpoints_enable_activitypoints'));
$smarty->assign('setting_userpoints_enable_topusers', semods::get_setting('userpoints_enable_topusers'));

$smarty->display("$page.tpl");
exit();
?>