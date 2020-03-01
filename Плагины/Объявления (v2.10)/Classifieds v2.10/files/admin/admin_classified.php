<?
$page = "admin_classified";
include "admin_header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }


// SET RESULT VARIABLE
$result = 0;


// SAVE CATEGORY
if($task == "savecat") {
  $cat_id = $_GET['cat_id'];
  $cat_title = $_GET['cat_title'];
  $cat_dependency = $_GET['cat_dependency'];

  // IF CAT TITLE IS BLANK, DELETE
  if($cat_title == "") {

    if($cat_id != "new") {
      $database->database_query("DELETE FROM se_classifiedcats WHERE classifiedcat_id='$cat_id' OR classifiedcat_dependency='$cat_id'");
      $fields = $database->database_query("SELECT classifiedfield_id FROM se_classifiedfields WHERE classifiedfield_classifiedcat_id='$cat_id'");
      while($field = $database->database_fetch_assoc($fields)) {
        $column = "classifiedvalue_".$field[classifiedfield_id];
        $database->database_query("ALTER TABLE se_classifiedvalues DROP COLUMN $column");
      }
      $database->database_query("DELETE FROM se_classifiedfields WHERE classifiedfield_classifiedcat_id='$cat_id'");
    }

    // SEND AJAX CONFIRMATION
    echo "<html><head><script type=\"text/javascript\">";
    echo "window.parent.removecat('$cat_id');";
    echo "</script></head><body></body></html>";
    exit();

  // SAVE CHANGES
  } else {

    // NEW CATEGORY
    if($cat_id == "new") {
      $database->database_query("INSERT INTO se_classifiedcats (classifiedcat_dependency, classifiedcat_title) VALUES ('$cat_dependency', '$cat_title')");
      $newcat_id = $database->database_insert_id();
  
    // EDIT CATEGORY
    } else {
      $database->database_query("UPDATE se_classifiedcats SET classifiedcat_title='$cat_title' WHERE classifiedcat_id='$cat_id'");
      $newcat_id = $cat_id;
    }

    // SEND AJAX CONFIRMATION
    echo "<html><head><script type=\"text/javascript\">";
    echo "window.parent.savecat_result('$cat_id', '$newcat_id', '$cat_title', '$cat_dependency');";
    echo "</script></head><body></body></html>";
    exit();

  }




// GET FIELD
} elseif($task == "getfield") {
  $field_id = $_GET['field_id'];

  $field = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_classifiedfields WHERE classifiedfield_id='$field_id'"));

  // PULL OPTIONS INTO NEW ARRAY
  $new_field_options = "";
  $field_options = explode("<~!~>", $field[classifiedfield_options]);
  for($i=0;$i<count($field_options);$i++) {
    if(str_replace(" ", "", $field_options[$i]) != "") {
      $options = explode("<!>", $field_options[$i]);
      $dependent_label = "";
      if($options[2] == "1") { 
        $dep_field = $database->database_query("SELECT classifiedfield_id, classifiedfield_title FROM se_classifiedfields WHERE classifiedfield_id='$options[3]'");
        if($database->database_num_rows($dep_field) != "1") {
          $options[2] = "0";
        } else {
          $options[2] = "1";
          $dep_field_info = $database->database_fetch_assoc($dep_field);
          $dependent_label = $dep_field_info[classifiedfield_title];
        }
      }
      $new_field_options .= "$options[0]<!>$options[1]<!>$options[2]<!>$dependent_label<!>$options[3]<~!~>";
    }
  }
  
  // SEND AJAX CONFIRMATION
  echo "<html><head><script type=\"text/javascript\">";
  echo "window.parent.editfield('$field[classifiedfield_id]', '$field[classifiedfield_classifiedcat_id]', '$field[classifiedfield_title]', '$field[classifiedfield_desc]', '$field[classifiedfield_error]', '$field[classifiedfield_type]', '$field[classifiedfield_style]', '$field[classifiedfield_maxlength]', '$field[classifiedfield_link]', '$new_field_options', '$field[classifiedfield_required]', '$field[classifiedfield_regex]', '$field[classifiedfield_html]', '$field[classifiedfield_search]');";
  echo "</script></head><body></body></html>";
  exit();



// GET DEPENDENT FIELD
} elseif($task == "getdepfield") {
  $field_id = $_GET['field_id'];

  $field = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_classifiedfields WHERE classifiedfield_id='$field_id'"));

  // SEND AJAX CONFIRMATION
  echo "<html><head><script type=\"text/javascript\">";
  echo "window.parent.editdepfield('$field[classifiedfield_id]', '$field[classifiedfield_classifiedcat_id]', '$field[classifiedfield_title]', '$field[classifiedfield_style]', '$field[classifiedfield_maxlength]', '$field[classifiedfield_link]', '$field[classifiedfield_required]', '$field[classifiedfield_regex]');";
  echo "</script></head><body></body></html>";
  exit();




// REMOVE FIELD
} elseif($task == "removefield") {
  $field_id = $_GET['field_id'];

  // DELETE ALL FIELD COLUMNS
  $fields = $database->database_query("SELECT classifiedfield_id FROM se_classifiedfields WHERE classifiedfield_id='$field_id' OR classifiedfield_dependency='$field_id'");
  while($field = $database->database_fetch_assoc($fields)) {
    $column = "classifiedvalue_".$field[classifiedfield_id];
    $database->database_query("ALTER TABLE se_classifiedvalues DROP COLUMN $column");
  }

  // DELETE ALL FIELDS
  $database->database_query("DELETE FROM se_classifiedfields WHERE classifiedfield_id='$field_id' OR classifiedfield_dependency='$field_id'");

  // SEND AJAX CONFIRMATION
  echo "<html><head><script type=\"text/javascript\">";
  echo "window.parent.removefield_result('$field_id');";
  echo "</script></head><body></body></html>";
  exit();


// SAVE DEP FIELD
} elseif($task == "savedepfield") {
  $field_id = $_POST['field_id'];
  $field_title = $_POST['field_title'];
  $field_style = $_POST['field_style'];
  $field_required = $_POST['field_required'];
  $field_maxlength = $_POST['field_maxlength'];
  $field_link = $_POST['field_link'];
  $field_regex = $_POST['field_regex'];

  $database->database_query("UPDATE se_classifiedfields SET classifiedfield_title='$field_title', classifiedfield_style='$field_style', classifiedfield_maxlength='$field_maxlength', classifiedfield_link='$field_link', classifiedfield_required='$field_required', classifiedfield_regex='$field_regex' WHERE classifiedfield_id='$field_id'");

  // SEND AJAX CONFIRMATION
  echo "<html><head><script type=\"text/javascript\">";
  echo "window.parent.cancelfield();";
  echo "</script></head><body></body></html>";
  exit();


// SAVE FIELD
} elseif($task == "savefield") {
  $field_id = $_POST['field_id'];
  $field_title = $_POST['field_title'];
  $field_cat_id = $_POST['field_cat_id'];
  $field_type = $_POST['field_type'];
  $field_style = $_POST['field_style'];
  $field_desc = $_POST['field_desc'];
  $field_error = $_POST['field_error'];
  $field_required = $_POST['field_required'];
  $field_html = $_POST['field_html'];
  $field_search = $_POST['field_search'];
  $field_maxlength = $_POST['field_maxlength'];
  $field_link = $_POST['field_link'];
  $field_regex = $_POST['field_regex'];

  // FIELD TYPE IS TEXT FIELD
  if($field_type == "1") {
    $column_type = "varchar(250)";
    $column_default = "default ''";

  // FIELD TYPE IS TEXTAREA
  } elseif($field_type == "2") {
    $column_type = "text";
    $column_default = "";

  // FIELD TYPE IS SELECT BOX
  } elseif($field_type == "3") {
    $column_type = "int(2)";
    $column_default = "default '-1'";
    $select_labels = $_POST['select_label'];
    $select_dependencies = $_POST['select_dependency'];
    $select_dependent_labels = $_POST['select_dependent_label'];
    $select_dependent_ids = $_POST['select_dependent_id'];
    $num_select_options = 0;
    for($i=0;$i<count($select_labels);$i++) {
      $select_label = $select_labels[$i];
      $select_dependency = $select_dependencies[$i];
      $select_dependent_label = $select_dependent_labels[$i];
      $select_dependent_id = $select_dependent_ids[$i];

      if(str_replace(" ", "", $select_label) != "") {
        $options[$num_select_options] = Array('option_id' => $num_select_options,
			 		      'option_label' => $select_label,
					      'option_dependency' => $select_dependency,
					      'option_dependent_label' => $select_dependent_label,
					      'option_dependent_id' => $select_dependent_id);

        $num_select_options++;

      }
    }


    // IF NO OPTIONS HAVE BEEN SPECIFIED
    if($num_select_options == 0) { $is_error = 1; $error_message = $admin_classified[56]; }



  // FIELD TYPE IS RADIO BUTTON
  } elseif($field_type == "4") {
    $box4_display = "block";
    $column_type = "int(2)";
    $column_default = "default '-1'";
    $radio_labels = $_POST['radio_label'];
    $radio_dependencies = $_POST['radio_dependency'];
    $radio_dependent_labels = $_POST['radio_dependent_label'];
    $radio_dependent_ids = $_POST['radio_dependent_id'];
    $num_radio_options = 0;
    for($i=0;$i<count($radio_labels);$i++) {
      $radio_label = $radio_labels[$i];
      $radio_dependency = $radio_dependencies[$i];
      $radio_dependent_label = $radio_dependent_labels[$i];
      $radio_dependent_id = $radio_dependent_ids[$i];
      
      if(str_replace(" ", "", $radio_label) != "") {
        $options[$num_radio_options] = Array('option_id' => $num_radio_options,
			 		     'option_label' => $radio_label,
					     'option_dependency' => $radio_dependency,
					     'option_dependent_label' => $radio_dependent_label,
					     'option_dependent_id' => $radio_dependent_id);

        $num_radio_options++;

      }
    }

    // IF NO OPTIONS HAVE BEEN SPECIFIED
    if($num_radio_options == 0) { $is_error = 1; $error_message = $admin_classified[56]; }


  // FIELD TYPE IS DATE FIELD
  } elseif($field_type == "5") {
    $box5_display = "block";
    $column_type = "int(14)";
    $column_default = "default '-2019787262'";


  // FIELD TYPE NOT SPECIFIED
  } else {
    $is_error = 1;
    $error_message = $admin_classified[57];
  }

  // FIELD TITLE IS EMPTY
  if(str_replace(" ", "", $field_title) == "") { $is_error = 1; $error_message = $admin_classified[58];
  }

  // ONLY GET HTML IF FIELD TYPE IS TEXT OR MULTILINE TEXT
  if($field_type == 1 OR $field_type == 2) { 
    if($field_html != "") { $field_html = str_replace("&gt;", "", str_replace("&lt;", "", str_replace(" ", "", $field_html))); }
  } else {
    $field_html = "";
  }




  // NO ERROR 
  if($is_error == 0) {

    $field = $database->database_query("SELECT classifiedfield_id FROM se_classifiedfields WHERE classifiedfield_id='$field_id'");
  
    // OLD FIELD (SAVE)
    if($database->database_num_rows($field)) { 

      $database->database_query("UPDATE se_classifiedfields SET classifiedfield_classifiedcat_id='$field_cat_id', classifiedfield_title='$field_title', classifiedfield_desc='$field_desc', classifiedfield_error='$field_error', classifiedfield_type='$field_type', classifiedfield_style='$field_style', classifiedfield_maxlength='$field_maxlength', classifiedfield_link='$field_link', classifiedfield_required='$field_required', classifiedfield_regex='$field_regex', classifiedfield_html='$field_html', classifiedfield_search='$field_search' WHERE classifiedfield_id='$field_id'");
      $column_name = "classifiedvalue_".$field_id;
      $database->database_query("ALTER TABLE se_classifiedvalues MODIFY $column_name $column_type NOT NULL $column_default");

      // EDIT DEPENDENT FIELDS
      $field_options = "";
      for($d=0;$d<count($options);$d++) {

        $option = $options[$d];
        $option_label = str_replace("<~!~>", "", str_replace("<!>", "", $option[option_label]));
        $option_dependent_label = str_replace("<~!~>", "", str_replace("<!>", "", $option[option_dependent_label]));
        $dep_field = $database->database_query("SELECT classifiedfield_id, classifiedfield_title FROM se_classifiedfields WHERE classifiedfield_id='$option[option_dependent_id]'");
        $dep_field_info_id = "";

        if($database->database_num_rows($dep_field) == "1") {
          $dep_field_info = $database->database_fetch_assoc($dep_field);
          if($option[option_dependency] == "1") {
            // MODIFY EXISTING DEPENDENT FIELD
            $dep_field_id = $dep_field_info[classifiedfield_id];
            $database->database_query("UPDATE se_classifiedfields SET classifiedfield_classifiedcat_id='$field_cat_id', classifiedfield_title='$option_dependent_label' WHERE classifiedfield_id='$dep_field_info[classifiedfield_id]'");
          } else {
            // DELETE DEPENDENT FIELD IF DEPENDENCY IS NO LONGER REQUIRED
            $database->database_query("DELETE FROM se_classifiedfields WHERE classifiedfield_id='$dep_field_info[classifiedfield_id]'");
            $column_name = "classifiedvalue_".$dep_field_info[classifiedfield_id];
            $database->database_query("ALTER TABLE se_classifiedvalues DROP COLUMN $column_name");
          }
        } else {
          if($option[option_dependency] == "1") {
            // ADD NEW DEPENDENT FIELD
            $dep_field_order = $database->database_num_rows($database->database_query("SELECT max(classifiedfield_order) AS f_order FROM se_classifiedfields WHERE classifiedfield_dependency='field_id'"));
            $dep_field_order = $dep_field_order[f_order]+1;
            $database->database_query("INSERT INTO se_classifiedfields (classifiedfield_classifiedcat_id, classifiedfield_title, classifiedfield_desc, classifiedfield_order, classifiedfield_type, classifiedfield_style, classifiedfield_dependency, classifiedfield_maxlength, classifiedfield_link, classifiedfield_options, classifiedfield_required, classifiedfield_regex) VALUES ('$field_cat_id', '$option_dependent_label', '', '$dep_field_order', '1', '', '$field_id', '100', '', '', '0', '')");
            $dep_field_id = $database->database_insert_id();
            $column_name = "classifiedvalue_".$dep_field_id;
            $database->database_query("ALTER TABLE se_classifiedvalues ADD $column_name varchar(250) NOT NULL");
          }
        }
        $field_options .= "$option[option_id]<!>$option_label<!>$option[option_dependency]<!>$dep_field_id<~!~>";
      }



      // INSERT OPTIONS
      $database->database_query("UPDATE se_classifiedfields SET classifiedfield_options='$field_options' WHERE classifiedfield_id='$field_id'");
      
      $new_field_id = $field_id;


    // NEW FIELD (ADD)
    } else {

      $field_order_info = $database->database_fetch_assoc($database->database_query("SELECT max(classifiedfield_order) as f_order FROM se_classifiedfields WHERE classifiedfield_dependency='0'"));
      $field_order = $field_order_info[f_order]+1;
      $database->database_query("INSERT INTO se_classifiedfields (classifiedfield_classifiedcat_id, classifiedfield_title, classifiedfield_desc, classifiedfield_error, classifiedfield_order, classifiedfield_type, classifiedfield_style, classifiedfield_dependency, classifiedfield_maxlength, classifiedfield_link, classifiedfield_required, classifiedfield_regex, classifiedfield_html, classifiedfield_search) VALUES ('$field_cat_id', '$field_title', '$field_desc', '$field_error', '$field_order', '$field_type', '$field_style', '0', '$field_maxlength', '$field_link', '$field_required', '$field_regex', '$field_html', '$field_search')");
      $new_field_id = $database->database_insert_id();
      $column_name = "classifiedvalue_".$new_field_id;
      $database->database_query("ALTER TABLE se_classifiedvalues ADD $column_name $column_type NOT NULL $column_default");

      // ADD DEPENDENT FIELDS
      $field_options = "";
      $num_dependent_fields = 1;
      for($d=0;$d<count($options);$d++) {
        $option = $options[$d];
        $option_label = str_replace("<~!~>", "", str_replace("<!>", "", $option[option_label]));
        $option_dependent_label = str_replace("<~!~>", "", str_replace("<!>", "", $option[option_dependent_label]));

        if($option[option_dependency] == "1") {
          $database->database_query("INSERT INTO se_classifiedfields (classifiedfield_classifiedcat_id, classifiedfield_title, classifiedfield_desc, classifiedfield_order, classifiedfield_type, classifiedfield_style, classifiedfield_dependency, classifiedfield_maxlength, classifiedfield_link, classifiedfield_options, classifiedfield_required, classifiedfield_regex) VALUES ('$field_cat_id', '$option_dependent_label', '', '$num_dependent_fields', '1', '', '$new_field_id', '100', '', '', '0', '')");
          $dep_field_id = $database->database_insert_id();
          $column_name = "classifiedvalue_".$dep_field_id;
          $database->database_query("ALTER TABLE se_classifiedvalues ADD $column_name varchar(250) NOT NULL");
          $num_dependent_fields++;
        }
        $field_options .= "$option[option_id]<!>$option_label<!>$option[option_dependency]<!>$dep_field_id<~!~>";
      }

      // INSERT OPTIONS
      $database->database_query("UPDATE se_classifiedfields SET classifiedfield_options='$field_options' WHERE classifiedfield_id='$new_field_id'");


    }

  }


  // SEND AJAX CONFIRMATION
  echo "<html><head><script type=\"text/javascript\">";
  echo "window.parent.savefield_result('$is_error', '$error_message', '$field_id', '$new_field_id', '$field_title', '$field_cat_id', '$field_options');";
  echo "</script></head><body></body></html>";
  exit();






// SAVE CHANGES
} elseif($task == "dosave") {
  $setting_permission_classified = $_POST['setting_permission_classified'];
  $setting_email_classifiedinvite_subject = $_POST['setting_email_classifiedinvite_subject'];
  $setting_email_classifiedinvite_message = $_POST['setting_email_classifiedinvite_message'];
  $setting_email_classifiedcomment_subject = $_POST['setting_email_classifiedcomment_subject'];
  $setting_email_classifiedcomment_message = $_POST['setting_email_classifiedcomment_message'];
  $setting_email_classifiedmediacomment_subject = $_POST['setting_email_classifiedmediacomment_subject'];
  $setting_email_classifiedmediacomment_message = $_POST['setting_email_classifiedmediacomment_message'];
  $setting_email_classifiedmemberrequest_subject = $_POST['setting_email_classifiedmemberrequest_subject'];
  $setting_email_classifiedmemberrequest_message = $_POST['setting_email_classifiedmemberrequest_message'];

  // SAVE CHANGES
  $database->database_query("UPDATE se_settings SET 
			setting_permission_classified='$setting_permission_classified',
			setting_email_classifiedcomment_subject='$setting_email_classifiedcomment_subject',
			setting_email_classifiedcomment_message='$setting_email_classifiedcomment_message'");

  $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_settings LIMIT 1"));
  $result = 1;
}






// GET CLASSIFIED CATEGORIES
$categories_array = Array();
$categories_query = $database->database_query("SELECT * FROM se_classifiedcats WHERE classifiedcat_dependency='0' ORDER BY classifiedcat_id");
while($category = $database->database_fetch_assoc($categories_query)) {


  // GET DEPENDENT CLASSIFIED CATS
  $subcat_query = $database->database_query("SELECT * FROM se_classifiedcats WHERE classifiedcat_dependency='$category[classifiedcat_id]' ORDER BY classifiedcat_id");
  $subcat_array = Array();
  while($subcategory = $database->database_fetch_assoc($subcat_query)) {
    $subcat_array[] = Array('subcat_id' => $subcategory[classifiedcat_id],
				'subcat_title' => $subcategory[classifiedcat_title]);
  }

  // GET CLASSIFIED FIELDS
  $field_query = $database->database_query("SELECT * FROM se_classifiedfields WHERE classifiedfield_classifiedcat_id='$category[classifiedcat_id]' AND classifiedfield_dependency='0' ORDER BY classifiedfield_order");
  $field_array = Array();
  while($field = $database->database_fetch_assoc($field_query)) {

    // GET FIELD OPTIONS INTO ARRAY
    $options = explode("<~!~>", $field[classifiedfield_options]);
    $field_options = Array();
    foreach($options as $key=>$value) {
      $options[$key]=explode("<!>", $value);
      if($options[$key][2] != 0 & $options[$key][3] != "") {
        $field_options[$options[$key][3]] = $options[$key][1];
      }
    }

    $dep_field_query = $database->database_query("SELECT classifiedfield_id, classifiedfield_title FROM se_classifiedfields WHERE classifiedfield_dependency='$field[classifiedfield_id]' ORDER BY classifiedfield_order");
    $dep_field_array = Array();
    while($dep_field = $database->database_fetch_assoc($dep_field_query)) {
      $dep_field_array[] = Array('field_id' => $dep_field[classifiedfield_id],
				'field_title' => $dep_field[classifiedfield_title],
				'option_label' => $field_options[$dep_field[classifiedfield_id]]);
    }

    $field_array[] = Array('field_id' => $field[classifiedfield_id],
			'field_title' => $field[classifiedfield_title],
			'dep_fields' => $dep_field_array);
  }

  $categories_array[] = Array('cat_id' => $category[classifiedcat_id],
				'cat_title' => $category[classifiedcat_title],
				'subcats' => $subcat_array,
				'fields' => $field_array);
}







// ASSIGN VARIABLES AND SHOW GENERAL SETTINGS PAGE
$smarty->assign('result', $result);
$smarty->assign('cats', $categories_array);
$smarty->assign('permission_classified', $setting[setting_permission_classified]);
$smarty->assign('setting_email_classifiedinvite_subject', $setting[setting_email_classifiedinvite_subject]);
$smarty->assign('setting_email_classifiedinvite_message', $setting[setting_email_classifiedinvite_message]);
$smarty->assign('setting_email_classifiedcomment_subject', $setting[setting_email_classifiedcomment_subject]);
$smarty->assign('setting_email_classifiedcomment_message', $setting[setting_email_classifiedcomment_message]);
$smarty->assign('setting_email_classifiedmediacomment_subject', $setting[setting_email_classifiedmediacomment_subject]);
$smarty->assign('setting_email_classifiedmediacomment_message', $setting[setting_email_classifiedmediacomment_message]);
$smarty->assign('setting_email_classifiedmemberrequest_subject', $setting[setting_email_classifiedmemberrequest_subject]);
$smarty->assign('setting_email_classifiedmemberrequest_message', $setting[setting_email_classifiedmemberrequest_message]);
$smarty->display("$page.tpl");
exit();
?>