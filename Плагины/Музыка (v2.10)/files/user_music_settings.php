<?php
$page = "user_music_settings";
include "header.php";
if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }

if($user->level_info[level_music_allow] == 0){ header("Location: ".$url->url_create('profile', $user->user_info[user_username])); exit(); }

$user_id = $user->user_info[user_id];

if($task == "dosave"){
	$profile_autoplay = $_POST["profile_autoplay"];
	$site_autoplay = $_POST["site_autoplay"];
	$music_skin = $_POST["select_music_skin"];
	$database->database_query("UPDATE se_usersettings SET usersetting_music_profile_autoplay='$profile_autoplay', usersetting_music_site_autoplay='$site_autoplay', usersetting_music_skin_id='$music_skin' WHERE usersetting_user_id = '$user_id'");
}

$settings = $database->database_fetch_assoc($database->database_query("SELECT usersetting_music_profile_autoplay, usersetting_music_skin_id, usersetting_music_site_autoplay FROM se_usersettings WHERE usersetting_user_id = '$user_id'"));
$music = new se_music($user->user_info[user_id]);

if($user->level_info[level_music_allow_skins] != 0){
	$skins = $music->music_skin_list();
}

if($settings[usersetting_music_skin_id] != '0'){
	$smarty->assign('skin_id', $settings[usersetting_music_skin_id]);
} else {
	$smarty->assign('skin_id', '1');
}

$smarty->assign('skins', $skins);
$smarty->assign('profile_autoplay', $settings[usersetting_music_profile_autoplay]);
$smarty->assign('site_autoplay', $settings[usersetting_music_site_autoplay]);

include "footer.php";
?>
