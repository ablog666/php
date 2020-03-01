<?php
$page = "user_music_upload";
include "header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = NULL; }
if(isset($_POST['user_id'])) { $user_id = $_POST['user_id']; } elseif(isset($_GET['user_id'])) { $user_id = $_GET['user_id']; } else { $user_id = 0; }
if(isset($_POST['upload_token'])) { $upload_token = $_POST['upload_token']; } elseif(isset($_GET['upload_token'])) { $upload_token = $_GET['upload_token']; } else { $upload_token = 0; }
if(isset($_POST['upload_method'])) { $upload_method = $_POST['upload_method']; } elseif(isset($_GET['upload_method'])) { $upload_method = $_GET['upload_method']; }

// SET MUSIC
$music = new se_music($user->user_info[user_id]);

// GET TOTAL SPACE USED
$space_used = $music->music_space();
if($user->level_info[level_music_storage]) {
  $space_left = $user->level_info[level_music_storage] - $space_used;
} else {
  $space_left = ( $dfs=disk_free_space("/") ? $dfs : pow(2, 32) );
}

// Do upload - check token and create user object
if($upload_method == "basic"){
	// UPLOAD FILES
	if($task == "douploadbasic") {
	  $file_result = Array();
		
	  // RUN FILE UPLOAD FUNCTION FOR EACH SUBMITTED FILE
	  $update_music = 0;
	  for($f=1;$f<6;$f++) {
	    $fileid = "file".$f;
	    if($_FILES[$fileid]['name'] != "") {
	      $file_result[$fileid] = $music->music_upload($fileid, $space_left);
	      if($file_result[$fileid]['is_error'] == 0) {
	  		$file_result[$fileid]['message'] = $user_music_upload[14].stripslashes($file_result[$fileid][music_title])." $user_music_upload[15]";
	        $update_music = 1;
	      }
	    }
	  }
	  // UPDATE STATUS TO SHOW MUSIC
	  if($update_music == 1) {
	    $newdate = time();
	    // UPDATE LAST UPDATE DATE (SAY THAT 10 TIMES FAST)
	    $user->user_lastupdate();
	
	    // INSERT ACTION
	    $actions->actions_add($user, "newmusic", Array('[username]'), Array($user->user_info[user_username]));
	
	  }
	
	} // END TASK	  

	$smarty->assign('file1_result', $file_result[file1][message]);
	$smarty->assign('file2_result', $file_result[file2][message]);
	$smarty->assign('file3_result', $file_result[file3][message]);
	$smarty->assign('file4_result', $file_result[file4][message]);
	$smarty->assign('file5_result', $file_result[file5][message]);	
} else {

	if( $task=="doupload" )
	{
	  $is_error = FALSE;
	  $file_result = '';
	  $update_music = FALSE;
	  
		$file_param_name = 'file';
	
	  
	  // Check token
	  session_start();
	  
	  if( $_SESSION['upload_token']!=$upload_token )
	  {
	    $is_error = TRUE;
	    $file_result = 'failure;' . "Invalid token";
	  }
	  
	  
	  // Create the user object if token is valid
	  if( !$is_error && !$user->user_exists && $user_id )
	  {
	    $user = new se_user(array($user_id));
	  }
	}
	
	// ENSURE MUSIC IS ENABLED FOR THIS USER
	if($user->level_info[level_music_allow] == 0) { header("Location: user_home.php"); exit(); }
	
	// SET RESULT AND ERROR VARS
	$result = "";
	$error_message = "";
	
	// UPLOAD FILES
	if($task == "doupload") {
	 if( !$is_error && !empty($_FILES[$file_param_name]['name']) )
	  {
	    $file_result_array = $music->music_upload($file_param_name, $space_left);
	    
	    if( !$file_result_array['is_error'] )
	    {
	      $file_result = 'success;' .$user_music_upload[14]. stripslashes($_FILES[$file_param_name]['name'])." ".$user_music_upload[15];
	      $update_music = TRUE;
	    }
	    else
	    {
	      $file_result = 'failure:' .$user_music_upload[14]. stripslashes($_FILES[$file_param_name]['name'])." ".$user_music_upload[16];
	    }
	  }
	 
	 
	 
	  // UPDATE MUSIC UPDATED DATE
	  if($update_music == TRUE) {
	    $newdate = time();
	        // UPDATE LAST UPDATE DATE (SAY THAT 10 TIMES FAST)
	    $user->user_lastupdate();
	
	    // INSERT ACTION
	    $actions->actions_add($user, "newmusic", Array('[username]'), Array($user->user_info[user_username]));
	
	  }
	  echo $file_result;
	  exit();
	
	} // END TASK
	
	// Make token
	session_start();
	$smarty->assign( 'upload_token', $_SESSION['upload_token'] = md5(uniqid(rand(), true)) );
}
// GET MAX FILESIZE ALLOWED
$max_filesize_kb = ($user->level_info[level_music_maxsize] / 1024) / 1024;
$max_filesize_kb = round($max_filesize_kb, 0);

// CONVERT UPDATED SPACE LEFT TO MB
$space_left_mb = ($space_left / 1024) / 1024;
$space_left_mb = round($space_left_mb, 2);

// ASSIGN VARIABLES AND SHOW UPLOAD FILES PAGE
$smarty->assign('music_title', $music->music_title);
$smarty->assign('space_left', $space_left_mb);
$smarty->assign('allowed_exts', str_replace(",", ", ", $user->level_info[level_music_exts]));
$smarty->assign('max_filesize', $max_filesize_kb);
include "footer.php";
?>