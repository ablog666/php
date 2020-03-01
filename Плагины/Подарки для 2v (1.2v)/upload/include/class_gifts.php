<?


class se_gifts {

	// INITIALIZE VARIABLES
	var $is_error;			// DETERMINES WHETHER THERE IS AN ERROR OR NOT
	var $error_message;		// CONTAINS RELEVANT ERROR MESSAGE

	var $user_id;			// CONTAINS THE USER ID OF THE USER WHOSE gifts WE ARE EDITING








	// THIS METHOD SETS INITIAL VARS
	// INPUT: $user_id (OPTIONAL) REPRESENTING THE USER ID OF THE USER WHOSE giftsS WE ARE CONCERNED WITH
	// OUTPUT: 
	function se_gifts($user_id = 0) {

	  $this->user_id = $user_id;

	} // END se_gifts() METHOD








	// THIS METHOD RETURNS THE TOTAL NUMBER OF giftsS
	// INPUT: $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN INTEGER REPRESENTING THE NUMBER OF giftsS
	function gifts_total($where = "") {
	  global $database;

	  // BEGIN gifts QUERY
	  $gifts_query = "SELECT gifts_id FROM se_gifts";

	  // ADD WHERE CLAUSE, IF NECESSARY
	  if($where != "") { $gifts_query .= " $where"; }

	  // GET AND RETURN TOTAL PHOTO giftsS
	  $gifts_total = $database->database_num_rows($database->database_query($gifts_query));
	  return $gifts_total;


	} // END gifts_total() METHOD



	function gifts_user_total($where = "") {
	  global $database;

	  // BEGIN gifts QUERY
	  $gifts_query = "SELECT gifts_id FROM se_gifts_user";

	  // ADD WHERE CLAUSE, IF NECESSARY
	  if($where != "") { $gifts_query .= " WHERE $where"; }
	  // GET AND RETURN TOTAL PHOTO giftsS
	  $gifts_total = $database->database_num_rows($database->database_query($gifts_query));
	  return $gifts_total;


	} // END gifts_total() METHOD





	// THIS METHOD RETURNS AN ARRAY OF gifts
	// INPUT: $start REPRESENTING THE gifts TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF giftsS TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	// OUTPUT: AN ARRAY OF gifts
	function gifts_list($start, $limit, $sort_by = "gifts_id DESC",$where="") {
	  global $database;

	  // BEGIN QUERY
	  $gifts_query = "SELECT * FROM se_gifts";
	
	 if($where != ""){
	  $gifts_query .= " WHERE ".$where;
	 }	

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $gifts_query .= " GROUP BY gifts_id ORDER BY $sort_by LIMIT $start, $limit";
	  // RUN QUERY
	  $gifts = $database->database_query($gifts_query);

	  // GET giftsS INTO AN ARRAY
	  $gifts_array = Array();
	  while($gifts_info = $database->database_fetch_assoc($gifts)) {

	      $gifts_category = $database->database_query("SELECT gifts_cat_name FROM se_gifts_cat WHERE gifts_cat_id='$gifts_info[gifts_category]'");
	      if($database->database_num_rows($gifts_category) == 1) {
	        $gifts_cat_array = $database->database_fetch_assoc($gifts_category);
	        $gifts_cat_name = $gifts_cat_array[gifts_cat_name];
	      }

	    // CREATE ARRAY OF gifts DATA
	    $gifts_array[] = Array('gifts_id' => $gifts_info[gifts_id],
				   'gifts_cat_name' => $gifts_cat_name,
				   'gifts_category' => $gifts_info[gifts_category],
			           'gifts_price' => $gifts_info[gifts_price]);

	  }

	  // RETURN ARRAY
	  return $gifts_array;

	} // END gifts_list() METHOD




	// THIS METHOD RETURNS AN ARRAY OF gifts category
	// INPUT: $start REPRESENTING THE gifts TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF gifts TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	// OUTPUT: AN ARRAY OF gifts
	function giftsc_list($start, $limit, $sort_by = "gifts_cat_id ASC") {
	  global $database;

	  // BEGIN QUERY
	  $gifts_query = "SELECT * FROM se_gifts_cat";
	

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $gifts_query .= " GROUP BY gifts_cat_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $gifts = $database->database_query($gifts_query);

	  // GET giftsS INTO AN ARRAY
	  $gifts_array = Array();
	  while($gifts_info = $database->database_fetch_assoc($gifts)) {
	    // CREATE ARRAY OF gifts DATA
	    $gifts_array[] = Array('giftsc_id' => $gifts_info[gifts_cat_id],
			           'giftsc_name' => $gifts_info[gifts_cat_name]);

	  }

	  // RETURN ARRAY
	  return $gifts_array;

	} // END giftsc_list() METHOD






	// THIS METHOD DELETES A SPECIFIED gifts category
	// INPUT: $gifts_cat_id REPRESENTING THE ID OF THE gifts TO DELETE
	// OUTPUT: 
	function gifts_cat_delete($gifts_id) {
	  global $database;

	  $media = $database->database_query("SELECT gifts_id FROM se_gifts WHERE gifts_category='$gifts_id'");

	  // LOOP OVER MEDIA
	  while($media_info = $database->database_fetch_assoc($media)) {
	    unlink('../images/gifts/'.$media_info[gifts_id].'.png');
	  }
	
	  $database->database_query("DELETE FROM se_gifts_cat, se_gifts, se_gifts_user USING se_gifts_cat LEFT JOIN se_gifts ON se_gifts_cat.gifts_cat_id=se_gifts.gifts_category  LEFT JOIN se_gifts_user ON se_gifts.gifts_id=se_gifts_user.gifts_user_id WHERE se_gifts_cat.gifts_cat_id='$gifts_id'");

	} // END gifts_delete() METHOD



	// THIS METHOD DELETES A SPECIFIED gifts
	// INPUT: $gifts_id REPRESENTING THE ID OF THE gifts TO DELETE
	// OUTPUT: 
	function gifts_delete($gifts_id) {
	  global $database;

	  $database->database_query("DELETE FROM se_gifts, se_gifts_user USING se_gifts LEFT JOIN se_gifts_user ON se_gifts.gifts_id=se_gifts_user.gifts_user_id WHERE se_gifts.gifts_id='$gifts_id'");
	  unlink('../images/gifts/'.$gifts_id.'.png');

	} // END gifts_delete() METHOD



	// THIS METHOD ADD NEW GIFTS
	// INPUT: $file_name REPRESENTING THE NAME OF THE FILE INPUT
	//	  $gifts_id_cat CATEGORY OF GIFTS
	//	  $gifts_price PRICE OF GIFTS
	// OUTPUT:
	function add_gifts($file_name, $gifts_id_cat,$gifts_price) {
	  global $database,$url;

	  // SET KEY VARIABLES
	  $file_maxsize = 1024*1024*5;
	  $file_exts = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
	  $file_types = array('image/png','image/gif','image/jpeg');
	  $file_maxwidth = 100;
	  $file_maxheight = 100;

	  $new_media = new se_upload();
	  $new_media->new_upload($file_name, $file_maxsize, $file_exts, $file_types, $file_maxwidth, $file_maxheight);

	  // UPLOAD AND RESIZE PHOTO IF NO ERROR
	  if($new_media->is_error == 0) {

	    // INSERT ROW INTO GIFTS TABLE
	    $database->database_query("INSERT INTO se_gifts (
							gifts_id,
							gifts_category,
							gifts_price
							) VALUES (
							NULL,
							'$gifts_id_cat',
							'$gifts_price'
							)");
	    $media_id = $database->database_insert_id();

	      $file_dest = "../images/gifts/".$media_id.".png";

	      $new_media->upload_photo($file_dest);




	    // DELETE FROM DATABASE IF ERROR
	    if($new_media->is_error != 0) {
	      $database->database_query("DELETE FROM se_media WHERE media_id='$media_id' AND media_album_id='$album_id'");
	      @unlink($file_dest);

	    // UPDATE ROW IF NO ERROR
	    }
	  }
	
	  // RETURN FILE STATS
	  $file = $new_media->error_message;

	  return $file;

	} // END album_media_upload() METHOD

	// THIS METHOD ADD NEW GIFTS CATEGORY
	// INPUT: $name CATEGORY NAME
	// OUTPUT:	
	function add_gifts_cat($name) {
	global $database;
	    // INSERT ROW INTO GIFTS CATEGORY TABLE
	    $database->database_query("INSERT INTO se_gifts_cat (gifts_cat_id,gifts_cat_name) VALUES (NULL,'$name')");
	return "$class_gifts[7]";
	}

	
	// THIS METHOD UPDATE GIFTS
	// INPUT: $gifts_id ID OF UPDATE GIFTS
	//	  $gifts_id_cat NEW CATEGORY OF GIFTS
	//	  $gifts_price NEW PRICE OF GIFTS
	// OUTPUT:	
	function update_gifts($gifts_id,$gifts_id_cat,$gifts_price) {
	global $database;
	    // INSERT ROW INTO GIFTS CATEGORY TABLE
	$db_query=$database->database_query("UPDATE se_gifts SET gifts_category='$gifts_id_cat',gifts_price='$gifts_price' WHERE gifts_id='$gifts_id'");
	    if($db_query){
		$ret="$class_gifts[1] #$gifts_id $class_gifts[2]";
	    }else{
		$ret="$class_gifts[3] #$gifts_id";
	    }

	return $ret;
	}
	// THIS METHOD UPDATE GIFTS CATEGOTY
	// INPUT: $gifts_cat_id ID OF UPDATE GIFTS CATEGORY
	//	  $gifts_cat_name NEW CATEGORY NAME
	// OUTPUT:	
	function update_gifts_cat($gifts_cat_id,$gifts_cat_name) {
	global $database;
	    // INSERT ROW INTO GIFTS CATEGORY TABLE
	$db_query=$database->database_query("UPDATE se_gifts_cat SET gifts_cat_name='$gifts_cat_name' WHERE gifts_cat_id='$gifts_cat_id'");
	    if($db_query){
		$ret="$class_gifts[4] #$gifts_cat_id $class_gifts[5]";
	    }else{
		$ret="$class_gifts[6] #$gifts_cat_id";
	    }

	return $ret;
	}

	// THIS METHOD RETURNS AN ARRAY OF GIFTS USERS
	// INPUT: $start REPRESENTING THE GIFTS TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF GIFTS TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN ARRAY OF GIFTS
	function gifts_user_list($start, $limit, $sort_by = "gifts_user_id DESC", $where = "") {
	  global $database, $user, $owner;

	  // BEGIN QUERY
	  $gifts_query = "SELECT se_gifts_user.*, se_gifts_cat.gifts_cat_name, count(se_gifts_user.gifts_user_id) AS total_gifts ";
	
	  // CONTINUE QUERY
	  $gifts_query .= " FROM se_gifts_user LEFT JOIN se_gifts ON se_gifts.gifts_id=se_gifts_user.gifts_id LEFT JOIN se_gifts_cat ON se_gifts_cat.gifts_cat_id=se_gifts.gifts_category ";

	  // ADD WHERE CLAUSE, IF NECESSARY
	  if($where != "") { $gifts_query .= " WHERE $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $gifts_query .= "  GROUP BY gifts_user_id ORDER BY se_gifts_user.gifts_user_id DESC LIMIT $start, $limit";

	  // RUN QUERY
	  $gifts = $database->database_query($gifts_query);

	  // GET gifts INTO AN ARRAY
	  $gifts_array = Array();
	  while($gifts_info = $database->database_fetch_assoc($gifts)) {

	    $author = new se_user(array($gifts_info[gifts_fuser_id]));
	    $to = new se_user(array($gifts_info[gifts_tuser_id]));

	    // CREATE ARRAY OF gifts DATA
	    $gifts_array[] = Array('gifts_user_id' => $gifts_info[gifts_user_id],
				     'gifts_id' => $gifts_info[gifts_id],
				     'gifts_category' => $gifts_info[gifts_cat_name],
				     'gifts_type' => $gifts_info[gifts_type],
				     'gifts_comment' => $gifts_info[gifts_comment],
				     'gifts_type' => $gifts_info[gifts_type],
				     'gifts_from' => $author,
				     'gifts_to' => $to);

	  }

	  // RETURN ARRAY
	  return $gifts_array;

	} // END gifts_user_list() METHOD


	function gifts_user_delete($gifts_id) {
	  global $database;

	  $database->database_query("DELETE FROM se_gifts_user WHERE gifts_user_id='$gifts_id'");


	} // END gifts_delete() METHOD


	
	function add_user_gifts($to_id,$from_id,$gifts_type,$gifts_comment,$gifts_id) {
	global $database,$setting,$url;
	$sql="INSERT INTO se_gifts_user VALUES (NULL,'$gifts_id','$from_id','$to_id','$gifts_comment','$gifts_type')";
	$to = new se_user(array($to_id));
        send_generic($to->user_info['user_email'], "$setting[setting_email_fromname] <$setting[setting_email_fromemail]>", $setting[setting_email_gifts_subject], $setting[setting_email_gifts_message], Array('[username]', '[link]'), Array($to->user_info['user_username'], "<a href='".$url->url_create('profile',$to->user_info['user_username'])."'>".$url->url_create('profile',$to->user_info['user_username'])."</a> "));	
	$database->database_query($sql);
	return "$class_gifts[7]";
	}
}
?>