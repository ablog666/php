<?
$page = "admin_levels_classifiedsettings";
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
  $level_classified_allow = $_POST['level_classified_allow'];
  $level_classified_entries = $_POST['level_classified_entries'];
  $level_classified_search = $_POST['level_classified_search'];
  $level_classified_photo = $_POST['level_classified_photo'];
  $level_classified_photo_width = $_POST['level_classified_photo_width'];
  $level_classified_photo_height = $_POST['level_classified_photo_height'];
  $level_classified_photo_exts = str_replace(", ", ",", $_POST['level_classified_photo_exts']);
  $level_classified_album_exts = str_replace(", ", ",", $_POST['level_classified_album_exts']);
  $level_classified_album_mimes = str_replace(", ", ",", $_POST['level_classified_album_mimes']);
  $level_classified_album_storage = $_POST['level_classified_album_storage'];
  $level_classified_album_maxsize = $_POST['level_classified_album_maxsize'];
  $level_classified_album_width = $_POST['level_classified_album_width'];
  $level_classified_album_height = $_POST['level_classified_album_height'];

  // GET classified PRIVACY SETTING
  $classified_privacy_0 = $_POST['classified_privacy_0'];
  $classified_privacy_1 = $_POST['classified_privacy_1'];
  $classified_privacy_2 = $_POST['classified_privacy_2'];
  $classified_privacy_3 = $_POST['classified_privacy_3'];
  $classified_privacy_4 = $_POST['classified_privacy_4'];
  $classified_privacy_5 = $_POST['classified_privacy_5'];
  $level_classified_privacy = $classified_privacy_0.$classified_privacy_1.$classified_privacy_2.$classified_privacy_3.$classified_privacy_4.$classified_privacy_5;

  // GET classified COMMENT SETTING
  $classified_comments_0 = $_POST['classified_comments_0'];
  $classified_comments_1 = $_POST['classified_comments_1'];
  $classified_comments_2 = $_POST['classified_comments_2'];
  $classified_comments_3 = $_POST['classified_comments_3'];
  $classified_comments_4 = $_POST['classified_comments_4'];
  $classified_comments_5 = $_POST['classified_comments_5'];
  $classified_comments_6 = $_POST['classified_comments_6'];
  $level_classified_comments = $classified_comments_0.$classified_comments_1.$classified_comments_2.$classified_comments_3.$classified_comments_4.$classified_comments_5.$classified_comments_6;

  // CHECK THAT A NUMBER BETWEEN 1 AND 999 WAS ENTERED FOR classified ENTRIES
  if(!is_numeric($level_classified_entries) OR $level_classified_entries < 1 OR $level_classified_entries > 999) {
    $is_error = 1;
    $error_message = $admin_levels_classifiedsettings[8];
  }

  // CHECK THAT A NUMBER BETWEEN 1 AND 999 WAS ENTERED FOR WIDTH AND HEIGHT
  if(!is_numeric($level_classified_photo_width) OR !is_numeric($level_classified_photo_height) OR $level_classified_photo_width < 1 OR $level_classified_photo_height < 1 OR $level_classified_photo_width > 999 OR $level_classified_photo_height > 999) {
    $is_error = 1;
    $error_message = $admin_levels_classifiedsettings[13];
  }

  // CHECK THAT A NUMBER BETWEEN 1 AND 204800 (200MB) WAS ENTERED FOR MAXSIZE
  if(!is_numeric($level_classified_album_maxsize) OR $level_classified_album_maxsize < 1 OR $level_classified_album_maxsize > 204800) {
    $is_error = 1;
    $error_message = $admin_levels_classifiedsettings[14];
  }

  // CHECK THAT WIDTH AND HEIGHT ARE NUMBERS
  if(!is_numeric($level_classified_album_width) OR !is_numeric($level_classified_album_height)) {
    $is_error = 1;
    $error_message = $admin_levels_classifiedsettings[15];
  }


  if($is_error == 0) {

    // SAVE SETTINGS
    $level_classified_album_maxsize = $level_classified_album_maxsize*1024;
    $database->database_query("UPDATE se_levels SET 
			level_classified_search='$level_classified_search',
			level_classified_privacy='$level_classified_privacy',
			level_classified_comments='$level_classified_comments',
			level_classified_allow='$level_classified_allow',
			level_classified_entries='$level_classified_entries',
			level_classified_photo='$level_classified_photo',
			level_classified_photo_width='$level_classified_photo_width',
			level_classified_photo_height='$level_classified_photo_height',
			level_classified_photo_exts='$level_classified_photo_exts',
			level_classified_album_exts='$level_classified_album_exts',
			level_classified_album_mimes='$level_classified_album_mimes',
			level_classified_album_storage='$level_classified_album_storage',
			level_classified_album_maxsize='$level_classified_album_maxsize',
			level_classified_album_width='$level_classified_album_width',
			level_classified_album_height='$level_classified_album_height' WHERE level_id='$level_id'");
    if($level_classified_search == 0) { $database->database_query("UPDATE se_classifieds, se_users SET se_classifieds.classified_search='1' WHERE se_users.user_level_id='$level_id' AND se_classifieds.classified_user_id=se_users.user_id"); }
    $level_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_levels WHERE level_id='$level_id'"));
    $result = 1;

  }

}


// ADD SPACES BACK AFTER COMMAS
$level_classified_photo_exts = str_replace(",", ", ", $level_info[level_classified_photo_exts]);
$level_classified_album_exts = str_replace(",", ", ", $level_info[level_classified_album_exts]);
$level_classified_album_mimes = str_replace(",", ", ", $level_info[level_classified_album_mimes]);
$level_classified_album_maxsize = $level_info[level_classified_album_maxsize]/1024;


// GET PREVIOUS classified PRIVACY SETTING
$count = 0;
while($count < 6) {
  if(user_privacy_levels($count) != "") {
    if(strpos($level_info[level_classified_privacy], "$count") !== FALSE) { $privacy_selected = 1; } else { $privacy_selected = 0; }
    $privacy_options[$count] = Array('privacy_name' => "classified_privacy_".$count,
				'privacy_value' => $count,
				'privacy_option' => user_privacy_levels($count),
				'privacy_selected' => $privacy_selected);
  }
  $count++;
}
$count = 0;
while($count < 10) {
  if(user_privacy_levels($count) != "") {
    if(strpos($level_info[level_classified_comments], "$count") !== FALSE) { $comment_selected = 1; } else { $comment_selected = 0; }
    $comment_options[$count] = Array('comment_name' => "classified_comments_".$count,
				'comment_value' => $count,
				'comment_option' => user_privacy_levels($count),
				'comment_selected' => $comment_selected);
  }
  $count++;
}




// ASSIGN VARIABLES AND SHOW classified SETTINGS PAGE
$smarty->assign('result', $result);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('level_id', $level_info[level_id]);
$smarty->assign('level_name', $level_info[level_name]);
$smarty->assign('classified_allow', $level_info[level_classified_allow]);
$smarty->assign('entries_value', $level_info[level_classified_entries]);
$smarty->assign('classified_photo', $level_info[level_classified_photo]);
$smarty->assign('classified_photo_width', $level_info[level_classified_photo_width]);
$smarty->assign('classified_photo_height', $level_info[level_classified_photo_height]);
$smarty->assign('classified_photo_exts', $level_classified_photo_exts);
$smarty->assign('classified_album_exts', $level_classified_album_exts);
$smarty->assign('classified_album_mimes', $level_classified_album_mimes);
$smarty->assign('classified_album_storage', $level_info[level_classified_album_storage]);
$smarty->assign('classified_album_maxsize', $level_classified_album_maxsize);
$smarty->assign('classified_album_width', $level_info[level_classified_album_width]);
$smarty->assign('classified_album_height', $level_info[level_classified_album_height]);
$smarty->assign('classified_search', $level_info[level_classified_search]);
$smarty->assign('classified_privacy', $privacy_options);
$smarty->assign('classified_comments', $comment_options);
$smarty->display("$page.tpl");
exit();
?>