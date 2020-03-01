<?

//  THIS CLASS CONTAINS EVENT-RELATED METHODS 
//  METHODS IN THIS CLASS:
//    se_event()
//    event_total()
//    event_list()
//    event_create()
//    event_delete()
//    event_delete_selected()
//    event_lastupdate()
//    event_privacy_max()
//    event_member_total()
//    event_member_list()
//    event_dir()
//    event_photo()
//    event_photo_upload()
//    event_photo_delete()
//    event_media_upload()
//    event_media_space()
//    event_media_total()
//    event_media_list()
//    event_media_update()
//    event_media_delete()





class se_event {

	// INITIALIZE VARIABLES
	var $is_error;			// DETERMINES WHETHER THERE IS AN ERROR OR NOT
	var $error_message;		// CONTAINS RELEVANT ERROR MESSAGE

	var $user_id;			// CONTAINS THE USER ID OF THE USER WHOSE EVENTS WE ARE EDITING OR THE LOGGED-IN USER
	var $is_member;			// DETERMINES WHETHER USER IS IN THE EVENTMEMBER TABLE OR NOT

	var $event_exists;		// DETERMINES WHETHER THE EVENT HAS BEEN SET AND EXISTS OR NOT

	var $event_info;		// CONTAINS THE EVENT INFO OF THE EVENT WE ARE EDITING
	var $eventowner_level_info;	// CONTAINS THE EVENT CREATOR'S LEVEL INFO
	var $eventmember_info;		// CONTAINS THE EVENT MEMBER INFO FOR THE LOGGED-IN USER








	// THIS METHOD SETS INITIAL VARS
	// INPUT: $user_id (OPTIONAL) REPRESENTING THE USER ID OF THE USER WHOSE EVENTS WE ARE CONCERNED WITH
	//	  $event_id (OPTIONAL) REPRESENTING THE EVENT ID OF THE EVENT WE ARE CONCERNED WITH
	// OUTPUT: 
	function se_event($user_id = 0, $event_id = 0) {
	  global $database, $user;

	  $this->user_id = $user_id;
	  $this->event_exists = 0;
	  $this->is_member = 0;

	  if($event_id != 0) {
	    $event = $database->database_query("SELECT * FROM se_events WHERE event_id='$event_id'");
	    if($database->database_num_rows($event) == 1) {
	      $this->event_exists = 1;
	      $this->event_info = $database->database_fetch_assoc($event);
	      
	      // GET LEVEL INFO
	      if($this->event_info[event_user_id] == $user->user_info[user_id]) {
	        $this->eventowner_level_info = $user->level_info;
	      } else {
		$this->eventowner_level_info = $database->database_fetch_assoc($database->database_query("SELECT se_levels.* FROM se_users LEFT JOIN se_levels ON se_users.user_level_id=se_levels.level_id WHERE se_users.user_id='".$this->event_info[event_user_id]."'"));
	      }

	      if($this->user_id != 0) {
	        $eventmember = $database->database_query("SELECT eventmember_id, eventmember_status FROM se_eventmembers WHERE eventmember_user_id='".$this->user_id."' AND eventmember_event_id='$event_id'");
	        if($database->database_num_rows($eventmember) == 1) {
	          $this->eventmember_info = $database->database_fetch_assoc($eventmember);
		  $this->is_member = 1;
	        }
	      }
	    }
	  }

	} // END se_event() METHOD








	// THIS METHOD RETURNS THE TOTAL NUMBER OF EVENTS
	// INPUT: $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	//	  $event_details (OPTIONAL) REPRESENTING A BOOLEAN THAT DETERMINES WHETHER TO RETRIEVE EVENT CREATOR
	// OUTPUT: AN INTEGER REPRESENTING THE NUMBER OF EVENTS
	function event_total($where = "", $event_details = 0) {
	  global $database;

	  // BEGIN QUERY
	  $event_query = "SELECT se_events.event_id";

	  // IF USER ID NOT EMPTY, GET USER AS MEMBER
	  if($this->user_id != 0) { $event_query .= ", se_eventmembers.eventmember_status"; }

	  // CONTINUE QUERY
	  $event_query .= " FROM";

	  // IF USER ID NOT EMPTY, SELECT FROM EVENTMEMBER TABLE
	  if($this->user_id != 0) { 
	    $event_query .= " se_eventmembers LEFT JOIN se_events ON se_eventmembers.eventmember_event_id=se_events.event_id "; 
	  } else {
	    $event_query .= " se_events";
	  }

	  // CONTINUE QUERY IF NECESSARY
	  if($event_details == 1) { $event_query .= " LEFT JOIN se_users ON se_events.event_user_id=se_users.user_id"; }

	  // ADD WHERE IF NECESSARY
	  if($where != "" | $this->user_id != 0) { $event_query .= " WHERE"; }

	  // IF USER ID NOT EMPTY, MAKE SURE USER IS A MEMBER
	  if($this->user_id != 0) { $event_query .= " se_eventmembers.eventmember_user_id='".$this->user_id."'"; }

	  // INSERT AND IF NECESSARY
	  if($this->user_id != 0 & $where != "") { $event_query .= " AND"; }

	  // ADD WHERE CLAUSE, IF NECESSARY
	  if($where != "") { $event_query .= " $where"; }

	  // ADD GROUP BY
	  $event_query .= " GROUP BY event_id";

	  // RUN QUERY
	  $event_total = $database->database_num_rows($database->database_query($event_query));
	  return $event_total;

	} // END event_total() METHOD








	// THIS METHOD RETURNS AN ARRAY OF EVENTS
	// INPUT: $start REPRESENTING THE EVENT TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF EVENTS TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	//	  $event_details (OPTIONAL) REPRESENTING A BOOLEAN THAT DETERMINES WHETHER TO RETRIEVE EVENT CREATOR
	// OUTPUT: AN ARRAY OF EVENTS
	function event_list($start, $limit, $sort_by = "event_id DESC", $where = "", $event_details = 0) {
	  global $database, $user;

	  // BEGIN QUERY
	  $event_query = "SELECT se_events.*";

	  // SELECT RELEVANT EVENT DETAILS IF NECESSARY
	  if($event_details == 1) { $event_query .= ", se_users.user_id, se_users.user_username"; }

	  // IF USER ID NOT EMPTY, GET USER AS MEMBER
	  if($this->user_id != 0) { $event_query .= ", se_eventmembers.eventmember_status"; }

	  // CONTINUE QUERY
	  $event_query .= " FROM";

	  // IF USER ID NOT EMPTY, SELECT FROM EVENTMEMBER TABLE
	  if($this->user_id != 0) { 
	    $event_query .= " se_eventmembers LEFT JOIN se_events ON se_eventmembers.eventmember_event_id=se_events.event_id "; 
	  } else {
	    $event_query .= " se_events";
	  }

	  // CONTINUE QUERY IF NECESSARY
	  if($event_details == 1) { $event_query .= " LEFT JOIN se_users ON se_events.event_user_id=se_users.user_id"; }

	  // ADD WHERE IF NECESSARY
	  if($where != "" | $this->user_id != 0) { $event_query .= " WHERE"; }

	  // IF USER ID NOT EMPTY, MAKE SURE USER IS A MEMBER
	  if($this->user_id != 0) { $event_query .= " se_eventmembers.eventmember_user_id='".$this->user_id."' AND se_eventmembers.eventmember_status<>'-1'"; }

	  // INSERT AND IF NECESSARY
	  if($this->user_id != 0 & $where != "") { $event_query .= " AND"; }

	  // ADD WHERE CLAUSE, IF NECESSARY
	  if($where != "") { $event_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $event_query .= " GROUP BY event_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $events = $database->database_query($event_query);

	  // GET EVENTS INTO AN ARRAY
	  $event_array = Array();
	  while($event_info = $database->database_fetch_assoc($events)) {

	    // CREATE OBJECT FOR EVENT
	    $event = new se_event($event_info[user_id]);
	    $event->event_exists = 1;
	    $event->event_info= $event_info;

	    // CREATE OBJECT FOR EVENT CREATOR IF EVENT DETAILS
	    if($event_details == 1) {
      	      $creator = new se_user();
	      $creator->user_exists = 1;
	      $creator->user_info[user_id] = $event_info[user_id];
	      $creator->user_info[user_username] = $event_info[user_username];
	    }

	    // SET EVENT ARRAY
	    $event_array[] = Array('event' => $event,
				'event_status' => $event_info[eventmember_status],
				'event_creator' => $creator);
	  }

	  // RETURN ARRAY
	  return $event_array;

	} // END event_list() METHOD








	// THIS METHOD CREATES A NEW EVENT
	// INPUT: $event_title REPRESENTING THE EVENT TITLE
	//	  $event_desc REPRESENTING THE EVENT DESCRIPTION
	//	  $eventcat_id REPRESENTING THE EVENT CATEGORY ID
	//	  $event_date_start REPRESENTING THE EVENT'S START TIMESTAMP
	//	  $event_date_end REPRESENTING THE EVENT'S END TIMESTAMP
	//	  $event_host REPRESENTING THE EVENT'S HOST
	//	  $event_location REPRESENTING THE EVENT'S LOCATION
	//	  $event_search REPRESENTING WHETHER THE EVENT SHOULD BE SEARCHABLE
	//	  $event_privacy REPRESENTING THE PRIVACY OF THE EVENT
	//	  $event_comments REPRESENTING WHO CAN POST COMMENTS ON THE EVENT
	//	  $event_inviteonly REPRESENTING WHETHER UNINVITED USERS MUST REQUEST A MEMBERSHIP TO RSVP
	// OUTPUT: THE NEWLY CREATED EVENT'S EVENT ID
	function event_create($event_title, $event_desc, $eventcat_id, $event_date_start, $event_date_end, $event_host, $event_location, $event_search, $event_privacy, $event_comments, $event_inviteonly) {
	  global $database;

	  // ADD ROW TO EVENTS TABLE
	  $database->database_query("INSERT INTO se_events (event_user_id, event_eventcat_id, event_title, event_desc, event_date_start, event_date_end, event_host, event_location, event_search, event_privacy, event_comments, event_inviteonly) VALUES ('".$this->user_id."', '$eventcat_id', '$event_title', '$event_desc', '$event_date_start', '$event_date_end', '$event_host', '$event_location', '$event_search', '$event_privacy', '$event_comments', '$event_inviteonly')");
	  $event_id = $database->database_insert_id();

	  // MAKE CREATOR A MEMBER
	  $database->database_query("INSERT INTO se_eventmembers (eventmember_user_id, eventmember_event_id, eventmember_status) VALUES ('".$this->user_id."', '$event_id', '1')");

	  // ADD EVENT STYLES ROW
	  $database->database_query("INSERT INTO se_eventstyles (eventstyle_event_id) VALUES ('$event_id')");

	  // ADD EVENT ALBUM
	  $database->database_query("INSERT INTO se_eventalbums (eventalbum_event_id, eventalbum_datecreated, eventalbum_dateupdated, eventalbum_title, eventalbum_desc, eventalbum_search, eventalbum_privacy, eventalbum_comments) VALUES ('$event_id', '".time()."', '".time()."', '', '', '$event_search', '$event_privacy', '$event_comments')");

	  // ADD EVENT DIRECTORY
	  $event_directory = $this->event_dir($event_id);
	  $event_path_array = explode("/", $event_directory);
	  array_pop($event_path_array);
	  array_pop($event_path_array);
	  $subdir = implode("/", $event_path_array)."/";
	  if(!is_dir($subdir)) { 
	    mkdir($subdir, 0777); 
	    chmod($subdir, 0777); 
	    $handle = fopen($subdir."index.php", 'x+');
	    fclose($handle);
	  }
	  mkdir($event_directory, 0777);
	  chmod($event_directory, 0777);
	  $handle = fopen($event_directory."/index.php", 'x+');
	  fclose($handle);

	  return $event_id;

	} // END event_create() METHOD









	// THIS METHOD DELETES AN EVENT
	// INPUT: $event_id (OPTIONAL) REPRESENTING THE ID OF THE EVENT TO DELETE
	// OUTPUT:
	function event_delete($event_id = 0) {
	  global $database;

	  if($event_id == 0) { $event_id = $this->event_info[event_id]; }

	  // DELETE EVENT ALBUM, MEDIA, MEDIA COMMENTS
	  $database->database_query("DELETE FROM se_eventalbums, se_eventmedia, se_eventmediacomments USING se_eventalbums LEFT JOIN se_eventmedia ON se_eventalbums.eventalbum_id=se_eventmedia.eventmedia_eventalbum_id LEFT JOIN se_eventmediacomments ON se_eventmedia.eventmedia_id=se_eventmediacomments.eventmediacomment_eventmedia_id WHERE se_eventalbums.eventalbum_event_id='$event_id'");

	  // DELETE ALL MEMBERS
	  $database->database_query("DELETE FROM se_eventmembers WHERE se_eventmembers.eventmember_event_id='$event_id'");

	  // DELETE EVENT STYLE
	  $database->database_query("DELETE FROM se_eventstyles WHERE se_eventstyles_event_id='$event_id'");

	  // DELETE EVENT ROW
	  $database->database_query("DELETE FROM se_events WHERE se_events.event_id='$event_id'");

	  // DELETE EVENT COMMENTS
	  $database->database_query("DELETE FROM se_eventcomments WHERE se_eventcomments.eventcomment_event_id='$event_id'");

	  // DELETE EVENT'S FILES
	  if(is_dir($this->event_dir($event_id))) {
	    $dir = $this->event_dir($event_id);
	  } else {
	    $dir = ".".$this->event_dir($event_id);
	  }
	  if($dh = opendir($dir)) {
	    while(($file = readdir($dh)) !== false) {
	      if($file != "." & $file != "..") {
	        unlink($dir.$file);
	      }
	    }
	    closedir($dh);
	  }
	  rmdir($dir);

	} // END event_delete() METHOD








	// THIS METHOD DELETES SELECTED EVENTS
	// INPUT: $start REPRESENTING THE GROUP TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF GROUPS TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	//	  $event_details (OPTIONAL) REPRESENTING A BOOLEAN THAT DETERMINES WHETHER TO RETRIEVE EVENT CREATOR
	// OUTPUT: AN ARRAY OF EVENTS
	function event_delete_selected($start, $limit, $sort_by = "event_id DESC", $where = "", $event_details = 0) {
	  global $database, $user;

	  // BEGIN QUERY
	  $event_query = "SELECT se_events.*";

	  // SELECT RELEVANT EVENT DETAILS IF NECESSARY
	  if($event_details == 1) { $event_query .= ", se_users.user_id, se_users.user_username"; }

	  // IF USER ID NOT EMPTY, GET USER AS MEMBER
	  if($this->user_id != 0) { $event_query .= ", se_eventmembers.eventmember_status"; }

	  // CONTINUE QUERY
	  $event_query .= " FROM";

	  // IF USER ID NOT EMPTY, SELECT FROM EVENTMEMBER TABLE
	  if($this->user_id != 0) { 
	    $event_query .= " se_eventmembers LEFT JOIN se_events ON se_eventmembers.eventmember_event_id=se_events.event_id "; 
	  } else {
	    $event_query .= " se_events";
	  }

	  // CONTINUE QUERY IF NECESSARY
	  if($event_details == 1) { $event_query .= " LEFT JOIN se_users ON se_events.event_user_id=se_users.user_id"; }

	  // ADD WHERE IF NECESSARY
	  if($where != "" | $this->user_id != 0) { $event_query .= " WHERE"; }

	  // IF USER ID NOT EMPTY, MAKE SURE USER IS A MEMBER
	  if($this->user_id != 0) { $event_query .= " se_eventmembers.eventmember_user_id='".$this->user_id."' AND se_eventmembers.eventmember_status<>'-1'"; }

	  // INSERT AND IF NECESSARY
	  if($this->user_id != 0 & $where != "") { $event_query .= " AND"; }

	  // ADD WHERE CLAUSE, IF NECESSARY
	  if($where != "") { $event_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $event_query .= " GROUP BY event_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $events = $database->database_query($event_query);

	  // GET EVENTS INTO AN ARRAY
	  while($event_info = $database->database_fetch_assoc($events)) {
    	    $var = "delete_event_".$event_info[event_id];
	    if($_POST[$var] == 1) { $this->event_delete($event_info[event_id]); }
	  }

	} // END event_delete_selected() METHOD








	// THIS METHOD UPDATES THE EVENT'S LAST UPDATE DATE
	// INPUT: 
	// OUTPUT: 
	function event_lastupdate() {
	  global $database;

	  $database->database_query("UPDATE se_events SET event_dateupdated='".time()."' WHERE event_id='".$this->event_info[event_id]."'");
	  
	} // END event_lastupdate() METHOD








	// THIS METHOD RETURNS MAXIMUM PRIVACY LEVEL VIEWABLE BY A USER WITH REGARD TO THE CURRENT EVENT
	// INPUT: $user REPRESENTING A USER OBJECT
	//	  $allowable_privacy (OPTIONAL) REPRESENTING A STRING OF ALLOWABLE PRIVACY SETTINGS
	// OUTPUT: RETURNS THE INTEGER REPRESENTING THE MAXIMUM PRIVACY LEVEL VIEWABLE BY A USER WITH REGARD TO THE CURRENT EVENT
	function event_privacy_max($user, $allowable_privacy = "01234567") {
	  global $database;

	  switch(TRUE) {

	    // NOBODY
	    // NO ONE HAS $privacy_level = 7

	    // EVENT CREATOR
	    case($this->event_info[event_user_id] == $user->user_info[user_id]):
	      $privacy_level = 6;
	      break;

	    // EVENT INVITEE
	    case($database->database_num_rows($database->database_query("SELECT eventmember_id FROM se_eventmembers WHERE eventmember_user_id='".$user->user_info[user_id]."' AND eventmember_event_id='".$this->event_info[event_id]."' AND eventmember_status<>'-1'")) != 0):
	      $privacy_level = 5;
	      break;
    
	    // EVENT CREATOR'S FRIEND
	    case($database->database_num_rows($database->database_query("SELECT friend_id FROM se_friends WHERE friend_user_id1='".$this->event_info[event_user_id]."' AND friend_user_id2='".$user->user_info[user_id]."'")) != 0):
	      $privacy_level = 4;
	      break;

	    // EVENT INVITEE'S FRIEND
	    case($database->database_num_rows($database->database_query("SELECT se_friends.friend_id FROM se_eventmembers LEFT JOIN se_friends ON se_eventmembers.eventmember_user_id=se_friends.friend_user_id1 AND se_eventmembers.eventmember_status<>'-1' WHERE se_eventmembers.eventmember_event_id='".$this->event_info[event_id]."' AND se_friends.friend_user_id2='".$user->user_info[user_id]."'")) != 0):
	      $privacy_level = 3;
	      break;

	    // FRIEND OF EVENT INVITEE'S FRIENDS
	    case($database->database_num_rows($database->database_query("SELECT t2.friend_user_id2 FROM se_eventmembers LEFT JOIN se_friends AS t1 ON se_eventmembers.eventmember_user_id=t1.friend_user_id1 AND se_eventmembers.eventmember_status<>'-1' LEFT JOIN se_friends AS t2 ON t1.friend_user_id2=t2.friend_user_id1 WHERE se_eventmembers.eventmember_event_id='".$event->event_info[event_id]."' AND t2.friend_user_id2='".$user->user_info[user_id]."'")) != 0):
	      $privacy_level = 2;
	      break;
    
	    // REGISTERED USER
	    case($user->user_exists != 0):
	      $privacy_level = 1;
	      break;
    
	    // EVERYONE (DEFAULT)
	    default:	
	      $privacy_level = 0;
	      break;

	  }

	  // MAKE SURE PRIVACY LEVEL IS ALLOWED BY ADMIN
	  $allowable_privacy = str_split($allowable_privacy);
	  rsort($allowable_privacy);
	  if($privacy_level >= $allowable_privacy[0]) {
	    $privacy_level = 7;
	  }

	  // RETURN PRIVACY LEVEL
	  return $privacy_level;
	  
	} // END event_privacy_max() METHOD








	// THIS METHOD RETURNS THE TOTAL NUMBER OF INVITED USERS IN AN EVENT
	// INPUT: $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	//	  $member_details (OPTIONAL) REPRESENTING WHETHER TO JOIN TO THE USER TABLE FOR SEARCH PURPOSES
	// OUTPUT: AN INTEGER REPRESENTING THE NUMBER OF EVENT MEMBERS
	function event_member_total($where = "", $member_details = 0) {
	  global $database;

	  // BEGIN QUERY
	  $eventmember_query = "SELECT se_eventmembers.eventmember_id FROM se_eventmembers";

	  // JOIN TO USER TABLE IF NECESSARY
	  if($member_details == 1) { $eventmember_query .= " LEFT JOIN se_users ON se_eventmembers.eventmember_user_id=se_users.user_id"; }

	  // ADD WHERE IF NECESSARY
	  if($this->event_exists != 0 | $where != "") { $eventmember_query .= " WHERE"; }

	  // IF EVENT ID IS SET
	  if($this->event_exists != 0) { $eventmember_query .= " se_eventmembers.eventmember_event_id='".$this->event_info[event_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->event_exists != 0 & $where != "") { $eventmember_query .= " AND"; }  

	  // ADD REST OF WHERE CLAUSE
	  if($where != "") { $eventmember_query .= " $where"; }

	  // RUN QUERY
	  $eventmember_total = $database->database_num_rows($database->database_query($eventmember_query));
	  return $eventmember_total;

	} // END event_member_total() METHOD








	// THIS METHOD RETURNS AN ARRAY OF EVENT INVITEES
	// INPUT: $start REPRESENTING THE EVENT MEMBER TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF EVENT MEMBERS TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN ARRAY OF EVENT MEMBERS
	function event_member_list($start, $limit, $sort_by = "eventmember_id DESC", $where = "") {
	  global $database;

	  // BEGIN QUERY
	  $eventmember_query = "SELECT se_eventmembers.*, se_users.user_id, se_users.user_username, se_users.user_photo, se_users.user_dateupdated, se_users.user_lastlogindate, se_users.user_signupdate FROM se_eventmembers LEFT JOIN se_users ON se_eventmembers.eventmember_user_id=se_users.user_id";

	  // ADD WHERE IF NECESSARY
	  if($this->event_exists != 0 | $where != "") { $eventmember_query .= " WHERE"; }

	  // IF EVENT ID IS SET
	  if($this->event_exists != 0) { $eventmember_query .= " se_eventmembers.eventmember_event_id='".$this->event_info[event_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->event_exists != 0 & $where != "") { $eventmember_query .= " AND"; }  

	  // ADD REST OF WHERE CLAUSE
	  if($where != "") { $eventmember_query .= " $where"; }

	  // ADD ORDER, AND LIMIT CLAUSE
	  $eventmember_query .= " ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $eventmembers = $database->database_query($eventmember_query);

	  // GET EVENT MEMBERS INTO AN ARRAY
	  $eventmember_array = Array();
	  while($eventmember_info = $database->database_fetch_assoc($eventmembers)) {

	    // CREATE OBJECT FOR MEMBER
	    $member = new se_user();
	    $member->user_exists = 1;
	    $member->user_info[user_id] = $eventmember_info[user_id];
	    $member->user_info[user_username] = $eventmember_info[user_username];
	    $member->user_info[user_photo] = $eventmember_info[user_photo];
	    $member->user_info[user_dateupdated] = $eventmember_info[user_dateupdated];
	    $member->user_info[user_lastlogindate] = $eventmember_info[user_lastlogindate];
	    $member->user_info[user_signupdate] = $eventmember_info[user_signupdate];

	    // SET EVENT ARRAY
	    $eventmember_array[] = Array('eventmember_id' => $eventmember_info[eventmember_id],
					'eventmember_status' => $eventmember_info[eventmember_status],
					'eventmember_title' => $eventmember_info[eventmember_title],
					'member' => $member);
	  }

	  // RETURN ARRAY
	  return $eventmember_array;

	} // END event_member_list() METHOD








	// THIS METHOD RETURNS THE PATH TO THE GIVEN EVENT'S DIRECTORY
	// INPUT: $event_id (OPTIONAL) REPRESENTING A EVENT'S EVENT_ID
	// OUTPUT: A STRING REPRESENTING THE RELATIVE PATH TO THE EVENT'S DIRECTORY
	function event_dir($event_id = 0) {

	  if($event_id == 0 & $this->event_exists) { $event_id = $this->event_info[event_id]; }

	  $subdir = $event_id+999-(($event_id-1)%1000);
	  $eventdir = "./uploads_event/$subdir/$event_id/";
	  return $eventdir;

	} // END event_dir() METHOD








	// THIS METHOD OUTPUTS THE PATH TO THE EVENT'S PHOTO OR THE GIVEN NOPHOTO IMAGE
	// INPUT: $nophoto_image (OPTIONAL) REPRESENTING THE PATH TO AN IMAGE TO OUTPUT IF NO PHOTO EXISTS
	// OUTPUT: A STRING CONTAINING THE PATH TO THE EVENT'S PHOTO
	function event_photo($nophoto_image = "") {

	  $event_photo = $this->event_dir($this->event_info[event_id]).$this->event_info[event_photo];
	  if(!file_exists($event_photo) | $this->event_info[event_photo] == "") { $event_photo = $nophoto_image; }
	  return $event_photo;
	  
	} // END event_photo() METHOD








	// THIS METHOD UPLOADS AN EVENT PHOTO ACCORDING TO SPECIFICATIONS AND RETURNS EVENT PHOTO
	// INPUT: $photo_name REPRESENTING THE NAME OF THE FILE INPUT
	// OUTPUT: 
	function event_photo_upload($photo_name) {
	  global $database, $url;

	  // SET KEY VARIABLES
	  $file_maxsize = "4194304";
	  $file_exts = explode(",", str_replace(" ", "", strtolower($this->eventowner_level_info[level_event_photo_exts])));
	  $file_types = explode(",", str_replace(" ", "", strtolower("image/jpeg, image/jpg, image/jpe, image/pjpeg, image/pjpg, image/x-jpeg, x-jpg, image/gif, image/x-gif, image/png, image/x-png")));
	  $file_maxwidth = $this->eventowner_level_info[level_event_photo_width];
	  $file_maxheight = $this->eventowner_level_info[level_event_photo_height];
	  $photo_newname = "0_".rand(1000, 9999).".jpg";
	  $file_dest = $this->event_dir($this->event_info[event_id]).$photo_newname;

	  $new_photo = new se_upload();
	  $new_photo->new_upload($photo_name, $file_maxsize, $file_exts, $file_types, $file_maxwidth, $file_maxheight);

	  // UPLOAD AND RESIZE PHOTO IF NO ERROR
	  if($new_photo->is_error == 0) {

	    // DELETE OLD AVATAR IF EXISTS
	    $this->event_photo_delete();

	    // CHECK IF IMAGE RESIZING IS AVAILABLE, OTHERWISE MOVE UPLOADED IMAGE
	    if($new_photo->is_image == 1) {
	      $new_photo->upload_photo($file_dest);
	    } else {
	      $new_photo->upload_file($file_dest);
	    }

	    // UPDATE EVENT INFO WITH IMAGE IF STILL NO ERROR
	    if($new_photo->is_error == 0) {
	      $database->database_query("UPDATE se_events SET event_photo='$photo_newname' WHERE event_id='".$this->event_info[event_id]."'");
	      $this->event_info[event_photo] = $photo_newname;
	    }
	  }
	
	  $this->is_error = $new_photo->is_error;
	  $this->error_message = $new_photo->error_message;
	  
	} // END event_photo_upload() METHOD








	// THIS METHOD DELETES A EVENT PHOTO
	// INPUT: 
	// OUTPUT: 
	function event_photo_delete() {
	  global $database;
	  $event_photo = $this->event_photo();
	  if($event_photo != "") {
	    unlink($event_photo);
	    $database->database_query("UPDATE se_events SET event_photo='' WHERE event_id='".$this->event_info[event_id]."'");
	    $this->event_info[event_photo] = "";
	  }
	} // END event_photo_delete() METHOD








	// THIS METHOD UPLOADS MEDIA TO A EVENT ALBUM
	// INPUT: $file_name REPRESENTING THE NAME OF THE FILE INPUT
	//	  $eventalbum_id REPRESENTING THE ID OF THE EVENT ALBUM TO UPLOAD THE MEDIA TO
	//	  $space_left REPRESENTING THE AMOUNT OF SPACE LEFT
	// OUTPUT:
	function event_media_upload($file_name, $eventalbum_id, &$space_left) {
	  global $class_event, $database, $url;

	  // SET KEY VARIABLES
	  $file_maxsize = $this->eventowner_level_info[level_event_album_maxsize];
	  $file_exts = explode(",", str_replace(" ", "", strtolower($this->eventowner_level_info[level_event_album_exts])));
	  $file_types = explode(",", str_replace(" ", "", strtolower($this->eventowner_level_info[level_event_album_mimes])));
	  $file_maxwidth = $this->eventowner_level_info[level_event_album_width];
	  $file_maxheight = $this->eventowner_level_info[level_event_album_height];

	  $new_media = new se_upload();
	  $new_media->new_upload($file_name, $file_maxsize, $file_exts, $file_types, $file_maxwidth, $file_maxheight);

	  // UPLOAD AND RESIZE PHOTO IF NO ERROR
	  if($new_media->is_error == 0) {

	    // INSERT ROW INTO MEDIA TABLE
	    $database->database_query("INSERT INTO se_eventmedia (
							eventmedia_eventalbum_id,
							eventmedia_date
							) VALUES (
							'$eventalbum_id',
							'".time()."'
							)");
	    $eventmedia_id = $database->database_insert_id();

	    // CHECK IF IMAGE RESIZING IS AVAILABLE, OTHERWISE MOVE UPLOADED IMAGE
	    if($new_media->is_image == 1) {
	      $file_dest = $this->event_dir($this->event_info[event_id]).$eventmedia_id.".jpg";
	      $thumb_dest = $this->event_dir($this->event_info[event_id]).$eventmedia_id."_thumb.jpg";
	      $new_media->upload_photo($file_dest);
	      $new_media->upload_photo($thumb_dest, 200, 200);
	      $file_ext = "jpg";
	      $file_filesize = filesize($file_dest);
	    } else {
	      $file_dest = $this->event_dir($this->event_info[event_id]).$eventmedia_id.".".$new_media->file_ext;
	      $new_media->upload_file($file_dest);
	      $file_ext = $new_media->file_ext;
	      $file_filesize = filesize($file_dest);
	    }

	    // CHECK SPACE LEFT
	    if($file_filesize > $space_left) {
	      $new_media->is_error = 1;
	      $new_media->error_message = $class_event[1].$_FILES[$file_name]['name'];
	    } else {
	      $space_left = $space_left-$file_filesize;
	    }

	    // DELETE FROM DATABASE IF ERROR
	    if($new_media->is_error != 0) {
	      $database->database_query("DELETE FROM se_eventmedia WHERE eventmedia_id='$eventmedia_id' AND eventmedia_eventalbum_id='$eventalbum_id'");
	      @unlink($file_dest);

	    // UPDATE ROW IF NO ERROR
	    } else {
	      $database->database_query("UPDATE se_eventmedia SET eventmedia_ext='$file_ext', eventmedia_filesize='$file_filesize' WHERE eventmedia_id='$eventmedia_id' AND eventmedia_eventalbum_id='$eventalbum_id'");
	    }
	  }
	
	  // RETURN FILE STATS
	  $file = Array('is_error' => $new_media->is_error,
			'error_message' => $new_media->error_message,
			'eventmedia_id' => $eventmedia_id,
			'eventmedia_ext' => $file_ext,
			'eventmedia_filesize' => $file_filesize);
	  return $file;

	} // END event_media_upload() METHOD








	// THIS METHOD RETURNS THE SPACE USED
	// INPUT: $eventalbum_id (OPTIONAL) REPRESENTING THE ID OF THE ALBUM TO CALCULATE
	// OUTPUT: AN INTEGER REPRESENTING THE SPACE USED
	function event_media_space($eventalbum_id = 0) {
	  global $database;

	  // BEGIN QUERY
	  $eventmedia_query = "SELECT sum(se_eventmedia.eventmedia_filesize) AS total_space";
	
	  // CONTINUE QUERY
	  $eventmedia_query .= " FROM se_eventalbums LEFT JOIN se_eventmedia ON se_eventalbums.eventalbum_id=se_eventmedia.eventmedia_eventalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->event_exists != 0 | $eventalbum_id != 0) { $eventmedia_query .= " WHERE"; }

	  // IF EVENT EXISTS, SPECIFY EVENT ID
	  if($this->event_exists != 0) { $eventmedia_query .= " se_eventalbums.eventalbum_event_id='".$this->event_info[event_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->event_exists != 0 & $eventalbum_id != 0) { $eventmedia_query .= " AND"; }

	  // SPECIFY ALBUM ID IF NECESSARY
	  if($eventalbum_id != 0) { $eventmedia_query .= " se_eventalbums.eventalbum_id='$eventalbum_id'"; }

	  // GET AND RETURN TOTAL SPACE USED
	  $space_info = $database->database_fetch_assoc($database->database_query($eventmedia_query));
	  return $space_info[total_space];

	} // END event_media_space() METHOD








	// THIS METHOD RETURNS THE NUMBER OF EVENT MEDIA
	// INPUT: $eventalbum_id (OPTIONAL) REPRESENTING THE ID OF THE EVENT ALBUM TO CALCULATE
	// OUTPUT: AN INTEGER REPRESENTING THE NUMBER OF FILES
	function event_media_total($eventalbum_id = 0) {
	  global $database;

	  // BEGIN QUERY
	  $eventmedia_query = "SELECT count(se_eventmedia.eventmedia_id) AS total_files";
	
	  // CONTINUE QUERY
	  $eventmedia_query .= " FROM se_eventalbums LEFT JOIN se_eventmedia ON se_eventalbums.eventalbum_id=se_eventmedia.eventmedia_eventalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->event_exists != 0 | $eventalbum_id != 0) { $eventmedia_query .= " WHERE"; }

	  // IF EVENT EXISTS, SPECIFY EVENT ID
	  if($this->event_exists != 0) { $eventmedia_query .= " se_eventalbums.eventalbum_event_id='".$this->event_info[event_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->event_exists != 0 & $eventalbum_id != 0) { $eventmedia_query .= " AND"; }

	  // SPECIFY ALBUM ID IF NECESSARY
	  if($eventalbum_id != 0) { $eventmedia_query .= " se_eventalbums.eventalbum_id='$eventalbum_id'"; }

	  // GET AND RETURN TOTAL FILES
	  $file_info = $database->database_fetch_assoc($database->database_query($eventmedia_query));
	  return $file_info[total_files];

	} // END event_media_total() METHOD








	// THIS METHOD RETURNS AN ARRAY OF EVENT MEDIA
	// INPUT: $start REPRESENTING THE EVENT MEDIA TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF EVENT MEDIA TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN ARRAY OF EVENT MEDIA
	function event_media_list($start, $limit, $sort_by = "eventmedia_id DESC", $where = "") {
	  global $database;

	  // BEGIN QUERY
	  $eventmedia_query = "SELECT se_eventmedia.*, se_eventalbums.eventalbum_id, se_eventalbums.eventalbum_event_id, se_eventalbums.eventalbum_title, count(se_eventmediacomments.eventmediacomment_id) AS total_comments";
	
	  // CONTINUE QUERY
	  $eventmedia_query .= " FROM se_eventmedia LEFT JOIN se_eventmediacomments ON se_eventmediacomments.eventmediacomment_eventmedia_id=se_eventmedia.eventmedia_id LEFT JOIN se_eventalbums ON se_eventalbums.eventalbum_id=se_eventmedia.eventmedia_eventalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->event_exists != 0 | $where != "") { $eventmedia_query .= " WHERE"; }

	  // IF EVENT EXISTS, SPECIFY EVENT ID
	  if($this->event_exists != 0) { $eventmedia_query .= " se_eventalbums.eventalbum_event_id='".$this->event_info[event_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->event_exists != 0 & $where != "") { $eventmedia_query .= " AND"; }

	  // ADD ADDITIONAL WHERE CLAUSE
	  if($where != "") { $eventmedia_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $eventmedia_query .= " GROUP BY eventmedia_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $eventmedia = $database->database_query($eventmedia_query);

	  // GET EVENT MEDIA INTO AN ARRAY
	  $eventmedia_array = Array();
	  while($eventmedia_info = $database->database_fetch_assoc($eventmedia)) {

	    // CREATE ARRAY OF MEDIA DATA
	    $eventmedia_array[] = Array('eventmedia_id' => $eventmedia_info[eventmedia_id],
					'eventmedia_eventalbum_id' => $eventmedia_info[eventmedia_eventalbum_id],
					'eventmedia_date' => $eventmedia_info[eventmedia_date],
					'eventmedia_title' => $eventmedia_info[eventmedia_title],
					'eventmedia_desc' => str_replace("<br>", "\r\n", $eventmedia_info[eventmedia_desc]),
					'eventmedia_ext' => $eventmedia_info[eventmedia_ext],
					'eventmedia_filesize' => $eventmedia_info[eventmedia_filesize],
					'eventmedia_comments_total' => $eventmedia_info[total_comments]);

	  }

	  // RETURN ARRAY
	  return $eventmedia_array;

	} // END event_media_list() METHOD








	// THIS METHOD UPDATES EVENT MEDIA INFORMATION
	// INPUT: $start REPRESENTING THE EVENT MEDIA TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF EVENT MEDIA TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN ARRAY CONTAINING ALL THE EVENT MEDIA ID
	function event_media_update($start, $limit, $sort_by = "eventmedia_id DESC", $where = "") {
	  global $database;

	  // BEGIN QUERY
	  $eventmedia_query = "SELECT se_eventmedia.*, se_eventalbums.eventalbum_id, se_eventalbums.eventalbum_event_id, se_eventalbums.eventalbum_title, count(se_eventmediacomments.eventmediacomment_id) AS total_comments";
	
	  // CONTINUE QUERY
	  $eventmedia_query .= " FROM se_eventmedia LEFT JOIN se_eventmediacomments ON se_eventmediacomments.eventmediacomment_eventmedia_id=se_eventmedia.eventmedia_id LEFT JOIN se_eventalbums ON se_eventalbums.eventalbum_id=se_eventmedia.eventmedia_eventalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->event_exists != 0 | $where != "") { $eventmedia_query .= " WHERE"; }

	  // IF EVENT EXISTS, SPECIFY EVENT ID
	  if($this->event_exists != 0) { $eventmedia_query .= " se_eventalbums.eventalbum_event_id='".$this->event_info[event_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->event_exists != 0 & $where != "") { $eventmedia_query .= " AND"; }

	  // ADD ADDITIONAL WHERE CLAUSE
	  if($where != "") { $eventmedia_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $eventmedia_query .= " GROUP BY eventmedia_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $eventmedia = $database->database_query($eventmedia_query);

	  // GET EVENT MEDIA INTO AN ARRAY
	  $eventmedia_array = Array();
	  while($eventmedia_info = $database->database_fetch_assoc($eventmedia)) {
	    $var1 = "eventmedia_title_".$eventmedia_info[eventmedia_id];
	    $var2 = "eventmedia_desc_".$eventmedia_info[eventmedia_id];
	    $eventmedia_title = censor($_POST[$var1]);
	    $eventmedia_desc = censor(str_replace("\r\n", "<br>", $_POST[$var2]));
	    if($eventmedia_title != $eventmedia_info[eventmedia_title] OR $eventmedia_desc != $eventmedia_info[eventmedia_desc]) {
	      $database->database_query("UPDATE se_eventmedia SET eventmedia_title='$eventmedia_title', eventmedia_desc='$eventmedia_desc' WHERE eventmedia_id='$eventmedia_info[eventmedia_id]'");
	    }
	    $eventmedia_array[] = $eventmedia_info[eventmedia_id];
	  }

	  return $eventmedia_array;

	} // END event_media_update() METHOD








	// THIS METHOD DELETES SELECTED EVENT MEDIA
	// INPUT: $start REPRESENTING THE EVENT MEDIA TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF EVENT MEDIA TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT:
	function event_media_delete($start, $limit, $sort_by = "eventmedia_id DESC", $where = "") {
	  global $database, $url;

	  // BEGIN QUERY
	  $eventmedia_query = "SELECT se_eventmedia.*, se_eventalbums.eventalbum_id, se_eventalbums.eventalbum_event_id, se_eventalbums.eventalbum_title, count(se_eventmediacomments.eventmediacomment_id) AS total_comments";
	
	  // CONTINUE QUERY
	  $eventmedia_query .= " FROM se_eventmedia LEFT JOIN se_eventmediacomments ON se_eventmediacomments.eventmediacomment_eventmedia_id=se_eventmedia.eventmedia_id LEFT JOIN se_eventalbums ON se_eventalbums.eventalbum_id=se_eventmedia.eventmedia_eventalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->event_exists != 0 | $where != "") { $eventmedia_query .= " WHERE"; }

	  // IF EVENT EXISTS, SPECIFY EVENT ID
	  if($this->event_exists != 0) { $eventmedia_query .= " se_eventalbums.eventalbum_event_id='".$this->event_info[event_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->event_exists != 0 & $where != "") { $eventmedia_query .= " AND"; }

	  // ADD ADDITIONAL WHERE CLAUSE
	  if($where != "") { $eventmedia_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $eventmedia_query .= " GROUP BY eventmedia_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $eventmedia = $database->database_query($eventmedia_query);

	  // LOOP OVER EVENT MEDIA
	  $eventmedia_delete = "";
	  while($eventmedia_info = $database->database_fetch_assoc($eventmedia)) {
	    $var = "delete_eventmedia_".$eventmedia_info[eventmedia_id];
	    if($_POST[$var] == 1) { 
	      if($eventmedia_delete != "") { $eventmedia_delete .= " OR "; }
	      $eventmedia_delete .= "eventmedia_id='$eventmedia_info[eventmedia_id]'";
	      $eventmedia_path = $this->event_dir($this->event_info[event_id]).$eventmedia_info[eventmedia_id].".".$eventmedia_info[eventmedia_ext];
	      if(file_exists($eventmedia_path)) { unlink($eventmedia_path); }
	      $thumb_path = $this->event_dir($this->event_info[event_id]).$eventmedia_info[eventmedia_id]."_thumb.".$eventmedia_info[eventmedia_ext];
	      if(file_exists($thumb_path)) { unlink($thumb_path); }
	    }
	  }

	  // IF DELETE CLAUSE IS NOT EMPTY, DELETE EVENT MEDIA
	  if($eventmedia_delete != "") { $database->database_query("DELETE FROM se_eventmedia, se_eventmediacomments USING se_eventmedia LEFT JOIN se_eventmediacomments ON se_eventmedia.eventmedia_id=se_eventmediacomments.eventmediacomment_eventmedia_id WHERE ($eventmedia_delete)"); }

	} // END event_media_delete() METHOD

}
?>