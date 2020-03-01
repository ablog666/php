<?
$page = "user_classified_edit";
include "header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }
if(isset($_GET['classified_id'])) { $classified_id = $_GET['classified_id']; } elseif(isset($_POST['classified_id'])) { $classified_id = $_POST['classified_id']; } else { $classified_id = 0; }

// SET VARS
$result = "";
$is_error = 0;

// ENSURE CLASSIFIED ARE ENABLED FOR THIS USER
if($user->level_info[level_classified_allow] == 0) { header("Location: user_home.php"); exit(); }

// START CLASSIFIED METHOD 
$classified = new se_classified($user->user_info[user_id], $classified_id);
if($classified->classified_info[classified_user_id] != $user->user_info[user_id] || $classified->classified_exists == 0) { header("Location: user_classified.php"); exit(); }

if($task == "doedit") { $validate = 1; } else { $validate = 0; }
$classified->classified_fields($validate);
if($validate == 1) { $is_error = $classified->is_error; $result = $classified->error_message; }


// EDIT THIS CLASSIFIED
if($task == "doedit") {
  $classified_title = $_POST['classified_title'];
  $classified_body = $_POST['classified_body'];
  $classified_classifiedcat_id = $_POST['classified_classifiedcat_id'];
  $classified_classifiedsubcat_id = $_POST['classified_classifiedsubcat_id'];
  $classified_classifiedsubcat_id_original = $_POST['classified_classifiedsubcat_id'];
  $classified_search = $_POST['classified_search'];
  $classified_privacy = $_POST['classified_privacy'];
  $classified_comments = $_POST['classified_comments'];

  // MAKE SURE PARENT CATEGORY IS SELECTED IF SUBCAT IS SELECTED
  if($classified_classifiedcat_id == 0) {
    $classified_classifiedsubcat_id = 0;
  }

  // MAKE SURE NO FIELDS ARE EMPTY
  if(str_replace(" ", "", $classified_title) == "" OR str_replace(" ", "", $classified_body) == "") {
    $result = $user_classified_edit[16];
    $is_error = 1;
  }

  // IF NO ERROR, CONTINUE
  if($is_error != 1) { 

    // GET CATEGORY ID IF SUBCAT WAS SELECTED
    if($classified_classifiedsubcat_id != "0" AND $classified_classifiedsubcat_id > 0) {
      $classified_classifiedcat_id = $classified_classifiedsubcat_id;
    }

    // ADD BREAKS TO BODY, STRIP TAGS
    $classified_body = strip_tags(htmlspecialchars_decode($classified_body));
    $classified_body = nl2br($classified_body);

    // POST ENTRY
    $classified->classified_post($classified_id, $classified_title, $classified_body, $classified_classifiedcat_id, $classified_search, $classified_privacy, $classified_comments);
 
    // UPDATE LAST UPDATE DATE (SAY THAT 10 TIMES FAST)
    $user->user_lastupdate();

    // SEND USER BACK TO VIEW ENTRIES PAGE
    header("Location: user_classified.php");
    exit;

  }
}

// CONVERT HTML CHARACTERS BACK
$classified->classified_info[classified_body] = str_replace("\r\n", "", html_entity_decode($classified->classified_info[classified_body]));

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


// GET TOTAL COMMENTS POSTED ON THIS ENTRY
$comments_total = $database->database_num_rows($database->database_query("SELECT classifiedcomment_id FROM se_classifiedcomments WHERE classifiedcomment_classified_id='".$classified->classified_info[classified_id]."'"));

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

// CONVERT BREAKS
$classified->classified_info[classified_body] = str_replace("<br />", "\r\n", $classified->classified_info[classified_body]);
$classified->classified_info[classified_body] = str_replace("<br>", "\r\n", $classified->classified_info[classified_body]);

// GET PARENT AND CHILD CATEGORY IDS
$category_info = $database->database_fetch_assoc($database->database_query("SELECT * FROM se_classifiedcats WHERE classifiedcat_id='".$classified->classified_info[classified_classifiedcat_id]."' LIMIT 1"));
if($category_info[classifiedcat_dependency] != 0 AND $category_info[classifiedcat_dependency] > 0) {
  $classified->classified_info[classified_classifiedparentcat_id] = $category_info[classifiedcat_dependency];
  $classified->classified_info[classified_classifiedchildcat_id] = $category_info[classifiedcat_id];
} else {
  $classified->classified_info[classified_classifiedparentcat_id] = $category_info[classifiedcat_id];
  $classified->classified_info[classified_classifiedchildcat_id] = 0;
}

// SET FIELD VALUES IF NO ERROR
if($is_error == 0) {
  $classified_title = $classified->classified_info[classified_title];
  $classified_body = $classified->classified_info[classified_body];
  $classified_classifiedcat_id = $classified->classified_info[classified_classifiedparentcat_id];
  $classified_classifiedsubcat_id_original = $classified->classified_info[classified_classifiedchildcat_id];
}

// ASSIGN VARIABLES AND SHOW EDIT classified ENTRY PAGE
$smarty->assign('classifiedcats', $classifiedcats_array);
$smarty->assign('classified_info', $classified->classified_info);
$smarty->assign('classified_privacy', true_privacy($classified->classified_info[classified_privacy], $user->level_info[level_classified_privacy]));
$smarty->assign('classified_comments', true_privacy($classified->classified_info[classified_comments], $user->level_info[level_classified_comments]));
$smarty->assign('search_classifieds', $user->level_info[level_classified_search]);
$smarty->assign('privacy_options', $privacy_options);
$smarty->assign('comment_options', $comment_options);
$smarty->assign('comments_total', $comments_total);
$smarty->assign('result', $result);
$smarty->assign('is_error', $is_error);
$smarty->assign('cats', $classified->cats);
$smarty->assign('classified_id', $classified_id);
$smarty->assign('classified_title', $classified_title);
$smarty->assign('classified_body', $classified_body);
$smarty->assign('classified_classifiedcat_id', $classified_classifiedcat_id);
$smarty->assign('classified_classifiedsubcat_id', $classified_classifiedsubcat_id_original);
include "footer.php";
?>