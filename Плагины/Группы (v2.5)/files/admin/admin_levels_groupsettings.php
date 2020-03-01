<?
$page = "admin_levels_groupsettings";
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
  $level_group_allow = $_POST['level_group_allow'];
  $level_group_photo = $_POST['level_group_photo'];
  $level_group_photo_width = $_POST['level_group_photo_width'];
  $level_group_photo_height = $_POST['level_group_photo_height'];
  $level_group_photo_exts = str_replace(", ", ",", $_POST['level_group_photo_exts']);
  $level_group_titles = $_POST['level_group_titles'];
  $level_group_officers = $_POST['level_group_officers'];
  $level_group_approval = $_POST['level_group_approval'];
  $level_group_style = $_POST['level_group_style'];
  $level_group_album_exts = str_replace(", ", ",", $_POST['level_group_album_exts']);
  $level_group_album_mimes = str_replace(", ", ",", $_POST['level_group_album_mimes']);
  $level_group_album_storage = $_POST['level_group_album_storage'];
  $level_group_album_maxsize = $_POST['level_group_album_maxsize'];
  $level_group_album_width = $_POST['level_group_album_width'];
  $level_group_album_height = $_POST['level_group_album_height'];
  $level_group_maxnum = $_POST['level_group_maxnum'];
  $level_group_search = $_POST['level_group_search'];

  // GET GROUP PRIVACY SETTING
  $group_privacy_0 = $_POST['group_privacy_0'];
  $group_privacy_1 = $_POST['group_privacy_1'];
  $group_privacy_2 = $_POST['group_privacy_2'];
  $group_privacy_3 = $_POST['group_privacy_3'];
  $group_privacy_4 = $_POST['group_privacy_4'];
  $group_privacy_5 = $_POST['group_privacy_5'];
  $level_group_privacy = $group_privacy_0.$group_privacy_1.$group_privacy_2.$group_privacy_3.$group_privacy_4.$group_privacy_5;

  // GET GROUP COMMENTS SETTING
  $group_comments_0 = $_POST['group_comments_0'];
  $group_comments_1 = $_POST['group_comments_1'];
  $group_comments_2 = $_POST['group_comments_2'];
  $group_comments_3 = $_POST['group_comments_3'];
  $group_comments_4 = $_POST['group_comments_4'];
  $group_comments_5 = $_POST['group_comments_5'];
  $group_comments_6 = $_POST['group_comments_6'];
  $group_comments_7 = $_POST['group_comments_7'];
  $level_group_comments = $group_comments_0.$group_comments_1.$group_comments_2.$group_comments_3.$group_comments_4.$group_comments_5.$group_comments_6.$group_comments_7;

  // GET GROUP DISCUSSION SETTING
  $group_discussion_0 = $_POST['group_discussion_0'];
  $group_discussion_1 = $_POST['group_discussion_1'];
  $group_discussion_2 = $_POST['group_discussion_2'];
  $group_discussion_3 = $_POST['group_discussion_3'];
  $group_discussion_4 = $_POST['group_discussion_4'];
  $group_discussion_5 = $_POST['group_discussion_5'];
  $group_discussion_6 = $_POST['group_discussion_6'];
  $group_discussion_7 = $_POST['group_discussion_7'];
  $level_group_discussion = $group_discussion_0.$group_discussion_1.$group_discussion_2.$group_discussion_3.$group_discussion_4.$group_discussion_5.$group_discussion_6.$group_discussion_7;

  // CHECK THAT A NUMBER BETWEEN 1 AND 999 WAS ENTERED FOR WIDTH AND HEIGHT
  if(!is_numeric($level_group_photo_width) OR !is_numeric($level_group_photo_height) OR $level_group_photo_width < 1 OR $level_group_photo_height < 1 OR $level_group_photo_width > 999 OR $level_group_photo_height > 999) {
    $is_error = 1;
    $error_message = $admin_levels_groupsettings[48];
  }

  // CHECK THAT A NUMBER BETWEEN 1 AND 204800 (200MB) WAS ENTERED FOR MAXSIZE
  if(!is_numeric($level_group_album_maxsize) OR $level_group_album_maxsize < 1 OR $level_group_album_maxsize > 204800) {
    $is_error = 1;
    $error_message = $admin_levels_groupsettings[49];
  }

  // CHECK THAT WIDTH AND HEIGHT ARE NUMBERS
  if(!is_numeric($level_group_album_width) OR !is_numeric($level_group_album_height)) {
    $is_error = 1;
    $error_message = $admin_levels_groupsettings[50];
  }

  // CHECK THAT MAX ALBUMS IS A NUMBER
  if(!is_numeric($level_group_maxnum) OR $level_group_maxnum < 1 OR $level_group_maxnum > 999) {
    $is_error = 1;
    $error_message = $admin_levels_groupsettings[51];
  }

  // IF THERE WERE NO ERRORS, SAVE CHANGES
  if($is_error == 0) {

    // IF ALLOW OFFICERS WAS SET FROM YES TO NO, DEMOTE ALL OFFICERS TO MEMBERS
    if($level_group_officers == 0 AND $level_info[level_group_officers] == 1) {
      $database->database_query("UPDATE se_groupmembers SET groupmember_rank='0' WHERE groupmember_rank='1'");
    }

    // SAVE OTHER SETTINGS
    $level_group_album_maxsize = $level_group_album_maxsize*1024;
    $database->database_query("UPDATE se_levels SET 
			level_group_search='$level_group_search',
			level_group_discussion='$level_group_discussion',
			level_group_comments='$level_group_comments',
			level_group_privacy='$level_group_privacy',
			level_group_allow='$level_group_allow',
			level_group_photo='$level_group_photo',
			level_group_photo_width='$level_group_photo_width',
			level_group_photo_height='$level_group_photo_height',
			level_group_photo_exts='$level_group_photo_exts',
			level_group_titles='$level_group_titles',
			level_group_officers='$level_group_officers',
			level_group_approval='$level_group_approval',
			level_group_style='$level_group_style',
			level_group_album_exts='$level_group_album_exts',
			level_group_album_mimes='$level_group_album_mimes',
			level_group_album_storage='$level_group_album_storage',
			level_group_album_maxsize='$level_group_album_maxsize',
			level_group_album_width='$level_group_album_width',
			level_group_album_height='$level_group_album_height',
			level_group_maxnum='$level_group_maxnum' WHERE level_id='$level_info[level_id]'");
    if($level_group_search == 0) { $database->database_query("UPDATE se_groups, se_users SET group_search='1' WHERE se_users.user_level_id='$level_info[level_id]' AND se_groups.group_user_id=se_users.user_id"); }
    $level_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_levels WHERE level_id='$level_info[level_id]'"));
    $result = 1;
  }
}








// ADD SPACES BACK AFTER COMMAS
$level_group_photo_exts = str_replace(",", ", ", $level_info[level_group_photo_exts]);
$level_group_album_exts = str_replace(",", ", ", $level_info[level_group_album_exts]);
$level_group_album_mimes = str_replace(",", ", ", $level_info[level_group_album_mimes]);
$level_group_album_maxsize = $level_info[level_group_album_maxsize]/1024;

// GET CURRENT GROUP PRIVACY SETTING
$count = 0;
while($count < 6) {
  if(group_privacy_levels($count) != "") {
    if(strpos($level_info[level_group_privacy], "$count") !== FALSE) { $privacy_selected = 1; } else { $privacy_selected = 0; }
    $privacy_options[$count] = Array('privacy_name' => "group_privacy_".$count,
				'privacy_value' => $count,
				'privacy_option' => group_privacy_levels($count),
				'privacy_selected' => $privacy_selected);
  }
  $count++;
}

// GET CURRENT GROUP COMMENT SETTINGS
$count = 0;
while($count < 10) {
  if(group_privacy_levels($count) != "") {
    if(strpos($level_info[level_group_comments], "$count") !== FALSE) { $comment_selected = 1; } else { $comment_selected = 0; }
    $comment_options[$count] = Array('comment_name' => "group_comments_".$count,
				'comment_value' => $count,
				'comment_option' => group_privacy_levels($count),
				'comment_selected' => $comment_selected);
  }
  $count++;
}

// GET CURRENT GROUP DISCUSSION SETTINGS
$count = 0;
while($count < 10) {
  if(group_privacy_levels($count) != "") {
    if(strpos($level_info[level_group_discussion], "$count") !== FALSE) { $discussion_selected = 1; } else { $discussion_selected = 0; }
    $discussion_options[$count] = Array('discussion_name' => "group_discussion_".$count,
					'discussion_value' => $count,
					'discussion_option' => group_privacy_levels($count),
					'discussion_selected' => $discussion_selected);
  }
  $count++;
}





// ASSIGN VARIABLES AND SHOW USER GROUPS PAGE
$smarty->assign('level_id', $level_info[level_id]);
$smarty->assign('level_name', $level_info[level_name]);
$smarty->assign('result', $result);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('group_allow', $level_info[level_group_allow]);
$smarty->assign('group_photo', $level_info[level_group_photo]);
$smarty->assign('group_photo_width', $level_info[level_group_photo_width]);
$smarty->assign('group_photo_height', $level_info[level_group_photo_height]);
$smarty->assign('group_photo_exts', $level_group_photo_exts);
$smarty->assign('group_titles', $level_info[level_group_titles]);
$smarty->assign('group_officers', $level_info[level_group_officers]);
$smarty->assign('group_approval', $level_info[level_group_approval]);
$smarty->assign('group_style', $level_info[level_group_style]);
$smarty->assign('group_album_exts', $level_group_album_exts);
$smarty->assign('group_album_mimes', $level_group_album_mimes);
$smarty->assign('group_album_storage', $level_info[level_group_album_storage]);
$smarty->assign('group_album_maxsize', $level_group_album_maxsize);
$smarty->assign('group_album_width', $level_info[level_group_album_width]);
$smarty->assign('group_album_height', $level_info[level_group_album_height]);
$smarty->assign('group_maxnum', $level_info[level_group_maxnum]);
$smarty->assign('group_search', $level_info[level_group_search]);
$smarty->assign('group_privacy', $privacy_options);
$smarty->assign('group_comments', $comment_options);
$smarty->assign('group_discussion', $discussion_options);
$smarty->display("$page.tpl");
exit();
?>