<?php
switch($page){
	
	case "profile":
		if($owner->level_info[level_music_allow] == 1){
			$music = new se_music($owner->user_info[user_id]);
			$profile_settings = $music->profile_settings();
			$smarty->assign('skin', $profile_settings[skin]); 
			$smarty->assign('skin_height', $profile_settings[skin_height]);
			$smarty->assign('skin_width', $profile_settings[skin_width]);
			$view_music = new se_music($user->user_info[user_id]);
			$view_profile_settings = $view_music->profile_settings();
			if($music->music_list() != false){
				$smarty->assign('music_allow', '1');
			}
			if($view_profile_settings[site_autoplay] != "0"){
				$smarty->assign('autoplay', $profile_settings[profile_autoplay]);
			} else {
				$smarty->assign('autoplay', $view_profile_settings[site_autoplay]);
			}
		}
		break;
}
?>
