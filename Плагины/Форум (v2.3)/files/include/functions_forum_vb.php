<?

//  THIS FILE CONTAINS FORUM-RELATED FUNCTIONS
//  FUNCTIONS IN THIS CLASS:
//    detect_forum()
//    deleteuser_forum()













// THIS FUNCTION IS USED TO DETECT WHETHER THE FORUM IS PRESENT OR NOT IN ADMIN SECTION
// INPUT: $forum_path REPRESENTING THE RELATIVE PATH TO THE FORUM FROM SOCIALENGINE
// OUTPUT: 
function detect_forum($forum_path) {

	if(substr($forum_path, 0, 2) == "./") {
	  $forum_path = ".".$forum_path;
	} else {
	  $forum_path = "../".$forum_path;
	}

	if((file_exists($forum_path."includes/functions.php")) && (file_exists($forum_path."includes/class_core.php"))) {
	  return true;
	} else {
	  return false;
	}


} // END detect_forum() FUNCTION













// THIS FUNCTION IS RUN WHEN A USER IS DELETED
// INPUT: $user_id REPRESENTING THE USER ID OF THE USER BEING DELETED
// OUTPUT: 
function deleteuser_forum($user_id) {
	global $vbulletin, $setting, $url, $database;

	$user_info = $database->database_fetch_assoc($database->database_query("SELECT user_id, user_username FROM se_users WHERE user_id='$user_id'"));

	// GET FORUM USER'S INFO
	$vb_user_query = $vbulletin->db->query_write("SELECT userid, username, avatarrevision, profilepicrevision, sigpicrevision FROM " . TABLE_PREFIX . "user WHERE username='".$user_info[user_username]."' LIMIT 1");
	if($vbulletin->db->num_rows($vb_user_query) == 1) {

	  $forum_user = $vbulletin->db->fetch_array($vb_user_query);
	
	  // DELETE FORUM USER
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "user WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "userfield WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "usertextfield WHERE userid='$forum_user[userid]'");

	  // DELETE FORUM USER ASSOCIATIONS
	  $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "post SET username='".$user_info[user_username]."', userid='0' WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("UPDATE " . TABLE_PREFIX . "usernote SET username='".$user_info[user_username]."', posterid='0' WHERE posterid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "usernote	WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "access WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "event WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "customavatar WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "customprofilepic WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "sigpic WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "moderator WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "subscribeforum WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "subscribethread WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "subscribeevent WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "subscriptionlog WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "session WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "userban WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "usergrouprequest WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "announcementread WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "infraction WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "pmreceipt WHERE userid='$forum_user[userid]'");
	  $vbulletin->db->query_write("DELETE FROM " . TABLE_PREFIX . "pm WHERE userid='$forum_user[userid]'");

	  // GET FILE SETTINGS AND DELETE FILES
	  $setting_avatar = $vbulletin->db->query_write("SELECT varname, value FROM " . TABLE_PREFIX . "setting WHERE varname='avatarpath'");
	  $setting_profile = $vbulletin->db->query_write("SELECT varname, value FROM " . TABLE_PREFIX . "setting WHERE varname='profilepicpath'");
	  $setting_sig = $vbulletin->db->query_write("SELECT varname, value FROM " . TABLE_PREFIX . "setting WHERE varname='sigpicpath'");

	  if(substr($setting_avatar[value], 0, 2) == "./") { $setting_avatar = $setting[setting_forum_path].substr($setting_avatar[value], 2); } else { $setting_avatar = $setting[setting_forum_path].$setting_avatar[value]; }
	  if(substr($setting_profile[value], 0, 2) == "./") { $setting_profile = $setting[setting_forum_path].substr($setting_profile[value], 2); } else { $setting_profile = $setting[setting_forum_path].$setting_profile[value]; }
	  if(substr($setting_sig[value], 0, 2) == "./") { $setting_sig = $setting[setting_forum_path].substr($setting_sig[value], 2); } else { $setting_sig = $setting[setting_forum_path].$setting_sig[value]; }

	  if(!is_dir($url->url_userdir($user_info[user_id]))) {
	    $setting_avatar = ".".$setting_avatar;
	    $setting_profile = ".".$setting_profile;
	    $setting_sig = ".".$setting_sig;
	  }

	  @unlink($setting_avatar.'/avatar'.$forum_user[userid].'_'.$forum_user[avatarrevision].'.gif');
	  @unlink($setting_profile.'/profilepic'.$forum_user[userid].'_'.$forum_user[profilepicrevision].'.gif');
	  @unlink($setting_sig.'/sigpic'.$forum_user[userid].'_'.$forum_user[sigpicrevision].'.gif');
	}


} // END deleteuser_forum() FUNCTION

?>