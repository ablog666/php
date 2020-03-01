<?
session_start();
$page = "user_graffiti";
include "header.php";
if($owner->user_exists == 0)
{
  $page = "error";
  $smarty->assign('error_header', $user_graffiti[2]);
  $smarty->assign('error_message', $user_graffiti[3]);
  $smarty->assign('error_submit', $user_graffiti[4]);
  include "footer.php";
}
else
{
  if(isset($_POST['Signature']) && isset($_GET['graffiti']))
  {
    $graffiti_num		= intval($_GET['graffiti']);
    if($graffiti_num == $_SESSION['graffiti_session'])
    {
      if(isset($_FILES['Filedata']))
      {
        $fHandle			= fopen($_FILES['Filedata']['tmp_name'], "rb");
        if($fHandle)
        {
          $fData			= bin2hex(fread($fHandle, 32));
          if($fData == "89504e470d0a1a0a0000000d494844520000024a0000012508060000001b69cd")
          {
            $fImageData	= getimagesize($_FILES['Filedata']['tmp_name']);
            if($fImageData[0] == 586 && $fImageData[1] == 293)
            {
              $file_time	= time();
              $file_rand	= rand(0,9);
              $file_time	= $file_time . $file_rand;
              $file_name	= md5($file_time) . ".png";
              $i			= 0;
              while(file_exists($file_name) && $i < 20)
              {
                // If we tried 20x, then we must give up... small chance it happens though.
                $i++;
                // In case the file already exists, generate a new one.
                $file_time	= time();
                $file_rand	= rand(0,9)+$i;
                $file_time	= $file_time . $file_rand;
                $file_name	= md5($file_time) . ".png";
              }
              $origImage		= imagecreatefrompng($_FILES['Filedata']['tmp_name']);
              $newImage		= imagecreatetruecolor(272, 136);
              imagecopyresized($newImage, $origImage, 0, 0, 0, 0, 272, 136, $fImageData[0], $fImageData[1]);
              imagepng($newImage, "uploads_graffiti/" . $file_name);
              $comment_date	= time();
              $comment_body	= "<img src=\"uploads_graffiti/" . $file_name . "\" border=\"0\" />";
              $database->database_query("INSERT INTO se_profilecomments (profilecomment_user_id, profilecomment_authoruser_id, profilecomment_date, profilecomment_body) VALUES ('".$owner->user_info[user_id]."', '".$user->user_info[user_id]."', '$comment_date', '$comment_body')");
			  
              if($user->user_exists != 0)
              {
                $commenter = $user->user_info[user_username];
                $comment_body_encoded = $user_graffiti[1];
                $actions->actions_add($user, "postcomment", Array('[username1]', '[username2]', '[comment]'), Array($commenter, $owner->user_info[user_username], $comment_body_encoded));
                if($owner->user_info[user_id] != $user->user_info[user_id])
                {
                  send_profilecomment($owner, $commenter);
                }
              }

              $_SESSION['graffiti_session'] = "emptyString";
            }
          }
	}
      }
    }
  }
  else
  {
    $graffitiRand			= rand(10000,99999);
    $_SESSION['graffiti_session'] = $graffitiRand;
    $smarty->assign('graffitiName', $owner->user_info[user_username]);
    $smarty->assign('graffitiRand', $graffitiRand);
  }
}
include "footer.php";
?>