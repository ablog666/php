<?
$page = "admin_group_addfield";
include "admin_header.php";


if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }


// INITIALIZE ERROR VARS
$is_error = 0;
$error_message = "";


// CANCEL ADD FIELD
if($task == "cancel") {
  header("Location: admin_group.php");
  exit();


// TRY TO ADD FIELD
} elseif($task == "addfield") {

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
					'select_dependent_label' => ''));
  $num_radio_options = 1;
  $radio_options = Array('0' => Array('radio_id' => 0,
					'radio_label' => '',
					'radio_dependency' => '0',
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
      
      $select_label = $_POST[$var_label];
      $select_dependency = $_POST[$var_dependency];
      $select_dependent_label = $_POST[$var_dependent_label];

      
      
      if(str_replace(" ", "", $select_label) != "") {
        $select_options[$num_select_options] = Array('select_id' => $num_select_options,
			 			     'select_label' => $select_label,
						     'select_dependency' => $select_dependency,
						     'select_dependent_label' => $select_dependent_label);

        $options[$num_select_options] = Array('option_id' => $num_select_options,
			 		      'option_label' => $select_label,
					      'option_dependency' => $select_dependency,
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
					   'select_dependent_label' => ''));
      $is_error = 1;
      $error_message = $admin_group_addfield[18];
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
      
      $radio_label = $_POST[$var_label];
      $radio_dependency = $_POST[$var_dependency];
      $radio_dependent_label = $_POST[$var_dependent_label];

      
      
      if(str_replace(" ", "", $radio_label) != "") {
        $radio_options[$num_radio_options] = Array('radio_id' => $num_radio_options,
			 			     'radio_label' => $radio_label,
						     'radio_dependency' => $radio_dependency,
						     'radio_dependent_label' => $radio_dependent_label);

        $options[$num_radio_options] = Array('option_id' => $num_radio_options,
			 		     'option_label' => $radio_label,
					     'option_dependency' => $radio_dependency,
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
					  'radio_dependent_label' => '')); 
      $is_error = 1;
      $error_message = $admin_group_addfield[18];
    }


  // FIELD TYPE IS DATE FIELD
  } elseif($field_type == "5") {
    $column_type = "int(14)";


  // FIELD TYPE NOT SPECIFIED
  } else {
    $is_error = 1;
    $error_message = $admin_group_addfield[26];
  }


  // FIELD TITLE IS EMPTY
  if(str_replace(" ", "", $field_title) == "") {
    $is_error = 1;
    $error_message = $admin_group_addfield[28];
  }


  // ADD FIELD IF NO ERROR
  if($is_error == 0) {
    $field_order = $database->database_num_rows($database->database_query("SELECT groupfield_id FROM se_groupfields WHERE groupfield_dependency='0'"))+1;
    $database->database_query("INSERT INTO se_groupfields (groupfield_title, groupfield_desc, groupfield_error, groupfield_order, groupfield_type, groupfield_style, groupfield_dependency, groupfield_maxlength, groupfield_required, groupfield_regex) VALUES ('$field_title', '$field_desc', '$field_error', '$field_order', '$field_type', '$field_style', '0', '$field_maxlength', '$field_required', '$field_regex')");
    $field_info = $database->database_fetch_assoc($database->database_query("SELECT groupfield_id FROM se_groupfields WHERE groupfield_title='$field_title' AND groupfield_desc='$field_desc' AND groupfield_error='$field_error' AND groupfield_order='$field_order' AND groupfield_type='$field_type' AND groupfield_style='$field_style' AND groupfield_dependency='0' AND groupfield_maxlength='$field_maxlength' AND groupfield_required='$field_required' AND groupfield_regex='$field_regex' ORDER BY groupfield_id DESC LIMIT 1"));
    $column_name = "groupvalue_".$field_info[groupfield_id];
    $database->database_query("ALTER TABLE se_groupvalues ADD $column_name $column_type NOT NULL");

    // ADD DEPENDENT FIELDS
    $field_options = "";
    $num_dependent_fields = 1;
    for($d=0;$d<count($options);$d++) {
      $option = $options[$d];
      $option_label = str_replace("<~!~>", "", str_replace("<!>", "", $option[option_label]));
      $option_dependent_label = str_replace("<~!~>", "", str_replace("<!>", "", $option[option_dependent_label]));

      if($option[option_dependency] == "1") {
        $database->database_query("INSERT INTO se_groupfields (groupfield_title, groupfield_desc, groupfield_order, groupfield_type, groupfield_style, groupfield_dependency, groupfield_maxlength, groupfield_options, groupfield_required, groupfield_regex) VALUES ('$option_dependent_label', '', '$num_dependent_fields', '1', '', '$field_info[groupfield_id]', '100', '', '0', '')");
        $dep_field_info = $database->database_fetch_assoc($database->database_query("SELECT groupfield_id FROM se_groupfields WHERE groupfield_title='$option_dependent_label' AND groupfield_desc='' AND groupfield_order='$num_dependent_fields' AND groupfield_type='1' AND groupfield_style='' AND groupfield_dependency='$field_info[groupfield_id]' AND groupfield_maxlength='100' AND groupfield_options='' AND groupfield_regex='' AND groupfield_required='0' ORDER BY groupfield_id DESC LIMIT 1"));
        $column_name = "groupvalue_".$dep_field_info[groupfield_id];
        $database->database_query("ALTER TABLE se_groupvalues ADD $column_name varchar(250) NOT NULL");
        $num_dependent_fields++;
      }
      $field_options .= "$option[option_id]<!>$option_label<!>$option[option_dependency]<!>$dep_field_info[groupfield_id]<~!~>";
    }

    // INSERT OPTIONS
    $database->database_query("UPDATE se_groupfields SET groupfield_options='$field_options' WHERE groupfield_id='$field_info[groupfield_id]'");

    header("Location: admin_group.php");
    exit();
  }


// ADD FIELD FORM
} else {
  $field_title = "";
  $field_type = "";
  $field_style = "";
  $field_desc = "";
  $field_error = "";
  $field_regex = "";
  $field_maxlength = "";
  $field_required = 0;
  $box1_display = "none";
  $box3_display = "none";
  $box4_display = "none";
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

}



// ASSIGN VARIABLES AND SHOW ADD FIELD PAGE
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
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