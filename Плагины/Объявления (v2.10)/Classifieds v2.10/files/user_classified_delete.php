<?
$page = "user_classified_delete";
include "header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }
if(isset($_GET['classified_id'])) { $classified_id = $_GET['classified_id']; } elseif(isset($_POST['classified_id'])) { $classified_id = $_POST['classified_id']; } else { $classified_id = 0; }

// ENSURE CLASSIFIEDS ARE ENABLED FOR THIS USER
if($user->level_info[level_classified_allow] == 0) { header("Location: user_home.php"); exit(); }

// MAKE SURE THIS CLASSIFIED ENTRY BELONGS TO THIS USER AND IS NUMERIC
$classified = $database->database_query("SELECT * FROM se_classifieds WHERE classified_id='$classified_id' AND classified_user_id='".$user->user_info[user_id]."' LIMIT 1");
if($database->database_num_rows($classified) != 1) { header("Location: user_classified.php"); exit(); }

// START CLASSIFIED METHOD 
$classified = new se_classified($user->user_info[user_id]);

// DELETE THIS ENTRY
if($task == "dodelete") {

  $classified->classified_delete($classified_id);

  header("Location: user_classified.php");
  exit();
}

$smarty->assign('classified_id', $classified_id);
include "footer.php";
?>