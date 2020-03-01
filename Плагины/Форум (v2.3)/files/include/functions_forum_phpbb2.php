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

	if((file_exists($forum_path."config.php")) && (file_exists($forum_path."includes/constants.php"))) {
	  return true;
	} else {
	  return false;
	}


} // END detect_forum() FUNCTION













// THIS FUNCTION IS RUN WHEN A USER IS DELETED
// INPUT: $user_id REPRESENTING THE USER ID OF THE USER BEING DELETED
// OUTPUT: 
function deleteuser_forum($user_id) {
	global $database, $db;

	$user_info = $database->database_fetch_assoc($database->database_query("SELECT user_id, user_username FROM se_users WHERE user_id='$user_id'"));

	// SEARCH PHPBB2 DATABASE FOR SE USER
	$phpbb2_user_query = $db->sql_query("SELECT user_id FROM " . USERS_TABLE . " WHERE username='".$user_info[user_username]."' LIMIT 1");

	// RETURN TRUE/FALSE IF PHPBB2 USER EXISTS
	if($db->sql_numrows($phpbb2_user_query) == 1) {

	  $forum_user = $db->sql_fetchrow($phpbb2_user_query);

	  // DELETE FORUM USER ASSOCIATIONS
	  $result = $db->sql_query("SELECT g.group_id FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g  WHERE ug.user_id = ".$forum_user[user_id]." AND g.group_id = ug.group_id AND g.group_single_user = 1");
	  $row = $db->sql_fetchrow($result);
	  $db->sql_query("UPDATE " . POSTS_TABLE . " SET poster_id = " . DELETED . ", post_username = '".$user_info[user_username]."' WHERE poster_id = ".$forum_user[user_id]);
	  $db->sql_query("UPDATE " . TOPICS_TABLE . " SET topic_poster = " . DELETED . " WHERE topic_poster = ".$forum_user[user_id]);
	  $db->sql_query("UPDATE " . VOTE_USERS_TABLE . " SET vote_user_id = " . DELETED . " WHERE vote_user_id = ".$forum_user[user_id]);
	  $result = $db->sql_query("SELECT group_id FROM " . GROUPS_TABLE . " WHERE group_moderator = ".$forum_user[user_id]);
	  while($row_group = $db->sql_fetchrow($result)) { $group_moderator[] = $row_group['group_id']; }
	  if(count($group_moderator)) {
	    $update_moderator_id = implode(', ', $group_moderator);
	    $admin_row = $db->sql_fetchrow($db->sql_query("SELECT ug.user_id FROM " . USER_GROUP_TABLE . " ug, " . GROUPS_TABLE . " g  WHERE g.group_name = 'Admin' AND g.group_id = ug.group_id AND g.group_single_user = 1 LIMIT 1"));
	    $db->sql_query("UPDATE " . GROUPS_TABLE . "	SET group_moderator = '".$admin_row['user_id']."' WHERE group_id IN ($update_moderator_id)");
	  }
	  $db->sql_query("DELETE FROM " . USERS_TABLE . " WHERE user_id = ".$forum_user[user_id]);
	  $db->sql_query("DELETE FROM " . USER_GROUP_TABLE . " WHERE user_id = ".$forum_user[user_id]);
	  $db->sql_query("DELETE FROM " . GROUPS_TABLE . " WHERE group_id = ".$row['group_id']);
	  $db->sql_query("DELETE FROM " . AUTH_ACCESS_TABLE . "	WHERE group_id = ".$row['group_id']);
	  $db->sql_query("DELETE FROM " . TOPICS_WATCH_TABLE . " WHERE user_id = ".$forum_user[user_id]);
	  $db->sql_query("DELETE FROM " . BANLIST_TABLE . " WHERE ban_userid = ".$forum_user[user_id]);
	  $db->sql_query("DELETE FROM " . SESSIONS_TABLE . " WHERE session_user_id = ".$forum_user[user_id]);
	  $db->sql_query("DELETE FROM " . SESSIONS_KEYS_TABLE . " WHERE user_id = ".$forum_user[user_id]);
	  $result = $db->sql_query("SELECT privmsgs_id FROM " . PRIVMSGS_TABLE . " WHERE privmsgs_from_userid = ".$forum_user[user_id]." OR privmsgs_to_userid = ".$forum_user[user_id]);
	  while($row_privmsgs = $db->sql_fetchrow($result)) { $mark_list[] = $row_privmsgs['privmsgs_id']; }
	  if(count($mark_list))	{
	    $delete_sql_id = implode(', ', $mark_list);
	    $db->sql_query("DELETE FROM " . PRIVMSGS_TEXT_TABLE . " WHERE privmsgs_text_id IN ($delete_sql_id)");
	    $db->sql_query("DELETE FROM " . PRIVMSGS_TABLE . " WHERE privmsgs_id IN ($delete_sql_id)");
	  }
	}

} // END deleteuser_forum() FUNCTION

?>