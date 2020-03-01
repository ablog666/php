<?php
$page = "user_music_delete";
include "header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } else { $task = "main"; }
if(isset($_GET['music_id'])) { $music_id = $_GET['music_id']; } elseif(isset($_POST['music_id'])) { $music_id = $_POST['music_id']; } else { $music_id = 0; }

// START MUSIC METHOD 
$music = new se_music($user->user_info[user_id]);


// DELETE THIS ENTRY
if($task == "dodelete") {
  $file = $url->url_userdir($user->user_info[user_id]);
  $music->music_delete($file, $music_id);

  header("Location: user_music_edit.php");
  exit();
}


// ASSIGN SMARTY VARIABLES AND DISPLAY DELETE ENTRY PAGE
$smarty->assign('music_id', $music_id);
include "footer.php";
?>
