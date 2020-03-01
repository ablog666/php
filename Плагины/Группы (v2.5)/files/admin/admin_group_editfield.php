<?
$page = "admin_group_editfield";
include "admin_header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['groupfield_id'])) { $groupfield_id = $_POST['groupfield_id']; } elseif(isset($_GET['groupfield_id'])) { $groupfield_id = $_GET['groupfield_id']; } else { $groupfield_id = 0; }

// VALIDATE FIELD ID AND GET FIELD INFO
$field = $database->database_query("SELECT * FROM se_groupfields WHERE groupfield_id='$groupfield_id'");
if($database->database_num_rows($field) != 1) {
  header("Location: admin_group.php");
  exit();
}
$field_info = $database->database_fetch_assoc($field);


// INITIALIZE ERROR VARS
$is_error = 0;
$error_message = "";



// CANCEL EDIT FIELD
if($task == "cancel") {
  header("Location: admin_group.php");
  exit();




// CONFIRM FIELD DELETION
} elseif($task == "confirmdeletefield") {

  // SET HIDDEN INPUT ARRAYS FOR TWO TASKS
  $confirm_hidden = Array(Array('name' => 'task', 'value' => 'deletefield'),
			  Array('name' => 'groupfield_id', 'value' => $field_info[groupfield_id]));
  $cancel_hidden = Array(Array('name' => 'task', 'value' => 'main'),
			  Array('name' => 'groupfield_id', 'value' => $field_info[groupfield_id]));

  // LOAD CONFIRM PAGE WITH APPROPRIATE VARIABLES
  $smarty->assign('confirm_form_action', 'admin_group_editfield.php');
  $smarty->assign('cancel_form_action', 'admin_group_editfield.php');
  $smarty->assign('confirm_hidden', $confirm_hidden);
  $smarty->assign('cancel_hidden', $cancel_hidden);
  $smarty->assign('headline', $admin_group_editfield[35]);
  $smarty->assign('instructions', $admin_group_editfield[36]);
  $smarty->assign('confirm_submit', $admin_group_editfield[34]);
  $smarty->assign('cancel_submit', $admin_group_editfield[24]);
  $smarty->display("admin_confirm.tpl");
  exit();  





// DELETE FIELD
} elseif($task == "deletefield") {
  
  // DELETE ALL FIELD COLUMNS
  $fields = $database->database_query("SELECT groupfield_id FROM se_groupfields WHERE groupfield_id='$field_info[groupfield_id]' OR groupfield_dependency='$field_info[groupfield_id]'");
  while($field = $database->database_fetch_assoc($fields)) {
    $column = "groupvalue_".$field[groupfield_id];
    $database->database_query("ALTER TABLE se_groupvalues DROP COLUMN $column");
  }

  // DELETE ALL FIELDS
  $database->database_query("DELETE FROM se_groupfields WHERE groupfield_id='$field_info[groupfield_id]' OR groupfield_dependency='$field_info[groupfield_id]'");

  // RETURN TO ADMIN GROUP SETTINGS
  header("Location: admin_group.php");
  exit();








// TRY TO EDIT FIELD
} elseif($task == "editfield") {

  // GET ALL POSTED VARS AND RESET OTHER VARS
  $field_title = $_POST['field_title'];
  $field_type = $_POST['field_type'];
  $field_style = $_POST['field_style'];
  $field_desc = $_POST['field_desc'];
  $field_error = $_POST['field_error'];
  $field_required = $_POST['field_required'];
  $field_maxlength = $_POST['field_maxlength'];
  $field_regex = $_POST['field_regex'];
  $box1_display = "none";
  $box3_display = "none";
  $box4_display = "none";
  $num_select_options = 1;
  $select_options = Array('0' => Array('select_id' => 0,
			 		'select_label' => '',
					'select_dependency' => '0',
					'select_dependent_field_id' => '',
					'select_dependent_label' => ''));
  $num_radio_options = 1;
  $radio_options = Array('0' => Array('radio_id' => 0,
					'radio_label' => '',
					'radio_dependency' => '0',
					'radio_dependent_field_id' => '',
					'radio_dependent_label' => ''));


  // FIELD TYPE IS TEXT FIELD
  if($field_type == "1") {
    $box1_display = "block";
    $column_type = "varchar(250)";


  // FIELD TYPE IS TEXTAREA
  } elseif($field_type == "2") {
    $column_type = "text";


  // FIELD TYPE IS SELECT BOX
  } elseif($field_type == "3") {
    $box3_display = "block";
    $column_type = "int(2)";
    $select_options = Array();
    $old_num_select_options = $_POST['num_select_options'];
    $num_select_options = 0;
    // PULL OPTIONS INTO NEW ARRAY
    for($i=0;$i<$old_num_select_options;$i++) {
      $var_label = "select_label$i";
      $var_dependency = "select_dependency$i";
      $var_dependent_label = "select_dependent_label$i";
      $var_dependent_field_id = "select_dependent_field_id$i";
      
      $select_label = $_POST[$var_label];
      $select_dependency = $_POST[$var_dependency];
      $select_dependent_label = $_POST[$var_dependent_label];
      $select_dependent_field_id = $_POST[$var_dependent_field_id];
      
      
      if(str_replace(" ", "", $select_label) != "") {
        $select_options[$num_select_options] = Array('select_id' => $num_select_options,
			 			     'select_label' => $select_label,
						     'select_dependency' => $select_dependency,
						     'select_dependent_field_id' => $select_dependent_field_id,
						     'select_dependent_label' => $select_dependent_label);

        $options[$num_select_options] = Array('option_id' => $num_select_options,
			 		      'option_label' => $select_label,
					      'option_dependency' => $select_dependency,
					      'option_dependent_field_id' => $select_dependent_field_id,
					      'option_dependent_label' => $select_dependent_label);

        $num_select_options++;

      }
    }


    // IF NO OPTIONS HAVE BEEN SPECIFIED
    if($num_select_options == 0) {
      $num_select_options = 1;
      $select_options = Array('0' => Array('select_id' => 0,
			 		   'select_label' => '',
					   'select_dependency' => '0',
					   'select_dependent_field_id' => '',
					   'select_dependent_label' => ''));
      $is_error = 1;
      $error_message = $admin_group_editfield[18];
    }



  // FIELD TYPE IS RADIO BUTTON
  } elseif($field_type == "4") {
    $box4_display = "block";
    $column_type = "int(2)";
    $radio_options = Array();
    $old_num_radio_options = $_POST['num_radio_options'];
    $num_radio_options = 0;
    // PULL OPTIONS INTO NEW ARRAY
    for($i=0;$i<$old_num_radio_options;$i++) {
      $var_label = "radio_label$i";
      $var_dependency = "radio_dependency$i";
      $var_dependent_label = "radio_dependent_label$i";
      $var_dependent_field_id = "radio_dependent_field_id$i";
      
      $radio_label = $_POST[$var_label];
      $radio_dependency = $_POST[$var_dependency];
      $radio_dependent_label = $_POST[$var_dependent_label];
      $radio_dependent_field_id = $_POST[$var_dependent_field_id];
      
      
      if(str_replace(" ", "", $radio_label) != "") {
        $radio_options[$num_radio_options] = Array('radio_id' => $num_radio_options,
			 			     'radio_label' => $radio_label,
						     'radio_dependency' => $radio_dependency,
						     'radio_dependent_field_id' => $radio_dependent_field_id,
						     'radio_dependent_label' => $radio_dependent_label);

        $options[$num_radio_options] = Array('option_id' => $num_radio_options,
			 		     'option_label' => $radio_label,
					     'option_dependency' => $radio_dependency,
					     'option_dependent_field_id' => $radio_dependent_field_id,
					     'option_dependent_label' => $radio_dependent_label);

        $num_radio_options++;

      }
    }

    // IF NO OPTIONS HAVE BEEN SPECIFIED
    if($num_radio_options == 0) {
      $num_radio_options = 1;
      $radio_options = Array('0' => Array('radio_id' => 0,
					  'radio_label' => '',
					  'radio_dependency' => '0',
					  'radio_dependent_field_id' => '',
					  'radio_dependent_label' => '')); 
      $is_error = 1;
      $error_message = $admin_group_editfield[18];
    }


  // FIELD TYPE IS DATE FIELD
  } elseif($field_type == "5") {
    $column_type = "int(14)";


  // FIELD TYPE NOT SPECIFIED
  } else {
    $is_error = 1;
    $error_message = $admin_group_editfield[26];
  }


  // FIELD TITLE IS EMPTY
  if(str_replace(" ", "", $field_title) == "") {
    $is_error = 1;
    $error_message = $admin_group_editfield[28];
  }


  // EDIT FIELD IF NO ERROR
  if($is_error == 0) {
    $database->database_query("UPDATE se_groupfields SET groupfield_title='$field_title', groupfield_desc='$field_desc', groupfield_error='$field_error', groupfield_type='$field_type', groupfield_style='$field_style', groupfield_maxlength='$field_maxlength', groupfield_required='$field_required', groupfield_regex='$field_regex' WHERE groupfield_id='$field_info[groupfield_id]'");
    $column_name = "groupvalue_".$field_info[groupfield_id];
    $database->database_query("ALTER TABLE se_groupvalues MODIFY $column_name $column_type NOT NULL");

    // EDIT DEPENDENT FIELDS
    $field_options = "";
    for($d=0;$d<count($options);$d++) {

      $option = $options[$d];
      $option_label = str_replace("<~!~>", "", str_replace("<!>", "", $option[option_label]));
      $option_dependent_label = str_replace("<~!~>", "", str_replace("<!>", "", $option[option_dependent_label]));
      $dep_field = $database->database_query("SELECT groupfield_id, groupfield_title FROM se_groupfields WHERE groupfield_id='$option[option_dependent_field_id]'");
      $dep_field_info_id = "";

      if($database->database_num_rows($dep_field) == "1") {
        $dep_field_info = $database->database_fetch_assoc($dep_field);
        if($option[option_dependency] == "1") {
          // MODIFY EXISTING DEPENDENT FIELD
          $dep_field_info_id = $dep_field_info[groupfield_id];
          $database->database_query("UPDATE se_groupfields SET groupfield_title='$option_dependent_label' WHERE groupfield_id='$dep_field_info[groupfield_id]'");
        } else {
          // DELETE DEPENDENT FIELD IF DEPENDENCY IS NO LONGER REQUIRED
          $database->database_query("DELETE FROM se_groupfields WHERE groupfield_id='$dep_field_info[groupfield_id]'");
          $column_name = "groupvalue_".$dep_field_info[groupfield_id];
          $database->database_query("ALTER TABLE se_groupvalues DROP COLUMN $column_name");
        }
      } else {
        if($option[option_dependency] == "1") {
          // ADD NEW DEPENDENT FIELD
          $dep_field_order = $database->database_num_rows($database->database_query("SELECT groupfield_id FROM se_groupfields WHERE groupfield_dependency='$field_info[groupfield_id]'"))+1;
          $database->database_query("INSERT INTO se_groupfields (groupfield_title, groupfield_desc, groupfield_order, groupfield_type, groupfield_style, groupfield_dependency, groupfield_maxlength, groupfield_options, groupfield_required, groupfield_regex) VALUES ('$option_dependent_label', '', '$dep_field_order', '1', '', '$field_info[groupfield_id]', '100', '', '0', '')");
          $dep_field_info = $database->database_fetch_assoc($database->database_query("SELECT groupfield_id FROM se_groupfields WHERE groupfield_title='$option_dependent_label' AND groupfield_desc='' AND groupfield_order='$dep_field_order' AND groupfield_type='1' AND groupfield_style='' AND groupfield_dependency='$field_info[groupfield_id]' AND groupfield_maxlength='100' AND groupfield_options='' AND groupfield_required='0' AND groupfield_regex='' ORDER BY groupfield_id DESC LIMIT 1"));
          $column_name = "groupvalue_".$dep_field_info[groupfield_id];
          $database->database_query("ALTER TABLE se_groupvalues ADD $column_name varchar(250) NOT NULL");
          $dep_field_info_id = $dep_field_info[groupfield_id];
        }
      }


      $field_options .= "$option[option_id]<!>$option_label<!>$option[option_dependency]<!>$dep_field_info_id<~!~>";
    }

    // INSERT OPTIONS
    $database->database_query("UPDATE se_groupfields SET groupfield_options='$field_options' WHERE groupfield_id='$field_info[groupfield_id]'");

    header("Location: admin_group.php");
    exit();
  }






// EDIT FIELD FORM
} else {
  $field_title = $field_info[groupfield_title];
  $field_type = $field_info[groupfield_type];
  $field_style = $field_info[groupfield_style];
  $field_desc = $field_info[groupfield_desc];
  $field_error = $field_info[groupfield_error];
  $field_maxlength = $field_info[groupfield_maxlength];
  $field_regex = $field_info[groupfield_regex];
  $field_required = $field_info[groupfield_required];
  $field_options = $field_info[groupfield_options];

  $num_select_options = 1;
  $select_options = Array('0' => Array('select_id' => 0,
			 		'select_label' => '',
					'select_dependency' => '0',
					'select_dependent_label' => ''));
  $num_radio_options = 1;
  $radio_options = Array('0' => Array('radio_id' => 0,
					'radio_label' => '',
					'radio_dependency' => '0',
					'radio_dependent_label' => ''));

  $box1_display = "none";
  $box3_display = "none";
  $box4_display = "none";
  if($field_type == "1") {
    $box1_display = "block";
  } elseif($field_type == "3") {
    $box3_display = "block";
    // PULL OPTIONS INTO NEW ARRAY    
    $field_options = explode("<~!~>", $field_options);
    $num_select_options = 0;
    for($i=0;$i<count($field_options);$i++) {
      if(str_replace(" ", "", $field_options[$i]) != "") {
        $options = explode("<!>", $field_options[$i]);
        $select_id = $options[0];
        $select_label = $options[1];
        $select_dependency = $options[2];
        $select_dependent_field_id = $options[3];
        $select_dependent_label = "";
        if($select_dependency == "1") { 
          $dep_field = $database->database_query("SELECT groupfield_id, groupfield_title FROM se_groupfields WHERE groupfield_id='$select_dependent_field_id'");
          if($database->database_num_rows($dep_field) != "1") {
            $select_dependency = "0";
          } else {
            $select_dependency = "1";
            $dep_field_info = $database->database_fetch_assoc($dep_field);
            $select_dependent_label = $dep_field_info[groupfield_title];
          }
        } else { 
          $select_dependency_0 = " SELECTED"; 
        }
        $select_options[$num_select_options] = Array('select_id' => $select_id,
			 			     'select_label' => $select_label,
						     'select_dependency' => $select_dependency,
						     'select_dependent_field_id' => $select_dependent_field_id,
						     'select_dependent_label' => $select_dependent_label);
        $num_select_options++;
      }
    }

    // IF NO OPTIONS HAVE BEEN SPECIFIED
    if($num_select_options == 0) {
      $num_select_options = 1;
      $select_options = Array('0' => Array('select_id' => 0,
			 		   'select_label' => '',
					   'select_dependency' => '0',
					   'select_dependent_field_id' => '',
					   'select_dependent_label' => ''));
    }

  } elseif($field_type == "4") {
    $box4_display = "block";
    // PULL OPTIONS INTO NEW ARRAY    
    $field_options = explode("<~!~>", $field_options);
    $num_radio_options = 0;
    for($i=0;$i<count($field_options);$i++) {
      if(str_replace(" ", "", $field_options[$i]) != "") {
        $options = explode("<!>", $field_options[$i]);
        $radio_id = $options[0];
        $radio_label = $options[1];
        $radio_dependency = $options[2];
        $radio_dependent_field_id = $options[3];
        $radio_dependent_label = "";
        if($radio_dependency == "1") { 
          $dep_field = $database->database_query("SELECT groupfield_id, groupfield_title FROM se_groupfields WHERE groupfield_id='$radio_dependent_field_id'");
          if($database->database_num_rows($dep_field) != "1") {
            $radio_dependency = "0";
          } else {
            $radio_dependency = "1";
            $dep_field_info = $database->database_fetch_assoc($dep_field);
            $radio_dependent_label = $dep_field_info[groupfield_title];
          }
        } else { 
          $radio_dependency_0 = " SELECTED"; 
        }
        $radio_options[$num_radio_options] = Array('radio_id' => $radio_id,
			 			     'radio_label' => $radio_label,
						     'radio_dependency' => $radio_dependency,
						     'radio_dependent_field_id' => $radio_dependent_field_id,
						     'radio_dependent_label' => $radio_dependent_label);
        $num_radio_options++;
      }
    }

    // IF NO OPTIONS HAVE BEEN SPECIFIED
    if($num_radio_options == 0) {
      $num_radio_options = 1;
      $radio_options = Array('0' => Array('radio_id' => 0,
			 		  'radio_label' => '',
					  'radio_dependency' => '0',
					  'radio_dependent_field_id' => '',
					  'radio_dependent_label' => ''));
    }
  }
  

}



// ASSIGN VARIABLES AND SHOW ADD FIELD PAGE
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('field_id', $field_info[groupfield_id]);
$smarty->assign('field_title', $field_title);
$smarty->assign('field_type', $field_type);
$smarty->assign('field_style', $field_style);
$smarty->assign('field_desc', $field_desc);
$smarty->assign('field_error', $field_error);
$smarty->assign('field_regex', $field_regex);
$smarty->assign('field_maxlength', $field_maxlength);
$smarty->assign('num_select_options', $num_select_options);
$smarty->assign('select_options', $select_options);
$smarty->assign('num_radio_options', $num_radio_options);
$smarty->assign('radio_options', $radio_options);
$smarty->assign('box1_display', $box1_display);
$smarty->assign('box3_display', $box3_display);
$smarty->assign('box4_display', $box4_display);
$smarty->assign('field_required', $field_required);
$smarty->display("$page.tpl");
exit();
?>