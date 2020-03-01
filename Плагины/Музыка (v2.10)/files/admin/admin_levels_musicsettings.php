<?php
$page = "admin_levels_musicsettings";
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

$skins = $database->database_query("SELECT * FROM se_music_skins");
$skin_array = Array();
while($skinlist = $database->database_fetch_assoc($skins)){
	$skin_array[] = Array('skin_id' => $skinlist[se_music_skins_id],
						   'skin_title' => $skinlist[se_music_skins_title],
						   'skin_height' => $skinlist[se_music_skins_height],
						   'skin_width' => $skinlist[se_music_skins_width]
	);
}

// SET RESULT VARIABLE
$result = 0;
$is_error = 0;
$error_message = "";


// SAVE CHANGES
if($task == "dosave") {
  $level_music_allow = $_POST['level_music_allow'];
  $level_music_exts = str_replace(", ", ",", $_POST['level_music_exts']);
  $level_music_mimes = str_replace(", ", ",", $_POST['level_music_mimes']);
  $level_music_storage = $_POST['level_music_storage'];
  $level_music_maxsize = $_POST['level_music_maxsize'];
  $level_music_maxnum = $_POST['level_music_maxnum'];
  $level_music_allow_skins = $_POST['level_music_allow_skins'];
  $level_music_skin_default = $_POST['level_music_skin_default'];

  // CHECK THAT A NUMBER BETWEEN 1 AND 204800 (200MB) WAS ENTERED FOR MAXSIZE
  if(!is_numeric($level_music_maxsize) OR $level_music_maxsize < 1 OR $level_music_maxsize > 204800) {
    $is_error = 1;
    $error_message = $admin_levels_musicsettings[22];

  // CHECK THAT MAX SONGS IS A NUMBER
  } elseif(!is_numeric($level_music_maxnum) OR $level_music_maxnum < 1 OR $level_music_maxnum > 999) {
    $is_error = 1;
    $error_message = $admin_levels_musicsettings[23];

  } else {
    $level_music_maxsize = $level_music_maxsize*1024;
    $database->database_query("UPDATE se_levels SET 
			level_music_allow='$level_music_allow',
			level_music_maxnum='$level_music_maxnum',
			level_music_exts='$level_music_exts',
			level_music_mimes='$level_music_mimes',
			level_music_storage='$level_music_storage',
			level_music_maxsize='$level_music_maxsize',
			level_music_allow_skins='$level_music_allow_skins',
			level_music_skin_default='$level_music_skin_default'
			WHERE level_id='$level_id'");
    $level_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_levels WHERE level_id='$level_id'"));
    $result = 1;
  }
} // END DOSAVE TASK



// ADD SPACES AFTER COMMAS
$level_music_exts = str_replace(",", ", ", $level_info[level_music_exts]);
$level_music_mimes = str_replace(",", ", ", $level_info[level_music_mimes]);
$level_music_maxsize = $level_info[level_music_maxsize]/1024;

// ASSIGN VARIABLES AND SHOW MUSIC SETTINGS PAGE
$smarty->assign('result', $result);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('level_id', $level_info[level_id]);
$smarty->assign('level_name', $level_info[level_name]);
$smarty->assign('music_allow', $level_info[level_music_allow]);
$smarty->assign('music_exts_value', $level_music_exts);
$smarty->assign('music_mimes_value', $level_music_mimes);
$smarty->assign('music_storage', $level_info[level_music_storage]);
$smarty->assign('music_maxsize', $level_music_maxsize);
$smarty->assign('music_maxnum', $level_info[level_music_maxnum]);
$smarty->assign('music_allow_skins', $level_info[level_music_allow_skins]);
$smarty->assign('music_skin_default', $level_info[level_music_skin_default]);
$smarty->assign('music_skins', $skin_array);
$smarty->display("$page.tpl");
exit();
?>