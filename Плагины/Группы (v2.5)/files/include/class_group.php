<?

//  THIS CLASS CONTAINS GROUP-RELATED METHODS 
//  METHODS IN THIS CLASS:
//    se_group()
//    group_total()
//    group_list()
//    group_create()
//    group_fields()
//    group_delete()
//    group_delete_selected()
//    group_lastupdate()
//    group_privacy_max()
//    group_member_total()
//    group_member_list()
//    group_dir()
//    group_photo()
//    group_photo_upload()
//    group_photo_delete()
//    group_media_upload()
//    group_media_space()
//    group_media_total()
//    group_media_list()
//    group_media_update()
//    group_media_delete()
//    group_topic_list()
//    group_topic_total()
//    group_post_list()
//    group_post_total()





class se_group {

	// INITIALIZE VARIABLES
	var $is_error;			// DETERMINES WHETHER THERE IS AN ERROR OR NOT
	var $error_message;		// CONTAINS RELEVANT ERROR MESSAGE

	var $user_id;			// CONTAINS THE USER ID OF THE USER WHOSE GROUPS WE ARE EDITING
	var $user_rank;			// CONTAINS THE USER'S ASSOCIATION TO THE GROUP (LEADER - 2, OFFICER - 1, MEMBER - 0, NOT AFFILIATED - -1)

	var $group_exists;		// DETERMINES WHETHER THE GROUP HAS BEEN SET AND EXISTS OR NOT

	var $group_info;		// CONTAINS THE GROUP INFO OF THE GROUP WE ARE EDITING
	var $groupvalue_info;		// CONTAINS THE GROUPVALUE INFO OF THE GROUP WE ARE EDITING
	var $groupowner_level_info;	// CONTAINS THE GROUP OWNER'S LEVEL INFO FOR THE GROUP WE ARE EDITING

	var $group_fields;		// CONTAINS ARRAY OF GROUP FIELDS
	var $group_field_query;		// CONTAINS A PARTIAL DATABASE QUERY TO SAVE/RETRIEVE GROUP FIELD VALUES








	// THIS METHOD SETS INITIAL VARS
	// INPUT: $user_id (OPTIONAL) REPRESENTING THE USER ID OF THE USER WHOSE GROUPS WE ARE CONCERNED WITH
	//	  $group_id (OPTIONAL) REPRESENTING THE GROUP ID OF THE GROUP WE ARE CONCERNED WITH
	// OUTPUT: 
	function se_group($user_id = 0, $group_id = 0) {
	  global $database;

	  $this->user_id = $user_id;
	  $this->group_exists = 0;
	  $this->user_rank = -1;

	  if($group_id != 0) {
	    $group = $database->database_query("SELECT * FROM se_groups WHERE group_id='$group_id'");
	    if($database->database_num_rows($group) == 1) {
	      $this->group_exists = 1;
	      $this->group_info = $database->database_fetch_assoc($group);
	      $this->groupvalue_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_groupvalues WHERE groupvalue_group_id='$group_id'"));
	      $this->groupowner_level_info = $database->database_fetch_assoc($database->database_query("SELECT se_levels.* FROM se_users LEFT JOIN se_levels ON se_users.user_level_id=se_levels.level_id WHERE se_users.user_id='".$this->group_info[group_user_id]."'"));

	      if($this->user_id != 0) {
	        $groupmember = $database->database_query("SELECT groupmember_id, groupmember_rank FROM se_groupmembers WHERE groupmember_user_id='".$this->user_id."' AND groupmember_group_id='$group_id' AND groupmember_status='1'");
	        if($database->database_num_rows($groupmember) == 1) {
	          $groupmember_info = $database->database_fetch_assoc($groupmember);
	          $this->user_rank = $groupmember_info[groupmember_rank];
	        }
	      }
	    }
	  }

	} // END se_group() METHOD








	// THIS METHOD RETURNS THE TOTAL NUMBER OF GROUPS
	// INPUT: $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	//	  $group_details (OPTIONAL) REPRESENTING A BOOLEAN THAT DETERMINES WHETHER TO RETRIEVE TOTAL MEMBERS, GROUP LEADER, ETC
	// OUTPUT: AN INTEGER REPRESENTING THE NUMBER OF GROUPS
	function group_total($where = "", $group_details = 0) {
	  global $database;

	  // BEGIN QUERY
	  $group_query = "SELECT se_groups.group_id";

	  // SELECT RELEVANT GROUP DETAILS IF NECESSARY
	  if($group_details == 1) { $group_query .= ", count(member_table.groupmember_id) AS num_members, se_users.user_id, se_users.user_username"; }

	  // IF USER ID NOT EMPTY, GET USER AS MEMBER
	  if($this->user_id != 0) { $group_query .= ", se_groupmembers.groupmember_rank"; }

	  // CONTINUE QUERY
	  $group_query .= " FROM";

	  // IF USER ID NOT EMPTY, SELECT FROM GROUPMEMBER TABLE
	  if($this->user_id != 0) { 
	    $group_query .= " se_groupmembers LEFT JOIN se_groups ON se_groupmembers.groupmember_group_id=se_groups.group_id "; 
	  } else {
	    $group_query .= " se_groups";
	  }

	  // CONTINUE QUERY IF NECESSARY
	  if($group_details == 1) { $group_query .= " LEFT JOIN se_groupmembers AS member_table ON se_groups.group_id=member_table.groupmember_group_id AND member_table.groupmember_status='1' AND member_table.groupmember_approved='1' LEFT JOIN se_users ON se_groups.group_user_id=se_users.user_id"; }

	  // ADD WHERE IF NECESSARY
	  if($where != "" | $this->user_id != 0) { $group_query .= " WHERE"; }

	  // IF USER ID NOT EMPTY, MAKE SURE USER IS A MEMBER
	  if($this->user_id != 0) { $group_query .= " se_groupmembers.groupmember_user_id='".$this->user_id."'"; }

	  // INSERT AND IF NECESSARY
	  if($this->user_id != 0 & $where != "") { $group_query .= " AND"; }

	  // ADD WHERE CLAUSE, IF NECESSARY
	  if($where != "") { $group_query .= " $where"; }

	  // ADD GROUP BY
	  $group_query .= " GROUP BY group_id";

	  // RUN QUERY
	  $group_total = $database->database_num_rows($database->database_query($group_query));
	  return $group_total;

	} // END group_total() METHOD








	// THIS METHOD RETURNS AN ARRAY OF GROUPS
	// INPUT: $start REPRESENTING THE GROUP TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF GROUPS TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	//	  $group_details (OPTIONAL) REPRESENTING A BOOLEAN THAT DETERMINES WHETHER TO RETRIEVE TOTAL MEMBERS, GROUP LEADER, ETC
	// OUTPUT: AN ARRAY OF GROUPS
	function group_list($start, $limit, $sort_by = "group_id DESC", $where = "", $group_details = 0) {
	  global $database, $user;

	  // BEGIN QUERY
	  $group_query = "SELECT se_groups.*";

	  // SELECT RELEVANT GROUP DETAILS IF NECESSARY
	  if($group_details == 1) { $group_query .= ", count(member_table.groupmember_id) AS num_members, se_users.user_id, se_users.user_username, se_users.user_photo"; }

	  // IF USER ID NOT EMPTY, GET USER AS MEMBER
	  if($this->user_id != 0) { $group_query .= ", se_groupmembers.groupmember_rank"; }

	  // CONTINUE QUERY
	  $group_query .= " FROM";

	  // IF USER ID NOT EMPTY, SELECT FROM GROUPMEMBER TABLE
	  if($this->user_id != 0) { 
	    $group_query .= " se_groupmembers LEFT JOIN se_groups ON se_groupmembers.groupmember_group_id=se_groups.group_id "; 
	  } else {
	    $group_query .= " se_groups";
	  }

	  // CONTINUE QUERY IF NECESSARY
	  if($group_details == 1) { $group_query .= " LEFT JOIN se_groupmembers AS member_table ON se_groups.group_id=member_table.groupmember_group_id AND member_table.groupmember_status='1' AND member_table.groupmember_approved='1' LEFT JOIN se_users ON se_groups.group_user_id=se_users.user_id"; }

	  // ADD WHERE IF NECESSARY
	  if($where != "" | $this->user_id != 0) { $group_query .= " WHERE"; }

	  // IF USER ID NOT EMPTY, MAKE SURE USER IS A MEMBER
	  if($this->user_id != 0) { $group_query .= " se_groupmembers.groupmember_user_id='".$this->user_id."'"; }

	  // INSERT AND IF NECESSARY
	  if($this->user_id != 0 & $where != "") { $group_query .= " AND"; }

	  // ADD WHERE CLAUSE, IF NECESSARY
	  if($where != "") { $group_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $group_query .= " GROUP BY group_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $groups = $database->database_query($group_query);

	  // GET GROUPS INTO AN ARRAY
	  $group_array = Array();
	  while($group_info = $database->database_fetch_assoc($groups)) {

	    // CREATE OBJECT FOR LEADER
	    if($user->user_info[user_id] == $group_info[group_user_id]) {
	      $leader = $user;
	    } else {
	      $leader = new se_user();
	      $leader->user_exists = 1;
	      $leader->user_info[user_id] = $group_info[user_id];
	      $leader->user_info[user_username] = $group_info[user_username];
	      $leader->user_info[user_photo] = $group_info[user_photo];
	    }

	    // CREATE OBJECT FOR GROUP
	    $group = new se_group($group_info[user_id]);
	    $group->group_exists = 1;
	    $group->group_info= $group_info;


	    // SET GROUP ARRAY
	    $group_array[] = Array('group' => $group,
				'group_leader' => $leader,
				'group_rank' => $group_info[groupmember_rank],
				'group_members' => $group_info[num_members]);
	  }

	  // RETURN ARRAY
	  return $group_array;

	} // END group_list() METHOD








	// THIS METHOD CREATES A NEW GROUP
	// INPUT: $group_title REPRESENTING THE GROUP TITLE
	//	  $group_desc REPRESENTING THE GROUP DESCRIPTION
	//	  $groupcat_id REPRESENTING THE GROUP CATEGORY ID
	//	  $group_search REPRESENTING WHETHER THE GROUP SHOULD BE SEARCHABLE
	//	  $group_privacy REPRESENTING THE PRIVACY OF THE GROUP
	//	  $group_comments REPRESENTING WHO CAN POST COMMENTS ON THE GROUP
	//	  $group_discussion REPRESENTING WHO CAN CREATE AND POST IN DISCUSSION TOPICS IN THIS GROUP
	//	  $group_approval REPRESENTING WHETHER THE LEADER MUST APPROVE MEMBERSHIP REQUESTS
	// OUTPUT: THE NEWLY CREATED GROUP'S GROUP ID
	function group_create($group_title, $group_desc, $groupcat_id, $group_search, $group_privacy, $group_comments, $group_discussion, $group_approval) {
	  global $database;

	  $datecreated = time();

	  // ADD ROW TO GROUPS TABLE
	  $database->database_query("INSERT INTO se_groups (group_user_id, group_groupcat_id, group_datecreated, group_title, group_desc, group_search, group_privacy, group_comments, group_discussion, group_approval) VALUES ('".$this->user_id."', '$groupcat_id', '$datecreated', '$group_title', '$group_desc', '$group_search', '$group_privacy', '$group_comments', '$group_discussion', '$group_approval')");
	  $group_id = $database->database_insert_id();

	  // ADD GROUP FIELD VALUES
	  $database->database_query("INSERT INTO se_groupvalues (groupvalue_group_id) VALUES ('$group_id')");
	  if(count($this->group_field_query) != "") {
	    $groupvalue_query = "UPDATE se_groupvalues SET ".$this->group_field_query." WHERE groupvalue_group_id='$group_id'";
	    $database->database_query($groupvalue_query);
	  }

	  // MAKE OWNER A MEMBER
	  $database->database_query("INSERT INTO se_groupmembers (groupmember_user_id, groupmember_group_id, groupmember_status, groupmember_approved, groupmember_rank) VALUES ('".$this->user_id."', '$group_id', '1', '1', '2')");

	  // ADD GROUP STYLES ROW
	  $database->database_query("INSERT INTO se_groupstyles (groupstyle_group_id) VALUES ('$group_id')");

	  // ADD GROUP ALBUM
	  $database->database_query("INSERT INTO se_groupalbums (groupalbum_group_id, groupalbum_datecreated, groupalbum_dateupdated, groupalbum_title, groupalbum_desc, groupalbum_search, groupalbum_privacy, groupalbum_comments) VALUES ('$group_id', '$datecreated', '$datecreated', '', '', '$group_search', '$group_privacy', '$group_comments')");

	  // ADD GROUP DIRECTORY
	  $group_directory = $this->group_dir($group_id);
	  $group_path_array = explode("/", $group_directory);
	  array_pop($group_path_array);
	  array_pop($group_path_array);
	  $subdir = implode("/", $group_path_array)."/";
	  if(!is_dir($subdir)) { 
	    mkdir($subdir, 0777); 
	    chmod($subdir, 0777); 
	    $handle = fopen($subdir."index.php", 'x+');
	    fclose($handle);
	  }
	  mkdir($group_directory, 0777);
	  chmod($group_directory, 0777);
	  $handle = fopen($group_directory."/index.php", 'x+');
	  fclose($handle);

	  return $group_id;

	} // END group_create() METHOD









	// THIS METHOD LOOPS AND/OR VALIDATES GROUP FIELD INPUT AND CREATES A PARTIAL QUERY TO UPDATE GROUP TABLE
	// INPUT: $validate (OPTIONAL) REPRESENTING A BOOLEAN THAT DETERMINES WHETHER TO VALIDATE POST VARS OR NOT
	//	  $profile (OPTIONAL) REPRESENTING A BOOLEAN THAT DETERMINES WHETHER TO CREATE FORMATTED PROFILE FIELD VALUES
	// OUTPUT: 
	function group_fields($validate = 0, $profile = 0) {
	  global $database, $datetime, $setting, $class_group;

	  // GET NON DEPENDENT FIELDS
	  $field_count = 0;
	  $this->group_fields = "";
	  $field_query = "SELECT * FROM se_groupfields WHERE groupfield_dependency='0' ORDER BY groupfield_order";
	  $fields = $database->database_query($field_query);
	  while($field_info = $database->database_fetch_assoc($fields)) {

	    // SET FIELD VARS
	    $is_field_error = 0;
	    $field_value = "";
	    $field_value_group = "";

	    // FIELD TYPE SWITCH
	    switch($field_info[groupfield_type]) {

	      case 1: // TEXT FIELD
	      case 2: // TEXTAREA

	        // VALIDATE POSTED FIELD VALUE
	        if($validate == 1) {

	          // RETRIEVE POSTED FIELD VALUE
	          $groupvalue_var = "field_".$field_info[groupfield_id];
	          $field_value = censor($_POST[$groupvalue_var]);
	          if($field_info[groupfield_type] == 2) { $field_value = str_replace("\r\n", "<br>", $field_value); }

	          // CHECK FOR REQUIRED
	          if($field_info[groupfield_required] != 0 & str_replace(" ", "", $field_value) == "") {
	            $this->is_error = 1;
	            $this->error_message = $class_group[1];
	            $is_field_error = 1;
	          }

	          // RUN PREG MATCH (ONLY FOR TEXT FIELDS)
	          if($field_info[groupfield_regex] != "" & str_replace(" ", "", $field_value) != "") {
	            if(!preg_match($field_info[groupfield_regex], $field_value)) {
	              $this->is_error = 1;
	              $this->error_message = $class_group[2];
	              $is_field_error = 1;
	            }
	          }

	          // UPDATE SAVE GROUP QUERY
	          if($this->group_field_query != "") { $this->group_field_query .= ", "; }
	          $this->group_field_query .= "groupvalue_$field_info[groupfield_id]='$field_value'";

		// DO NOT VALIDATE FIELD VALUE
	        } else {
	          // RETRIEVE DATABASE FIELD VALUE
	          if($this->groupvalue_info != "") {
	            $groupvalue_column = "groupvalue_".$field_info[groupfield_id];
	            $field_value = $this->groupvalue_info[$groupvalue_column];
	          }
	        }

		// FORMAT VALUE FOR PROFILE
		if($profile == 1) {
		  $field_value_group = $field_value;

		// FORMAT VALUE FOR FORM
		} else {
		  if($field_info[groupfield_type] == 2) { $field_value = str_replace("<br>", "\r\n", $field_value); }
		}
	        break;



	      case 3: // SELECT BOX
	      case 4: // RADIO BUTTON

	        // VALIDATE POSTED FIELD
	        if($validate == 1) {

	          // RETRIEVE POSTED FIELD VALUE
	          $groupvalue_var = "field_".$field_info[groupfield_id];
	          $field_value = censor($_POST[$groupvalue_var]);

	          // CHECK FOR REQUIRED
	          if($field_info[groupfield_required] != 0 & $field_value == "-1") {
	            $this->is_error = 1;
	            $this->error_message = $class_group[1];
	            $is_field_error = 1;
	          }

	          // UPDATE SAVE GROUP VALUE QUERY
	          if($this->group_field_query != "") { $this->group_field_query .= ", "; }
	          $this->group_field_query .= "groupvalue_$field_info[groupfield_id]='$field_value'";


		// DO NOT VALIDATE FIELD VALUE
	        } else {
	          // RETRIEVE DATABASE FIELD VALUE
	          if($this->groupvalue_info != "") {
	            $groupvalue_column = "groupvalue_".$field_info[groupfield_id];
	            $field_value = $this->groupvalue_info[$groupvalue_column];
	          }
	        }

	        // LOOP OVER FIELD OPTIONS
	        $field_options = Array();
	        $options = explode("<~!~>", $field_info[groupfield_options]);
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
	              $dep_field = $database->database_query("SELECT groupfield_id, groupfield_title, groupfield_maxlength, groupfield_style, groupfield_required, groupfield_regex FROM se_groupfields WHERE groupfield_id='$option_dependent_field_id' AND groupfield_dependency='$field_info[groupfield_id]'");
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
	                    $dep_groupvalue_var = "field_".$dep_field_info[groupfield_id];
	                    $dep_field_value = censor($_POST[$dep_groupvalue_var]);
  
	                    // CHECK FOR REQUIRED
	                    if($dep_field_info[groupfield_required] != 0 & str_replace(" ", "", $dep_field_value) == "") {
	                      $this->is_error = 1;
	                      $this->error_message = $class_group[1];
	                      $is_field_error = 1;
	                    }

	                    // RUN PREG MATCH
	                    if($dep_field_info[groupfield_regex] != "" & str_replace(" ", "", $dep_field_value) != "") {
	                      if(!preg_match($dep_field_info[groupfield_regex], $dep_field_value)) {
	                        $this->is_error = 1;
	                        $this->error_message = $class_group[2];
	                        $is_field_error = 1;
	                      }
	                    }

	                  // OPTION NOT SELECTED
	                  } else {
	                    $dep_field_value = "";
	                  }

	    	          // UPDATE SAVE GROUP VALUE QUERY
	   	          if($this->group_field_query != "") { $this->group_field_query .= ", "; }
	    	          $this->group_field_query .= "groupvalue_$dep_field_info[groupfield_id]='$dep_field_value'";


			// DO NOT VALIDATE POSTED FIELD VALUE
	                } else {
	                  // RETRIEVE DATABASE FIELD VALUE
	                  if($this->groupvalue_info != "") {
	                    $groupvalue_column = "groupvalue_".$dep_field_info[groupfield_id];
	                    $dep_field_value = $this->groupvalue_info[$groupvalue_column];
	                  }
	                }
	              }
	            }

		    // FORMAT VALUE FOR PROFILE IF OPTION IS SELECTED
		    if($profile == 1 & $field_value == $option_id) {
		      $field_value_group = $option_label;

		      // ADD DEPENDENT VALUE TO FIELD VALUE
		      if($dep_field_value != "") { $field_value_group .= " ".$dep_field_info[groupfield_title]." ".$dep_field_value; }
		    }
          
	            // SET OPTIONS ARRAY
	            $field_options[$num_options] = Array('option_id' => $option_id,
							'option_label' => $option_label,
							'option_dependency' => $option_dependency,
							'dep_field_id' => $dep_field_info[groupfield_id],
							'dep_field_title' => $dep_field_info[groupfield_title],
							'dep_field_required' => $dep_field_info[groupfield_required],
							'dep_field_maxlength' => $dep_field_info[groupfield_maxlength],
							'dep_field_style' => $dep_field_info[groupfield_style],
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
	          $groupvalue_var1 = "field_".$field_info[groupfield_id]."_1";
	          $groupvalue_var2 = "field_".$field_info[groupfield_id]."_2";
	          $groupvalue_var3 = "field_".$field_info[groupfield_id]."_3";
	          $field_1 = $_POST[$groupvalue_var1];
	          $field_2 = $_POST[$groupvalue_var2];
	          $field_3 = $_POST[$groupvalue_var3];

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
	          if($field_info[groupfield_required] != 0 & $field_value == $datetime->MakeTime("0", "0", "0", "0", "0", "0")) {
	            $this->is_error = 1;
	            $this->error_message = $class_group[1];
	            $is_field_error = 1;
	          }

	          // UPDATE SAVE GROUP VALUE QUERY
	          if($this->group_field_query != "") { $this->group_field_query .= ", "; }
	          $this->group_field_query .= "groupvalue_$field_info[groupfield_id]='$field_value'";

		// DO NOT VALIDATE FIELD VALUE AND DON'T CREATE SEARCH VALUE
	        } else {
	          // RETRIEVE DATABASE FIELD VALUE
	          if($this->groupvalue_info != "") {
	            $groupvalue_column = "groupvalue_".$field_info[groupfield_id];
	            $field_value = $this->groupvalue_info[$groupvalue_column];
	          } else {
	            $field_value = $datetime->MakeTime("0", "0", "0", "0", "0", "0");
	          }
	        }


		// FORMAT VALUE FOR PROFILE
		if($profile == 1) {
	   	  if($field_value != $datetime->MakeTime("0", "0", "0", "0", "0", "0")) { $field_value_group = $datetime->cdate($setting[setting_dateformat], $field_value); }

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
	          $month_array[0] = Array('name' => "[$class_group[4]]", 'value' => "0", 'selected' => "");
	          for($m=1;$m<=12;$m++) {
	            if($field_month == $m) { $selected = " SELECTED"; } else { $selected = ""; }
	            $month_array[$m] = Array('name' => $datetime->cdate("$month_format", mktime(0, 0, 0, $m, 1, 1990)),
						'value' => $m,
						'selected' => $selected);
	          }
  
	          // CONSTRUCT DAY ARRAY
	          $day_array = Array();
	          $day_array[0] = Array('name' => "[$class_group[5]]", 'value' => "0", 'selected' => "");
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
	          $year_array[0] = Array('name' => "[$class_group[6]]", 'value' => "0", 'selected' => "");
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
	    if($is_field_error == 1) { $field_error = $field_info[groupfield_error]; } else { $field_error = ""; }

	    // SET FIELD ARRAY AND INCREMENT FIELD COUNT
	    if($profile == 0 | ($profile == 1 & $field_value_group != "")) {
	      $this->group_fields[] = Array('field_id' => $field_info[groupfield_id], 
						'field_title' => $field_info[groupfield_title], 
						'field_desc' => $field_info[groupfield_desc],
						'field_type' => $field_info[groupfield_type],
						'field_required' => $field_info[groupfield_required],
						'field_style' => $field_info[groupfield_style],
						'field_maxlength' => $field_info[groupfield_maxlength],
						'field_options' => $field_options,
						'field_value' => $field_value,
						'field_value_group' => $field_value_group,
						'field_error' => $field_error,
						'date_array1' => $date_array1,
						'date_array2' => $date_array2,
						'date_array3' => $date_array3);
	    }

	  } 

	} // END group_fields() METHOD









	// THIS METHOD DELETES A GROUP
	// INPUT: $group_id (OPTIONAL) REPRESENTING THE ID OF THE GROUP TO DELETE
	// OUTPUT:
	function group_delete($group_id = 0) {
	  global $database;

	  if($group_id == 0) { $group_id = $this->group_info[group_id]; }

	  // DELETE GROUP ALBUM, MEDIA, MEDIA COMMENTS
	  $database->database_query("DELETE FROM se_groupalbums, se_groupmedia, se_groupmediacomments USING se_groupalbums LEFT JOIN se_groupmedia ON se_groupalbums.groupalbum_id=se_groupmedia.groupmedia_groupalbum_id LEFT JOIN se_groupmediacomments ON se_groupmedia.groupmedia_id=se_groupmediacomments.groupmediacomment_groupmedia_id WHERE se_groupalbums.groupalbum_group_id='$group_id'");

	  // DELETE ALL MEMBERS
	  $database->database_query("DELETE FROM se_groupmembers WHERE se_groupmembers.groupmember_group_id='$group_id'");

	  // DELETE GROUP VALUES
	  $database->database_query("DELETE FROM se_groupvalues WHERE se_groupvalues.groupvalue_group_id='$group_id'");

	  // DELETE GROUP STYLE
	  $database->database_query("DELETE FROM se_groupstyles WHERE se_groupstyles_group_id='$group_id'");

	  // DELETE GROUP ROW
	  $database->database_query("DELETE FROM se_groups WHERE se_groups.group_id='$group_id'");

	  // DELETE GROUP COMMENTS
	  $database->database_query("DELETE FROM se_groupcomments WHERE se_groupcomments.groupcomment_group_id='$group_id'");

	  // DELETE GROUP'S FILES
	  if(is_dir($this->group_dir($group_id))) {
	    $dir = $this->group_dir($group_id);
	  } else {
	    $dir = ".".$this->group_dir($group_id);
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

	} // END group_delete() METHOD








	// THIS METHOD DELETES SELECTED GROUPS
	// INPUT: $start REPRESENTING THE GROUP TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF GROUPS TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	//	  $group_details (OPTIONAL) REPRESENTING A BOOLEAN THAT DETERMINES WHETHER TO RETRIEVE TOTAL MEMBERS, GROUP LEADER, ETC
	// OUTPUT: AN ARRAY OF GROUPS
	function group_delete_selected($start, $limit, $sort_by = "group_id DESC", $where = "", $group_details = 0) {
	  global $database, $user;

	  // BEGIN QUERY
	  $group_query = "SELECT se_groups.group_id";

	  // SELECT RELEVANT GROUP DETAILS IF NECESSARY
	  if($group_details == 1) { $group_query .= ", count(member_table.groupmember_id) AS num_members, se_users.user_id, se_users.user_username, se_users.user_photo"; }

	  // IF USER ID NOT EMPTY, GET USER AS MEMBER
	  if($this->user_id != 0) { $group_query .= ", se_groupmembers.groupmember_rank"; }

	  // CONTINUE QUERY
	  $group_query .= " FROM";

	  // IF USER ID NOT EMPTY, SELECT FROM GROUPMEMBER TABLE
	  if($this->user_id != 0) { 
	    $group_query .= " se_groupmembers LEFT JOIN se_groups ON se_groupmembers.groupmember_group_id=se_groups.group_id "; 
	  } else {
	    $group_query .= " se_groups";
	  }

	  // CONTINUE QUERY IF NECESSARY
	  if($group_details == 1) { $group_query .= " LEFT JOIN se_groupmembers AS member_table ON se_groups.group_id=member_table.groupmember_group_id AND member_table.groupmember_status='1' AND member_table.groupmember_approved='1' LEFT JOIN se_users ON se_groups.group_user_id=se_users.user_id"; }

	  // ADD WHERE IF NECESSARY
	  if($where != "" | $this->user_id != 0) { $group_query .= " WHERE"; }

	  // IF USER ID NOT EMPTY, MAKE SURE USER IS A MEMBER
	  if($this->user_id != 0) { $group_query .= " se_groupmembers.groupmember_user_id='".$this->user_id."'"; }

	  // INSERT AND IF NECESSARY
	  if($this->user_id != 0 & $where != "") { $group_query .= " AND"; }

	  // ADD WHERE CLAUSE, IF NECESSARY
	  if($where != "") { $group_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $group_query .= " GROUP BY group_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $groups = $database->database_query($group_query);

	  // GET GROUPS INTO AN ARRAY
	  while($group_info = $database->database_fetch_assoc($groups)) {
    	    $var = "delete_group_".$group_info[group_id];
	    if($_POST[$var] == 1) { $this->group_delete($group_info[group_id]); }
	  }

	} // END group_delete_selected() METHOD








	// THIS METHOD UPDATES THE GROUP'S LAST UPDATE DATE
	// INPUT: 
	// OUTPUT: 
	function group_lastupdate() {
	  global $database;

	  $database->database_query("UPDATE se_groups SET group_dateupdated='".time()."' WHERE group_id='".$this->group_info[group_id]."'");
	  
	} // END group_lastupdate() METHOD








	// THIS METHOD RETURNS MAXIMUM PRIVACY LEVEL VIEWABLE BY A USER WITH REGARD TO THE CURRENT GROUP
	// INPUT: $user REPRESENTING A USER OBJECT
	//	  $allowable_privacy (OPTIONAL) REPRESENTING A STRING OF ALLOWABLE PRIVACY SETTINGS
	// OUTPUT: RETURNS THE INTEGER REPRESENTING THE MAXIMUM PRIVACY LEVEL VIEWABLE BY A USER WITH REGARD TO THE CURRENT GROUP
	function group_privacy_max($user, $allowable_privacy = "01234567") {
	  global $database;

	  switch(TRUE) {

	    // NOBODY
	    // NO ONE HAS $privacy_level = 7

	    // GROUP LEADER
	    case($this->group_info[group_user_id] == $user->user_info[user_id]):
	      $privacy_level = 6;
	      break;

	    // GROUP MEMBER
	    case($database->database_num_rows($database->database_query("SELECT groupmember_id FROM se_groupmembers WHERE groupmember_user_id='".$user->user_info[user_id]."' AND groupmember_group_id='".$this->group_info[group_id]."' AND groupmember_status='1'")) != 0):
	      $privacy_level = 5;
	      break;
    
	    // GROUP LEADER'S FRIEND
	    case($database->database_num_rows($database->database_query("SELECT friend_id FROM se_friends WHERE friend_user_id1='".$this->group_info[group_user_id]."' AND friend_user_id2='".$user->user_info[user_id]."'")) != 0):
	      $privacy_level = 4;
	      break;

	    // GROUP MEMBER'S FRIEND
	    case($database->database_num_rows($database->database_query("SELECT se_friends.friend_id FROM se_groupmembers LEFT JOIN se_friends ON se_groupmembers.groupmember_user_id=se_friends.friend_user_id1 AND se_groupmembers.groupmember_status='1' WHERE se_groupmembers.groupmember_group_id='".$this->group_info[group_id]."' AND se_friends.friend_user_id2='".$user->user_info[user_id]."'")) != 0):
	      $privacy_level = 3;
	      break;

	    // FRIEND OF GROUP MEMBER'S FRIENDS
	    case($database->database_num_rows($database->database_query("SELECT t2.friend_user_id2 FROM se_groupmembers LEFT JOIN se_friends AS t1 ON se_groupmembers.groupmember_user_id=t1.friend_user_id1 AND se_groupmembers.groupmember_status='1' LEFT JOIN se_friends AS t2 ON t1.friend_user_id2=t2.friend_user_id1 WHERE se_groupmembers.groupmember_group_id='".$group->group_info[group_id]."' AND t2.friend_user_id2='".$user->user_info[user_id]."'")) != 0):
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
	  
	} // END group_privacy_max() METHOD








	// THIS METHOD RETURNS THE TOTAL NUMBER OF MEMBERS IN A GROUP
	// INPUT: $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	//	  $member_details (OPTIONAL) REPRESENTING WHETHER TO JOIN TO THE USER TABLE FOR SEARCH PURPOSES
	// OUTPUT: AN INTEGER REPRESENTING THE NUMBER OF GROUP MEMBERS
	function group_member_total($where = "", $member_details = 0) {
	  global $database;

	  // BEGIN QUERY
	  $groupmember_query = "SELECT se_groupmembers.groupmember_id FROM se_groupmembers";

	  // JOIN TO USER TABLE IF NECESSARY
	  if($member_details == 1) { $groupmember_query .= " LEFT JOIN se_users ON se_groupmembers.groupmember_user_id=se_users.user_id"; }

	  // ADD WHERE IF NECESSARY
	  if($this->group_exists != 0 | $where != "") { $groupmember_query .= " WHERE"; }

	  // IF GROUP ID IS SET
	  if($this->group_exists != 0) { $groupmember_query .= " se_groupmembers.groupmember_group_id='".$this->group_info[group_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->group_exists != 0 & $where != "") { $groupmember_query .= " AND"; }  

	  // ADD REST OF WHERE CLAUSE
	  if($where != "") { $groupmember_query .= " $where"; }

	  // RUN QUERY
	  $groupmember_total = $database->database_num_rows($database->database_query($groupmember_query));
	  return $groupmember_total;

	} // END group_member_total() METHOD








	// THIS METHOD RETURNS AN ARRAY OF GROUP MEMBERS
	// INPUT: $start REPRESENTING THE GROUP MEMBER TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF GROUP MEMBERS TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN ARRAY OF GROUP MEMBERS
	function group_member_list($start, $limit, $sort_by = "groupmember_id DESC", $where = "") {
	  global $database;

	  // BEGIN QUERY
	  $groupmember_query = "SELECT se_groupmembers.*, se_users.user_id, se_users.user_username, se_users.user_photo, se_users.user_dateupdated, se_users.user_lastlogindate, se_users.user_signupdate FROM se_groupmembers LEFT JOIN se_users ON se_groupmembers.groupmember_user_id=se_users.user_id";

	  // ADD WHERE IF NECESSARY
	  if($this->group_exists != 0 | $where != "") { $groupmember_query .= " WHERE"; }

	  // IF GROUP ID IS SET
	  if($this->group_exists != 0) { $groupmember_query .= " se_groupmembers.groupmember_group_id='".$this->group_info[group_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->group_exists != 0 & $where != "") { $groupmember_query .= " AND"; }  

	  // ADD REST OF WHERE CLAUSE
	  if($where != "") { $groupmember_query .= " $where"; }

	  // ADD ORDER, AND LIMIT CLAUSE
	  $groupmember_query .= " ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $groupmembers = $database->database_query($groupmember_query);

	  // GET GROUP MEMBERS INTO AN ARRAY
	  $groupmember_array = Array();
	  while($groupmember_info = $database->database_fetch_assoc($groupmembers)) {

	    // CREATE OBJECT FOR MEMBER
	    $member = new se_user();
	    $member->user_exists = 1;
	    $member->user_info[user_id] = $groupmember_info[user_id];
	    $member->user_info[user_username] = $groupmember_info[user_username];
	    $member->user_info[user_photo] = $groupmember_info[user_photo];
	    $member->user_info[user_dateupdated] = $groupmember_info[user_dateupdated];
	    $member->user_info[user_lastlogindate] = $groupmember_info[user_lastlogindate];
	    $member->user_info[user_signupdate] = $groupmember_info[user_signupdate];

	    // SET GROUP ARRAY
	    $groupmember_array[] = Array('groupmember_id' => $groupmember_info[groupmember_id],
					'groupmember_rank' => $groupmember_info[groupmember_rank],
					'groupmember_title' => $groupmember_info[groupmember_title],
					'member' => $member);
	  }

	  // RETURN ARRAY
	  return $groupmember_array;

	} // END group_member_list() METHOD








	// THIS METHOD RETURNS THE PATH TO THE GIVEN GROUP'S DIRECTORY
	// INPUT: $group_id (OPTIONAL) REPRESENTING A GROUP'S GROUP_ID
	// OUTPUT: A STRING REPRESENTING THE RELATIVE PATH TO THE GROUP'S DIRECTORY
	function group_dir($group_id = 0) {

	  if($group_id == 0 & $this->group_exists) { $group_id = $this->group_info[group_id]; }

	  $subdir = $group_id+999-(($group_id-1)%1000);
	  $groupdir = "./uploads_group/$subdir/$group_id/";
	  return $groupdir;

	} // END group_dir() METHOD








	// THIS METHOD OUTPUTS THE PATH TO THE GROUP'S PHOTO OR THE GIVEN NOPHOTO IMAGE
	// INPUT: $nophoto_image (OPTIONAL) REPRESENTING THE PATH TO AN IMAGE TO OUTPUT IF NO PHOTO EXISTS
	// OUTPUT: A STRING CONTAINING THE PATH TO THE GROUP'S PHOTO
	function group_photo($nophoto_image = "") {

	  $group_photo = $this->group_dir($this->group_info[group_id]).$this->group_info[group_photo];
	  if(!file_exists($group_photo) | $this->group_info[group_photo] == "") { $group_photo = $nophoto_image; }
	  return $group_photo;
	  
	} // END group_photo() METHOD








	// THIS METHOD UPLOADS A GROUP PHOTO ACCORDING TO SPECIFICATIONS AND RETURNS GROUP PHOTO
	// INPUT: $photo_name REPRESENTING THE NAME OF THE FILE INPUT
	// OUTPUT: 
	function group_photo_upload($photo_name) {
	  global $database, $url;

	  // SET KEY VARIABLES
	  $file_maxsize = "4194304";
	  $file_exts = explode(",", str_replace(" ", "", strtolower($this->groupowner_level_info[level_group_photo_exts])));
	  $file_types = explode(",", str_replace(" ", "", strtolower("image/jpeg, image/jpg, image/jpe, image/pjpeg, image/pjpg, image/x-jpeg, x-jpg, image/gif, image/x-gif, image/png, image/x-png")));
	  $file_maxwidth = $this->groupowner_level_info[level_group_photo_width];
	  $file_maxheight = $this->groupowner_level_info[level_group_photo_height];
	  $photo_newname = "0_".rand(1000, 9999).".jpg";
	  $file_dest = $this->group_dir($this->group_info[group_id]).$photo_newname;

	  $new_photo = new se_upload();
	  $new_photo->new_upload($photo_name, $file_maxsize, $file_exts, $file_types, $file_maxwidth, $file_maxheight);

	  // UPLOAD AND RESIZE PHOTO IF NO ERROR
	  if($new_photo->is_error == 0) {

	    // DELETE OLD AVATAR IF EXISTS
	    $this->group_photo_delete();

	    // CHECK IF IMAGE RESIZING IS AVAILABLE, OTHERWISE MOVE UPLOADED IMAGE
	    if($new_photo->is_image == 1) {
	      $new_photo->upload_photo($file_dest);
	    } else {
	      $new_photo->upload_file($file_dest);
	    }

	    // UPDATE GROUP INFO WITH IMAGE IF STILL NO ERROR
	    if($new_photo->is_error == 0) {
	      $database->database_query("UPDATE se_groups SET group_photo='$photo_newname' WHERE group_id='".$this->group_info[group_id]."'");
	      $this->group_info[group_photo] = $photo_newname;
	    }
	  }
	
	  $this->is_error = $new_photo->is_error;
	  $this->error_message = $new_photo->error_message;
	  
	} // END group_photo_upload() METHOD








	// THIS METHOD DELETES A GROUP PHOTO
	// INPUT: 
	// OUTPUT: 
	function group_photo_delete() {
	  global $database;
	  $group_photo = $this->group_photo();
	  if($group_photo != "") {
	    unlink($group_photo);
	    $database->database_query("UPDATE se_groups SET group_photo='' WHERE group_id='".$this->group_info[group_id]."'");
	    $this->group_info[group_photo] = "";
	  }
	} // END group_photo_delete() METHOD








	// THIS METHOD UPLOADS MEDIA TO A GROUP ALBUM
	// INPUT: $file_name REPRESENTING THE NAME OF THE FILE INPUT
	//	  $groupalbum_id REPRESENTING THE ID OF THE GROUP ALBUM TO UPLOAD THE MEDIA TO
	//	  $space_left REPRESENTING THE AMOUNT OF SPACE LEFT
	// OUTPUT:
	function group_media_upload($file_name, $groupalbum_id, &$space_left) {
	  global $class_group, $database, $url;

	  // SET KEY VARIABLES
	  $file_maxsize = $this->groupowner_level_info[level_group_album_maxsize];
	  $file_exts = explode(",", str_replace(" ", "", strtolower($this->groupowner_level_info[level_group_album_exts])));
	  $file_types = explode(",", str_replace(" ", "", strtolower($this->groupowner_level_info[level_group_album_mimes])));
	  $file_maxwidth = $this->groupowner_level_info[level_group_album_width];
	  $file_maxheight = $this->groupowner_level_info[level_group_album_height];

	  $new_media = new se_upload();
	  $new_media->new_upload($file_name, $file_maxsize, $file_exts, $file_types, $file_maxwidth, $file_maxheight);

	  // UPLOAD AND RESIZE PHOTO IF NO ERROR
	  if($new_media->is_error == 0) {

	    // INSERT ROW INTO MEDIA TABLE
	    $database->database_query("INSERT INTO se_groupmedia (
							groupmedia_groupalbum_id,
							groupmedia_date
							) VALUES (
							'$groupalbum_id',
							'".time()."'
							)");
	    $groupmedia_id = $database->database_insert_id();

	    // CHECK IF IMAGE RESIZING IS AVAILABLE, OTHERWISE MOVE UPLOADED IMAGE
	    if($new_media->is_image == 1) {
	      $file_dest = $this->group_dir($this->group_info[group_id]).$groupmedia_id.".jpg";
	      $thumb_dest = $this->group_dir($this->group_info[group_id]).$groupmedia_id."_thumb.jpg";
	      $new_media->upload_photo($file_dest);
	      $new_media->upload_photo($thumb_dest, 200, 200);
	      $file_ext = "jpg";
	      $file_filesize = filesize($file_dest);
	    } else {
	      $file_dest = $this->group_dir($this->group_info[group_id]).$groupmedia_id.".".$new_media->file_ext;
	      $new_media->upload_file($file_dest);
	      $file_ext = $new_media->file_ext;
	      $file_filesize = filesize($file_dest);
	    }

	    // CHECK SPACE LEFT
	    if($file_filesize > $space_left) {
	      $new_media->is_error = 1;
	      $new_media->error_message = $class_group[3].$_FILES[$file_name]['name'];
	    } else {
	      $space_left = $space_left-$file_filesize;
	    }

	    // DELETE FROM DATABASE IF ERROR
	    if($new_media->is_error != 0) {
	      $database->database_query("DELETE FROM se_groupmedia WHERE groupmedia_id='$groupmedia_id' AND groupmedia_groupalbum_id='$groupalbum_id'");
	      @unlink($file_dest);

	    // UPDATE ROW IF NO ERROR
	    } else {
	      $database->database_query("UPDATE se_groupmedia SET groupmedia_ext='$file_ext', groupmedia_filesize='$file_filesize' WHERE groupmedia_id='$groupmedia_id' AND groupmedia_groupalbum_id='$groupalbum_id'");
	    }
	  }
	
	  // RETURN FILE STATS
	  $file = Array('is_error' => $new_media->is_error,
			'error_message' => $new_media->error_message,
			'groupmedia_id' => $groupmedia_id,
			'groupmedia_ext' => $file_ext,
			'groupmedia_filesize' => $file_filesize);
	  return $file;

	} // END group_media_upload() METHOD








	// THIS METHOD RETURNS THE SPACE USED
	// INPUT: $groupalbum_id (OPTIONAL) REPRESENTING THE ID OF THE ALBUM TO CALCULATE
	// OUTPUT: AN INTEGER REPRESENTING THE SPACE USED
	function group_media_space($groupalbum_id = 0) {
	  global $database;

	  // BEGIN QUERY
	  $groupmedia_query = "SELECT sum(se_groupmedia.groupmedia_filesize) AS total_space";
	
	  // CONTINUE QUERY
	  $groupmedia_query .= " FROM se_groupalbums LEFT JOIN se_groupmedia ON se_groupalbums.groupalbum_id=se_groupmedia.groupmedia_groupalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->group_exists != 0 | $groupalbum_id != 0) { $groupmedia_query .= " WHERE"; }

	  // IF GROUP EXISTS, SPECIFY GROUP ID
	  if($this->group_exists != 0) { $groupmedia_query .= " se_groupalbums.groupalbum_group_id='".$this->group_info[group_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->group_exists != 0 & $groupalbum_id != 0) { $groupmedia_query .= " AND"; }

	  // SPECIFY ALBUM ID IF NECESSARY
	  if($groupalbum_id != 0) { $groupmedia_query .= " se_groupalbums.groupalbum_id='$groupalbum_id'"; }

	  // GET AND RETURN TOTAL SPACE USED
	  $space_info = $database->database_fetch_assoc($database->database_query($groupmedia_query));
	  return $space_info[total_space];

	} // END group_media_space() METHOD








	// THIS METHOD RETURNS THE NUMBER OF GROUP MEDIA
	// INPUT: $groupalbum_id (OPTIONAL) REPRESENTING THE ID OF THE GROUP ALBUM TO CALCULATE
	// OUTPUT: AN INTEGER REPRESENTING THE NUMBER OF FILES
	function group_media_total($groupalbum_id = 0) {
	  global $database;

	  // BEGIN QUERY
	  $groupmedia_query = "SELECT count(se_groupmedia.groupmedia_id) AS total_files";
	
	  // CONTINUE QUERY
	  $groupmedia_query .= " FROM se_groupalbums LEFT JOIN se_groupmedia ON se_groupalbums.groupalbum_id=se_groupmedia.groupmedia_groupalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->group_exists != 0 | $groupalbum_id != 0) { $groupmedia_query .= " WHERE"; }

	  // IF GROUP EXISTS, SPECIFY GROUP ID
	  if($this->group_exists != 0) { $groupmedia_query .= " se_groupalbums.groupalbum_group_id='".$this->group_info[group_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->group_exists != 0 & $groupalbum_id != 0) { $groupmedia_query .= " AND"; }

	  // SPECIFY ALBUM ID IF NECESSARY
	  if($groupalbum_id != 0) { $groupmedia_query .= " se_groupalbums.groupalbum_id='$groupalbum_id'"; }

	  // GET AND RETURN TOTAL FILES
	  $file_info = $database->database_fetch_assoc($database->database_query($groupmedia_query));
	  return $file_info[total_files];

	} // END group_media_total() METHOD








	// THIS METHOD RETURNS AN ARRAY OF GROUP MEDIA
	// INPUT: $start REPRESENTING THE GROUP MEDIA TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF GROUP MEDIA TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN ARRAY OF GROUP MEDIA
	function group_media_list($start, $limit, $sort_by = "groupmedia_id DESC", $where = "") {
	  global $database;

	  // BEGIN QUERY
	  $groupmedia_query = "SELECT se_groupmedia.*, se_groupalbums.groupalbum_id, se_groupalbums.groupalbum_group_id, se_groupalbums.groupalbum_title, count(se_groupmediacomments.groupmediacomment_id) AS total_comments";
	
	  // CONTINUE QUERY
	  $groupmedia_query .= " FROM se_groupmedia LEFT JOIN se_groupmediacomments ON se_groupmediacomments.groupmediacomment_groupmedia_id=se_groupmedia.groupmedia_id LEFT JOIN se_groupalbums ON se_groupalbums.groupalbum_id=se_groupmedia.groupmedia_groupalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->group_exists != 0 | $where != "") { $groupmedia_query .= " WHERE"; }

	  // IF GROUP EXISTS, SPECIFY GROUP ID
	  if($this->group_exists != 0) { $groupmedia_query .= " se_groupalbums.groupalbum_group_id='".$this->group_info[group_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->group_exists != 0 & $where != "") { $groupmedia_query .= " AND"; }

	  // ADD ADDITIONAL WHERE CLAUSE
	  if($where != "") { $groupmedia_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $groupmedia_query .= " GROUP BY groupmedia_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $groupmedia = $database->database_query($groupmedia_query);

	  // GET GROUP MEDIA INTO AN ARRAY
	  $groupmedia_array = Array();
	  while($groupmedia_info = $database->database_fetch_assoc($groupmedia)) {

	    // CREATE ARRAY OF MEDIA DATA
	    $groupmedia_array[] = Array('groupmedia_id' => $groupmedia_info[groupmedia_id],
					'groupmedia_groupalbum_id' => $groupmedia_info[groupmedia_groupalbum_id],
					'groupmedia_date' => $groupmedia_info[groupmedia_date],
					'groupmedia_title' => $groupmedia_info[groupmedia_title],
					'groupmedia_desc' => str_replace("<br>", "\r\n", $groupmedia_info[groupmedia_desc]),
					'groupmedia_ext' => $groupmedia_info[groupmedia_ext],
					'groupmedia_filesize' => $groupmedia_info[groupmedia_filesize],
					'groupmedia_comments_total' => $groupmedia_info[total_comments]);

	  }

	  // RETURN ARRAY
	  return $groupmedia_array;

	} // END group_media_list() METHOD








	// THIS METHOD UPDATES GROUP MEDIA INFORMATION
	// INPUT: $start REPRESENTING THE GROUP MEDIA TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF GROUP MEDIA TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN ARRAY CONTAINING ALL THE GROUP MEDIA ID
	function group_media_update($start, $limit, $sort_by = "groupmedia_id DESC", $where = "") {
	  global $database;

	  // BEGIN QUERY
	  $groupmedia_query = "SELECT se_groupmedia.*, se_groupalbums.groupalbum_id, se_groupalbums.groupalbum_group_id, se_groupalbums.groupalbum_title, count(se_groupmediacomments.groupmediacomment_id) AS total_comments";
	
	  // CONTINUE QUERY
	  $groupmedia_query .= " FROM se_groupmedia LEFT JOIN se_groupmediacomments ON se_groupmediacomments.groupmediacomment_groupmedia_id=se_groupmedia.groupmedia_id LEFT JOIN se_groupalbums ON se_groupalbums.groupalbum_id=se_groupmedia.groupmedia_groupalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->group_exists != 0 | $where != "") { $groupmedia_query .= " WHERE"; }

	  // IF GROUP EXISTS, SPECIFY GROUP ID
	  if($this->group_exists != 0) { $groupmedia_query .= " se_groupalbums.groupalbum_group_id='".$this->group_info[group_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->group_exists != 0 & $where != "") { $groupmedia_query .= " AND"; }

	  // ADD ADDITIONAL WHERE CLAUSE
	  if($where != "") { $groupmedia_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $groupmedia_query .= " GROUP BY groupmedia_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $groupmedia = $database->database_query($groupmedia_query);

	  // GET GROUP MEDIA INTO AN ARRAY
	  $groupmedia_array = Array();
	  while($groupmedia_info = $database->database_fetch_assoc($groupmedia)) {
	    $var1 = "groupmedia_title_".$groupmedia_info[groupmedia_id];
	    $var2 = "groupmedia_desc_".$groupmedia_info[groupmedia_id];
	    $groupmedia_title = censor($_POST[$var1]);
	    $groupmedia_desc = censor(str_replace("\r\n", "<br>", $_POST[$var2]));
	    if($groupmedia_title != $groupmedia_info[groupmedia_title] OR $groupmedia_desc != $groupmedia_info[groupmedia_desc]) {
	      $database->database_query("UPDATE se_groupmedia SET groupmedia_title='$groupmedia_title', groupmedia_desc='$groupmedia_desc' WHERE groupmedia_id='$groupmedia_info[groupmedia_id]'");
	    }
	    $groupmedia_array[] = $groupmedia_info[groupmedia_id];
	  }

	  return $groupmedia_array;

	} // END group_media_update() METHOD








	// THIS METHOD DELETES SELECTED GROUP MEDIA
	// INPUT: $start REPRESENTING THE GROUP MEDIA TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF GROUP MEDIA TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT:
	function group_media_delete($start, $limit, $sort_by = "groupmedia_id DESC", $where = "") {
	  global $database, $url;

	  // BEGIN QUERY
	  $groupmedia_query = "SELECT se_groupmedia.*, se_groupalbums.groupalbum_id, se_groupalbums.groupalbum_group_id, se_groupalbums.groupalbum_title, count(se_groupmediacomments.groupmediacomment_id) AS total_comments";
	
	  // CONTINUE QUERY
	  $groupmedia_query .= " FROM se_groupmedia LEFT JOIN se_groupmediacomments ON se_groupmediacomments.groupmediacomment_groupmedia_id=se_groupmedia.groupmedia_id LEFT JOIN se_groupalbums ON se_groupalbums.groupalbum_id=se_groupmedia.groupmedia_groupalbum_id";

	  // ADD WHERE IF NECESSARY
	  if($this->group_exists != 0 | $where != "") { $groupmedia_query .= " WHERE"; }

	  // IF GROUP EXISTS, SPECIFY GROUP ID
	  if($this->group_exists != 0) { $groupmedia_query .= " se_groupalbums.groupalbum_group_id='".$this->group_info[group_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->group_exists != 0 & $where != "") { $groupmedia_query .= " AND"; }

	  // ADD ADDITIONAL WHERE CLAUSE
	  if($where != "") { $groupmedia_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $groupmedia_query .= " GROUP BY groupmedia_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $groupmedia = $database->database_query($groupmedia_query);

	  // LOOP OVER GROUP MEDIA
	  $groupmedia_delete = "";
	  while($groupmedia_info = $database->database_fetch_assoc($groupmedia)) {
	    $var = "delete_groupmedia_".$groupmedia_info[groupmedia_id];
	    if($_POST[$var] == 1) { 
	      if($groupmedia_delete != "") { $groupmedia_delete .= " OR "; }
	      $groupmedia_delete .= "groupmedia_id='$groupmedia_info[groupmedia_id]'";
	      $groupmedia_path = $this->group_dir($this->group_info[group_id]).$groupmedia_info[groupmedia_id].".".$groupmedia_info[groupmedia_ext];
	      if(file_exists($groupmedia_path)) { unlink($groupmedia_path); }
	      $thumb_path = $this->group_dir($this->group_info[group_id]).$groupmedia_info[groupmedia_id]."_thumb.".$groupmedia_info[groupmedia_ext];
	      if(file_exists($thumb_path)) { unlink($thumb_path); }
	    }
	  }

	  // IF DELETE CLAUSE IS NOT EMPTY, DELETE GROUP MEDIA
	  if($groupmedia_delete != "") { $database->database_query("DELETE FROM se_groupmedia, se_groupmediacomments USING se_groupmedia LEFT JOIN se_groupmediacomments ON se_groupmedia.groupmedia_id=se_groupmediacomments.groupmediacomment_groupmedia_id WHERE ($groupmedia_delete)"); }

	} // END group_media_delete() METHOD








	// THIS METHOD RETURNS AN ARRAY OF GROUP TOPICS
	// INPUT: $start REPRESENTING THE GROUP TOPIC TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF GROUP TOPICS TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN ARRAY OF GROUP TOPICS
	function group_topic_list($start, $limit, $sort_by = "grouptopic_date DESC", $where = "") {
	  global $database;

	  // BEGIN QUERY
	  $grouptopic_query = "SELECT se_grouptopics.*, count(se_groupposts.grouppost_id) AS total_posts";
	
	  // CONTINUE QUERY
	  $grouptopic_query .= " FROM se_grouptopics LEFT JOIN se_groupposts ON se_groupposts.grouppost_grouptopic_id=se_grouptopics.grouptopic_id";

	  // ADD WHERE IF NECESSARY
	  if($this->group_exists != 0 | $where != "") { $grouptopic_query .= " WHERE"; }

	  // IF GROUP EXISTS, SPECIFY GROUP ID
	  if($this->group_exists != 0) { $grouptopic_query .= " se_grouptopics.grouptopic_group_id='".$this->group_info[group_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->group_exists != 0 & $where != "") { $grouptopic_query .= " AND"; }

	  // ADD ADDITIONAL WHERE CLAUSE
	  if($where != "") { $grouptopic_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $grouptopic_query .= " GROUP BY grouptopic_id ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $grouptopics = $database->database_query($grouptopic_query);

	  // GET GROUP TOPICS INTO AN ARRAY
	  $grouptopic_array = Array();
	  while($grouptopic_info = $database->database_fetch_assoc($grouptopics)) {

	    // CREATE ARRAY OF TOPIC DATA
	    $grouptopic_array[] = Array('grouptopic_id' => $grouptopic_info[grouptopic_id],
					'grouptopic_group_id' => $grouptopic_info[grouptopic_group_id],
					'grouptopic_date' => $grouptopic_info[grouptopic_date],
					'grouptopic_subject' => $grouptopic_info[grouptopic_subject],
					'grouptopic_views' => $grouptopic_info[grouptopic_views],
					'groupposts_total' => $grouptopic_info[total_posts]);

	  }

	  // RETURN ARRAY
	  return $grouptopic_array;

	} // END group_topic_list() METHOD








	// THIS METHOD RETURNS THE NUMBER OF GROUP TOPICS
	// INPUT: $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN INTEGER REPRESENTING THE NUMBER OF TOPICS
	function group_topic_total($where = "") {
	  global $database;

	  // BEGIN QUERY
	  $grouptopic_query = "SELECT se_grouptopics.*, count(se_groupposts.grouppost_id) AS total_posts";
	
	  // CONTINUE QUERY
	  $grouptopic_query .= " FROM se_grouptopics LEFT JOIN se_groupposts ON se_groupposts.grouppost_grouptopic_id=se_grouptopics.grouptopic_id";

	  // ADD WHERE IF NECESSARY
	  if($this->group_exists != 0 | $where != "") { $grouptopic_query .= " WHERE"; }

	  // IF GROUP EXISTS, SPECIFY GROUP ID
	  if($this->group_exists != 0) { $grouptopic_query .= " se_grouptopics.grouptopic_group_id='".$this->group_info[group_id]."'"; }

	  // ADD AND IF NECESSARY
	  if($this->group_exists != 0 & $where != "") { $grouptopic_query .= " AND"; }

	  // ADD ADDITIONAL WHERE CLAUSE
	  if($where != "") { $grouptopic_query .= " $where"; }

	  // ADD GROUP BY, ORDER, AND LIMIT CLAUSE
	  $grouptopic_query .= " GROUP BY grouptopic_id";

	  // RUN QUERY
	  $total_topics = $database->database_num_rows($database->database_query($grouptopic_query));

	  // RETURN TOTAL TOPICS
	  return $total_topics;

	} // END group_topic_total() METHOD








	// THIS METHOD RETURNS AN ARRAY OF GROUP POSTS
	// INPUT: $start REPRESENTING THE GROUP POST TO START WITH
	//	  $limit REPRESENTING THE NUMBER OF GROUP POSTS TO RETURN
	//	  $sort_by (OPTIONAL) REPRESENTING THE ORDER BY CLAUSE
	//	  $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN ARRAY OF GROUP POSTS
	function group_post_list($start, $limit, $sort_by = "grouppost_date DESC", $where = "") {
	  global $database;

	  // BEGIN QUERY
	  $grouppost_query = "SELECT se_groupposts.*, se_users.user_id, se_users.user_username, se_users.user_photo";
	
	  // CONTINUE QUERY
	  $grouppost_query .= " FROM se_groupposts LEFT JOIN se_users ON se_groupposts.grouppost_authoruser_id=se_users.user_id";

	  // ADD WHERE IF NECESSARY
	  if($where != "") { $grouppost_query .= " WHERE $where"; }

	  // ADD ORDER, AND LIMIT CLAUSE
	  $grouppost_query .= " ORDER BY $sort_by LIMIT $start, $limit";

	  // RUN QUERY
	  $groupposts = $database->database_query($grouppost_query);

	  // GET GROUP POSTS INTO AN ARRAY
	  $grouppost_array = Array();
	  while($grouppost_info = $database->database_fetch_assoc($groupposts)) {

	    // CREATE AN OBJECT FOR AUTHOR
	    $author = new se_user();
	    $author->user_info[user_id] = $grouppost_info[user_id];
	    $author->user_info[user_username] = $grouppost_info[user_username];
	    $author->user_info[user_photo] = $grouppost_info[user_photo];

	    // CREATE ARRAY OF POST DATA
	    $grouppost_array[] = Array('grouppost_id' => $grouppost_info[grouppost_id],
					'grouppost_date' => $grouppost_info[grouppost_date],
					'grouppost_body' => $grouppost_info[grouppost_body],
					'grouppost_author' => $author);

	  }

	  // RETURN ARRAY
	  return $grouppost_array;

	} // END group_post_list() METHOD








	// THIS METHOD RETURNS THE NUMBER OF GROUP POSTS
	// INPUT: $where (OPTIONAL) REPRESENTING ADDITIONAL THINGS TO INCLUDE IN THE WHERE CLAUSE
	// OUTPUT: AN INTEGER REPRESENTING THE NUMBER OF POSTS
	function group_post_total($where = "") {
	  global $database;

	  // BEGIN QUERY
	  $grouppost_query = "SELECT se_groupposts.grouppost_id, se_users.user_id";
	
	  // CONTINUE QUERY
	  $grouppost_query .= " FROM se_groupposts LEFT JOIN se_users ON se_groupposts.grouppost_authoruser_id=se_users.user_id";

	  // ADD WHERE IF NECESSARY
	  if($where != "") { $grouppost_query .= " WHERE $where"; }

	  // RUN QUERY
	  $total_posts = $database->database_num_rows($database->database_query($grouppost_query));

	  // RETURN TOTAL POSTS
	  return $total_posts;

	} // END group_post_total() METHOD

}
?>