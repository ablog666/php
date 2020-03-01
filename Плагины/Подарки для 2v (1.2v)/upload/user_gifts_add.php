<?
$page = "user_gifts_add";
include "header.php";
// DISPLAY ERROR PAGE IF NO OWNER
header ('Content-type: text/html;charset="windows-1251"');
if($owner->user_exists == 0) {
  $page = "error";
  $smarty->assign('error_header', $profile[1]);
  $smarty->assign('error_message', $profile[2]);
  $smarty->assign('error_submit', $profile[43]);
  include "footer.php";
}

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }

if($task == "add_user_gifts"){
$to=$owner->user_info['user_id'];
$from=$user->user_info['user_id'];
$gifts_id=(int)$_POST['gifts_id'];
$gifts = new se_gifts();
$gifts = $gifts->gifts_list(0, 100,'gifts_id DESC',"gifts_id='$gifts_id'");
$gifts_comment=$_POST['gifts_comment'];
if($gifts[0]['gifts_id'] > 0){
if($user->user_info['user_points'] >= $gifts[0]['gifts_price']){
  $gifts_comment = censor(str_replace("\r\n", "<br>", $gifts_comment));
  $gifts_comment = preg_replace('/(<br>){3,}/is', '<br><br>', $gifts_comment);
  $gifts_comment = ChopText($gifts_comment);
  if(str_replace(" ", "", $gifts_comment) == "") { $gifts_comment = ""; }
$giftsa= new se_gifts();
$giftsa->add_user_gifts($to,$from,$_POST['gifts_type'],$gifts_comment,$gifts[0]['gifts_id']);
$se_points_up="UPDATE `se_users` SET user_points=user_points-".$gifts[0]['gifts_price']." WHERE user_id='$from'";
$database->database_query($se_points_up);
$result="$user_gifts_add[1] <a href='".$url->url_create('profile',$owner->user_info['user_username'])."'>".$owner->user_info['user_username']."</a> ";
}else{
$result="$user_gifts_add[2] ".$gifts[0]['gifts_price']." $user_gifts_add[3]";
}
}else{
$result="$user_gifts_add[4]";
}
}else{
$w=(int)$_GET['w'];

if($w > 0){
$where="gifts_category='$w'";
}else{
$where="";
}

$gifts = new se_gifts();
$sort="";
$gifts = $gifts->gifts_list(0, 100,'gifts_id DESC',$where);

$giftsc = new se_gifts();
$giftsc = $giftsc->giftsc_list(0, 100);
$smarty->assign('giftsc', $giftsc);
$smarty->assign('gifts', $gifts);
}
$smarty->assign('result', $result);
include "footer.php";
?>