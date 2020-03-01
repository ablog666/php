<?
$page = "admin_levels_eventsettings";
include "admin_header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }
if(isset($_POST['level_id'])) { $level_id = $_POST['level_id']; } elseif(isset($_GET['level_id'])) { $level_id = $_GET['level_id']; } else { $level_id = 0; }

// VALIDATE LEVEL ID
$level = $database->database_query("SELECT * FROM se_levels WHERE level_id='$level_id'");
if($database->database_num_rows($level) != 1) { 
  header("Location: admin_levels.php");
  exit();
}
$level_info = $database->database_fetch_assoc($level);


// SET RESULT AND ERROR VARS
$result = 0;
$is_error = 0;




// SAVE CHANGES
if($task == "dosave") {
  $level_event_allow = $_POST['level_event_allow'];
  $level_event_photo = $_POST['level_event_photo'];
  $level_event_photo_width = $_POST['level_event_photo_width'];
  $level_event_photo_height = $_POST['level_event_photo_height'];
  $level_event_photo_exts = str_replace(", ", ",", $_POST['level_event_photo_exts']);
  $level_event_inviteonly = $_POST['level_event_inviteonly'];
  $level_event_style = $_POST['level_event_style'];
  $level_event_album_exts = str_replace(", ", ",", $_POST['level_event_album_exts']);
  $level_event_album_mimes = str_replace(", ", ",", $_POST['level_event_album_mimes']);
  $level_event_album_storage = $_POST['level_event_album_storage'];
  $level_event_album_maxsize = $_POST['level_event_album_maxsize'];
  $level_event_album_width = $_POST['level_event_album_width'];
  $level_event_album_height = $_POST['level_event_album_height'];
  $level_event_search = $_POST['level_event_search'];

  // GET EVENT PRIVACY SETTING
  $event_privacy_0 = $_POST['event_privacy_0'];
  $event_privacy_1 = $_POST['event_privacy_1'];
  $event_privacy_2 = $_POST['event_privacy_2'];
  $event_privacy_3 = $_POST['event_privacy_3'];
  $event_privacy_4 = $_POST['event_privacy_4'];
  $event_privacy_5 = $_POST['event_privacy_5'];
  $level_event_privacy = $event_privacy_0.$event_privacy_1.$event_privacy_2.$event_privacy_3.$event_privacy_4.$event_privacy_5;

  // GET EVENT COMMENTS SETTING
  $event_comments_0 = $_POST['event_comments_0'];
  $event_comments_1 = $_POST['event_comments_1'];
  $event_comments_2 = $_POST['event_comments_2'];
  $event_comments_3 = $_POST['event_comments_3'];
  $event_comments_4 = $_POST['event_comments_4'];
  $event_comments_5 = $_POST['event_comments_5'];
  $event_comments_6 = $_POST['event_comments_6'];
  $event_comments_7 = $_POST['event_comments_7'];
  $level_event_comments = $event_comments_0.$event_comments_1.$event_comments_2.$event_comments_3.$event_comments_4.$event_comments_5.$event_comments_6.$event_comments_7;

  // CHECK THAT A NUMBER BETWEEN 1 AND 999 WAS ENTERED FOR WIDTH AND HEIGHT
  if(!is_numeric($level_event_photo_width) OR !is_numeric($level_event_photo_height) OR $level_event_photo_width < 1 OR $level_event_photo_height < 1 OR $level_event_photo_width > 999 OR $level_event_photo_height > 999) {
    $is_error = 1;
    $error_message = $admin_levels_eventsettings[48];
  }

  // CHECK THAT A NUMBER BETWEEN 1 AND 204800 (200MB) WAS ENTERED FOR MAXSIZE
  if(!is_numeric($level_event_album_maxsize) OR $level_event_album_maxsize < 1 OR $level_event_album_maxsize > 204800) {
    $is_error = 1;
    $error_message = $admin_levels_eventsettings[49];
  }

  // CHECK THAT WIDTH AND HEIGHT ARE NUMBERS
  if(!is_numeric($level_event_album_width) OR !is_numeric($level_event_album_height)) {
    $is_error = 1;
    $error_message = $admin_levels_eventsettings[50];
  }

  // IF THERE WERE NO ERRORS, SAVE CHANGES
  if($is_error == 0) {

    // SAVE OTHER SETTINGS
    $level_event_album_maxsize = $level_event_album_maxsize*1024;
    $database->database_query("UPDATE se_levels SET 
			level_event_search='$level_event_search',
			level_event_comments='$level_event_comments',
			level_event_privacy='$level_event_privacy',
			level_event_allow='$level_event_allow',
			level_event_photo='$level_event_photo',
			level_event_photo_width='$level_event_photo_width',
			level_event_photo_height='$level_event_photo_height',
			level_event_photo_exts='$level_event_photo_exts',
			level_event_inviteonly='$level_event_inviteonly',
			level_event_style='$level_event_style',
			level_event_album_exts='$level_event_album_exts',
			level_event_album_mimes='$level_event_album_mimes',
			level_event_album_storage='$level_event_album_storage',
			level_event_album_maxsize='$level_event_album_maxsize',
			level_event_album_width='$level_event_album_width',
			level_event_album_height='$level_event_album_height' WHERE level_id='$level_info[level_id]'");
    if($level_event_search == 0) { $database->database_query("UPDATE se_events, se_users SET event_search='1' WHERE se_users.user_level_id='$level_info[level_id]' AND se_events.event_user_id=se_users.user_id"); }
    $level_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_levels WHERE level_id='$level_info[level_id]'"));
    $result = 1;
  }
}








// ADD SPACES BACK AFTER COMMAS
$level_event_photo_exts = str_replace(",", ", ", $level_info[level_event_photo_exts]);
$level_event_album_exts = str_replace(",", ", ", $level_info[level_event_album_exts]);
$level_event_album_mimes = str_replace(",", ", ", $level_info[level_event_album_mimes]);
$level_event_album_maxsize = $level_info[level_event_album_maxsize]/1024;

// GET CURRENT EVENT PRIVACY SETTING
$count = 0;
while($count < 6) {
  if(event_privacy_levels($count) != "") {
    if(strpos($level_info[level_event_privacy], "$count") !== FALSE) { $privacy_selected = 1; } else { $privacy_selected = 0; }
    $privacy_options[$count] = Array('privacy_name' => "event_privacy_".$count,
				'privacy_value' => $count,
				'privacy_option' => event_privacy_levels($count),
				'privacy_selected' => $privacy_selected);
  }
  $count++;
}
$count = 0;
while($count < 10) {
  if(event_privacy_levels($count) != "") {
    if(strpos($level_info[level_event_comments], "$count") !== FALSE) { $comment_selected = 1; } else { $comment_selected = 0; }
    $comment_options[$count] = Array('comment_name' => "event_comments_".$count,
				'comment_value' => $count,
				'comment_option' => event_privacy_levels($count),
				'comment_selected' => $comment_selected);
  }
  $count++;
}





// ASSIGN VARIABLES AND SHOW USER EVENTS PAGE
$smarty->assign('level_id', $level_info[level_id]);
$smarty->assign('level_name', $level_info[level_name]);
$smarty->assign('result', $result);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('event_allow', $level_info[level_event_allow]);
$smarty->assign('event_photo', $level_info[level_event_photo]);
$smarty->assign('event_photo_width', $level_info[level_event_photo_width]);
$smarty->assign('event_photo_height', $level_info[level_event_photo_height]);
$smarty->assign('event_photo_exts', $level_event_photo_exts);
$smarty->assign('event_inviteonly', $level_info[level_event_inviteonly]);
$smarty->assign('event_style', $level_info[level_event_style]);
$smarty->assign('event_album_exts', $level_event_album_exts);
$smarty->assign('event_album_mimes', $level_event_album_mimes);
$smarty->assign('event_album_storage', $level_info[level_event_album_storage]);
$smarty->assign('event_album_maxsize', $level_event_album_maxsize);
$smarty->assign('event_album_width', $level_info[level_event_album_width]);
$smarty->assign('event_album_height', $level_info[level_event_album_height]);
$smarty->assign('event_search', $level_info[level_event_search]);
$smarty->assign('event_privacy', $privacy_options);
$smarty->assign('event_comments', $comment_options);
$smarty->display("$page.tpl");
exit();
?>