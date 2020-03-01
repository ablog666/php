<?
error_reporting (E_ALL ^ E_NOTICE);


///////////////////////////////////////////////////////
if($_GET['act'] == "" or $_GET['act'] == "main"){

$page = "matches";
include "header.php";

if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }

$query = "SELECT * FROM `se_matches` WHERE matches_user_id = ".$user->user_info[user_id]."";
$res = mysql_query($query);
while($row = mysql_fetch_array($res))
{
$smarty->assign('matches_body', $row['matches_body']);
$smarty->assign('matches_act', $row['matches_act']);
}

$page_title = "Предложения";
$smarty->assign('page_title', $page_title);

	function sent_list($start, $limit, $id) {
	  global $database;
	  $sent_array = Array();
	  $sent_query = "select  `sent_id`, `sent_user_id`, `sent_autheruser_id`, `sent_date`, `sent_view`, `user_username`, `user_id`, `user_photo`, `profile_9`, `profile_5`

from se_matches_sent JOIN se_users LEFT JOIN se_profiles ON sent_autheruser_id=se_profiles.profile_user_id

WHERE sent_user_id = $id AND sent_autheruser_id = se_users.user_id 

ORDER BY sent_id DESC LIMIT $start, $limit";
  	  $online_users_array = online_users();
	  $sents = $database->database_query($sent_query);
	  while($sent_info = $database->database_fetch_assoc($sents)) {$myuser = new se_user(); 
			$myuser->user_info[user_id] 			= $sent_info[user_id]; 
			$myuser->user_info[user_username] 		= $sent_info[user_username];
			$myuser->user_info[user_photo] 			= $sent_info[user_photo];
 if(in_array($sent_info[user_id], $online_users_array)) { $is_online = 1; } else { $is_online = 0; }
	   	 	$sent_array[] = Array('sent_id' 		=> $sent_info['sent_id'],
					'sent_user_id' 			=> $sent_info['sent_user_id'],
					'sent_autheruser_id' 		=> $sent_info['sent_autheruser_id'],
					'sent_date' 			=> $sent_info['sent_date'],
					'sent_view' 			=> $sent_info['sent_view'],
					'profile_9' 			=> $sent_info['profile_9'],
					'profile_5' 			=> $sent_info['profile_5'],
					'myuser' 			=> $myuser,
					'sent_online' => $is_online); }

	  return $sent_array;
	}

$total_users = $database->database_num_rows($database->database_query("SELECT sent_id FROM se_matches_sent WHERE sent_user_id='".$user->user_info[user_id]."'"));

// MAKE COMMENT PAGES
$comments_per_page = 50;
$page_vars = make_page($total_users, $comments_per_page, $p);

$sents = sent_list($page_vars[0], $comments_per_page, $user->user_info[user_id]); 
$smarty->assign('sents', $sents);  

$database->database_query("UPDATE se_matches_sent SET sent_view = 0  WHERE sent_user_id = ".$user->user_info[user_id]."");

$smarty->assign('p', $page_vars[1]);
$smarty->assign('total_users', $total_users);
$smarty->assign('maxpage', $page_vars[2]);
$smarty->assign('p_start', $page_vars[0]+1);
$smarty->assign('p_end', $page_vars[0]+count($comments));



$smarty->assign('pg', 11); 

include "footer.php";


}
///////////////////////////////////////////////////////


///////////////////////////////////////////////////////
elseif($_GET['act'] == "search"){

$page = "matches_search";
include "header.php";

$page_title = "Предложения";
$smarty->assign('page_title', $page_title);

if(isset($_POST['c'])) { $c = $_POST['c']; } elseif(isset($_GET['c'])) { $c = $_GET['c']; } else { $c = 0; }
if(isset($_POST['s'])) { $s = $_POST['s']; } elseif(isset($_GET['s'])) { $s = $_GET['s']; } else { $s = 0; }
if(isset($_POST['m'])) { $m = $_POST['m']; } elseif(isset($_GET['m'])) { $m = $_GET['m']; } else { $m = 0; }


$smarty->assign('s', $s);
$smarty->assign('c', $c);
$smarty->assign('m', $m);

if($c = 1){$cc = "Москва";}
if($c = 2){$cc = "Петербург";}
if($c = 3){$cc = "Киев";}

	function search_list($start, $limit, $id, $cc, $s) {
	  global $database;
	  $search_array = Array();
	  $search_query = "select `matches_id`, `matches_user_id`, `matches_body`, `matches_date`, `matches_act`, `user_username`, `user_id`, `user_photo`, `profile_9`, `profile_6`, `profile_5` from se_matches JOIN se_users LEFT JOIN se_profiles ON matches_user_id=se_profiles.profile_user_id ";

 $search_query .= " WHERE matches_act = 0 AND matches_user_id = se_users.user_id";
 if($c != ""){$search_query .= " AND profile_5 LIKE '%$c%'";}
 if($s != ""){$search_query .= " AND profile_6 = $s ";}

 $search_query .= " ORDER BY RAND() DESC LIMIT $start, $limit";
	  $searchs = $database->database_query($search_query);
	  while($search_info = $database->database_fetch_assoc($searchs)) {$myuser = new se_user(); 
				$myuser->user_info[user_id] 		= $search_info[user_id]; 
				$myuser->user_info[user_username] 	= $search_info[user_username]; 
				$myuser->user_info[user_photo] 		= $search_info[user_photo]; 
	    	$search_array[] = Array('matches_id' 			=> $search_info['matches_id'],
					'matches_user_id' 		=> $search_info['matches_user_id'],
					'matches_body'	 		=> $search_info['matches_body'],
					'matches_date' 			=> $search_info['matches_date'],
					'profile_5' 			=> $search_info['profile_5'],
					'profile_9' 			=> $search_info['profile_9'],
					'myuser' 			=> $myuser); }

	  return $search_array;


	}

$searchs = search_list(0, 1, $user->user_info[user_id], $c, $s); 
$smarty->assign('searchs', $searchs);  

$smarty->assign('pg', 11); 

include "footer.php";


}
///////////////////////////////////////////////////////


///////////////////////////////////////////////////////
elseif($_GET['act'] == "m_search"){

include "header.php";

$page_title = "Предложения";
$smarty->assign('page_title', $page_title);

$total_users = $database->database_num_rows($database->database_query("SELECT sent_id FROM se_matches_sent WHERE sent_user_id='".$owner->user_info[user_id]."' AND sent_autheruser_id='".$user->user_info[user_id]."' "));

$c = $_GET['c'];
$s = $_GET['s'];

if($total_users == 0){
$plus_text_query = mysql_query("
INSERT INTO se_matches_sent (sent_id, sent_user_id, sent_autheruser_id, sent_date, sent_view) 
		      VALUE ('', '".$owner->user_info[user_id]."', '".$user->user_info[user_id]."', '".time()."', '1')");
header("Location: ./matches.php?act=search&c=".$c."&s=".$s."&m=1"); exit();
}


if($total_users == 1){
header("Location: ./matches.php?act=search&c=".$c."&s=".$s."&m=1"); exit();
}


if($total_users >= 2){
$database->database_query("DELETE FROM se_matches_sent WHERE sent_autheruser_id='".$user->user_info[user_id]."' AND sent_user_id='".$owner->user_info[user_id]."'");
header("Location: ./matches.php?act=search&c=".$c."&s=".$s."&m=1"); exit();
}



}
///////////////////////////////////////////////////////


///////////////////////////////////////////////////////
elseif($_GET['act'] == "n_search"){

include "header.php";

$page_title = "Предложения";
$smarty->assign('page_title', $page_title);

$c = $_GET['c'];
$s = $_GET['s'];

$database->database_query("DELETE FROM se_matches_sent WHERE sent_autheruser_id='".$user->user_info[user_id]."' AND sent_user_id='".$owner->user_info[user_id]."'");
header("Location: ./matches.php?act=search&c=".$c."&s=".$s."&m=2"); exit();

}
///////////////////////////////////////////////////////


///////////////////////////////////////////////////////
elseif($_GET['act'] == "sent"){

$page = "matches_sent";
include "header.php";

$page_title = "Предложения";
$smarty->assign('page_title', $page_title);

if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }

	function sent_list($start, $limit, $id) {
	  global $database;
	  $sent_array = Array();
	  $sent_query = "select  `sent_id`, `sent_user_id`, `sent_autheruser_id`, `sent_date`, `sent_view`, `user_username`, `user_id`, `user_photo`, `profile_9`, `profile_5`

from se_matches_sent JOIN se_users LEFT JOIN se_profiles ON sent_user_id=se_profiles.profile_user_id

WHERE sent_autheruser_id = $id AND sent_user_id = se_users.user_id 

ORDER BY sent_id DESC LIMIT $start, $limit";
  	  $online_users_array = online_users();
	  $sents = $database->database_query($sent_query);
	  while($sent_info = $database->database_fetch_assoc($sents)) {$myuser = new se_user(); 
			$myuser->user_info[user_id] 			= $sent_info[user_id]; 
			$myuser->user_info[user_username] 		= $sent_info[user_username];
			$myuser->user_info[user_photo] 			= $sent_info[user_photo];
 if(in_array($sent_info[user_id], $online_users_array)) { $is_online = 1; } else { $is_online = 0; }
	   	 	$sent_array[] = Array('sent_id' 		=> $sent_info['sent_id'],
					'sent_user_id' 			=> $sent_info['sent_user_id'],
					'sent_autheruser_id' 		=> $sent_info['sent_autheruser_id'],
					'sent_date' 			=> $sent_info['sent_date'],
					'sent_view' 			=> $sent_info['sent_view'],
					'profile_9' 			=> $sent_info['profile_9'],
					'profile_5' 			=> $sent_info['profile_5'],
					'myuser' 			=> $myuser,
					'sent_online' => $is_online); }

	  return $sent_array;
	}


$total_users = $database->database_num_rows($database->database_query("SELECT sent_id FROM se_matches_sent WHERE sent_autheruser_id='".$user->user_info[user_id]."'"));

// MAKE COMMENT PAGES
$comments_per_page = 20;
$page_vars = make_page($total_users, $comments_per_page, $p);

$sents = sent_list($page_vars[0], $comments_per_page, $user->user_info[user_id]); 

$smarty->assign('sents', $sents);  
$smarty->assign('p', $page_vars[1]);
$smarty->assign('total_users', $total_users);
$smarty->assign('maxpage', $page_vars[2]);
$smarty->assign('p_start', $page_vars[0]+1);
$smarty->assign('p_end', $page_vars[0]+count($comments));

$smarty->assign('pg', 11); 

include "footer.php";

}
///////////////////////////////////////////////////////


///////////////////////////////////////////////////////
elseif($_GET['act'] == "a_sent"){

include "header.php";
$dec = $_GET['dec'];

$total = $database->database_num_rows($database->database_query("SELECT sent_id FROM se_matches_sent WHERE sent_user_id='".$owner->user_info[user_id]."' AND sent_autheruser_id='".$user->user_info[user_id]."'"));

	if($dec == 1){
if($total == 0){
$plus_text_query = mysql_query("
INSERT INTO se_matches_sent (sent_id, sent_user_id, sent_autheruser_id, sent_date, sent_view) 
		      VALUE ('', '".$owner->user_info[user_id]."', '".$user->user_info[user_id]."', '".time()."', '1')");
header("Location: ./profile.php?user=".$owner->user_info[user_username]."&m=1#matches"); exit();
}
if($total >= 1){
header("Location: ./profile.php?user=".$owner->user_info[user_username]."&m=2#matches"); exit();
}
	}


	if($dec == 0){

if($total == 0){
header("Location: ./profile.php?user=".$owner->user_info[user_username]."&m=4#matches"); exit();
	}

if($total >= 1){
$database->database_query("DELETE FROM se_matches_sent WHERE sent_autheruser_id='".$user->user_info[user_id]."' AND sent_user_id='".$owner->user_info[user_id]."'");
header("Location: ./profile.php?user=".$owner->user_info[user_username]."&m=3#matches"); exit();
}
	}

}
///////////////////////////////////////////////////////


///////////////////////////////////////////////////////
elseif($_GET['act'] == "a_close"){

include "header.php";

$page_title = "Предложения";
$smarty->assign('page_title', $page_title);

$database->database_query("UPDATE se_matches SET matches_act = 1  WHERE matches_user_id = ".$user->user_info[user_id]."");
header("Location: ./matches.php"); exit();
}
///////////////////////////////////////////////////////


///////////////////////////////////////////////////////
elseif($_GET['act'] == "a_open"){

include "header.php";

$page_title = "Предложения";
$smarty->assign('page_title', $page_title);

$database->database_query("UPDATE se_matches SET matches_act = 0  WHERE matches_user_id = ".$user->user_info[user_id]."");
header("Location: ./matches.php"); exit();
}
///////////////////////////////////////////////////////


///////////////////////////////////////////////////////
elseif($_GET['act'] == "a_save"){

include "header.php";

$page_title = "Предложения";
$smarty->assign('page_title', $page_title);

$text = $_GET['text'];

$database->database_query("DELETE FROM se_matches WHERE matches_user_id='".$user->user_info[user_id]."'");
$plus_text_query = mysql_query("
INSERT INTO se_matches (matches_id, matches_user_id, matches_body, matches_date, matches_act) 
			VALUE ('', '".$user->user_info[user_id]."', '".$text."', '".time()."', '0')");
header("Location: ./matches.php"); exit();
}
///////////////////////////////////////////////////////


///////////////////////////////////////////////////////
elseif($_GET['act'] == "a_delmem"){

include "header.php";

$page_title = "Предложения";
$smarty->assign('page_title', $page_title);

$md = $_GET['md'];


$database->database_query("DELETE FROM se_matches_sent WHERE sent_user_id='".$user->user_info[user_id]."' AND sent_id='".$md."'");


header("Location: ./matches.php"); exit();

}
///////////////////////////////////////////////////////
?>