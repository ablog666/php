<?

//  THIS FILE CONTAINS EVENT-RELATED FUNCTIONS
//  FUNCTIONS IN THIS CLASS:
//    notification_event()
//    search_event()
//    deleteuser_event()
//    event_privacy_levels()









// THIS FUNCTION IS RUN ON THE USER HOME PAGE TO GENERATE NOTIFICATIONS
// INPUT: 
// OUTPUT: 
function notification_event(&$notifications) {
	global $database, $user, $url, $functions_event;

	// SET VARIABLES AND INITIALIZE EVENT OBJECT
	$event = new se_event($user->user_info[user_id]);
	$where = "(se_eventmembers.eventmember_status='0')";

	// GET TOTAL EVENT INVITES
	$total_events = $event->event_total($where);

	// IF EVENT INVITES, CONTINUE
	if($total_events > 0) {

	  // GET PLUGIN ICON
	  $plugin_info = $database->database_fetch_assoc($database->database_query("SELECT plugin_icon FROM se_plugins WHERE plugin_type='event'"));

	  // SET NOTIFICATION ARRAY
	  $notifications[] = Array('notify_url' => $url->url_base."user_event.php?show_notification=1",
				'notify_icon' => $plugin_info[plugin_icon],
				'notify_text' => $total_events.$functions_event[11]);
	}

} // END notification_event() FUNCTION









// THIS FUNCTION IS RUN DURING THE SEARCH PROCESS TO SEARCH THROUGH EVENTS AND EVENT MEDIA
// INPUT: $search_text REPRESENTING THE STRING TO SEARCH FOR
//	  $total_only REPRESENTING 1/0 DEPENDING ON WHETHER OR NOT TO RETURN JUST THE TOTAL RESULTS
//	  $search_objects REPRESENTING AN ARRAY CONTAINING INFORMATION ABOUT THE POSSIBLE OBJECTS TO SEARCH
//	  $results REPRESENTING THE ARRAY OF SEARCH RESULTS
//	  $total_results REPRESENTING THE TOTAL SEARCH RESULTS
// OUTPUT: 
function search_event($search_text, $total_only, &$search_objects, &$results, &$total_results) {
	global $database, $url, $functions_event, $results_per_page, $p;

	// CONSTRUCT EVENT QUERY
	$eventvalue_query = "SELECT '1' AS sub_type, se_events.event_id AS event_id, se_events.event_photo AS event_photo, se_events.event_title AS title, se_events.event_desc AS description, '0' AS eventmedia_id FROM se_events WHERE se_events.event_search='1' AND (se_events.event_title LIKE '%$search_text%' OR se_events.event_desc LIKE '%$search_text%')";

	// CONSTRUCT EVENT MEDIA QUERY
	$eventmedia_query = "SELECT '2' AS sub_type, se_events.event_id AS event_id, '' AS event_photo, se_eventmedia.eventmedia_title AS title, se_events.event_title AS description, se_eventmedia.eventmedia_id AS eventmedia_id FROM se_eventmedia, se_eventalbums, se_events WHERE se_eventmedia.eventmedia_eventalbum_id=se_eventalbums.eventalbum_id AND se_eventalbums.eventalbum_id=se_events.event_id AND se_events.event_search='1' AND (se_eventmedia.eventmedia_title LIKE '%$search_text%' OR se_eventmedia.eventmedia_desc LIKE '%$search_text%')";

	// UNION TWO QUERIES
	$event_query = "($eventvalue_query) UNION ALL ($eventmedia_query)";

	// GET TOTAL QUERIES
	$total_events = $database->database_num_rows($database->database_query($event_query." LIMIT 201"));

	// IF NOT TOTAL ONLY
	if($total_only == 0) {

	  // MAKE EVENT PAGES
	  $start = ($p - 1) * $results_per_page;
	  $limit = $results_per_page+1;

	  // SEARCH EVENTS
	  $events = $database->database_query($event_query." ORDER BY event_id DESC LIMIT $start, $limit");
	  while($event_info = $database->database_fetch_assoc($events)) {

	    // CREATE AN OBJECT FOR EVENT
	    $event = new se_event();
	    $event->event_info[event_id] = $event_info[event_id];

	    // RESULT IS A EVENT
	    if($event_info[sub_type] == 1) {

	      // SET EVENT PHOTO, IF AVAILABLE
	      $event->event_info[event_photo] = $event_info[event_photo];
	      $event_photo = $event->event_photo();
	      if($event_photo != "") { $result_icon = $event_photo; } else { $result_icon = ""; }

	      // SET RESULT URL
	      $result_url = $url->url_base."event.php?event_id=".$event->event_info[event_id];

	      // SET RESULT DESCRIPTION
	      $result_desc = str_replace("<br>", " ", $event_info[description]);
	      if(strlen($result_desc) > 300) { $result_desc = substr($result_desc, 0, 297)."..."; }

	    // RESULT IS MEDIA
	    } else {
	      
	      // SET THUMBNAIL, IF AVAILABLE
	      $thumb_path = $event->event_dir($event->event_info[event_id]).$event_info[eventmedia_id]."_thumb.jpg";
	      if(file_exists($thumb_path)) { $result_icon = $thumb_path; } else { $result_icon = ""; }

	      // SET RESULT URL
	      $result_url = $url->url_base."event_album_file.php?event_id=".$event->event_info[event_id]."&eventmedia_id=$event_info[eventmedia_id]";
	
	      // SET RESULT DESCRIPTION
	      $result_desc = $functions_event[10].$event_info[description];

	    }

	    $results[] = Array('result_url' => $result_url,
				'result_icon' => $result_icon,
				'result_name' => $event_info[title],
				'result_desc' => $result_desc,
				'result_user' => '');
	  }

	  // SET TOTAL RESULTS
	  $total_results = $total_events;

	}

	// SET ARRAY VALUES
	if($total_events > 200) { $total_events = "200+"; }
	$search_objects[] = Array('search_type' => 'event',
				'search_item' => $functions_event[9],
				'search_total' => $total_events);
} // END search_event() FUNCTION









// THIS FUNCTION IS RUN WHEN A USER IS DELETED
// INPUT: $user_id REPRESENTING THE USER ID OF THE USER BEING DELETED
// OUTPUT: 
function deleteuser_event($user_id) {
	global $database;

	// INITATE EVENT OBJECT
	$event = new se_event($user_id);

	// LOOP OVER EVENTS AND DELETE THEM
	$events = $database->database_query("SELECT event_id FROM se_events WHERE event_user_id='$user_id'");
	while($event_info = $database->database_fetch_assoc($events)) {
	  $event->event_delete($event_info[event_id]);
	}

	// DELETE USER FROM EVENT GUESTLISTS
	$database->database_query("DELETE FROM se_eventmembers WHERE eventmember_user_id='$user_id'");
	
	// DELETE USER'S COMMENTS
	$database->database_query("DELETE FROM se_eventcomments WHERE eventcomment_authoruser_id='$user_id'");
	$database->database_query("DELETE FROM se_eventmediacomments WHERE eventmediacomment_authoruser_id='$user_id'");

} // END deleteuser_event() FUNCTION









// THIS FUNCTION RETURNS TEXT CORRESPONDING TO THE GIVEN EVENT PRIVACY LEVEL
// INPUT: $privacy_level REPRESENTING THE LEVEL OF EVENT PRIVACY
// OUTPUT: A STRING EXPLAINING THE GIVEN PRIVACY SETTING
function event_privacy_levels($privacy_level) {
	global $functions_event;

	switch($privacy_level) {
	  case 0: $privacy = $functions_event[1]; break;
	  case 1: $privacy = $functions_event[2]; break;
	  case 2: $privacy = $functions_event[3]; break;
	  case 3: $privacy = $functions_event[4]; break;
	  case 4: $privacy = $functions_event[5]; break;
	  case 5: $privacy = $functions_event[6]; break;
	  case 6: $privacy = $functions_event[7]; break;
	  case 7: $privacy = $functions_event[8]; break;
	  default: $privacy = ""; break;
	}

	return $privacy;
} // END event_privacy_levels() FUNCTION

?>