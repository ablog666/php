<?
$page = "user_classified_new";
include "header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }

// SET VARS
$result = "";
$is_error = 0;

// ENSURE CLASSIFIEDS ARE ENABLED FOR THIS USER
if($user->level_info[level_classified_allow] == 0) { header("Location: user_home.php"); exit(); }

// START CLASSIFIED METHOD 
$classified = new se_classified($user->user_info[user_id]);


if($task == "dosave") { $validate = 1; } else { $validate = 0; }
$classified->classified_fields($validate);
if($validate == 1) { $is_error = $classified->is_error; $result = $classified->error_message; }

// BEGIN POST ENTRY TASK
if($task == "dosave") {
  $classified_title = $_POST['classified_title'];
  $classified_body = $_POST['classified_body'];
  $classified_classifiedcat_id = $_POST['classified_classifiedcat_id'];
  $classified_classifiedsubcat_id = $_POST['classified_classifiedsubcat_id'];
  $classified_classifiedsubcat_id_original = $_POST['classified_classifiedsubcat_id'];
  $classified_search = $_POST['classified_search'];
  $classified_privacy = $_POST['classified_privacy'];
  $classified_comments = $_POST['classified_comments'];

  // MAKE SURE NO FIELDS ARE EMPTY
  if(str_replace(" ", "", $classified_title) == "" OR str_replace(" ", "", $classified_body) == "") {
    $result = $user_classified_new[15];
    $is_error = 1;
  }

  // IF NO ERROR, CONTINUE
  if($is_error != 1) { 

    // GET CATEGORY ID IF SUBCAT WAS SELECTED
    if($classified_classifiedsubcat_id != "0" AND $classified_classifiedsubcat_id > 0) {
      $classified_classifiedcat_id = $classified_classifiedsubcat_id;
    }

    // ADD BREAKS TO BODY
    $classified_body = strip_tags(htmlspecialchars_decode($classified_body));
    $classified_body = nl2br($classified_body);

    // POST ENTRY
    $classified->classified_post(0, $classified_title, $classified_body, $classified_classifiedcat_id, $classified_search, $classified_privacy, $classified_comments);

    // UPDATE LAST UPDATE DATE (SAY THAT 10 TIMES FAST)
    $user->user_lastupdate();

    // INSERT ACTION
    $new_query = $database->database_query("SELECT classified_id FROM se_classifieds WHERE classified_user_id='".$user->user_info[user_id]."' ORDER BY classified_id DESC LIMIT 1");
    $new_info = $database->database_fetch_assoc($new_query);
    if(strlen($classified_title) > 100) { $classified_title = substr($classified_title, 0, 97); $classified_title .= "..."; }
    $actions->actions_add($user, "postclassified", Array('[username]', '[id]', '[title]'), Array($user->user_info[user_username], $new_info[classified_id], $classified_title));

    // SEND USER BACK TO VIEW ENTRIES PAGE
    header("Location: user_classified_edit_media.php?classified_id=$new_info[classified_id]&justadded=1");
    exit;

  }
}


// GET CLASSIFIED CATEGORIES
$classifiedcats_query = $database->database_query("SELECT * FROM se_classifiedcats WHERE classifiedcat_dependency='0' ORDER BY classifiedcat_id ASC");
$classifiedcats_array = Array();
while($classifiedcat = $database->database_fetch_assoc($classifiedcats_query)) {

  // GET SUBCATEGORIES
  $classifiedsubcats_query = $database->database_query("SELECT * FROM se_classifiedcats WHERE classifiedcat_dependency='$classifiedcat[classifiedcat_id]'");
  $classifiedsubcats_array = Array();
  while($classifiedsubcat = $database->database_fetch_assoc($classifiedsubcats_query)) {
    $classifiedsubcats_array[] = Array('classifiedsubcat_id' => $classifiedsubcat[classifiedcat_id],
			               'classifiedsubcat_title' => $classifiedsubcat[classifiedcat_title]);
  }

  // ADD CATEGORY (AND SUBCATEGORIES) TO ARRAY
  $classifiedcats_array[] = Array('classifiedcat_id' => $classifiedcat[classifiedcat_id],
			          'classifiedcat_title' => $classifiedcat[classifiedcat_title],
				  'classifiedcat_subcats' => $classifiedsubcats_array);
}


// GET AVAILABLE CLASSIFIED PRIVACY OPTIONS
$privacy_options = Array();
for($p=0;$p<strlen($user->level_info[level_classified_privacy]);$p++) {
  $privacy_level = substr($user->level_info[level_classified_privacy], $p, 1);
  if(user_privacy_levels($privacy_level) != "") {
    $privacy_options[] = Array('privacy_id' => "classified_privacy".$privacy_level,
			       'privacy_value' => $privacy_level,
			       'privacy_option' => user_privacy_levels($privacy_level));
  }
}


// GET AVAILABLE CLASSIFIED COMMENT OPTIONS
$comment_options = Array();
for($p=0;$p<strlen($user->level_info[level_classified_comments]);$p++) {
  $comment_level = substr($user->level_info[level_classified_comments], $p, 1);
  if(user_privacy_levels($comment_level) != "") {
    $comment_options[] = Array('comment_id' => "classified_comment".$comment_level,
			       'comment_value' => $comment_level,
			       'comment_option' => user_privacy_levels($comment_level));
  }
}

// SET SOME DEFAULTS
if(!isset($classified_search)) { $classified_search = 1; }
if(!isset($classified_privacy)) { $classified_privacy = true_privacy(0, $user->level_info[level_classified_privacy]); }
if(!isset($classified_comments)) {$classified_comments = true_privacy(0, $user->level_info[level_classified_comments]); }

// ASSIGN VARIABLES AND SHOW NEW CLASSIFIED PAGE
$smarty->assign('classifiedcats', $classifiedcats_array);
$smarty->assign('privacy_options', $privacy_options);
$smarty->assign('comment_options', $comment_options);
$smarty->assign('cats', $classified->cats);
$smarty->assign('result', $result);
$smarty->assign('is_error', $is_error);
$smarty->assign('classified_title', $classified_title);
$smarty->assign('classified_body', $classified_body);
$smarty->assign('classified_classifiedcat_id', $classified_classifiedcat_id);
$smarty->assign('classified_classifiedsubcat_id', $classified_classifiedsubcat_id_original);
$smarty->assign('classified_comments', $classified_comments);
$smarty->assign('classified_privacy', $classified_privacy);
$smarty->assign('classified_search', $classified_search);
include "footer.php";
?>