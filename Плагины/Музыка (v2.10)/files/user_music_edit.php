<?php
$page = "user_music_edit";
include "header.php";
if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['music_id'])) { $music_id = $_POST['music_id']; } elseif(isset($_GET['music_id'])) { $music_id = $_GET['music_id']; }

// CREATE MUSIC OBJECT
$music = new se_music($user->user_info[user_id]);
$musiclist = $music->music_list();

// DELETE MULTIPLE SONGS
if($task == "dodelete") {
  for($i=0;$i<count($musiclist);$i++) {
    $var = "delete_music_".$musiclist[$i]['music_id'];
    if($_POST[$var] == 1) {
      $file = $url->url_userdir($user->user_info[user_id]);
      $music->music_delete($file, $musiclist[$i]['music_id']);
    }
  }
}



// MOVE A SONG UP IN THE PLAYLIST ORDER
if($task == "moveup") {
  $music->music_moveup($music_id);
  header("Location: user_music_edit.php");
  exit;
}

// EDIT A SONG TITLE
if($task == "edit") {
  $track_info = $music->music_track_info($music_id);
  $smarty->assign('track_info',$track_info);
}

// SAVE SONG TITLE CHANGE
if($task == "doedit") {
  $music_title = $_POST['music_title'];
  if(trim($music_title) == "") { $music_title = "Untitled Song"; }
  $update_track = $music->music_track_update($music_id, $music_title);
  $smarty->assign('updated_music_title',$update_track);
}

$musiclist = $music->music_list();
$smarty->assign('task', $task);
$smarty->assign('musiclist', $musiclist);

include "footer.php";
?>
