<?

//  THIS FILE CONTAINS classified-RELATED FUNCTIONS
//  FUNCTIONS IN THIS CLASS:
//    search_classified()
//    deleteuser_classified()













// THIS FUNCTION IS RUN DURING THE SEARCH PROCESS TO SEARCH THROUGH classified ENTRIES
// INPUT: $search_text REPRESENTING THE STRING TO SEARCH FOR
//	  $total_only REPRESENTING 1/0 DEPENDING ON WHETHER OR NOT TO RETURN JUST THE TOTAL RESULTS
//	  $search_objects REPRESENTING AN ARRAY CONTAINING INFORMATION ABOUT THE POSSIBLE OBJECTS TO SEARCH
//	  $results REPRESENTING THE ARRAY OF SEARCH RESULTS
//	  $total_results REPRESENTING THE TOTAL SEARCH RESULTS
// OUTPUT: 
function search_classified($search_text, $total_only, &$search_objects, &$results, &$total_results) {
	global $database, $url, $functions_classified, $results_per_page, $p;

	// GET CLASSIFIED FIELDS
	$classifiedfields = $database->database_query("SELECT classifiedfield_id, classifiedfield_type, classifiedfield_options FROM se_classifiedfields WHERE classifiedfield_type<>'5'");
	$classifiedvalue_query = "se_classifieds.classified_title LIKE '%$search_text%' OR se_classifieds.classified_body LIKE '%$search_text%'";
    
	// LOOP OVER CLASSIFIED FIELDS
	while($classifiedfield_info = $database->database_fetch_assoc($classifiedfields)) {
    
	  // TEXT FIELD OR TEXTAREA
	  if($classifiedfield_info[classifiedfield_type] == 1 | $classifiedfield_info[classifiedfield_type] == 2) {
	    if($classifiedvalue_query != "") { $classifiedvalue_query .= " OR "; }
	    $classifiedvalue_query .= "se_classifiedvalues.classifiedvalue_".$classifiedfield_info[classifiedfield_id]." LIKE '%$search_text%'";

	  // RADIO OR SELECT BOX
	  } elseif($classifiedfield_info[classifiedfield_type] == 3 | $classifiedfield_info[classifiedfield_type] == 4) {
	    // LOOP OVER FIELD OPTIONS
	    $options = explode("<~!~>", $classifiedfield_info[classifiedfield_options]);
	    for($i=0,$max=count($options);$i<$max;$i++) {
	      if(str_replace(" ", "", $options[$i]) != "") {
	        $option = explode("<!>", $options[$i]);
	        $option_id = $option[0];
	        $option_label = $option[1];
	        if(strpos($option_label, $search_text)) {
	          if($classifiedvalue_query != "") { $classifiedvalue_query .= " OR "; }
	          $classifiedvalue_query .= "se_classifiedvalues.classifiedvalue_".$classifiedfield_info[classifiedfield_id]."='$option_id'";
	        }
	      }
	    }
	  }
	}

	// CONSTRUCT QUERY
	$classified_query = "SELECT se_classifieds.classified_id, se_classifieds.classified_title, se_classifieds.classified_photo, se_users.user_id, se_users.user_username, se_users.user_photo FROM se_classifieds, se_users, se_levels LEFT JOIN se_classifiedvalues ON se_classifieds.classified_id=se_classifiedvalues.classifiedvalue_classified_id WHERE se_classifieds.classified_user_id=se_users.user_id AND se_users.user_level_id=se_levels.level_id AND (se_classifieds.classified_search='1' OR se_levels.level_classified_search='0') AND ($classifiedvalue_query)";


	// GET TOTAL ENTRIES
	$total_entries = $database->database_num_rows($database->database_query($classified_query." LIMIT 201"));

	// IF NOT TOTAL ONLY
	if($total_only == 0) {

	  // MAKE classified PAGES
	  $start = ($p - 1) * $results_per_page;
	  $limit = $results_per_page+1;

	  // SEARCH classifiedS
	  $classifieds = $database->database_query($classified_query." ORDER BY classified_id DESC LIMIT $start, $limit");
	  while($classified_info = $database->database_fetch_assoc($classifieds)) {

	    // CREATE AN OBJECT FOR AUTHOR
	    $profile = new se_user();
	    $profile->user_info[user_id] = $classified_info[user_id];
	    $profile->user_info[user_username] = $classified_info[user_username];
	    $profile->user_info[user_photo] = $classified_info[user_photo];

	    // IF EMPTY TITLE
	    if($classified_info[classified_title] == "") { $title = $functions_classified[3]; } else { $title = $classified_info[classified_title]; }

	    // CREATE AN OBJECT FOR CLASSIFIED
	    $classified = new se_classified();
	    $classified->classified_info[classified_id] = $classified_info[classified_id];

	    // SET CLASSIFIED PHOTO, IF AVAILABLE
	    $classified->classified_info[classified_photo] = $classified_info[classified_photo];
	    $classified_photo = $classified->classified_photo();
	    if($classified_photo != "") { $result_icon = $classified_photo; } else { $result_icon = ""; }

	    $results[] = Array('result_url' => $url->url_create('classified', $classified_info[user_username], $classified_info[classified_id]),
				'result_icon' => $result_icon,
				'result_name' => $title,
				'result_desc' => $functions_classified[1].$classified_info[user_username],
				'result_user' => '');
	  }

	  // SET TOTAL RESULTS
	  $total_results = $total_entries;

	}

	// SET ARRAY VALUES
	if($total_entries > 200) { $total_entries = "200+"; }
	$search_objects[] = Array('search_type' => 'classified',
				'search_item' => $functions_classified[2],
				'search_total' => $total_entries);
} // END search_classified() FUNCTION









// THIS FUNCTION IS RUN WHEN A USER IS DELETED
// INPUT: $user_id REPRESENTING THE USER ID OF THE USER BEING DELETED
// OUTPUT: 
function deleteuser_classified($user_id) {
	global $database;

	// DELETE classified ENTRIES AND COMMENTS
	$database->database_query("DELETE FROM se_classifieds, se_classifiedcomments USING se_classifieds LEFT JOIN se_classifiedcomments ON se_classifieds.classified_id=se_classifiedcomments.classifiedcomment_classified_id WHERE se_classifieds.classified_user_id='$user_id'");

	// DELETE COMMENTS POSTED BY USER
	$database->database_query("DELETE FROM se_classifiedcomments WHERE classifiedcomment_authoruser_id='$user_id'");

	// DELETE STYLE
	$database->database_query("DELETE FROM se_classifiedstyles WHERE classifiedstyle_user_id='$user_id'");

} // END deleteuser_classified() FUNCTION

?>