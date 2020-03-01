<?

//  THIS CLASS CONTAINS classified ENTRY-RELATED METHODS 
//  METHODS IN THIS CLASS:
//    se_classified()
//    classifieds_total()
//    classifieds_list()
//    classified_fields()
//    classifieds_delete()
//    classified_post()
//    classified_delete()
//    classified_dir()
//    classified_photo()
//    classified_photo_upload()
//    classified_photo_delete()
//    classified_lastupdate()
//    classified_media_upload()
//    classified_media_space()
//    classified_media_total()
//    classified_media_list()
//    classified_media_delete()


class se_classified {

	// INITIALIZE VARIABLES
	var $is_error;				// DETERMINES WHETHER THERE IS AN ERROR OR NOT
	var $error_message;			// CONTAINS RELEVANT ERROR MESSAGE

	var $user_id;				// CONTAINS THE USER ID OF THE USER WHOSE CLASSIFIED WE ARE EDITING

	var $classified_exists;			// DETERMINES WHETHER THE CLASSIFIED HAS BEEN SET AND EXISTS OR NOT

	var $cats;				// CONTAINS ARRAY OF CLASSIFIED CATEGORIES WITH CORRESPONDING FIELD ARRAYS
	var $fields;				// CONTAINS ARRAY OF CLASSIFIED FIELDS FOR GIVEN CATEGORY
	var $field_query;			// CONTAINS A PARTIAL DATABASE QUERY TO SAVE/RETRIEVE FIELD VALUES

	var $classified_info;			// CONTAINS THE CLASSIFIED INFO OF THE CLASSIFIED WE ARE EDITING
	var $classifiedvalue_info;		// CONTAINS THE VALUES FOR CLASSIFIED FIELDS FOR THE CLASSIFIED WE ARE EDITING
	var $classifiedowner_level_info;	// CONTAINS THE CLASSIFIED CREATOR'S LEVEL INFO

	var $url_string;		// CONTAINS VARIOUS PARTIAL URL STRINGS (SITUATION DEPENDENT)






	// THIS METHOD SETS INITIAL VARS
	// INPUT: $user_id (OPTIONAL) REPRESENTING THE USER ID OF THE USER WHOSE classified WE ARE CONCERNED WITH
	// OUTPUT: 
	function se_classified($user_id = 0, $classified_id = 0) {

	  global $database, $user;

	  $this->user_id = $user_id;
	  $this->classified_exists = 0;
	  $this->is_member = 0;

	  if($classified_id != 0) {
	    $classified = $database->database_query("SELECT * FROM se_classifieds WHERE classified_id='$classified_id'");
	    if($database->database_num_rows($classified) == 1) {
	      $this->classified_exists = 1;
	      $this->classified_info = $database->database_fetch_assoc($classified);
	      $this->classifiedvalue_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_classifiedvalues WHERE classifiedvalue_classified_id='$classified_id' LIMIT 1"));

	      // GET LEVEL INFO
	      if($this->classified_info[classified_user_id] == $user->user_info[user_id]) {
	        $this->classifiedowner_level_info = $user->level_info;
	      } else {
		$this->classifiedowner_level_info = $database->database_fetch_assoc($database->database_query("SELECT se_levels.* FROM se_users LEFT JOIN se_levels ON se_users.user_level_id=se_levels.level_id WHERE se_users.user_id='".$this->classified_info[classified_user_id]."'"));
	      }

	    }
	  }

	} // END se_classified() METHOD








	// THIS METHOD RETURNS THE TOTAL NUMBER OF ENTRIES
	// INPUT: $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	//	  $classified_details (OPTIONAL) REPRESENTING WHETHER TO RETRIEVE THE VALUES FROM CLASSIFIEDVALUES TABLE AS WELL
	// OUTPUT: AN INTEGER REPRESENTING THE NUMBER OF ENTRIES
	function classifieds_total($where = "", $classified_details = 0) {
	  global $database;

	  // BEGIN ENTRY QUERY
	  $classified_query = "SELECT classified_id FROM se_classifieds";

	  // IF NO USER ID SPECIFIED, JOIN TO USER TABLE
	  if($this->user_id == 0) { $classified_query .= " LEFT JOIN se_users ON se_classifieds.classified_user_id=se_users.user_id"; }

	  // IF CLASSIFIED DETAILS
	  if($classified_details == 1) { $classified_query .= " LEFT JOIN se_classifiedvalues ON se_classifieds.classified_id=se_classifiedvalues.classifiedvalue_classified_id"; }

	  // ADD WHERE IF NECESSARY
	  if($where != "" | $this->user_id != 0) { $classified_query .= " WHERE"; }

	  // ENSURE USER ID IS NOT EMPTY
	  if($this->user_id != 0) { $classified_query .= " classified_user_id='".$this->user_id."'"; }

	  // INSERT AND IF NECESSARY
	  if($this->user_id != 0 & $where != "") { $classified_query .= " AND"; }

	  // ADD WHERE CLAUSE, IF NECESSARY
	  if($where != "") { $classified_query .= " $where"; }

	  // GET AND RETURN TOTAL classified ENTRIES
	  $classified_total = $database->database_num_rows($database->database_query($classified_query));
	  return $classified_total;

	} // END classifieds_total() METHOD








	// THIS METHOD RETURNS AN ARRAY OF classified ENTRIES
	// INPUT: $start REPRESENTING THE ENTRY TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF ENTRIES TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	//	  $classified_details (OPTIONAL) REPRESENTING WHETHER TO RETRIEVE THE VALUES FROM CLASSIFIEDVALUES TABLE AS WELL
	// OUTPUT: AN ARRAY OF classified ENTRIES
	function classifieds_list($start, $limit, $sort_by = "classified_date DESC", $where = "", $classified_details = 0) {
	  global $database, $user, $owner;

	  // BEGIN QUERY
	  $classified_query = "SELECT se_classifieds.*, se_classifiedcats.classifiedcat_title, count(classifiedcomment_id) AS total_comments";
	
	  // IF NO USER ID SPECIFIED, RETRIEVE USER INFORMATION
	  if($this->user_id == 0) { $classified_query .= ", se_users.user_id, se_users.user_username, se_users.user_photo"; }

	  // IF CLASSIFIED DETAILS
	  if($classified_details == 1) { $classified_query .= ", se_classifiedvalues.*"; }

	  // CONTINUE QUERY
	  $classified_query .= " FROM se_classifieds LEFT JOIN se_classifiedcats ON se_classifieds.classified_classifiedcat_id=se_classifiedcats.classifiedcat_id LEFT JOIN se_classifiedcomments ON se_classifieds.classified_id=se_classifiedcomments.classifiedcomment_classified_id";

	  // IF NO USER ID SPECIFIED, JOIN TO USER TABLE
	  if($this->user_id == 0) { $classified_query .= " LEFT JOIN se_users ON se_classifieds.classified_user_id=se_users.user_id"; }

	  // IF CLASSIFIED DETAILS
	  if($classified_details == 1) { $classified_query .= " LEFT JOIN se_classifiedvalues ON se_classifieds.classified_id=se_classifiedvalues.classifiedvalue_classified_id"; }

	  // ADD WHERE IF NECESSARY
	  if($where != "" | $this->user_id != 0) { $classified_query .= " WHERE"; }

	  // ENSURE USER ID IS NOT EMPTY
	  if($this->user_id != 0) { $classified_query .= " classified_user_id='".$this->user_id."'"; }

	  // INSERT AND IF NECESSARY
	  if($this->user_id != 0 & $where != "") { $classified_query .= " AND"; }

	  // ADD WHERE CLAUSE, IF NECESSARY
	  if($where != "") { $classified_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $classified_query .= " GROUP BY classified_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $classifieds = $database->database_query($classified_query);
echo mysql_error();
	  // GET classified ENTRIES INTO AN ARRAY
	  $classified_array = Array();
	  while($classified_info = $database->database_fetch_assoc($classifieds)) {

	    // CONVERT HTML CHARACTERS BACK
	    $classified_body = str_replace("\r\n", "", html_entity_decode($classified_info[classified_body]));

	    // IF NO USER ID SPECIFIED, CREATE OBJECT FOR AUTHOR
	    if($this->user_id == 0) {
	      $author = new se_user();
	      $author->user_exists = 1;
	      $author->user_info[user_id] = $classified_info[user_id];
	      $author->user_info[user_username] = $classified_info[user_username];
	      $author->user_info[user_photo] = $classified_info[user_photo];

	    // OTHERWISE, SET AUTHOR TO OWNER/LOGGED-IN USER
	    } elseif($owner->user_exists != 0 & $owner->user_info[user_id] == $classified_info[classified_user_id]) {
	      $author = $owner;
	    } elseif($user->user_exists != 0 & $user->user_info[user_id] == $classified_info[classified_user_id]) {
	      $author = $user;
	    }

	    // GET ENTRY COMMENT PRIVACY
// FIND A WAY TO MAKE THIS WORK WITH THE AUTHOR
	    $allowed_to_comment = 1;
	    if($owner->user_exists != 0) {
	      $comment_level = $owner->user_privacy_max($user, $owner->level_info[level_classified_comments]);
	      if($comment_level < true_privacy($classified_info[classified_comments], $owner->level_info[level_classified_comments])) { $allowed_to_comment = 0; }
	    }

	    // CREATE OBJECT FOR CLASSIFIED
	    $classified = new se_classified($classified_info[user_id]);
	    $classified->classified_exists = 1;
	    $classified->classified_info= $classified_info;

	    // SET classified ARRAY
	    $classified_array[] = Array('classified' => $classified,
					'classified_id' => $classified_info[classified_id],
					'classified_user_id' => $classified_info[classified_user_id],
					'classified_classifiedcat_id' => $classified_info[classified_classifiedcat_id],
					'classified_classifiedcat_title' => $classified_info[classifiedcat_title],
					'classified_date' => $classified_info[classified_date],
					'classified_views' => $classified_info[classified_views],
					'classified_title' => $classified_info[classified_title],
					'classified_body' => $classified_body,
					'classified_privacy' => $classified_info[classified_privacy],
					'classified_author' => $author,
					'total_comments' => $classified_info[total_comments],
					'allowed_to_comment' => $allowed_to_comment);
	  }

	  // RETURN ARRAY
	  return $classified_array;

	} // END classifieds_list() METHOD









	// THIS METHOD LOOPS AND/OR VALIDATES CLASSIFIED FIELD INPUT AND CREATES A PARTIAL QUERY TO UPDATE CLASSIFIEDVALUES TABLE
	// INPUT: $validate (OPTIONAL) REPRESENTING A BOOLEAN THAT DETERMINES WHETHER TO VALIDATE POST VARS OR NOT
	//	  $format (OPTIONAL) REPRESENTING A BOOLEAN THAT DETERMINES WHETHER TO CREATE FORMATTED FIELD VALUES
	//	  $search (OPTIONAL) REPRESENTING A "2" TO CREATE A SEARCH QUERY, A "1" TO CREATE A SEARCH QUERY, AND A "0" TO DO NOTHING
	//	  $cat_id (OPTIONAL) REPRESENTING THE ID OF THE CATEGORY TO SELECT FIELDS FROM (0 INDICATES ALL CATEGORIES)
	// OUTPUT: 
	function classified_fields($validate = 0, $format = 0, $search = 0, $cat_id = 0) {
	  global $database, $datetime, $setting, $class_classified;

	  // INCLUDE FILTER CLASS
	  if(!class_exists("InputFilter")) { include "./include/class_inputfilter.php"; }

	  // SET CATEGORY VARIABLES
	  $cat_query = "SELECT * FROM se_classifiedcats WHERE classifiedcat_dependency='0'"; if($cat_id != 0) { $cat_query .= " AND classifiedcat_id='$cat_id'"; } $cat_query .= " ORDER BY classifiedcat_id";
	  $cats = $database->database_query($cat_query);

	  // LOOP THROUGH CATS
	  while($cat_info = $database->database_fetch_assoc($cats)) {

	    // GET NON DEPENDENT FIELDS IN CAT
	    $field_count = 0;
	    $this->fields = "";
	    $field_query = "SELECT * FROM se_classifiedfields WHERE classifiedfield_classifiedcat_id='$cat_info[classifiedcat_id]' AND classifiedfield_dependency='0' ORDER BY classifiedfield_order";
	    $fields = $database->database_query($field_query);
	    while($field_info = $database->database_fetch_assoc($fields)) {

	      // SET FIELD VARS
	      $is_field_error = 0;
	      $field_value = "";
	      $field_value_formatted = "";
	      $field_value_min = "";
	      $field_value_max = "";

	      // FIELD TYPE SWITCH
	      switch($field_info[classifiedfield_type]) {

	        case 1: // TEXT FIELD
	        case 2: // TEXTAREA

	          // VALIDATE POSTED FIELD VALUE
	          if($validate == 1) {

	            // RETRIEVE POSTED FIELD VALUE AND FILTER FOR ADMIN-SPECIFIED HTML TAGS
		    $xssFilter = new InputFilter(explode(",", $field_info[classifiedfield_html]), "", 0, 1, 1);
	            $var = "field_".$field_info[classifiedfield_id];
	            $field_value = security($xssFilter->process(censor($_POST[$var])));

	            if($field_info[classifiedfield_type] == 2) { $field_value = str_replace("\r\n", "<br>", $field_value); }

	            // CHECK FOR REQUIRED
	            if($field_info[classifiedfield_required] != 0 & str_replace(" ", "", $field_value) == "") {
	              $this->is_error = 1;
	              $this->error_message = $class_classified[1];
	              $is_field_error = 1;
	            }

	            // RUN PREG MATCH (ONLY FOR TEXT FIELDS)
	            if($field_info[classifiedfield_regex] != "" & str_replace(" ", "", $field_value) != "") {
	              if(!preg_match($field_info[classifiedfield_regex], $field_value)) {
	                $this->is_error = 1;
	                $this->error_message = $class_classified[2];
	                $is_field_error = 1;
	              }
	            }

	            // UPDATE SAVE QUERY
	            if($this->field_query != "") { $this->field_query .= ", "; }
	            $this->field_query .= "classifiedvalue_$field_info[classifiedfield_id]='$field_value'";

		  // CREATE A SEARCH QUERY FROM POSTED FIELD VALUE
		  } elseif($search == 1) {
		    if($field_info[classifiedfield_search] == 2) {
		      $var1 = "field_".$field_info[classifiedfield_id]."_min";
		      if(isset($_POST[$var1])) { $field_value_min = $_POST[$var1]; } elseif(isset($_GET[$var1])) { $field_value_min = $_GET[$var1]; } else { $field_value_min = ""; }
		      $var2 = "field_".$field_info[classifiedfield_id]."_max";
		      if(isset($_POST[$var2])) { $field_value_max = $_POST[$var2]; } elseif(isset($_GET[$var2])) { $field_value_max = $_GET[$var2]; } else { $field_value_max = ""; }
		      if($field_value_min != "") { 
		        if($this->field_query != "") { $this->field_query .= " AND "; } 
		        $this->field_query .= "classifiedvalue_$field_info[classifiedfield_id] >= $field_value_min"; 
		        $this->url_string .= $var1."=".urlencode($field_value_min)."&";
		      }
		      if($field_value_max != "") { 
		        if($this->field_query != "") { $this->field_query .= " AND "; } 
		        $this->field_query .= "classifiedvalue_$field_info[classifiedfield_id] <= $field_value_max"; 
		        $this->url_string .= $var2."=".urlencode($field_value_max)."&";
		      }
		    } elseif($field_info[classifiedfield_search] == 1) {
		      $var = "field_".$field_info[classifiedfield_id];
		      if(isset($_POST[$var])) { $field_value = $_POST[$var]; } elseif(isset($_GET[$var])) { $field_value = $_GET[$var]; } else { $field_value = ""; }
		      if($field_value != "") { 
		        if($this->field_query != "") { $this->field_query .= " AND "; } 
		        $this->field_query .= "classifiedvalue_$field_info[classifiedfield_id] LIKE '%$field_value%'"; 
		        $this->url_string .= $var."=".urlencode($field_value)."&";
		      }
		    } else {
		      $field_value = "";
		    }

		  // DO NOT VALIDATE FIELD VALUE AND DON'T CREATE SEARCH VALUE
	          } else {
	            // RETRIEVE DATABASE FIELD VALUE
	            if($this->classifiedvalue_info != "") {
	              $value_column = "classifiedvalue_".$field_info[classifiedfield_id];
	              $field_value = $this->classifiedvalue_info[$value_column];
	            }
	          }

		  // FORMAT VALUE FOR DISPLAY
		  if($format == 1) {

		    // MAKE SURE TO LINK FIELDS WITH A LINK TAG
		    $exploded_field_values = Array(trim($field_value));
		    array_walk($exploded_field_values, 'link_field_values', Array($field_info[classifiedfield_id], "", $field_info[classifiedfield_link], 0));
		    $field_value_formatted = implode("", $exploded_field_values);

		    // DECODE TO MAKE HTML TAGS FOR FIELDS VALID
		    $field_value_formatted = htmlspecialchars_decode($field_value_formatted, ENT_QUOTES);

		  // FORMAT VALUE FOR FORM
		  } else {
		    if($field_info[classifiedfield_type] == 2) { $field_value = str_replace("<br>", "\r\n", $field_value); }
		  }
	          break;



	        case 3: // SELECT BOX
	        case 4: // RADIO BUTTON

	          // VALIDATE POSTED FIELD
	          if($validate == 1) {

	            // RETRIEVE POSTED FIELD VALUE
	            $var = "field_".$field_info[classifiedfield_id];
	            $field_value = censor($_POST[$var]);

	            // CHECK FOR REQUIRED
	            if($field_info[classifiedfield_required] != 0 && $field_value == "-1") {
	              $this->is_error = 1;
	              $this->error_message = $class_classified[1];
	              $is_field_error = 1;
	            }

	            // UPDATE SAVE QUERY
	            if($this->field_query != "") { $this->field_query .= ", "; }
	            $this->field_query .= "classifiedvalue_$field_info[classifiedfield_id]='$field_value'";


		  // CREATE A SEARCH QUERY FROM POSTED FIELD VALUE
		  } elseif($search == 1) {
		    if($field_info[classifiedfield_search] == 2) {
		      $var1 = "field_".$field_info[classifiedfield_id]."_min";
		      if(isset($_POST[$var1])) { $field_value_min = $_POST[$var1]; } elseif(isset($_GET[$var1])) { $field_value_min = $_GET[$var1]; } else { $field_value_min = ""; }
		      $var2 = "field_".$field_info[classifiedfield_id]."_max";
		      if(isset($_POST[$var2])) { $field_value_max = $_POST[$var2]; } elseif(isset($_GET[$var2])) { $field_value_max = $_GET[$var2]; } else { $field_value_max = ""; }
		      if($field_value_min != "" && $field_value_min != "-1") { 
		        if($this->field_query != "") { $this->field_query .= " AND "; } 
		        $this->field_query .= "classifiedvalue_$field_info[classifiedfield_id] >= $field_value_min"; 
		        $this->url_string .= $var1."=".urlencode($field_value_min)."&";
		      }
		      if($field_value_max != "" && $field_value_max != "-1") { 
		        if($this->field_query != "") { $this->field_query .= " AND "; } 
		        $this->field_query .= "classifiedvalue_$field_info[classifiedfield_id] <= $field_value_max"; 
		        $this->url_string .= $var2."=".urlencode($field_value_max)."&";
		      }
		    } elseif($field_info[classifiedfield_search] == 1) {
		      $var = "field_".$field_info[classifiedfield_id];
		      if(isset($_POST[$var])) { $field_value = $_POST[$var]; } elseif(isset($_GET[$var])) { $field_value = $_GET[$var]; } else { $field_value = ""; }
	              if($field_value != "-1" && $field_value != "") { 
		        if($this->field_query != "") { $this->field_query .= " AND "; } 
		        $this->field_query .= "classifiedvalue_$field_info[classifiedfield_id]='$field_value'"; 
		        $this->url_string .= $var."=".urlencode($field_value)."&";
		      }
		    } else {
		      $field_value = "";
		    }

		  // DO NOT VALIDATE FIELD VALUE AND DON'T CREATE SEARCH VALUE
	          } else {
	            // RETRIEVE DATABASE FIELD VALUE
	            if($this->classifiedvalue_info != "") {
	              $value_column = "classifiedvalue_".$field_info[classifiedfield_id];
	              $field_value = $this->classifiedvalue_info[$value_column];
	            }
	          }

	          // LOOP OVER FIELD OPTIONS
	          $field_options = Array();
	          $options = explode("<~!~>", $field_info[classifiedfield_options]);
	          $num_options = 0;
	          for($i=0,$max=count($options);$i<$max;$i++) {
	            $dep_field_info = "";
	            $option_dependency = 0;
	            $dep_field_value = "";
	            if(str_replace(" ", "", $options[$i]) != "") {
	              $option = explode("<!>", $options[$i]);
	              $option_id = $option[0];
	              $option_label = $option[1];
	              $option_dependency = $option[2];
	              $option_dependent_field_id = $option[3];

	              // OPTION HAS DEPENDENCY
	              if($option_dependency == "1") { 
	                $dep_field = $database->database_query("SELECT classifiedfield_id, classifiedfield_title, classifiedfield_maxlength, classifiedfield_link, classifiedfield_style, classifiedfield_required, classifiedfield_regex FROM se_classifiedfields WHERE classifiedfield_id='$option_dependent_field_id' AND classifiedfield_dependency='$field_info[classifiedfield_id]'");
	                if($database->database_num_rows($dep_field) != "1") {
	                  $dep_field_info = "";
	                  $option_dependency = 0;
	                  $dep_field_value = "";
	                } else {
	                  $dep_field_info = $database->database_fetch_assoc($dep_field);

	                  // VALIDATE POSTED FIELD VALUE
	                  if($validate == 1) {
	                    // OPTION SELECTED
	                    if($field_value == $option_id) {
	                      $dep_var = "field_".$dep_field_info[classifiedfield_id];
	                      $dep_field_value = censor($_POST[$dep_var]);
  
	                      // CHECK FOR REQUIRED
	                      if($dep_field_info[classifiedfield_required] != 0 & str_replace(" ", "", $dep_field_value) == "") {
	                        $this->is_error = 1;
	                        $this->error_message = $class_classified[1];
	                        $is_field_error = 1;
	                      }

	                      // RUN PREG MATCH
	                      if($dep_field_info[classifiedfield_regex] != "" & str_replace(" ", "", $dep_field_value) != "") {
	                        if(!preg_match($dep_field_info[classifiedfield_regex], $dep_field_value)) {
	                          $this->is_error = 1;
	                          $this->error_message = $class_classified[2];
	                          $is_field_error = 1;
	                        }
	                      }

	                    // OPTION NOT SELECTED
	                    } else {
	                      $dep_field_value = "";
	                    }

	    	            // UPDATE SAVE QUERY
	    	            if($this->field_query != "") { $this->field_query .= ", "; }
	    	            $this->field_query .= "classifiedvalue_$dep_field_info[classifiedfield_id]='$dep_field_value'";


			  // DO NOT VALIDATE POSTED FIELD VALUE
	                  } else {
	                    // RETRIEVE DATABASE FIELD VALUE
	                    if($this->classifiedvalue_info != "") {
	                      $value_column = "classifiedvalue_".$dep_field_info[classifiedfield_id];
	                      $dep_field_value = $this->classifiedvalue_info[$value_column];
	                    }
	                  }
	                }
	              }

		      // FORMAT VALUE FOR DISPLAY IF OPTION IS SELECTED
		      if($format == 1 & $field_value == $option_id) {
			$field_value_formatted = $option_label;

			// LINK FIELD VALUES IF NECESSARY
			if($dep_field_value != "") { link_field_values($dep_field_value, "", Array($dep_field_info[classifiedfield_id], "", $dep_field_info[classifiedfield_link], 0)); }

			// ADD DEPENDENT VALUE TO FIELD VALUE
			if($dep_field_value != "") { $field_value_formatted .= " ".$dep_field_info[classifiedfield_title]." ".$dep_field_value; }
		      }
          
	              // SET OPTIONS ARRAY
	              $field_options[$num_options] = Array('option_id' => $option_id,
								'option_label' => $option_label,
								'option_dependency' => $option_dependency,
								'dep_field_id' => $dep_field_info[classifiedfield_id],
								'dep_field_title' => $dep_field_info[classifiedfield_title],
								'dep_field_required' => $dep_field_info[classifiedfield_required],
								'dep_field_maxlength' => $dep_field_info[classifiedfield_maxlength],
								'dep_field_style' => $dep_field_info[classifiedfield_style],
								'dep_field_value' => $dep_field_value,
								'dep_field_error' => $dep_field_error);
	              $num_options++;
	            }
	          }
	          break;


	        case 5: // DATE FIELD

		  // SET MONTH, DAY, AND YEAR FORMAT FROM SETTINGS
		  switch($setting[setting_dateformat]) {
		    case "n/j/Y": case "n.j.Y": case "n-j-Y": $month_format = "n"; $day_format = "j"; $year_format = "Y"; $date_order = "mdy"; break;
		    case "Y/n/j": case "Ynj": $month_format = "n"; $day_format = "j"; $year_format = "Y"; $date_order = "ymd"; break;
		    case "Y-n-d": $month_format = "n"; $day_format = "d"; $year_format = "Y"; $date_order = "ymd"; break;
		    case "Y-m-d": $month_format = "m"; $day_format = "d"; $year_format = "Y"; $date_order = "ymd"; break;
		    case "j/n/Y": case "j.n.Y": $month_format = "n"; $day_format = "j"; $year_format = "Y"; $date_order = "dmy"; break;
		    case "M. j, Y": $month_format = "M"; $day_format = "j"; $year_format = "Y"; $date_order = "mdy"; break;
		    case "F j, Y": case "l, F j, Y": $month_format = "F"; $day_format = "j"; $year_format = "Y"; $date_order = "mdy"; break;
		    case "j F Y": case "D j F Y": case "l j F Y": $month_format = "F"; $day_format = "j"; $year_format = "Y"; $date_order = "dmy"; break;
		    case "D-j-M-Y": case "D j M Y": case "j-M-Y": $month_format = "M"; $day_format = "j"; $year_format = "Y"; $date_order = "dmy"; break;
		    case "Y-M-j": $month_format = "M"; $day_format = "j"; $year_format = "Y"; $date_order = "ymd"; break;
		  }  
  

	          // VALIDATE POSTED VALUE
	          if($validate == 1) {
	            // RETRIEVE POSTED FIELD VALUE
	            $var1 = "field_".$field_info[classifiedfield_id]."_1";
	            $var2 = "field_".$field_info[classifiedfield_id]."_2";
	            $var3 = "field_".$field_info[classifiedfield_id]."_3";
	            $field_1 = $_POST[$var1];
	            $field_2 = $_POST[$var2];
	            $field_3 = $_POST[$var3];

	            // ORDER DATE VALUES PROPERLY
	            switch($date_order) {
	              case "mdy": $month = $field_1; $day = $field_2; $year = $field_3; break;
	              case "ymd": $year = $field_1; $month = $field_2; $day = $field_3; break;
	              case "dmy": $day = $field_1; $month = $field_2; $year = $field_3; break;
	            }
  
	            // SET ALL TO BLANK IF ONE FIELD BLANK
	            if($month == 0 | $day == 0 | $year == 0) { $month = 0; $day = 0; $year = 0; }

	            // CONSTRUCT TIMESTAMP FROM MONTH, DAY, YEAR
	            $field_value = $datetime->MakeTime("0", "0", "0", "$month", "$day", "$year");
  
	            // CHECK FOR REQUIRED
	            if($field_info[classifiedfield_required] != 0 & $field_value == $datetime->MakeTime("0", "0", "0", "0", "0", "0")) {
	              $this->is_error = 1;
	              $this->error_message = $class_classified[1];
	              $is_field_error = 1;
	            }

	            // UPDATE SAVE QUERY
	            if($this->field_query != "") { $this->field_query .= ", "; }
	            $this->field_query .= "classifiedvalue_$field_info[classifiedfield_id]='$field_value'";


		  // CREATE A SEARCH QUERY FROM POSTED FIELD VALUE
		  } elseif($search == 1) {
		    $var1 = "field_".$field_info[classifiedfield_id]."_1";
		    $var2 = "field_".$field_info[classifiedfield_id]."_2";
		    $var3 = "field_".$field_info[classifiedfield_id]."_3";
		    if(isset($_POST[$var1])) { $field_1 = $_POST[$var1]; } elseif(isset($_GET[$var1])) { $field_1 = $_GET[$var1]; } else { $field_1 = ""; }
		    if(isset($_POST[$var2])) { $field_2 = $_POST[$var2]; } elseif(isset($_GET[$var2])) { $field_2 = $_GET[$var2]; } else { $field_2 = ""; }
		    if(isset($_POST[$var3])) { $field_3 = $_POST[$var3]; } elseif(isset($_GET[$var3])) { $field_3 = $_GET[$var3]; } else { $field_3 = ""; }

	            // ORDER DATE VALUES PROPERLY
	            switch($date_order) {
	              case "mdy": $month = $field_1; $day = $field_2; $year = $field_3; break;
	              case "ymd": $year = $field_1; $month = $field_2; $day = $field_3; break;
	              case "dmy": $day = $field_1; $month = $field_2; $year = $field_3; break;
	            }

	            // SET ALL TO BLANK IF ONE FIELD BLANK
	            if($month == 0 | $day == 0 | $year == 0) { $month = 0; $day = 0; $year = 0; }

	            // CONSTRUCT TIMESTAMP FROM MONTH, DAY, YEAR
	            $field_value = $datetime->MakeTime("0", "0", "0", "$month", "$day", "$year");

	            if($field_value != $datetime->MakeTime("0", "0", "0", "0", "0", "0") && $field_info[classifiedfield_search] != 0) { 
		      if($this->field_query != "") { $this->field_query .= " AND "; } 
		      $this->field_query .= "classifiedvalue_$field_info[classifiedfield_id]='$field_value'"; 
		      $this->url_string .= $var1."=".urlencode($field_1)."&";
		      $this->url_string .= $var2."=".urlencode($field_2)."&";
		      $this->url_string .= $var3."=".urlencode($field_3)."&";
		    }

		  // DO NOT VALIDATE FIELD VALUE AND DON'T CREATE SEARCH VALUE
	          } else {
	            // RETRIEVE DATABASE FIELD VALUE
	            if($this->classifiedvalue_info != "") {
	              $value_column = "classifiedvalue_".$field_info[classifiedfield_id];
	              $field_value = $this->classifiedvalue_info[$value_column];
	            } else {
	              $field_value = $datetime->MakeTime("0", "0", "0", "0", "0", "0");
	            }
	          }


		  // FORMAT VALUE FOR DISPLAY
		  if($format == 1) {
	   	    if($field_value != $datetime->MakeTime("0", "0", "0", "0", "0", "0")) { 
	              $field_date = $datetime->MakeDate($field_value);
		      $field_time = strtotime("$field_date[1] $field_date[3] $field_date[2]");
		      $field_value_formatted = $datetime->cdate($setting[setting_dateformat], $field_time); 
		    }


		  // FORMAT VALUE FOR FORM
	    	  } else {

	            // DECONSTRUCT TIMESTAMP INTO DATE MONTH, DAY, AND YEAR
	            if($field_value != $datetime->MakeTime("0", "0", "0", "0", "0", "0")) {
	              $field_date = $datetime->MakeDate($field_value);
	              $field_month = $field_date[0]; $field_day = $field_date[1]; $field_year = $field_date[2];
	            } else {
	              $field_month = 0; $field_day = 0; $field_year = 0;
	            }

	            // CONSTRUCT MONTH ARRAY
	            $month_array = Array();
	            $month_array[0] = Array('name' => "[$class_classified[3]]", 'value' => "0", 'selected' => "");
	            for($m=1;$m<=12;$m++) {
	              if($field_month == $m) { $selected = " SELECTED"; } else { $selected = ""; }
	              $month_array[$m] = Array('name' => $datetime->cdate("$month_format", mktime(0, 0, 0, $m, 1, 1990)),
	    					'value' => $m,
	    					'selected' => $selected);
	            }
  
	            // CONSTRUCT DAY ARRAY
	            $day_array = Array();
	            $day_array[0] = Array('name' => "[$class_classified[4]]", 'value' => "0", 'selected' => "");
	            for($d=1;$d<=31;$d++) {
	              if($field_day == $d) { $selected = " SELECTED"; } else { $selected = ""; }
	              $day_array[$d] = Array('name' => $datetime->cdate("$day_format", mktime(0, 0, 0, 1, $d, 1990)),
	    					'value' => $d,
	    					'selected' => $selected);
	            }

	            // CONSTRUCT YEAR ARRAY
	            $year_array = Array();
	            $year_count = 1;
	            $current_year = $datetime->cdate("Y", time());
	            $year_array[0] = Array('name' => "[$class_classified[5]]", 'value' => "0", 'selected' => "");
	            for($y=$current_year;$y>=1920;$y--) {
	              if($field_year == $y) { $selected = " SELECTED"; } else { $selected = ""; }
	              $year_array[$year_count] = Array('name' => $y,
	    						'value' => $y,
	    						'selected' => $selected);
	              $year_count++;
	            }

	            // ORDER DATE ARRAYS PROPERLY
	            switch($date_order) {
	              case "mdy": $date_array1 = $month_array; $date_array2 = $day_array; $date_array3 = $year_array; break;
	              case "ymd": $date_array1 = $year_array; $date_array2 = $month_array; $date_array3 = $day_array; break;
	              case "dmy": $date_array1 = $day_array; $date_array2 = $month_array; $date_array3 = $year_array; break;
	            }
		  }

	          break;

	      }

	      // SET FIELD ERROR IF ERROR OCCURRED
	      if($is_field_error == 1) { $field_error = $field_info[field_error]; } else { $field_error = ""; }

	      // SET FIELD ARRAY AND INCREMENT FIELD COUNT
	      if(($format == 0 && $search == 0) || ($format == 1 && $field_value_formatted != "") || ($search == 1 && $field_info[classifiedfield_search] != 0)) {
		$this->fields[] = Array('field_id' => $field_info[classifiedfield_id], 
				'field_title' => $field_info[classifiedfield_title], 
				'field_desc' => $field_info[classifiedfield_desc],
				'field_type' => $field_info[classifiedfield_type],
				'field_required' => $field_info[classifiedfield_required],
				'field_style' => $field_info[classifiedfield_style],
				'field_maxlength' => $field_info[classifiedfield_maxlength],
				'field_search' => $field_info[classifiedfield_search],
				'field_options' => $field_options,
				'field_value' => $field_value,
				'field_value_min' => $field_value_min,
				'field_value_max' => $field_value_max,
				'field_value_formatted' => $field_value_formatted,
				'field_error' => $field_error,
				'date_array1' => $date_array1,
				'date_array2' => $date_array2,
				'date_array3' => $date_array3);
		$field_count++;
	      }

	    } 

 	    // SET CAT ARRAY AND INCREMENT CAT COUNT IF THERE ARE FIELDS IN THE CAT
	    if($field_count != 0) {
	      $this->cats[] = Array('cat_id' => $cat_info[classifiedcat_id],
				'fields' => $this->fields);
	    }
	  }
	} // END classified_fields() METHOD









	// THIS METHOD DELETES SELECTED CLASSIFIED ENTRIES
	// INPUT: $start REPRESENTING THE ENTRY TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF ENTRIES TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT:
	function classifieds_delete($start, $limit, $sort_by = "classified_date DESC", $where = "") {
	  global $database;

	  // BEGIN QUERY
	  $classified_query = "SELECT classified_id FROM se_classifieds";

	  // ADD WHERE IF NECESSARY
	  if($where != "" | $this->user_id != 0) { $classified_query .= " WHERE"; }

	  // ENSURE USER ID IS NOT EMPTY
	  if($this->user_id != 0) { $classified_query .= " classified_user_id='".$this->user_id."'"; }

	  // INSERT AND IF NECESSARY
	  if($this->user_id != 0 & $where != "") { $classified_query .= " AND"; }

	  // ADD WHERE CLAUSE, IF NECESSARY
	  if($where != "") { $classified_query .= " $where"; }

	  // ADD ORDER, AND LIMIT CLAUSE
	  $classified_query .= " ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $classifieds = $database->database_query($classified_query);
	  // GET CLASSIFIED LISTINGS INTO AN ARRAY
	  $classified_delete = "";
	  while($classified_info = $database->database_fetch_assoc($classifieds)) {
	    $var = "delete_classified_".$classified_info[classified_id];
	    if($_POST[$var] == 1) { 
	      if($classified_delete != "") { $classified_delete .= " OR "; }
	      $classified_delete .= "se_classifieds.classified_id='$classified_info[classified_id]'";
	    }
	  }

	  // IF DELETE CLAUSE IS NOT EMPTY, DELETE ENTRIES
	  if($classified_delete != "") { 
	    $database->database_query("DELETE FROM se_classifieds, se_classifiedvalues, se_classifiedcomments USING se_classifieds LEFT JOIN se_classifiedvalues ON se_classifieds.classified_id=se_classifiedvalues.classifiedvalue_classified_id LEFT JOIN se_classifiedcomments ON se_classifieds.classified_id=se_classifiedcomments.classifiedcomment_classified_id WHERE ($classified_delete)"); 
	  }

	} // END classifieds_delete() METHOD









	// THIS METHOD POSTS/EDITS AN ENTRY
	// INPUT: $classified_id REPRESENTING THE ID OF THE classified ENTRY TO EDIT. IF NO ENTRY WITH THIS ID IS FOUND, A NEW ENTRY WILL BE ADDED
	//	  $classified_title REPRESENTING THE TITLE OF THE classified ENTRY
	//	  $classified_body REPRESENTING THE BODY OF THE classified ENTRY
	//	  $classified_classifiedcat_id REPRESENTING THE ID OF THE SELECTED classified ENTRY CATEGORY
	//	  $classified_search REPRESENTING WHETHER THE classified ENTRY SHOULD BE INCLUDED IN SEARCH RESULTS
	//	  $classified_privacy REPRESENTING THE PRIVACY LEVEL OF THE ENTRY
	//	  $classified_comments REPRESENTING WHO CAN COMMENT ON THE ENTRY
	// OUTPUT:
	function classified_post($classified_id, $classified_title, $classified_body, $classified_classifiedcat_id, $classified_search, $classified_privacy, $classified_comments) {
	  global $database, $user;

	  // INCLUDE FILTER CLASS
	  if(!class_exists("InputFilter")) { include "./include/class_inputfilter.php"; }
	  $xssFilter = new InputFilter("", "", 1, 1, 1);

	  // SET classified VARS
	  $classified_user_id = $this->user_id;
	  $classified_date = time();
	  $classified_title = censor($classified_title);
	  $classified_body = security($xssFilter->process(censor($classified_body)));

	  // IF classified ENTRY CATEGORY IS NOT SET, MAKE IT UNCATEGORIZED
	  if($classified_classifiedcat_id == "") { $classified_classifiedcat_id = 0; }

	  // CHECK THAT PRIVACY IS NOT BLANK
	  if($classified_privacy == "") { $classified_privacy = true_privacy(0, $user->level_info[level_classified_privacy]); }
	  if($classified_comments == "") { $classified_comments = true_privacy(0, $user->level_info[level_classified_comments]); }

	  // ATTEMPT TO GET RELEVANT classified ENTRY
	  if($database->database_num_rows($database->database_query("SELECT classified_id FROM se_classifieds WHERE classified_id='$classified_id' AND classified_user_id='".$this->user_id."'")) == 1) {
	    $database->database_query("UPDATE se_classifieds SET classified_title='$classified_title',
								classified_body='$classified_body',
								classified_classifiedcat_id='$classified_classifiedcat_id',
								classified_search='$classified_search',
								classified_privacy='$classified_privacy',
								classified_comments='$classified_comments'
								WHERE classified_id='$classified_id'");

	    // UPDATE VALUES
	    $database->database_query("UPDATE se_classifiedvalues SET ".$this->field_query." WHERE classifiedvalue_classified_id='$classified_id'");

	  // ADD ENTRY IF NO ENTRY EXISTS
	  } else {
	    $database->database_query("INSERT INTO se_classifieds (classified_user_id,
								classified_classifiedcat_id,
								classified_date,
								classified_title,
								classified_body,
								classified_search,
								classified_privacy,
								classified_comments
								) VALUES (
								'$classified_user_id',
								'$classified_classifiedcat_id',
								'$classified_date',
								'$classified_title',
								'$classified_body',
								'$classified_search',
								'$classified_privacy',
								'$classified_comments')");

	    // GET NEW CLASSIFIED ID
	    $classified_id = $database->database_insert_id();


	    // UPDATE VALUES
            $database->database_query("INSERT INTO se_classifiedvalues (classifiedvalue_classified_id) VALUES ('$classified_id')");
	    $database->database_query("UPDATE se_classifiedvalues SET ".$this->field_query." WHERE classifiedvalue_classified_id='$classified_id'");

	    // ADD EVENT ALBUM
	    $database->database_query("INSERT INTO se_classifiedalbums (classifiedalbum_classified_id, 
									classifiedalbum_datecreated, 
									classifiedalbum_dateupdated, 
									classifiedalbum_title, 
									classifiedalbum_desc, 
									classifiedalbum_search, 
									classifiedalbum_privacy, 
									classifiedalbum_comments
									) VALUES (
									'$classified_id', 
									'".time()."', 
									'".time()."', 
									'', 
									'', 
									'$classified_search', 
									'$classified_privacy', 
									'$classified_comments')");

	    // ADD classified DIRECTORY
	    $classified_directory = $this->classified_dir($classified_id);
	    $classified_path_array = explode("/", $classified_directory);
	    array_pop($classified_path_array);
	    array_pop($classified_path_array);
	    $subdir = implode("/", $classified_path_array)."/";
	    if(!is_dir($subdir)) { 
	      mkdir($subdir, 0777); 
	      chmod($subdir, 0777); 
	      $handle = fopen($subdir."index.php", 'x+');
	      fclose($handle);
	    }
	    mkdir($classified_directory, 0777);
	    chmod($classified_directory, 0777);
	    $handle = fopen($classified_directory."/index.php", 'x+');
	    fclose($handle);
	  }

	} // END classified_post() METHOD









	// THIS METHOD DELETES AN ENTRY
	// INPUT: $classified_id REPRESENTING THE ID OF THE CLASSIFIED ENTRY TO DELETE
	// OUTPUT:
	function classified_delete($classified_id) {
	  global $database;

	  // CREATE DELETE QUERY
	  $classified_query1 = "DELETE FROM se_classifieds WHERE se_classifieds.classified_id='$classified_id'";
	  $classified_query2 = "DELETE FROM se_classifiedvalues WHERE se_classifiedvalues.classifiedvalue_classified_id='$classified_id'";
	  $classified_query3 = "DELETE FROM se_classifiedcomments WHERE se_classifiedcomments.classifiedcomment_classified_id='$classified_id'";

	  // IF USER ID IS NOT EMPTY, ADD USER ID CLAUSE
	  if($this->user_id != 0) { 
	    $classified_query1 .= " AND se_classifieds.classified_user_id='".$this->user_id."'"; 
	  }

	  // RUN QUERIES
	  $database->database_query($classified_query1);
	  $database->database_query($classified_query2);
	  $database->database_query($classified_query3);

	} // END classified_delete() METHOD








	// THIS METHOD RETURNS THE PATH TO THE GIVEN classified'S DIRECTORY
	// INPUT: $classified_id (OPTIONAL) REPRESENTING A classified'S classified_ID
	// OUTPUT: A STRING REPRESENTING THE RELATIVE PATH TO THE classified'S DIRECTORY
	function classified_dir($classified_id = 0) {

	  if($classified_id == 0 & $this->classified_exists) { $classified_id = $this->classified_info[classified_id]; }

	  $subdir = $classified_id+999-(($classified_id-1)%1000);
	  $classifieddir = "./uploads_classified/$subdir/$classified_id/";
	  return $classifieddir;

	} // END classified_dir() METHOD







	// THIS METHOD OUTPUTS THE PATH TO THE classified'S PHOTO OR THE GIVEN NOPHOTO IMAGE
	// INPUT: $nophoto_image (OPTIONAL) REPRESENTING THE PATH TO AN IMAGE TO OUTPUT IF NO PHOTO EXISTS
	// OUTPUT: A STRING CONTAINING THE PATH TO THE classified'S PHOTO
	function classified_photo($nophoto_image = "") {

	  $classified_photo = $this->classified_dir($this->classified_info[classified_id]).$this->classified_info[classified_photo];
	  if(!file_exists($classified_photo) | $this->classified_info[classified_photo] == "") { $classified_photo = $nophoto_image; }
	  return $classified_photo;
	  
	} // END classified_photo() METHOD






	// THIS METHOD UPLOADS AN classified PHOTO ACCORDING TO SPECIFICATIONS AND RETURNS classified PHOTO
	// INPUT: $photo_name REPRESENTING THE NAME OF THE FILE INPUT
	// OUTPUT: 
	function classified_photo_upload($photo_name) {
	  global $database, $url;

	  // SET KEY VARIABLES
	  $file_maxsize = "4194304";
	  $file_exts = explode(",", str_replace(" ", "", strtolower($this->classifiedowner_level_info[level_classified_photo_exts])));
	  $file_types = explode(",", str_replace(" ", "", strtolower("image/jpeg, image/jpg, image/jpe, image/pjpeg, image/pjpg, image/x-jpeg, x-jpg, image/gif, image/x-gif, image/png, image/x-png")));
	  $file_maxwidth = $this->classifiedowner_level_info[level_classified_photo_width];
	  $file_maxheight = $this->classifiedowner_level_info[level_classified_photo_height];
	  $photo_newname = "0_".rand(1000, 9999).".jpg";
	  $file_dest = $this->classified_dir($this->classified_info[classified_id]).$photo_newname;

	  $new_photo = new se_upload();
	  $new_photo->new_upload($photo_name, $file_maxsize, $file_exts, $file_types, $file_maxwidth, $file_maxheight);

	  // UPLOAD AND RESIZE PHOTO IF NO ERROR
	  if($new_photo->is_error == 0) {

	    // DELETE OLD AVATAR IF EXISTS
	    $this->classified_photo_delete();

	    // CHECK IF IMAGE RESIZING IS AVAILABLE, OTHERWISE MOVE UPLOADED IMAGE
	    if($new_photo->is_image == 1) {
	      $new_photo->upload_photo($file_dest);
	    } else {
	      $new_photo->upload_file($file_dest);
	    }

	    // UPDATE classified INFO WITH IMAGE IF STILL NO ERROR
	    if($new_photo->is_error == 0) {
	      $database->database_query("UPDATE se_classifieds SET classified_photo='$photo_newname' WHERE classified_id='".$this->classified_info[classified_id]."'");
	      $this->classified_info[classified_photo] = $photo_newname;
	    }
	  }
	
	  $this->is_error = $new_photo->is_error;
	  $this->error_message = $new_photo->error_message;

	} // END classified_photo_upload() METHOD








	// THIS METHOD DELETES A classified PHOTO
	// INPUT: 
	// OUTPUT: 
	function classified_photo_delete() {
	  global $database;
	  $classified_photo = $this->classified_photo();
	  if($classified_photo != "") {
	    unlink($classified_photo);
	    $database->database_query("UPDATE se_classifieds SET classified_photo='' WHERE classified_id='".$this->classified_info[classified_id]."'");
	    $this->classified_info[classified_photo] = "";
	  }
	} // END classified_photo_delete() METHOD




	// THIS METHOD UPDATES THE classified'S LAST UPDATE DATE
	// INPUT: 
	// OUTPUT: 
	function classified_lastupdate() {
	  global $database;

	  $database->database_query("UPDATE se_classifieds SET classified_dateupdated='".time()."' WHERE classified_id='".$this->classified_info[classified_id]."'");
	  
	} // END classified_lastupdate() METHOD













	// THIS METHOD UPLOADS MEDIA TO A classified ALBUM
	// INPUT: $file_name REPRESENTING THE NAME OF THE FILE INPUT
	//	  $classifiedalbum_id REPRESENTING THE ID OF THE classified ALBUM TO UPLOAD THE MEDIA TO
	//	  $space_left REPRESENTING THE AMOUNT OF SPACE LEFT
	// OUTPUT:
	function classified_media_upload($file_name, $classifiedalbum_id, &$space_left) {
	  global $class_classified, $database, $url;

	  // SET KEY VARIABLES
	  $file_maxsize = $this->classifiedowner_level_info[level_classified_album_maxsize];
	  $file_exts = explode(",", str_replace(" ", "", strtolower($this->classifiedowner_level_info[level_classified_album_exts])));
	  $file_types = explode(",", str_replace(" ", "", strtolower($this->classifiedowner_level_info[level_classified_album_mimes])));
	  $file_maxwidth = $this->classifiedowner_level_info[level_classified_album_width];
	  $file_maxheight = $this->classifiedowner_level_info[level_classified_album_height];

	  $new_media = new se_upload();
	  $new_media->new_upload($file_name, $file_maxsize, $file_exts, $file_types, $file_maxwidth, $file_maxheight);

	  // UPLOAD AND RESIZE PHOTO IF NO ERROR
	  if($new_media->is_error == 0) {

	    // INSERT ROW INTO MEDIA TABLE
	    $database->database_query("INSERT INTO se_classifiedmedia (
							classifiedmedia_classifiedalbum_id,
							classifiedmedia_date
							) VALUES (
							'$classifiedalbum_id',
							'".time()."'
							)");
	    $classifiedmedia_id = $database->database_insert_id();

	    // CHECK IF IMAGE RESIZING IS AVAILABLE, OTHERWISE MOVE UPLOADED IMAGE
	    if($new_media->is_image == 1) {
	      $file_dest = $this->classified_dir($this->classified_info[classified_id]).$classifiedmedia_id.".jpg";
	      $thumb_dest = $this->classified_dir($this->classified_info[classified_id]).$classifiedmedia_id."_thumb.jpg";
	      $new_media->upload_photo($file_dest);
	      $new_media->upload_photo($thumb_dest, 200, 200);
	      $file_ext = "jpg";
	      $file_filesize = filesize($file_dest);
	    } else {
	      $file_dest = $this->classified_dir($this->classified_info[classified_id]).$classifiedmedia_id.".".$new_media->file_ext;
	      $new_media->upload_file($file_dest);
	      $file_ext = $new_media->file_ext;
	      $file_filesize = filesize($file_dest);
	    }

	    // CHECK SPACE LEFT
	    if($file_filesize > $space_left) {
	      $new_media->is_error = 1;
	      $new_media->error_message = $class_classified[1].$_FILES[$file_name]['name'];
	    } else {
	      $space_left = $space_left-$file_filesize;
	    }

	    // DELETE FROM DATABASE IF ERROR
	    if($new_media->is_error != 0) {
	      $database->database_query("DELETE FROM se_classifiedmedia WHERE classifiedmedia_id='$classifiedmedia_id' AND classifiedmedia_classifiedalbum_id='$classifiedalbum_id'");
	      @unlink($file_dest);

	    // UPDATE ROW IF NO ERROR
	    } else {
	      $database->database_query("UPDATE se_classifiedmedia SET classifiedmedia_ext='$file_ext', classifiedmedia_filesize='$file_filesize' WHERE classifiedmedia_id='$classifiedmedia_id' AND classifiedmedia_classifiedalbum_id='$classifiedalbum_id'");
	    }
	  }
	
	  // RETURN FILE STATS
	  $file = Array('is_error' => $new_media->is_error,
			'error_message' => $new_media->error_message,
			'classifiedmedia_id' => $classifiedmedia_id,
			'classifiedmedia_ext' => $file_ext,
			'classifiedmedia_filesize' => $file_filesize);
	  return $file;

	} // END classified_media_upload() METHOD








	// THIS METHOD RETURNS THE SPACE USED
	// INPUT: $classifiedalbum_id (OPTIONAL) REPRESENTING THE ID OF THE ALBUM TO CALCULATE
	// OUTPUT: AN INTEGER REPRESENTING THE SPACE USED
	function classified_media_space($classifiedalbum_id = 0) {
	  global $database;

	  // BEGIN QUERY
	  $classifiedmedia_query = "SELECT sum(se_classifiedmedia.classifiedmedia_filesize) AS total_space";
	
	  // CONTINUE QUERY
	  $classifiedmedia_query .= " FROM se_classifiedalbums LEFT JOIN se_classifiedmedia ON se_classifiedalbums.classifiedalbum_id=se_classifiedmedia.classifiedmedia_classifiedalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->classified_exists != 0 | $classifiedalbum_id != 0) { $classifiedmedia_query .= " WHERE"; }

	  // IF classified EXISTS, SPECIFY classified ID
	  if($this->classified_exists != 0) { $classifiedmedia_query .= " se_classifiedalbums.classifiedalbum_classified_id='".$this->classified_info[classified_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->classified_exists != 0 & $classifiedalbum_id != 0) { $classifiedmedia_query .= " AND"; }

	  // SPECIFY ALBUM ID IF NECESSARY
	  if($classifiedalbum_id != 0) { $classifiedmedia_query .= " se_classifiedalbums.classifiedalbum_id='$classifiedalbum_id'"; }

	  // GET AND RETURN TOTAL SPACE USED
	  $space_info = $database->database_fetch_assoc($database->database_query($classifiedmedia_query));
	  return $space_info[total_space];

	} // END classified_media_space() METHOD








	// THIS METHOD RETURNS THE NUMBER OF classified MEDIA
	// INPUT: $classifiedalbum_id (OPTIONAL) REPRESENTING THE ID OF THE classified ALBUM TO CALCULATE
	// OUTPUT: AN INTEGER REPRESENTING THE NUMBER OF FILES
	function classified_media_total($classifiedalbum_id = 0) {
	  global $database;

	  // BEGIN QUERY
	  $classifiedmedia_query = "SELECT count(se_classifiedmedia.classifiedmedia_id) AS total_files";
	
	  // CONTINUE QUERY
	  $classifiedmedia_query .= " FROM se_classifiedalbums LEFT JOIN se_classifiedmedia ON se_classifiedalbums.classifiedalbum_id=se_classifiedmedia.classifiedmedia_classifiedalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->classified_exists != 0 | $classifiedalbum_id != 0) { $classifiedmedia_query .= " WHERE"; }

	  // IF classified EXISTS, SPECIFY classified ID
	  if($this->classified_exists != 0) { $classifiedmedia_query .= " se_classifiedalbums.classifiedalbum_classified_id='".$this->classified_info[classified_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->classified_exists != 0 & $classifiedalbum_id != 0) { $classifiedmedia_query .= " AND"; }

	  // SPECIFY ALBUM ID IF NECESSARY
	  if($classifiedalbum_id != 0) { $classifiedmedia_query .= " se_classifiedalbums.classifiedalbum_id='$classifiedalbum_id'"; }

	  // GET AND RETURN TOTAL FILES
	  $file_info = $database->database_fetch_assoc($database->database_query($classifiedmedia_query));
	  return $file_info[total_files];

	} // END classified_media_total() METHOD








	// THIS METHOD RETURNS AN ARRAY OF classified MEDIA
	// INPUT: $start REPRESENTING THE classified MEDIA TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF classified MEDIA TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN ARRAY OF classified MEDIA
	function classified_media_list($start, $limit, $sort_by = "classifiedmedia_id DESC", $where = "") {
	  global $database;

	  // BEGIN QUERY
	  $classifiedmedia_query = "SELECT se_classifiedmedia.*, se_classifiedalbums.classifiedalbum_id, se_classifiedalbums.classifiedalbum_classified_id, se_classifiedalbums.classifiedalbum_title";
	
	  // CONTINUE QUERY
	  $classifiedmedia_query .= " FROM se_classifiedmedia LEFT JOIN se_classifiedalbums ON se_classifiedalbums.classifiedalbum_id=se_classifiedmedia.classifiedmedia_classifiedalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->classified_exists != 0 | $where != "") { $classifiedmedia_query .= " WHERE"; }

	  // IF classified EXISTS, SPECIFY classified ID
	  if($this->classified_exists != 0) { $classifiedmedia_query .= " se_classifiedalbums.classifiedalbum_classified_id='".$this->classified_info[classified_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->classified_exists != 0 & $where != "") { $classifiedmedia_query .= " AND"; }

	  // ADD ADDITIONAL WHERE CLAUSE
	  if($where != "") { $classifiedmedia_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $classifiedmedia_query .= " GROUP BY classifiedmedia_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $classifiedmedia = $database->database_query($classifiedmedia_query);

	  // GET classified MEDIA INTO AN ARRAY
	  $classifiedmedia_array = Array();
	  while($classifiedmedia_info = $database->database_fetch_assoc($classifiedmedia)) {

	    // CREATE ARRAY OF MEDIA DATA
	    $classifiedmedia_array[] = Array('classifiedmedia_id' => $classifiedmedia_info[classifiedmedia_id],
					'classifiedmedia_classifiedalbum_id' => $classifiedmedia_info[classifiedmedia_classifiedalbum_id],
					'classifiedmedia_date' => $classifiedmedia_info[classifiedmedia_date],
					'classifiedmedia_title' => $classifiedmedia_info[classifiedmedia_title],
					'classifiedmedia_desc' => str_replace("<br>", "\r\n", $classifiedmedia_info[classifiedmedia_desc]),
					'classifiedmedia_ext' => $classifiedmedia_info[classifiedmedia_ext],
					'classifiedmedia_filesize' => $classifiedmedia_info[classifiedmedia_filesize]);

	  }

	  // RETURN ARRAY
	  return $classifiedmedia_array;

	} // END classified_media_list() METHOD













	// THIS METHOD DELETES SELECTED classified MEDIA
	// INPUT: $start REPRESENTING THE classified MEDIA TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF classified MEDIA TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT:
	function classified_media_delete($start, $limit, $sort_by = "classifiedmedia_id DESC", $where = "") {
	  global $database, $url;

	  // BEGIN QUERY
	  $classifiedmedia_query = "SELECT se_classifiedmedia.*, se_classifiedalbums.classifiedalbum_id, se_classifiedalbums.classifiedalbum_classified_id, se_classifiedalbums.classifiedalbum_title";
	
	  // CONTINUE QUERY
	  $classifiedmedia_query .= " FROM se_classifiedmedia LEFT JOIN se_classifiedalbums ON se_classifiedalbums.classifiedalbum_id=se_classifiedmedia.classifiedmedia_classifiedalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->classified_exists != 0 | $where != "") { $classifiedmedia_query .= " WHERE"; }

	  // IF classified EXISTS, SPECIFY classified ID
	  if($this->classified_exists != 0) { $classifiedmedia_query .= " se_classifiedalbums.classifiedalbum_classified_id='".$this->classified_info[classified_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->classified_exists != 0 & $where != "") { $classifiedmedia_query .= " AND"; }

	  // ADD ADDITIONAL WHERE CLAUSE
	  if($where != "") { $classifiedmedia_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $classifiedmedia_query .= " GROUP BY se_classifiedmedia.classifiedmedia_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $classifiedmedia = $database->database_query($classifiedmedia_query);

	  // LOOP OVER classified MEDIA
	  $classifiedmedia_delete = "";
	  while($classifiedmedia_info = $database->database_fetch_assoc($classifiedmedia)) {
	    $var = "delete_classifiedmedia_".$classifiedmedia_info[classifiedmedia_id]; 
	    if($classifiedmedia_delete != "") { $classifiedmedia_delete .= " OR "; }
	    $classifiedmedia_delete .= "classifiedmedia_id='$classifiedmedia_info[classifiedmedia_id]'";
	    $classifiedmedia_path = $this->classified_dir($this->classified_info[classified_id]).$classifiedmedia_info[classifiedmedia_id].".".$classifiedmedia_info[classifiedmedia_ext];
	    if(file_exists($classifiedmedia_path)) { unlink($classifiedmedia_path); }
	    $thumb_path = $this->classified_dir($this->classified_info[classified_id]).$classifiedmedia_info[classifiedmedia_id]."_thumb.".$classifiedmedia_info[classifiedmedia_ext];
	    if(file_exists($thumb_path)) { unlink($thumb_path); }
	  }

	  // IF DELETE CLAUSE IS NOT EMPTY, DELETE classified MEDIA
	  if($classifiedmedia_delete != "") { $database->database_query("DELETE FROM se_classifiedmedia WHERE ($classifiedmedia_delete)"); }

	} // END classified_media_delete() METHOD





}

?>