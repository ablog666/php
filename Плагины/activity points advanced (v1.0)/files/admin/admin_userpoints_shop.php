<?
$page = "admin_userpoints_shop";
include "admin_header.php";

$task = semods::getpost('task', "main");
$item_id = semods::getpost('item_id');

if($task == "addnew") {
  $offer_type_id = intval($_POST['offer_type']);
  $offer_name = semods::db_query_count("SELECT userpointspendertype_name FROM se_semods_userpointspendertypes WHERE userpointspendertype_id = $offer_type_id");
  if($offer_name) {
	header("Location: admin_userpoints_shop_" . $offer_name . ".php");
  }
}


if($task == "edit") {

  $sql = "SELECT userpointspendertype_name
		  FROM se_semods_userpointspender S
		  JOIN se_semods_userpointspendertypes T ON S.userpointspender_type = T.userpointspendertype_type
		  WHERE userpointspender_id = $item_id";

  $offer_name = semods::db_query_count( $sql );
  if($offer_name) {
	header("Location: admin_userpoints_shop_" . $offer_name . ".php?item_id=$item_id");
  }
}


// DELETE ITEM
if($task == "delete") {
  $upspender = new semods_upspender( $item_id, false );
  $upspender->delete();
  header("Location: admin_userpoints_shop.php");
}

// 
if($task == "enable") {
  $enable = semods::getpost('enable');
  $upspender = new semods_upspender( $item_id, false );
  $upspender->enable($enable);
  header("Location: admin_userpoints_shop.php");
}




$s = semods::getpost('s', "id");   // sort default by appid
$p = semods::getpost('p', 1);
$f_title = semods::getpost('f_title', "");
$f_level = semods::getpost('f_level', "");
$f_subnet = semods::getpost('f_subnet', "");
$f_enabled = semods::getpost('f_enabled', "");

$sql_count = "SELECT COUNT(*) ";

$sql_head = "SELECT * ";

$sql_body = "FROM se_semods_userpointspender S
             LEFT JOIN se_semods_userpointspendertypes T ON S.userpointspender_type = T.userpointspendertype_type";

$filters = array();
$filters[] = "userpointspender_type >= 100";
$f_title != ""	? $filters[] = "userpointspender_title LIKE '%$f_title%'" :0;
$f_level != ""	? $filters[] = "(FIND_IN_SET($f_level,userpointspender_levels) OR userpointspender_levels='')" :0;
$f_subnet != "" ? $filters[] = "(FIND_IN_SET($f_subnet,userpointspender_subnets) OR userpointspender_subnets='')" :0;
$f_enabled != ""? $filters[] = "userpointspender_enabled = $f_enabled" :0;

!empty($filters)  ? $sql_body .= " WHERE " . implode( " AND ", $filters):0;


$sql_count .= $sql_body;

$total_offers = semods::db_query_count( $sql_count );


// MAKE PAGES
$items_per_page = 20;
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

  $offers[] = array( 'offer_id'			=> 	$row['userpointspender_id'] ,
					'offer_title'		=> 	$row['userpointspender_title'] ,
					'offer_enabled'		=>	$row['userpointspender_enabled'] == 0 ? 'No' : 'Yes',
					'offer_cost'		=>	$row['userpointspender_cost'],
					'offer_date'		=>	$row['userpointspender_date'],
					'total_comments'	=>	$row['userpointspender_comments'],
					'offer_views'		=>	$row['userpointspender_views'],
					'offer_engagements'	=>	$row['userpointspender_engagements'],
					'offer_levels'		=>	'Custom',
					'offer_subnets'		=>	'Custom',

					'offer_type'		=>	$row['userpointspendertype_typename'],

					'offer_enabledisable'	=>	$row['userpointspender_enabled'] == 0 ? 1 : 0,
					'offer_enabledisabletext'	=>	$row['userpointspender_enabled'] == 0 ? $admin_userpoints_shop[22] : $admin_userpoints_shop[12]
				   );
}




// LOOP OVER USER LEVELS
$levels = $database->database_query("SELECT level_id, level_name FROM se_levels ORDER BY level_id");
while($level_info = $database->database_fetch_assoc($levels)) {
  $level_array[$level_info[level_id]] = Array('level_id' => $level_info[level_id],
											  'level_name' => $level_info[level_name]);
}


// LOOP OVER SUBNETWORKS
$subnets = $database->database_query("SELECT subnet_id, subnet_name FROM se_subnets ORDER BY subnet_name");
$subnet_array[0] = Array('subnet_id' => 0, 'subnet_name' => $admin_userpoints_shop[26]);
while($subnet_info = $database->database_fetch_assoc($subnets)) {
  $subnet_array[$subnet_info[subnet_id]] = Array('subnet_id' => $subnet_info[subnet_id],
												 'subnet_name' => $subnet_info[subnet_name]);
}


// LOOP OVER OFFER TYPES
$offer_types = array();
$rows = $database->database_query("SELECT * FROM se_semods_userpointspendertypes WHERE userpointspendertype_type >= 100 ORDER BY userpointspendertype_title");
while($row = $database->database_fetch_assoc($rows)) {
  $offer_types[] = $row;
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
$smarty->assign('f_title', $f_apptitle);
$smarty->assign('f_level', $f_level);
$smarty->assign('f_subnet', $f_subnet);
$smarty->assign('f_enabled', $f_enabled);
$smarty->assign('levels', array_values($level_array));
$smarty->assign('subnets', array_values($subnet_array));
$smarty->display("$page.tpl");
exit();
?>