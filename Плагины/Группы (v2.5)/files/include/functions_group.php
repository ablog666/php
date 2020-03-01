<?

//  THIS FILE CONTAINS GROUP-RELATED FUNCTIONS
//  FUNCTIONS IN THIS CLASS:
//    notification_group()
//    search_group()
//    deleteuser_group()
//    group_privacy_levels()









// THIS FUNCTION IS RUN ON THE USER HOME PAGE TO GENERATE NOTIFICATIONS
// INPUT: 
// OUTPUT: 
function notification_group(&$notifications) {
	global $database, $user, $url, $functions_group;

	// SET VARIABLES AND INITIALIZE GROUP OBJECT
	$group = new se_group($user->user_info[user_id]);
	$where = "(se_groupmembers.groupmember_status='0' AND se_groupmembers.groupmember_approved='1')";

	// GET TOTAL GROUP INVITES
	$total_groups = $group->group_total($where);

	// IF GROUP INVITES, CONTINUE
	if($total_groups > 0) {

	  // GET PLUGIN ICON
	  $plugin_info = $database->database_fetch_assoc($database->database_query("SELECT plugin_icon FROM se_plugins WHERE plugin_type='group'"));

	  // SET NOTIFICATION ARRAY
	  $notifications[] = Array('notify_url' => $url->url_base."user_group_invites.php",
				'notify_icon' => $plugin_info[plugin_icon],
				'notify_text' => $total_groups.$functions_group[11]);
	}

} // END notification_group() FUNCTION









// THIS FUNCTION IS RUN DURING THE SEARCH PROCESS TO SEARCH THROUGH GROUPS AND GROUP MEDIA
// INPUT: $search_text REPRESENTING THE STRING TO SEARCH FOR
//	  $total_only REPRESENTING 1/0 DEPENDING ON WHETHER OR NOT TO RETURN JUST THE TOTAL RESULTS
//	  $search_objects REPRESENTING AN ARRAY CONTAINING INFORMATION ABOUT THE POSSIBLE OBJECTS TO SEARCH
//	  $results REPRESENTING THE ARRAY OF SEARCH RESULTS
//	  $total_results REPRESENTING THE TOTAL SEARCH RESULTS
// OUTPUT: 
function search_group($search_text, $total_only, &$search_objects, &$results, &$total_results) {
	global $database, $url, $functions_group, $results_per_page, $p;

	// GET GROUP FIELDS
	$groupfields = $database->database_query("SELECT groupfield_id, groupfield_type, groupfield_options FROM se_groupfields WHERE groupfield_type<>'5'");
	$groupvalue_query = "se_groups.group_title LIKE '%$search_text%' OR se_groups.group_desc LIKE '%$search_text%'";
    
	// LOOP OVER GROUP FIELDS
	while($groupfield_info = $database->database_fetch_assoc($groupfields)) {
    
	  // TEXT FIELD OR TEXTAREA
	  if($groupfield_info[groupfield_type] == 1 | $groupfield_info[groupfield_type] == 2) {
	    if($groupvalue_query != "") { $groupvalue_query .= " OR "; }
	    $groupvalue_query .= "se_groupvalues.groupvalue_".$groupfield_info[groupfield_id]." LIKE '%$search_text%'";

	  // RADIO OR SELECT BOX
	  } elseif($groupfield_info[groupfield_type] == 3 | $groupfield_info[groupfield_type] == 4) {
	    // LOOP OVER FIELD OPTIONS
	    $options = explode("<~!~>", $groupfield_info[groupfield_options]);
	    for($i=0,$max=count($options);$i<$max;$i++) {
	      if(str_replace(" ", "", $options[$i]) != "") {
	        $option = explode("<!>", $options[$i]);
	        $option_id = $option[0];
	        $option_label = $option[1];
	        if(strpos($option_label, $search_text)) {
	          if($groupvalue_query != "") { $groupvalue_query .= " OR "; }
	          $groupvalue_query .= "se_groupvalues.groupvalue_".$groupfield_info[groupfield_id]."='$option_id'";
	        }
	      }
	    }
	  }
	}

	// CONSTRUCT GROUP QUERY
	$groupvalue_query = "SELECT '1' AS sub_type, se_groups.group_id AS group_id, se_groups.group_photo AS group_photo, se_groups.group_title AS title, se_groups.group_desc AS description, '0' AS groupmedia_id FROM se_groups LEFT JOIN se_groupvalues ON se_groups.group_id=se_groupvalues.groupvalue_group_id WHERE se_groups.group_search='1' AND ($groupvalue_query)";

	// CONSTRUCT GROUP MEDIA QUERY
	$groupmedia_query = "SELECT '2' AS sub_type, se_groups.group_id AS group_id, '' AS group_photo, se_groupmedia.groupmedia_title AS title, se_groups.group_title AS description, se_groupmedia.groupmedia_id AS groupmedia_id FROM se_groupmedia, se_groupalbums, se_groups WHERE se_groupmedia.groupmedia_groupalbum_id=se_groupalbums.groupalbum_id AND se_groupalbums.groupalbum_id=se_groups.group_id AND se_groups.group_search='1' AND (se_groupmedia.groupmedia_title LIKE '%$search_text%' OR se_groupmedia.groupmedia_desc LIKE '%$search_text%')";

	// UNION TWO QUERIES
	$group_query = "($groupvalue_query) UNION ALL ($groupmedia_query)";

	// GET TOTAL QUERIES
	$total_groups = $database->database_num_rows($database->database_query($group_query." LIMIT 201"));

	// IF NOT TOTAL ONLY
	if($total_only == 0) {

	  // MAKE GROUP PAGES
	  $start = ($p - 1) * $results_per_page;
	  $limit = $results_per_page+1;

	  // SEARCH GROUPS
	  $groups = $database->database_query($group_query." ORDER BY group_id DESC LIMIT $start, $limit");
	  while($group_info = $database->database_fetch_assoc($groups)) {

	    // CREATE AN OBJECT FOR GROUP
	    $group = new se_group();
	    $group->group_info[group_id] = $group_info[group_id];

	    // RESULT IS A GROUP
	    if($group_info[sub_type] == 1) {

	      // SET GROUP PHOTO, IF AVAILABLE
	      $group->group_info[group_photo] = $group_info[group_photo];
	      $group_photo = $group->group_photo();
	      if($group_photo != "") { $result_icon = $group_photo; } else { $result_icon = ""; }

	      // SET RESULT URL
	      $result_url = $url->url_base."group.php?group_id=".$group->group_info[group_id];

	      // SET RESULT DESCRIPTION
	      $result_desc = $group_info[description];

	    // RESULT IS MEDIA
	    } else {
	      
	      // SET THUMBNAIL, IF AVAILABLE
	      $thumb_path = $group->group_dir($group->group_info[group_id]).$group_info[groupmedia_id]."_thumb.jpg";
	      if(file_exists($thumb_path)) { $result_icon = $thumb_path; } else { $result_icon = ""; }

	      // SET RESULT URL
	      $result_url = $url->url_base."group_album_file.php?group_id=".$group->group_info[group_id]."&groupmedia_id=$group_info[groupmedia_id]";
	
	      // SET RESULT DESCRIPTION
	      $result_desc = $functions_group[10].$group_info[description];

	    }

	    $results[] = Array('result_url' => $result_url,
				'result_icon' => $result_icon,
				'result_name' => $group_info[title],
				'result_desc' => $result_desc,
				'result_user' => '');
	  }

	  // SET TOTAL RESULTS
	  $total_results = $total_groups;

	}

	// SET ARRAY VALUES
	if($total_groups > 200) { $total_groups = "200+"; }
	$search_objects[] = Array('search_type' => 'group',
				'search_item' => $functions_group[9],
				'search_total' => $total_groups);
} // END search_group() FUNCTION









// THIS FUNCTION IS RUN WHEN A USER IS DELETED
// INPUT: $user_id REPRESENTING THE USER ID OF THE USER BEING DELETED
// OUTPUT: 
function deleteuser_group($user_id) {
	global $database;

	// INITATE GROUP OBJECT
	$group = new se_group($user_id);

	// LOOP OVER GROUPS AND DELETE THEM
	$groups = $database->database_query("SELECT group_id FROM se_groups WHERE group_user_id='$user_id'");
	while($group_info = $database->database_fetch_assoc($groups)) {
	  $group->group_delete($group_info[group_id]);
	}

	// DELETE USER FROM ALL GROUPS
	$database->database_query("DELETE FROM se_groupmembers WHERE groupmember_user_id='$user_id'");
	
	// DELETE USER'S COMMENTS
	$database->database_query("DELETE FROM se_groupcomments WHERE groupcomment_authoruser_id='$user_id'");
	$database->database_query("DELETE FROM se_groupmediacomments WHERE groupmediacomment_authoruser_id='$user_id'");

} // END deleteuser_group() FUNCTION









// THIS FUNCTION RETURNS TEXT CORRESPONDING TO THE GIVEN GROUP PRIVACY LEVEL
// INPUT: $privacy_level REPRESENTING THE LEVEL OF GROUP PRIVACY
// OUTPUT: A STRING EXPLAINING THE GIVEN PRIVACY SETTING
function group_privacy_levels($privacy_level) {
	global $functions_group;

	switch($privacy_level) {
	  case 0: $privacy = $functions_group[1]; break;
	  case 1: $privacy = $functions_group[2]; break;
	  case 2: $privacy = $functions_group[3]; break;
	  case 3: $privacy = $functions_group[4]; break;
	  case 4: $privacy = $functions_group[5]; break;
	  case 5: $privacy = $functions_group[6]; break;
	  case 6: $privacy = $functions_group[7]; break;
	  case 7: $privacy = $functions_group[8]; break;
	  default: $privacy = ""; break;
	}

	return $privacy;
} // END group_privacy_levels() FUNCTION

?>