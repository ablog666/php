<?
$page = "admin_userpoints_offers";
include "admin_header.php";

$task = semods::getpost('task', "main");
$item_id = semods::getpost('item_id', 0);

if($task == "addnew") {
  $offer_type_id = $_POST['offer_type'];
  $offer_name = semods::db_query_count("SELECT userpointearnertype_name FROM se_semods_userpointearnertypes WHERE userpointearnertype_id = $offer_type_id");
  if($offer_name) {
	header("Location: admin_userpoints_offers_" . $offer_name . ".php");
  }
}


if($task == "edit") {

  $upearner = new semods_upearner( $item_id, false );
  if($upearner->upearner_exists != 0) {
	$offer_name = $upearner->upearner_info['userpointearnertype_name'];
	header("Location: admin_userpoints_offers_" . $offer_name . ".php?item_id=$item_id");
  }

}


// DELETE ITEM
if($task == "delete") {
  $upearner = new semods_upearner( $item_id, false );
  $upearner->delete();
  header("Location: admin_userpoints_offers.php");
}


if($task == "enable") {
  $enable = semods::getpost('enable');
  $upearner = new semods_upearner( $item_id, false );
  $upearner->enable($enable);
  header("Location: admin_userpoints_offers.php");
}



$s = semods::getpost('s', "id");   // sort default by id
$p = semods::getpost('p', 1);

$f_title = semods::getpost('f_title', "");
$f_level = semods::getpost('f_level', "");
$f_subnet = semods::getpost('f_subnet', "");
$f_enabled = semods::getpost('f_enabled', "");
$task = semods::getpost('task', "main");


//$total_offers = semods_upearner::total_items( false, $where );

$sql_count = "SELECT COUNT(*) ";

$sql_head = "SELECT * ";

$sql_body = "FROM se_semods_userpointearner E
			 LEFT JOIN se_semods_userpointearnertypes T ON E.userpointearner_type = T.userpointearnertype_type";



$filters = array();
$filters[] = "userpointearner_type >= 100";
$f_title != ""	? $filters[] = "userpointearner_title LIKE '%$f_title%'" :0;
$f_level != ""	? $filters[] = "(FIND_IN_SET($f_level,userpointearner_levels) OR userpointearner_levels='')" :0;
$f_subnet != "" ? $filters[] = "(FIND_IN_SET($f_subnet,userpointearner_subnets) OR userpointearner_subnets='')" :0;
$f_enabled != ""? $filters[] = "userpointearner_enabled = $f_enabled" :0;

!empty($filters)  ? $sql_body .= " WHERE " . implode( " AND ", $filters):0;




$sql_count .= $sql_body;

$total_offers = semods::db_query_count( $sql_count );

// MAKE PAGES
$items_per_page = 10;
$page_vars = make_page($total_offers, $items_per_page, $p);

$page_array = Array();
for($x=0;$x<=$page_vars[2]-1;$x++) {
  if($x+1 == $page_vars[1]) { $link = "1"; } else { $link = "0"; }
  $page_array[$x] = Array('page' => $x+1,
						  'link' => $link);
}


$sql = $sql_head . $sql_body . " LIMIT {$page_vars[0]}, $items_per_page";

$offers = array();
$rows = $database->database_query( $sql );
while($row = $database->database_fetch_assoc( $rows )) {

  $offers[] = array( 'offer_id'			=> 	$row['userpointearner_id'] ,
					'offer_title'		=> 	$row['userpointearner_title'] ,
					'offer_enabled'		=>	$row['userpointearner_enabled'] == 0 ? 'No' : 'Yes',
					'offer_cost'		=>	$row['userpointearner_cost'],
					'offer_date'		=>	$row['userpointearner_date'],
					'total_comments'	=>	$row['userpointearner_comments'],
					'offer_views'		=>	$row['userpointearner_views'],
					'offer_engagements'	=>	$row['userpointearner_engagements'],
					'offer_levels'		=>	'Custom',
					'offer_subnets'		=>	'Custom',

					'offer_type'		=>	$row['userpointearnertype_typename'],
					
					'offer_enabledisable'	=>	$row['userpointearner_enabled'] == 0 ? 1 : 0,
					'offer_enabledisabletext'	=>	$row['userpointearner_enabled'] == 0 ? $admin_userpoints_offers[22] : $admin_userpoints_offers[12]

				   );
}

// LOOP OVER USER LEVELS
$levels = $database->database_query("SELECT level_id, level_name FROM se_levels ORDER BY level_name");
while($level_info = $database->database_fetch_assoc($levels)) {
  $level_array[$level_info[level_id]] = Array('level_id' => $level_info[level_id],
											  'level_name' => $level_info[level_name]);
}


// LOOP OVER SUBNETWORKS
$subnets = $database->database_query("SELECT subnet_id, subnet_name FROM se_subnets ORDER BY subnet_name");
$subnet_array[0] = Array('subnet_id' => 0, 'subnet_name' => $admin_userpoints_offers[26]);
while($subnet_info = $database->database_fetch_assoc($subnets)) {
  $subnet_array[$subnet_info[subnet_id]] = Array('subnet_id' => $subnet_info[subnet_id],
												 'subnet_name' => $subnet_info[subnet_name]);
}


// LOOP OVER OFFER TYPES
$offer_types = array();
$rows = $database->database_query("SELECT * FROM se_semods_userpointearnertypes ORDER BY userpointearnertype_title");
while($row = $database->database_fetch_assoc($rows)) {
  $offer_types[] = array( 'offertype_id'	=> $row['userpointearnertype_id'],
						  'offertype_title'	=> $row['userpointearnertype_title'] );
}



// ASSIGN VARIABLES AND SHOW VIEW USERS PAGE
$smarty->assign('total_offers', $total_offers);
$smarty->assign('offers', $offers);
$smarty->assign('offer_types', $offer_types);
$smarty->assign('pages', $page_array);
$smarty->assign('i', $i);
$smarty->assign('at', $at);
$smarty->assign('ad', $ad);
$smarty->assign('ai', $ai);
$smarty->assign('p', $page_vars[1]);
$smarty->assign('s', $s);
$smarty->assign('f_title', $f_title);
$smarty->assign('f_level', $f_level);
$smarty->assign('f_subnet', $f_subnet);
$smarty->assign('f_enabled', $f_enabled);
$smarty->assign('levels', array_values($level_array));
$smarty->assign('subnets', array_values($subnet_array));
$smarty->display("$page.tpl");
exit();
?>