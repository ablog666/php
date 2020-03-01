<?
$page = 'photo';
include 'header.php';

if ($user->user_exists == 0) { header('Location: home.php'); exit; }

if(isset($_POST['page'])) { $p = $_POST['page']; } elseif(isset($_GET['page'])) { $p = $_GET['page']; } else { $p = 1; }

$result = 0;
$per_page = 3;
$temp_date = time()+(0*60) - (3600*24);

if ($do == "new"){
$wher = "AND media_date > '$temp_date'";
$link_files = "photo.php?do=new&";
$title = "Новые фотки сегодня";
}else{
$wher = "";
$link_files = "photo.php?";
$title = "Все фото";
}

$file_info = $database->database_fetch_assoc($database->database_query("SELECT count(*) AS total_files FROM se_media $wher"));
$total_files = $file_info[total_files];
$page_vars = make_page($total_files, $per_page, $p);
$media = $database->database_query("SELECT se_media.*,se_albums.album_id,se_users.user_id,se_users.user_username FROM se_media LEFT JOIN se_albums ON se_albums.album_id=se_media.media_album_id LEFT JOIN se_users ON se_users.user_id=se_albums.album_user_id LEFT JOIN se_levels ON se_users.user_level_id=se_levels.level_id WHERE $wher se_albums.album_search='1' OR se_levels.level_album_search='0' ORDER BY media_date DESC LIMIT $page_vars[0], $per_page");
$media_array = Array();

while($media_info = $database->database_fetch_assoc($media)) {

$mediacomment_info = $database->database_fetch_assoc($database->database_query("SELECT count(mediacomment_id) AS total_comments FROM se_mediacomments WHERE mediacomment_media_id='".$media_info[media_id]."'"));
$total_mediacomment = $mediacomment_info[total_comments];

$url = new se_url();
$media_path = $url->url_userdir($media_info['user_id']).$media_info['media_id'].'_thumb.'.$media_info['media_ext'];

if( !in_array($media_info[media_ext], array('jpg', 'jpeg', 'gif', 'png', 'bmp', 'tif')) ) continue;

$file_array[] = Array('media_id' => $media_info[media_id],
					'media_album_id' => $media_info[album_id],
					'media_path' => $media_path,
					'media_username' => $media_info[user_username],
					'media_title' => $media_info[media_title],
					'media_desc' => str_replace("<br>", "\r\n", $media_info[media_desc]),
					'media_ext' => $media_info[media_ext],
					'media_views' => $media_info[media_views],
          'media_comment' => $total_mediacomment); }

$smarty->assign('files', $file_array);
$smarty->assign('title', $title);
$smarty->assign('link_files', $link_files);
$smarty->assign('total_files', $total_files);
$smarty->assign('p', $page_vars[1]);
$smarty->assign('maxpage', $page_vars[2]);
$smarty->assign('p_start', $page_vars[0]+1);
$smarty->assign('p_end', $page_vars[0]+count($file_array));
include 'footer.php';
?>
