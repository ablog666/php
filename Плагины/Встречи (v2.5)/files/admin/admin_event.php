<?
$page = "admin_event";
include "admin_header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }


// SET RESULT VARIABLE
$result = 0;


// SAVE CHANGES
if($task == "dosave") {
  $setting_permission_event = $_POST['setting_permission_event'];
  $setting_email_eventinvite_subject = $_POST['setting_email_eventinvite_subject'];
  $setting_email_eventinvite_message = $_POST['setting_email_eventinvite_message'];
  $setting_email_eventcomment_subject = $_POST['setting_email_eventcomment_subject'];
  $setting_email_eventcomment_message = $_POST['setting_email_eventcomment_message'];
  $setting_email_eventmediacomment_subject = $_POST['setting_email_eventmediacomment_subject'];
  $setting_email_eventmediacomment_message = $_POST['setting_email_eventmediacomment_message'];
  $setting_email_eventmemberrequest_subject = $_POST['setting_email_eventmemberrequest_subject'];
  $setting_email_eventmemberrequest_message = $_POST['setting_email_eventmemberrequest_message'];

    // SAVE EVENT CATEGORIES
    $max_eventcat_id = 0;
    $old_eventcats = $database->database_query("SELECT eventcat_id FROM se_eventcats WHERE eventcat_dependency='0' ORDER BY eventcat_id");
    while($old_eventcat_info = $database->database_fetch_assoc($old_eventcats)) {
      $var = "eventcat_title".$old_eventcat_info[eventcat_id];
      $eventcat_title = $_POST[$var];
      if(str_replace(" ", "", $eventcat_title) == "") {
        $database->database_query("DELETE FROM se_eventcats WHERE eventcat_id='$old_eventcat_info[eventcat_id]' OR eventcat_dependency='$old_eventcat_info[eventcat_id]'");
	$database->database_query("UPDATE se_events SET event_eventcat_id='0' WHERE event_eventcat_id='$old_eventcat_info[eventcat_id]'");
      } else {
        $database->database_query("UPDATE se_eventcats SET eventcat_title='$eventcat_title' WHERE eventcat_id='$old_eventcat_info[eventcat_id]'");

          // SAVE DEP EVENT CATEGORIES
          $max_dep_eventcat_id = 0;
          $old_dep_eventcats = $database->database_query("SELECT eventcat_id FROM se_eventcats WHERE eventcat_dependency='$old_eventcat_info[eventcat_id]' ORDER BY eventcat_id");
          while($old_dep_eventcat_info = $database->database_fetch_assoc($old_dep_eventcats)) {
            $var = "eventcat_title".$old_eventcat_info[eventcat_id]."_".$old_dep_eventcat_info[eventcat_id];
            $dep_eventcat_title = $_POST[$var];
            if(str_replace(" ", "", $dep_eventcat_title) == "") {
              $database->database_query("DELETE FROM se_eventcats WHERE eventcat_id='$old_dep_eventcat_info[eventcat_id]'");
	      $database->database_query("UPDATE se_events SET event_eventcat_id='0' WHERE event_eventcat_id='$old_dep_eventcat_info[eventcat_id]'");
            } else {
              $database->database_query("UPDATE se_eventcats SET eventcat_title='$dep_eventcat_title' WHERE eventcat_id='$old_dep_eventcat_info[eventcat_id]'");
            }  
            $max_dep_eventcat_id = $old_dep_eventcat_info[eventcat_id];
          }

          $var = "num_subcat_".$old_eventcat_info[eventcat_id];
          $num_dep_eventcats = $_POST[$var];
          $dep_eventcat_count = 0;
          for($t=$max_dep_eventcat_id+1;$t<$num_dep_eventcats;$t++) {
            $var = "eventcat_title".$old_eventcat_info[eventcat_id]."_$t";
            $dep_eventcat_title = $_POST[$var];
            if(str_replace(" ", "", $dep_eventcat_title) != "") {
              $database->database_query("INSERT INTO se_eventcats (eventcat_title, eventcat_dependency) VALUES ('$dep_eventcat_title', '$old_eventcat_info[eventcat_id]')");
            }
          }
      }  
      $max_eventcat_id = $old_eventcat_info[eventcat_id];
    }

    $num_eventcats = $_POST['num_eventcategories'];
    $eventcat_count = 0;
    for($t=$max_eventcat_id+1;$t<=$num_eventcats;$t++) {
      $var = "eventcat_title$t";
      $eventcat_title = $_POST[$var];
      if(str_replace(" ", "", $eventcat_title) != "") {
        $database->database_query("INSERT INTO se_eventcats (eventcat_title) VALUES ('$eventcat_title')");
        $old_eventcat_info = $database->database_fetch_assoc($database->database_query("SELECT eventcat_id FROM se_eventcats WHERE eventcat_title='$eventcat_title' ORDER BY eventcat_id DESC LIMIT 1"));

          // SAVE DEP EVENT CATEGORIES
          $var = "num_subcat_".$t;
          $num_dep_eventcats = $_POST[$var];
          $dep_eventcat_count = 0;
          for($d=0;$d<$num_dep_eventcats;$d++) {
            $var = "eventcat_title".$t."_$d";
            $dep_eventcat_title = $_POST[$var];
            if(str_replace(" ", "", $dep_eventcat_title) != "") {
              $database->database_query("INSERT INTO se_eventcats (eventcat_title, eventcat_dependency) VALUES ('$dep_eventcat_title', '$old_eventcat_info[eventcat_id]')");
            }
          }
      }
    }

  // SAVE CHANGES
  $database->database_query("UPDATE se_settings SET 
			setting_permission_event='$setting_permission_event',
			setting_email_eventinvite_subject='$setting_email_eventinvite_subject',
			setting_email_eventinvite_message='$setting_email_eventinvite_message',
			setting_email_eventcomment_subject='$setting_email_eventcomment_subject',
			setting_email_eventcomment_message='$setting_email_eventcomment_message',
			setting_email_eventmediacomment_subject='$setting_email_eventmediacomment_subject',
			setting_email_eventmediacomment_message='$setting_email_eventmediacomment_message',
			setting_email_eventmemberrequest_subject='$setting_email_eventmemberrequest_subject',
			setting_email_eventmemberrequest_message='$setting_email_eventmemberrequest_message'");

  $setting = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_settings LIMIT 1"));
  $result = 1;
}






// GET EVENT CATEGORIES
$categories_array = Array();
$categories_query = $database->database_query("SELECT * FROM se_eventcats WHERE eventcat_dependency='0' ORDER BY eventcat_id");
while($category = $database->database_fetch_assoc($categories_query)) {
  // GET DEPENDENT EVENT CATS
  $dep_categories_query = $database->database_query("SELECT * FROM se_eventcats WHERE eventcat_dependency='$category[eventcat_id]' ORDER BY eventcat_id");
  $dep_eventcat_array = Array();
  while($dep_category = $database->database_fetch_assoc($dep_categories_query)) {
    $dep_eventcat_array[] = Array('dep_eventcat_id' => $dep_category[eventcat_id],
					'dep_eventcat_title' => $dep_category[eventcat_title]);
  }

  $max_dep_eventcat_id = $database->database_fetch_assoc($database->database_query("SELECT max(eventcat_id) AS max_eventcat_id FROM se_eventcats WHERE eventcat_dependency='$category[eventcat_id]'"));
  $num_dep_cats = $max_dep_eventcat_id[max_eventcat_id]+1;

  $categories_array[] = Array('eventcat_id' => $category[eventcat_id],
				'eventcat_title' => $category[eventcat_title],
				'dep_eventcats' => $dep_eventcat_array,
				'eventcat_num_deps' => $num_dep_cats);
}
$max_eventcat_id = $database->database_fetch_assoc($database->database_query("SELECT max(eventcat_id) AS max_eventcat_id FROM se_eventcats"));
$num_cats = $max_eventcat_id[max_eventcat_id];







// ASSIGN VARIABLES AND SHOW GENERAL SETTINGS PAGE
$smarty->assign('result', $result);
$smarty->assign('num_cats', $num_cats);
$smarty->assign('categories', $categories_array);
$smarty->assign('permission_event', $setting[setting_permission_event]);
$smarty->assign('setting_email_eventinvite_subject', $setting[setting_email_eventinvite_subject]);
$smarty->assign('setting_email_eventinvite_message', $setting[setting_email_eventinvite_message]);
$smarty->assign('setting_email_eventcomment_subject', $setting[setting_email_eventcomment_subject]);
$smarty->assign('setting_email_eventcomment_message', $setting[setting_email_eventcomment_message]);
$smarty->assign('setting_email_eventmediacomment_subject', $setting[setting_email_eventmediacomment_subject]);
$smarty->assign('setting_email_eventmediacomment_message', $setting[setting_email_eventmediacomment_message]);
$smarty->assign('setting_email_eventmemberrequest_subject', $setting[setting_email_eventmemberrequest_subject]);
$smarty->assign('setting_email_eventmemberrequest_message', $setting[setting_email_eventmemberrequest_message]);
$smarty->display("$page.tpl");
exit();
?>