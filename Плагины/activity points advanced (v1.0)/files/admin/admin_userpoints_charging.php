<?
$page = "admin_userpoints_charging";
include "admin_header.php";

$task = semods::getpost('task', 'main');
$subject =  semods::post('subject', $admin_userpoints_give[10]);
$message =  semods::post('message', $admin_userpoints_give[11]);

$is_error = 0;
$error_message = '';
$result = 0;

$points = semods::getpost('points',0);

if($task == "dosave") {
  $charge_classified = semods::getpost('charge_classified',0);
  $charge_classified_amount = semods::getpost('charge_classified_amount',0);
  $charge_group = semods::getpost('charge_group',0);
  $charge_group_amount = semods::getpost('charge_group_amount',0);
  $charge_event = semods::getpost('charge_event',0);
  $charge_event_amount = semods::getpost('charge_event_amount',0);
  $charge_poll = semods::getpost('charge_poll',0);
  $charge_poll_amount = semods::getpost('charge_poll_amount',0);
  
  $database->database_query( "UPDATE se_semods_settings SET
							  setting_userpoints_charge_newevent = $charge_event,
							  setting_userpoints_charge_newgroup = $charge_group,
							  setting_userpoints_charge_newpoll = $charge_poll,
							  setting_userpoints_charge_postclassified = $charge_classified" );

  $database->database_query( "UPDATE se_semods_userpointspender SET userpointspender_cost = $charge_classified_amount WHERE userpointspender_type = 1" );
  $database->database_query( "UPDATE se_semods_userpointspender SET userpointspender_cost = $charge_event_amount WHERE userpointspender_type = 2" );
  $database->database_query( "UPDATE se_semods_userpointspender SET userpointspender_cost = $charge_group_amount WHERE userpointspender_type = 3" );
  $database->database_query( "UPDATE se_semods_userpointspender SET userpointspender_cost = $charge_poll_amount WHERE userpointspender_type = 4" );
  
 
  if($is_error == 0) {
	$result = 1;
  }
  
}

// Get costs in one row, hacky stuff
$costs = explode( ',', semods::db_query_count("SELECT GROUP_CONCAT(userpointspender_cost) FROM ( SELECT userpointspender_cost FROM se_semods_userpointspender WHERE userpointspender_type IN (1,2,3,4) ORDER BY userpointspender_type ASC) AS costs") );

list( $charge_classified_amount, $charge_event_amount, $charge_group_amount, $charge_poll_amount ) = $costs;

$charge_classified = semods::get_setting('userpoints_charge_postclassified');
$charge_group = semods::get_setting('userpoints_charge_newgroup');
$charge_event = semods::get_setting('userpoints_charge_newevent');
$charge_poll = semods::get_setting('userpoints_charge_newpoll');


// ASSIGN VARIABLES AND SHOW PAGE
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('result', $result);

$smarty->assign('charge_classified', $charge_classified);
$smarty->assign('charge_group', $charge_group);
$smarty->assign('charge_event', $charge_event);
$smarty->assign('charge_poll', $charge_poll);

$smarty->assign('charge_classified_amount', $charge_classified_amount);
$smarty->assign('charge_group_amount', $charge_group_amount);
$smarty->assign('charge_event_amount', $charge_event_amount);
$smarty->assign('charge_poll_amount', $charge_poll_amount);

$smarty->display("$page.tpl");
exit();
?>