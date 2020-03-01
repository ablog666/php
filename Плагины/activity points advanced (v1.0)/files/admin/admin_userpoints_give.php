<?
$page = "admin_userpoints_give";
include "admin_header.php";

$task = semods::getpost('task', 'main');
$subject =  semods::post('subject', $admin_userpoints_give[10]);
$message =  semods::post('message', $admin_userpoints_give[11]);

$is_error = 0;
$error_message = '';
$result = 0;

$points = semods::getpost('points',0);

if($task == "dogivepoints") {
  $sendto_type = semods::getpost('sendtotype',0);
  $level_id = semods::getpost('level',0); 
  $subnet_id = semods::getpost('subnet',0);
  $username = semods::getpost('username',0);
  $send_message = semods::getpost('send_message',0);
  $subject = semods::getpost('subject',0);
  $message = semods::getpost('message',0);
  
  $admin_user = new se_user();
  $admin_user->user_info['user_id'] = 0;
  
  switch($sendto_type) {
	
	// All users .. 
	// would be great to just inc all pointscoint, but there are some that have no rows
	case 0:
	  ignore_user_abort( true );
	  set_time_limit( 0 );

	  $sql = "
		SELECT
		  se_users.user_id,
		  se_users.user_username,
		  se_levels.level_message_allow
		FROM
		  se_users
		LEFT JOIN
		  se_levels
		  ON se_users.user_level_id = se_levels.level_id";
	  
	  $rows = $database->database_query( $sql );
	  while($row = $database->database_fetch_assoc($rows)) {
		userpoints_add( $row['user_id'], $points );
		if($send_message && ($row['level_message_allow'] != 0)) 
		  $admin_user->user_message_send( $row['user_username'], $subject, $message );
	  }
	  
	  break;


	
	// All users on level.. 
	case 1:
	  ignore_user_abort( true );
	  set_time_limit( 0 );
	  
	  $sql = "
		SELECT
		  se_users.user_id,
		  se_users.user_username,
		  se_levels.level_message_allow
		FROM
		  se_users
		LEFT JOIN
		  se_levels
		  ON se_users.user_level_id = se_levels.level_id
		WHERE se_users.user_level_id = $level_id";
	  
	  $rows = $database->database_query( $sql );
	  while($row = $database->database_fetch_assoc($rows)) {
		userpoints_add( $row['user_id'], $points );
		if($send_message && ($row['level_message_allow'] != 0)) 
		  $admin_user->user_message_send( $row['user_username'], $subject, $message );
	  }

	  break;


	
	// All users on subnet.. 
	case 2:
	  ignore_user_abort( true );
	  set_time_limit( 0 );

	  $sql = "
		SELECT
		  se_users.user_id,
		  se_users.user_username,
		  se_levels.level_message_allow
		FROM
		  se_users
		LEFT JOIN
		  se_levels
		  ON se_users.user_level_id = se_levels.level_id
		WHERE se_users.user_subnet_id = $subnet_id";
	  
	  $rows = $database->database_query( $sql );
	  while($row = $database->database_fetch_assoc($rows)) {
		//echo $row['user_username'];
		userpoints_add( $row['user_id'], $points );
		if($send_message && ($row['level_message_allow'] != 0)) {
		  $admin_user->user_message_send( $row['user_username'], $subject, $message );
		}
	  }
	  break;
	
  
  
	// Specific user
	case 3:
	  $happy_user = new se_user( array( 0, $username) );
	  if($happy_user->user_exists == 0) {
		$is_error = 1;
		$error_message = $admin_userpoints_give[12];
	  } else {
		userpoints_add( $happy_user->user_info['user_id'], $points );

		if($send_message && ($happy_user->level_info['level_message_allow'] != 0)) {
		  $admin_user->user_message_send( $happy_user->user_info['user_username'], $subject, $message );
		}
	  }
	  break;
	  
  }
  
  if($is_error == 0) {
	$result = 1;
  }
  

}


// LOOP OVER USER LEVELS
$levels = $database->database_query("SELECT level_id, level_name FROM se_levels ORDER BY level_name");
while($level_info = $database->database_fetch_assoc($levels)) {
  $level_array[$level_info['level_id']] = $level_info['level_name'];
}


// LOOP OVER SUBNETWORKS
$subnets = $database->database_query("SELECT subnet_id, subnet_name FROM se_subnets ORDER BY subnet_name");
$subnet_array[0] = "Default"; // $admin_voter_viewusers[26];
while($subnet_info = $database->database_fetch_assoc($subnets)) {
  $subnet_array[$subnet_info['subnet_id']] = $subnet_info['subnet_name'];
}



// ASSIGN VARIABLES AND SHOW PAGE

$smarty->assign('levels', $level_array);
$smarty->assign('subnets', $subnet_array);

$smarty->assign('subject', $subject);
$smarty->assign('message', $message);
$smarty->assign('send_message', $send_message);
$smarty->assign('points', $points);

$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('result', $result);

$smarty->display("$page.tpl");
exit();
?>