<?php
include "header.php";
if(isset($_POST['user_id'])) { $music_user_id = explode("?", $_POST['user_id']); } elseif(isset($_GET['user_id'])) { $music_user_id = explode("?", $_GET['user_id']); }
$music = new se_music($music_user_id[0]);
$musiclist = $music->music_list();
echo '<?xml version="1.0" encoding="UTF-8"?>';
?>
<playlist version="0" xmlns = "http://xspf.org/ns/0/">
  <trackList>
<?php foreach($musiclist as $song){ ?>
   <track>
    <location><?= $url->url_userdir($music_user_id[0]).$song[music_id].'.'.$song[music_ext] ?></location>
    <annotation><?= $song[music_title] ?></annotation>
   </track>
<?php } ?>
  </trackList>
</playlist>