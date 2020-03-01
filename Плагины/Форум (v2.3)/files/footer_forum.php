<?

// ENSURE THIS IS BEING INCLUDED IN AN SE SCRIPT
if(!defined('SE_PAGE')) { exit(); }

// CHECK IF PLUGIN IS ENABLED
if($setting[setting_forum_enabled] == 1) {

  switch($page) {

    // CODE FOR USER ACCOUNT PAGE
    case "user_account":
	if($task == "dosave" && $is_error == 0) {
	  $forum->forum_user_change($user->user_info[user_username]);
	}
	break;

    // CODE FOR USER PASSWORD PAGE
    case "user_account_pass":
	if($task == "dosave" && $is_error == 0) {
	  $forum->forum_password_change($password_new);
	}
	break;

  }

}
?>