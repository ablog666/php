<?

//  THIS FILE CONTAINS gifts-RELATED FUNCTIONS
//  FUNCTIONS IN THIS CLASS:
//    search_gifts()
//    deleteuser_gifts()













// THIS FUNCTION IS RUN DURING THE SEARCH PROCESS TO SEARCH THROUGH giftsS AND MEDIA
// INPUT: $search_text REPRESENTING THE STRING TO SEARCH FOR
//	  $total_only REPRESENTING 1/0 DEPENDING ON WHETHER OR NOT TO RETURN JUST THE TOTAL RESULTS
//	  $search_objects REPRESENTING AN ARRAY CONTAINING INFORMATION ABOUT THE POSSIBLE OBJECTS TO SEARCH
//	  $results REPRESENTING THE ARRAY OF SEARCH RESULTS
//	  $total_results REPRESENTING THE TOTAL SEARCH RESULTS
// OUTPUT: 
function search_gifts($search_text, $total_only, &$search_objects, &$results, &$total_results) {
	global $database, $url, $functions_gifts, $results_per_page, $p;

	// CONSTRUCT QUERY
	$gifts_query = "
	(
	SELECT
          '1' AS sub_type,
	  se_media.media_gifts_id AS gifts_id,
	  se_media.media_title AS title,
	  se_media.media_id AS media_id,
	  se_users.user_id,
	  se_users.user_username,
	  se_users.user_photo
	FROM
	  se_media,
	  se_giftss,
	  se_users,
	  se_levels
	WHERE
	  se_media.media_gifts_id=se_giftss.gifts_id AND
	  se_giftss.gifts_user_id=se_users.user_id AND
	  se_users.user_level_id=se_levels.level_id AND
	  (
	    se_giftss.gifts_search='1' OR
	    se_levels.level_gifts_search='0'
	  )
	  AND
	  (
	    se_media.media_title LIKE '%$search_text%' OR
	    se_media.media_desc LIKE '%$search_text%'
	  )
	)
	UNION ALL
	(
	SELECT
	  '2' AS sub_type,
	  se_giftss.gifts_id AS gifts_id,
	  se_giftss.gifts_title AS title,
	  se_giftss.gifts_cover AS media_id,
	  se_users.user_id,
	  se_users.user_username,
	  se_users.user_photo
	FROM
	  se_giftss,
	  se_users,
	  se_levels
	WHERE
	  se_giftss.gifts_user_id=se_users.user_id AND
	  se_users.user_level_id=se_levels.level_id AND
	  (
	    se_giftss.gifts_search='1' OR
	    se_levels.level_gifts_search='0'
	  )
	  AND
	  (
	    se_giftss.gifts_title LIKE '%$search_text%' OR
	    se_giftss.gifts_desc LIKE '%$search_text%'
	  )
	)"; 

	// GET TOTAL RESULTS
	$total_giftss = $database->database_num_rows($database->database_query($gifts_query." LIMIT 201"));

	// IF NOT TOTAL ONLY
	if($total_only == 0) {

	  // MAKE gifts PAGES
	  $start = ($p - 1) * $results_per_page;
	  $limit = $results_per_page+1;

	  // SEARCH giftsS
	  $giftss = $database->database_query($gifts_query." ORDER BY gifts_id DESC LIMIT $start, $limit");
	  while($gifts_info = $database->database_fetch_assoc($giftss)) {

	    // CREATE AN OBJECT FOR AUTHOR
	    $profile = new se_user();
	    $profile->user_info[user_id] = $gifts_info[user_id];
	    $profile->user_info[user_username] = $gifts_info[user_username];
	    $profile->user_info[user_photo] = $gifts_info[user_photo];

	    // RESULT IS A MEDIA
	    if($gifts_info[sub_type] == 1) {
	      $result_url = $url->url_create('gifts_file', $gifts_info[user_username], $gifts_info[gifts_id], $gifts_info[media_id]);
	      $desc_prefix = $functions_gifts[4];

	    // RESULT IS AN gifts
	    } else {
	      $result_url = $url->url_create('gifts', $gifts_info[user_username], $gifts_info[gifts_id]);
	      $desc_prefix = $functions_gifts[1];
	    }

	    // SET THUMBNAIL, IF AVAILABLE
	    $thumb_path = $url->url_userdir($gifts_info[user_id]).$gifts_info[media_id]."_thumb.jpg";
	    if(file_exists($thumb_path)) { $result_icon = $thumb_path; } else { $result_icon = ""; }

	    // IF NO TITLE
	    if($gifts_info[title] == "") { $title = $functions_gifts[3]; } else { $title = $gifts_info[title]; }

	    $results[] = Array('result_url' => $result_url,
				'result_icon' => $result_icon,
				'result_name' => $title,
				'result_desc' => $desc_prefix.$gifts_info[user_username],
				'result_user' => '');
	  }

	  // SET TOTAL RESULTS
	  $total_results = $total_giftss;

	}

	// SET ARRAY VALUES
	if($total_giftss > 200) { $total_giftss = "200+"; }
	$search_objects[] = Array('search_type' => 'gifts',
				'search_item' => $functions_gifts[2],
				'search_total' => $total_giftss);
} // END search_gifts() FUNCTION









// THIS FUNCTION IS RUN WHEN A USER IS DELETED
// INPUT: $user_id REPRESENTING THE USER ID OF THE USER BEING DELETED
// OUTPUT: 
function deleteuser_gifts($user_id) {
	global $database;

	// DELETE giftsS, MEDIA, AND COMMENTS
	$database->database_query("DELETE FROM se_giftss, se_media, se_mediacomments USING se_giftss LEFT JOIN se_media ON se_giftss.gifts_id=se_media.media_gifts_id LEFT JOIN se_mediacomments ON se_media.media_id=se_mediacomments.mediacomment_media_id WHERE se_giftss.gifts_user_id='$user_id'");

	// DELETE COMMENTS POSTED BY USER
	$database->database_query("DELETE FROM se_mediacomments WHERE mediacomment_authoruser_id='$user_id'");

	// DELETE STYLE
	$database->database_query("DELETE FROM se_giftsstyles WHERE giftsstyle_user_id='$user_id'");

} // END deleteuser_gifts() FUNCTION

?>