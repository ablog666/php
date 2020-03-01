<?
$page = "admin_userpoints_offers_affiliate";
include "admin_header.php";

$task = semods::getpost('task', "main");
$item_id = semods::getpost('item_id', 0);

// SET ERROR VARIABLES
$is_error = 0;
$error_message = "";

// Load item data for editing
if( ($task != "addoffer") && ($item_id > 0)) {
  $upearner = new semods_upearner( $item_id, false );

  if($upearner->upearner_exists == 0) 
    header("Location: admin_userpoints_offers.php");

  $offer_title = $upearner->upearner_info['userpointearner_title'];
  $offer_enabled = $upearner->upearner_info['userpointearner_enabled'];
  $offer_desc = $upearner->upearner_info['userpointearner_body'];
  $offer_cost = $upearner->upearner_info['userpointearner_cost'];
  $offer_tags = $upearner->upearner_info['userpointearner_tags'];
  $offer_allow_comments = $upearner->upearner_info['userpointearner_comments_allowed'];
  $offer_levels = $upearner->upearner_info['userpointearner_levels'];
  $offer_subnets = $upearner->upearner_info['userpointearner_subnets'];
  $offer_transact_state = $upearner->upearner_info['userpointearner_transact_state'];
  
  // CONVERT HTML CHARACTERS BACK
  $offer_desc = html_entity_decode( $offer_desc, ENT_QUOTES, 'UTF-8' );
  
  $metadata = unserialize( $upearner->upearner_info['userpointearner_metadata'] );

  $affiliate_url = html_entity_decode( $metadata['url'] );
  
} else {
  // Defaults
  $offer_cost = 0;
  $offer_enabled = 1;
  $offer_allow_comments = 1;
  $offer_levels = '';  // all levels
  $offer_subnets = '';  // all subnets
  
  $offer_transact_state = 1;	// require action to complete
}


// CREATE / EDIT
if($task == "addoffer") {
  
  $item_type = semods::getpost('item_type', 0);
  
  $offer_enabled = semods::getpost('offer_enabled',0);
  $offer_title = trim(semods::getpost('offer_title',''));
  $offer_desc = $_POST['offer_desc'];
  $offer_cost = $_POST['offer_cost'];
  $offer_tags = $_POST['offer_tags'];
  $offer_allow_comments = $_POST['offer_allow_comments'];
  $offer_levels_all = semods::post('offer_levels_all',0);
  $offer_levels = $offer_levels_all ? array() : semods::post('offer_levels',array());
  $offer_subnets_all = semods::post('offer_subnets_all',0);
  $offer_subnets = $offer_subnets_all ? array() : semods::post('offer_subnets',array());

  $offer_levels = implode( ',', $offer_levels );
  $offer_subnets = implode( ',', $offer_subnets );

  $offer_transact_state = $_POST['offer_transact_state'];
  
  $offer_desc_encoded = htmlspecialchars( $offer_desc );

  $affiliate_url = semods::getpost('affiliate_url');

  if(empty($offer_title)) {
    $is_error = 1;
    $error_message = $admin_userpoints_offers_affiliate[45];
  }

  if($is_error == 0) {

	$metadata = array( 'url'	=> $affiliate_url );
	
	$metadata = serialize( $metadata );
	
	if($item_id == 0) {
	  $database->database_query("INSERT INTO se_semods_userpointearner(
								userpointearner_type,
								userpointearner_name,
								userpointearner_title,
								userpointearner_body,
								userpointearner_date,
								userpointearner_cost,
								userpointearner_metadata,
								userpointearner_enabled,
								userpointearner_tags,
								userpointearner_comments_allowed,
                                userpointearner_levels,
                                userpointearner_subnets,
								userpointearner_transact_state
								)
								VALUES(
								100,
								'',
								'$offer_title',
								'$offer_desc_encoded',
								UNIX_TIMESTAMP(NOW()),
								$offer_cost,
								'$metadata',
								$offer_enabled,
								'$offer_tags',
								$offer_allow_comments,
                                '$offer_levels',
                                '$offer_subnets',
								$offer_transact_state
								)");
	  
	  $item_id = $database->database_insert_id();
    }
	else
	  $database->database_query("UPDATE se_semods_userpointearner SET
								userpointearner_title = '$offer_title',
								userpointearner_body = '$offer_desc_encoded',
								userpointearner_cost = $offer_cost,
								userpointearner_metadata = '$metadata',
								userpointearner_enabled = $offer_enabled,
								userpointearner_tags = '$offer_tags',
								userpointearner_comments_allowed = $offer_allow_comments,
								userpointearner_transact_state = $offer_transact_state,
                                userpointearner_levels = '$offer_levels',
                                userpointearner_subnets = '$offer_subnets'
								WHERE userpointearner_id = $item_id");
	
	$result = 1;
  }

}



$offer_levels = empty($offer_levels) ? array() : explode(",", $offer_levels);

// LOOP OVER USER LEVELS, TAKE SELECTED
$levels = $database->database_query("SELECT level_id, level_name, level_default FROM se_levels ORDER BY level_id");
while($level_info = $database->database_fetch_assoc($levels)) {
  $level_info['level_selected'] = in_array($level_info['level_id'], $offer_levels) || $item_id == 0 || empty($offer_levels) ? 1 : 0;
  $level_array[] = $level_info;
}

$offer_subnets = empty($offer_subnets) ? array() : explode(",", $offer_subnets);

// LOOP OVER USER LEVELS, TAKE SELECTED
$rows = $database->database_query("SELECT subnet_id, subnet_name FROM se_subnets");
while($row = $database->database_fetch_assoc($rows)) {
  $row['subnet_selected'] = in_array($row['subnet_id'], $offer_subnets) || $item_id == 0 || empty($offer_subnets) ? 1 : 0;
  $subnet_array[] = $row;
}



// ASSIGN VARIABLES AND SHOW ADMIN ADD USER LEVEL PAGE
$smarty->assign('result', $result);
$smarty->assign('is_error', $is_error);
$smarty->assign('error_message', $error_message);

$smarty->assign('levels', $level_array);
$smarty->assign('levels_all', empty($level_array) ? 1 : 0);
$smarty->assign('subnets', $subnet_array);
$smarty->assign('subnets_all', empty($subnet_array) ? 1 : 0);

$smarty->assign('offer_title', $offer_title);
$smarty->assign('offer_enabled', $offer_enabled);
$smarty->assign('offer_desc', $offer_desc);
$smarty->assign('offer_cost', $offer_cost);
$smarty->assign('offer_tags', $offer_tags);
$smarty->assign('offer_allow_comments', $offer_allow_comments);

$smarty->assign('offer_transact_state', $offer_transact_state);

$smarty->assign('affiliate_url', $affiliate_url);


$smarty->assign('item_id', $item_id);

$smarty->display("$page.tpl");
exit();
?>