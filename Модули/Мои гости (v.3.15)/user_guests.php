<?
$page = "user_guests";
include "header.php";
// MY GUESTS by PASSTOR
$myg = new MyGuests($user->user_info[user_id]);
$guests = $myg -> GetResults();

if($guests == 0)
{
		header('Location: user_home.php');
		exit;
}
$guest_array = array();

foreach($guests as $guest)
{
		$my_guest = new se_user();
		$my_guest -> user_info[user_id] = $guest[user_id];;
		$my_guest -> user_info[user_username] = $guest[user_username];
		$my_guest -> user_info[user_photo] = $guest[user_photo];
		$guest_array[] = array('guest' => $my_guest,
														'date' => $guest[date],
														'p_views' => $guest[p_views],
														'f_views' => $guest[f_views],
														'b_views' => $guest[b_views]
													);
}
// END MY GUESTS

// ASSIGN SMARTY VARS AND INCLUDE FOOTER
$smarty->assign('myguests', $guest_array);
include "footer.php";
?>