<?
$page = "admin_group";
include "admin_header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }


// SET RESULT VARIABLE
$result = 0;


// CHANGE GROUP ORDER
if($task == "order") {
  if(isset($_GET['groupfield_id'])) { $groupfield_id = $_GET['groupfield_id']; } else { $groupfield_id = 0; }

  // VALIDATE GROUP FIELD ID
  $group = $database->database_query("SELECT groupfield_id, groupfield_order FROM se_groupfields WHERE groupfield_id='$groupfield_id'");
  if($database->database_num_rows($group) != 1) { exit(); }
  $group_down_info = $database->database_fetch_assoc($group);

  // MAKE SURE GROUP FIELD IS NOT LAST
  $max = $database->database_fetch_assoc($database->database_query("SELECT max(groupfield_order) as groupfield_order FROM se_groupfields"));
  if($group_down_info[groupfield_order] == $max[groupfield_order]) { exit(); }

  // SELECT GROUP FIELD TO BE MOVED UP
  $new = $database->database_fetch_assoc($database->database_query("SELECT groupfield_order FROM se_groupfields WHERE groupfield_order > '$group_down_info[groupfield_order]' ORDER BY groupfield_order LIMIT 1"));
  $group_up_info = $database->database_fetch_assoc($database->database_query("SELECT groupfield_id, groupfield_order FROM se_groupfields WHERE groupfield_order='$new[groupfield_order]' LIMIT 1"));


  // SWAP GROUP FIELD ORDERS
  $database->database_query("UPDATE se_groupfields SET groupfield_order='$group_down_info[groupfield_order]' WHERE groupfield_id='$group_up_info[groupfield_id]'");
  $database->database_query("UPDATE se_groupfields SET groupfield_order='$group_up_info[groupfield_order]' WHERE groupfield_id='$group_down_info[groupfield_id]'");

  echo "<html><head><script type=\"text/javascript\">";
  echo "window.parent.ChangeOrder($group_down_info[groupfield_id], $group_up_info[groupfield_id]);";
  echo "</script></head><body></body></html>";
  exit();


// SAVE CHANGES
} elseif($task == "dosave") {
  $setting_permission_group = $_POST['setting_permission_group'];
  $discussion_code = $_POST['discussion_code'];
  $setting_email_groupinvite_subject = $_POST['setting_email_groupinvite_subject'];
  $setting_email_groupinvite_message = $_POST['setting_email_groupinvite_message'];
  $setting_email_groupcomment_subject = $_POST['setting_email_groupcomment_subject'];
  $setting_email_groupcomment_message = $_POST['setting_email_groupcomment_message'];
  $setting_email_groupmediacomment_subject = $_POST['setting_email_groupmediacomment_subject'];
  $setting_email_groupmediacomment_message = $_POST['setting_email_groupmediacomment_message'];
  $setting_email_groupmemberrequest_subject = $_POST['setting_email_groupmemberrequest_subject'];
  $setting_email_groupmemberrequest_message = $_POST['setting_email_groupmemberrequest_message'];

    // SAVE GROUP CATEGORIES
    $max_groupcat_id = 0;
    $old_groupcats = $database->database_query("SELECT groupcat_id FROM se_groupcats WHERE groupcat_dependency='0' ORDER BY groupcat_id");
    while($old_groupcat_info = $database->database_fetch_assoc($old_groupcats)) {
      $var = "groupcat_title".$old_groupcat_info[groupcat_id];
      $groupcat_title = $_POST[$var];
      if(str_replace(" ", "", $groupcat_title) == "") {
        $database->database_query("DELETE FROM se_groupcats WHERE groupcat_id='$old_groupcat_info[groupcat_id]' OR groupcat_dependency='$old_groupcat_info[groupcat_id]'");
	$database->database_query("UPDATE se_groups SET group_groupcat_id='0' WHERE group_groupcat_id='$old_groupcat_info[groupcat_id]'");
      } else {
        $database->database_query("UPDATE se_groupcats SET groupcat_title='$groupcat_title' WHERE groupcat_id='$old_groupcat_info[groupcat_id]'");

          // SAVE DEP GROUP CATEGORIES
          $max_dep_groupcat_id = 0;
          $old_dep_groupcats = $database->database_query("SELECT groupcat_id FROM se_groupcats WHERE groupcat_dependency='$old_groupcat_info[groupcat_id]' ORDER BY groupcat_id");
          while($old_dep_groupcat_info = $database->database_fetch_assoc($old_dep_groupcats)) {
            $var = "groupcat_title".$old_groupcat_info[groupcat_id]."_".$old_dep_groupcat_info[groupcat_id];
            $dep_groupcat_title = $_POST[$var];
            if(str_replace(" ", "", $dep_groupcat_title) == "") {
              $database->database_query("DELETE FROM se_groupcats WHERE groupcat_id='$old_dep_groupcat_info[groupcat_id]'");
	      $database->database_query("UPDATE se_groups SET group_groupcat_id='0' WHERE group_groupcat_id='$old_dep_groupcat_info[groupcat_id]'");
            } else {
              $database->database_query("UPDATE se_groupcats SET groupcat_title='$dep_groupcat_title' WHERE groupcat_id='$old_dep_groupcat_info[groupcat_id]'");
            }  
            $max_dep_groupcat_id = $old_dep_groupcat_info[groupcat_id];
          }

          $var = "num_subcat_".$old_groupcat_info[groupcat_id];
          $num_dep_groupcats = $_POST[$var];
          $dep_groupcat_count = 0;
          for($t=$max_dep_groupcat_id+1;$t<$num_dep_groupcats;$t++) {
            $var = "groupcat_title".$old_groupcat_info[groupcat_id]."_$t";
            $dep_groupcat_title = $_POST[$var];
            if(str_replace(" ", "", $dep_groupcat_title) != "") {
              $database->database_query("INSERT INTO se_groupcats (groupcat_title, groupcat_dependency) VALUES ('$dep_groupcat_title', '$old_groupcat_info[groupcat_id]')");
            }
          }
      }  
      $max_groupcat_id = $old_groupcat_info[groupcat_id];
    }

    $num_groupcats = $_POST['num_groupcategories'];
    $groupcat_count = 0;
    for($t=$max_groupcat_id+1;$t<=$num_groupcats;$t++) {
      $var = "groupcat_title$t";
      $groupcat_title = $_POST[$var];
      if(str_replace(" ", "", $groupcat_title) != "") {
        $database->database_query("INSERT INTO se_groupcats (groupcat_title) VALUES ('$groupcat_title')");
        $old_groupcat_info = $database->database_fetch_assoc($database->database_query("SELECT groupcat_id FROM se_groupcats WHERE groupcat_title='$groupcat_title' ORDER BY groupcat_id DESC LIMIT 1"));

          // SAVE DEP GROUP CATEGORIES
          $var = "num_subcat_".$t;
          $num_dep_groupcats = $_POST[$var];
          $dep_groupcat_count = 0;
          for($d=0;$d<$num_dep_groupcats;$d++) {
            $var = "groupcat_title".$t."_$d";
            $dep_groupcat_title = $_POST[$var];
            if(str_replace(" ", "", $dep_groupcat_title) != "") {
              $database->database_query("INSERT INTO se_groupcats (groupcat_title, groupcat_dependency) VALUES ('$dep_groupcat_title', '$old_groupcat_info[groupcat_id]')");
            }
          }
      }
    }

  // SAVE CHANGES
  $database->database_query("UPDATE se_settings SET 
			setting_permission_group='$setting_permission_group',
			setting_group_discussion_code = '$discussion_code',
			setting_email_groupinvite_subject='$setting_email_groupinvite_subject',
			setting_email_groupinvite_message='$setting_email_groupinvite_message',
			setting_email_groupcomment_subject='$setting_email_groupcomment_subject',
			setting_email_groupcomment_message='$setting_email_groupcomment_message',
			setting_email_groupmediacomment_subject='$setting_email_groupmediacomment_subject',
			setting_email_groupmediacomment_message='$setting_email_groupmediacomment_message',
			setting_email_groupmemberrequest_subject='$setting_email_groupmemberrequest_subject',
			setting_email_groupmemberrequest_message='$setting_email_groupmemberrequest_message'");

  $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_settings LIMIT 1"));
  $result = 1;
}





// SET FIELD ARRAY VAR
$field_array = Array();
$fields = $database->database_query("SELECT groupfield_id, groupfield_title FROM se_groupfields WHERE groupfield_dependency='0' ORDER BY groupfield_order");
$num_fields = $database->database_num_rows($fields);
$field_count = 0;
$prev_groupfield_id = 0;
    
// LOOP OVER NON DEPENDENT FIELDS
while($field_info = $database->database_fetch_assoc($fields)) {

  // SET DEPENDENT FIELD ARRAY VAR
  $dep_field_array = Array();

  // GET DEPENDENT FIELDS FOR ORIGINAL FIELD
  $dep_fields = $database->database_query("SELECT groupfield_id, groupfield_title FROM se_groupfields WHERE groupfield_dependency='$field_info[groupfield_id]' ORDER BY groupfield_order");
  $num_dep_fields = $database->database_num_rows($dep_fields);
  $dep_field_count = 0;
    
  // LOOP OVER DEPENDENT FIELDS
  while($dep_field_info = $database->database_fetch_assoc($dep_fields)) {

    // SET DEPENDENT TITLE IF NOTHING
    if(str_replace(" ", "", $dep_field_info[groupfield_title]) == "") {
      $dep_field_title = 'Untitled';
    } else {
      $dep_field_title = $dep_field_info[groupfield_title];
    }

    // SET DEPENDENT FIELD ARRAY AND INCREMENT DEPENDENT FIELD COUNT
    $dep_field_array[$dep_field_count] = Array('dep_groupfield_id' => $dep_field_info[groupfield_id], 
					       'dep_groupfield_title' => $dep_field_title, 
					       'dep_groupfield_order' => $dep_field_order);
    $dep_field_count++;
  } 
    

  // SET FIELD ARRAY AND INCREMENT FIELD COUNT
  $field_array[$field_count] = Array('groupfield_id' => $field_info[groupfield_id], 
				     'groupfield_title' => $field_info[groupfield_title], 
				     'groupfield_order' => $field_order,
				     'dep_groupfields' => $dep_field_array,
				     'prev_groupfield_id' => $prev_groupfield_id);
  $field_count++;
  $prev_groupfield_id = $field_info[groupfield_id];
} 



// GET GROUP CATEGORIES
$categories_array = Array();
$categories_query = $database->database_query("SELECT * FROM se_groupcats WHERE groupcat_dependency='0' ORDER BY groupcat_id");
while($category = $database->database_fetch_assoc($categories_query)) {
  // GET DEPENDENT GROUP CATS
  $dep_categories_query = $database->database_query("SELECT * FROM se_groupcats WHERE groupcat_dependency='$category[groupcat_id]' ORDER BY groupcat_id");
  $dep_groupcat_array = Array();
  while($dep_category = $database->database_fetch_assoc($dep_categories_query)) {
    $dep_groupcat_array[] = Array('dep_groupcat_id' => $dep_category[groupcat_id],
					'dep_groupcat_title' => $dep_category[groupcat_title]);
  }

  $max_dep_groupcat_id = $database->database_fetch_assoc($database->database_query("SELECT max(groupcat_id) AS max_groupcat_id FROM se_groupcats WHERE groupcat_dependency='$category[groupcat_id]'"));
  $num_dep_cats = $max_dep_groupcat_id[max_groupcat_id]+1;

  $categories_array[] = Array('groupcat_id' => $category[groupcat_id],
				'groupcat_title' => $category[groupcat_title],
				'dep_groupcats' => $dep_groupcat_array,
				'groupcat_num_deps' => $num_dep_cats);
}
$max_groupcat_id = $database->database_fetch_assoc($database->database_query("SELECT max(groupcat_id) AS max_groupcat_id FROM se_groupcats"));
$num_cats = $max_groupcat_id[max_groupcat_id];







// ASSIGN VARIABLES AND SHOW GENERAL SETTINGS PAGE
$smarty->assign('result', $result);
$smarty->assign('fields', $field_array);
$smarty->assign('total_groupfields', $field_count);
$smarty->assign('num_cats', $num_cats);
$smarty->assign('categories', $categories_array);
$smarty->assign('permission_group', $setting[setting_permission_group]);
$smarty->assign('setting_group_discussion_code', $setting[setting_group_discussion_code]);
$smarty->assign('setting_email_groupinvite_subject', $setting[setting_email_groupinvite_subject]);
$smarty->assign('setting_email_groupinvite_message', $setting[setting_email_groupinvite_message]);
$smarty->assign('setting_email_groupcomment_subject', $setting[setting_email_groupcomment_subject]);
$smarty->assign('setting_email_groupcomment_message', $setting[setting_email_groupcomment_message]);
$smarty->assign('setting_email_groupmediacomment_subject', $setting[setting_email_groupmediacomment_subject]);
$smarty->assign('setting_email_groupmediacomment_message', $setting[setting_email_groupmediacomment_message]);
$smarty->assign('setting_email_groupmemberrequest_subject', $setting[setting_email_groupmemberrequest_subject]);
$smarty->assign('setting_email_groupmemberrequest_message', $setting[setting_email_groupmemberrequest_message]);
$smarty->display("$page.tpl");
exit();
?>