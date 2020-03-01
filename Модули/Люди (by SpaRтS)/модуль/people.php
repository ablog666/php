<?
$page = "people";
include "header.php";


// GET RANDOM USERS
$randoms_query = $database->database_query("
 
  SELECT 
    user_id, 
    user_username, 
    user_photo 
  FROM 
    se_users 
  WHERE 
    user_verified='1' 
  AND 
    user_enabled='1'  
  ORDER BY 
    rand() 
  DESC LIMIT 
    10
  ");
  
$random_array = Array();
while($random = $database->database_fetch_assoc($randoms_query)) {

  $random_user = new se_user();
  $random_user->user_info[user_id] = $random[user_id];
  $random_user->user_info[user_username] = $random[user_username];
  $random_user->user_info[user_photo] = $random[user_photo];
  $random_user->user_info[user_lastlogindate] = $random[user_lastlogindate];

  $random_array[] = $random_user;
}  



$smarty->assign('randoms', $random_array);
include "footer.php";
?> 