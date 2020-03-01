<?
//////////////////////////////////
//    Автор:  Fost		//
//    Сайт:   www.vceti.net	//
//    E-mail: admin@vceti.net	//
//    ICQ:    434-897-434	//
//            473-167-680	//
//////////////////////////////////

 $page = "opinions";
 include "header.php";

if($owner->user_info[user_id] == 0 OR $owner->user_info[user_id] == ""){
header("Location: ./user_opinions.php");
}
else
{
$m = $_GET['m'];

$smarty->assign('m', $m); 

	function checkbox_list($start, $limit, $id) {
	  global $database;

	  $checkbox_array = Array();
	  $checkbox_query = "select  `checkbox_id`, `checkbox_user_id`, `checkbox_authoruser_id`, `checkbox_date`, `checkbox_body`, `checkbox_view`,  `user_username`, `user_photo` from se_checkbox JOIN se_users WHERE checkbox_user_id = $id AND checkbox_user_id = se_users.user_id ORDER BY checkbox_id DESC LIMIT $start, $limit";
	  $checkboxs = $database->database_query($checkbox_query);
	  while($checkbox_info = $database->database_fetch_assoc($checkboxs)) {$myuser = new se_user(); 
				$myuser->user_info[user_id] 		= $checkbox_info[user_id]; 
				$myuser->user_info[user_username] 	= $checkbox_info[user_username]; 
				$myuser->user_info[user_photo] 		= $checkbox_info[user_photo]; 
	    	$checkbox_array[] = Array('checkbox_id' 		=> $checkbox_info['checkbox_id'],
					'checkbox_user_id' 		=> $checkbox_info['checkbox_user_id'],
					'checkbox_authoruser_id' 	=> $checkbox_info['checkbox_authoruser_id'],
					'checkbox_date' 		=> $checkbox_info['checkbox_date'],
					'checkbox_body' 		=> $checkbox_info['checkbox_body'],
					'checkbox_view' 		=> $checkbox_info['checkbox_view'],
					'myuser' 			=> $myuser); }

	  return $checkbox_array;

	}

$checkboxs = checkbox_list(0, 1000, $owner->user_info[user_id]); 
$total_checkbox = $database->database_num_rows($database->database_query("SELECT checkbox_user_id FROM se_checkbox WHERE checkbox_user_id='".$owner->user_info[user_id]."'"));
$total_checkbox_user = $database->database_num_rows($database->database_query("SELECT checkbox_user_id FROM se_checkbox WHERE checkbox_user_id='".$owner->user_info[user_id]."' AND checkbox_authoruser_id='".$user->user_info[user_id]."'"));

$smarty->assign('total_checkbox_user', $total_checkbox_user); 
$smarty->assign('total_checkbox', $total_checkbox); 
$smarty->assign('checkboxs', $checkboxs);  
}
include "footer.php";

?>