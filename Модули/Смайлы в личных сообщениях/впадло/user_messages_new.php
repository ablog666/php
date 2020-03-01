<?
$page = "user_messages_new";
include "header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['pm_id'])) { $pm_id = $_POST['pm_id']; } elseif(isset($_GET['pm_id'])) { $pm_id = $_GET['pm_id']; } else { $pm_id = 0; }


// CHECK FOR ADMIN ALLOWANCE OF MESSAGES
if($user->level_info[level_message_allow] == 0) { header("Location: user_home.php"); exit(); }


// SET ERROR VARIABLES AND EMPTY VARS
$is_error = 0;
$error_message = "";


// TRY TO SEND MESSAGE
if($task == "send") {
  $to = $_POST['to'];
  $subject = $_POST['subject'];
  $message = $_POST['message'];
  $convo_id = $_POST['convo_id'];

  // SEND MESSAGE TO USER
  $user->user_message_send($to, $subject, $message, $convo_id);
  $is_error = $user->is_error;
  $error_message = $user->error_message;

  // IF NO ERROR, SEND BACK TO INBOX
  if($is_error == 0) { header("Location: user_messages.php?justsent=1"); exit(); }


// MAIN SEND/REPLY PAGE
} else {

  // VALIDATE MESSAGE ID IF SET (REPLY)

  $pm = $database->database_query("SELECT se_pms.pm_id,se_pms.pm_convo_id,se_pms.pm_subject,se_pms.pm_body,se_users.user_username FROM se_pms LEFT JOIN se_users ON se_pms.pm_authoruser_id=se_users.user_id WHERE pm_id='$pm_id' AND pm_user_id='".$user->user_info[user_id]."' AND pm_status<>'2'");
  if($database->database_num_rows($pm) == 1) {
    $pm_info = $database->database_fetch_assoc($pm);
    $to = $pm_info[user_username];
    $subject = "RE: ".$pm_info[pm_subject];
    if($pm_info[pm_convo_id] != 0) { $convo_id = $pm_info[pm_convo_id]; } else { $convo_id = $pm_info[pm_id]; }

    // Include message being replied to
    $pm_info['pm_body'] = ">> Сообщение от $pm_info[user_username]:".$pm_info['pm_body'];
    $pm_info['pm_body'] = str_replace("", ">> ", $pm_info['pm_body']);
    $pm_info['pm_body'] = str_replace("<br>", ">> ", $pm_info['pm_body']);
    $message = "".$pm_info['pm_body'];

  // NO MESSAGE ID SET (NEW MESSAGE)
  } else {
    if(isset($_GET['to'])) { $to = $_GET['to']; } else { $to = ""; }
    if(isset($_GET['subject'])) { $subject = $_GET['subject']; } else { $subject = ""; }
    if(isset($_GET['message'])) { $message = $_GET['message']; } else { $message = ""; }
  }
}

// CRANK SMILES START //
$asconf['smiles'] = "baffled,biggrin,confused,cool,dull,eek,growl,nerd,no,oo,redface,rofl,rolleyes,sad,sorry,tongue,wink,yes";
$i = 0;
$smilies = explode(",", $asconf['smiles']);
		foreach($smilies as $smile) {
			$i++; $smile = trim($smile);
			$outsmile .= "<img style=\"border: 0; cursor: pointer;\" src=\"./images/smilies_pm/$smile.gif\" alt=\"$smile\" onclick=\"addsmiley(':$smile:')\" />"; }
// CRANK SMILES END //

// GET LIST OF FRIENDS FOR SUGGEST BOX
$total_friends = $user->user_friend_total(0);
$friends = $user->user_friend_list(0, $total_friends, 0);


// ASSIGN SMARTY VARS AND INCLUDE FOOTER
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);
$smarty->assign('friends', $friends);
$smarty->assign('to', $to);
$smarty->assign('subject', $subject);
$smarty->assign('smiles', $outsmile);
$smarty->assign('message', $message);
$smarty->assign('convo_id', $convo_id);
include "footer.php";
?>
