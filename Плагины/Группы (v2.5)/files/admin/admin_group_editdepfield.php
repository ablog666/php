<?
$page = "admin_group_editdepfield";
include "admin_header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['groupfield_id'])) { $groupfield_id = $_POST['groupfield_id']; } elseif(isset($_GET['groupfield_id'])) { $groupfield_id = $_GET['groupfield_id']; } else { $groupfield_id = 0; }

// VALIDATE DEPENDENT FIELD ID AND GET DEPENDENT FIELD INFO
$dep_field = $database->database_query("SELECT * FROM se_groupfields WHERE groupfield_id='$groupfield_id' AND groupfield_dependency <> '0'");
if($database->database_num_rows($dep_field) != 1) {
  header("Location: admin_group.php");
  exit();
}
$dep_field_info = $database->database_fetch_assoc($dep_field);

// VALIDATE PARENT FIELD ID AND GET PARENT FIELD INFO
$field = $database->database_query("SELECT groupfield_id, groupfield_title FROM se_groupfields WHERE groupfield_id='$dep_field_info[groupfield_dependency]'");
if($database->database_num_rows($field) != 1) {
  header("Location: admin_group.php");
  exit();
}
$field_info = $database->database_fetch_assoc($field);




// CANCEL EDIT FIELD
if($task == "cancel") {
  header("Location: admin_group.php");
  exit();







} elseif($task == "editdepfield") {

  $field_title = $_POST['field_title'];
  $field_style = $_POST['field_style'];
  $field_required = $_POST['field_required'];
  $field_maxlength = $_POST['field_maxlength'];
  $field_regex = $_POST['field_regex'];

  $database->database_query("UPDATE se_groupfields SET groupfield_title='$field_title', groupfield_style='$field_style', groupfield_maxlength='$field_maxlength', groupfield_required='$field_required', groupfield_regex='$field_regex' WHERE groupfield_id='$dep_field_info[groupfield_id]'");
  header("Location: admin_group.php");
  exit();

} else {

  $field_parent_id = $field_info[groupfield_id];
  $field_parent_title = $field_info[groupfield_title];
  $field_title = $dep_field_info[groupfield_title];
  $field_style = $dep_field_info[groupfield_style];
  $field_required = $dep_field_info[groupfield_required];
  $field_maxlength = $dep_field_info[groupfield_maxlength];
  $field_regex = $dep_field_info[groupfield_regex];
  $dep_field_id = $dep_field_info[groupfield_id];

}







// ASSIGN VARIABLES AND SHOW EDIT DEPENDENT FIELD PAGE
$smarty->assign('field_parent_id', $field_parent_id);
$smarty->assign('field_parent_title', $field_parent_title);
$smarty->assign('field_id', $dep_field_id);
$smarty->assign('field_title', $field_title);
$smarty->assign('field_style', $field_style);
$smarty->assign('field_regex', $field_regex);
$smarty->assign('field_required', $field_required);
$smarty->assign('field_maxlength', $field_maxlength);
$smarty->display("$page.tpl");
exit();
?>