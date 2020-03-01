<?
$page = "admin_viewgroups";
include "admin_header.php";

if(isset($_POST['s'])) { $s = $_POST['s']; } elseif(isset($_GET['s'])) { $s = $_GET['s']; } else { $s = "id"; }
if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }
if(isset($_POST['f_title'])) { $f_title = $_POST['f_title']; } elseif(isset($_GET['f_title'])) { $f_title = $_GET['f_title']; } else { $f_title = ""; }
if(isset($_POST['f_owner'])) { $f_owner = $_POST['f_owner']; } elseif(isset($_GET['f_owner'])) { $f_owner = $_GET['f_owner']; } else { $f_owner = ""; }
if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['group_id'])) { $group_id = $_POST['group_id']; } elseif(isset($_GET['group_id'])) { $group_id = $_GET['group_id']; } else { $group_id = 0; }

// VALIDATE GROUP ID OR SET TASK TO MAIN
if($task == "confirm" OR $task == "deletegroup") {
  if($database->database_num_rows($database->database_query("SELECT group_id FROM se_groups WHERE group_id='$group_id'")) != 1) { $task = "main"; }
}


// CREATE GROUP OBJECT
$groups_per_page = 100;
$group = new se_group();


// CONFIRM GROUP DELETION
if($task == "confirm") {

  // SET HIDDEN INPUT ARRAYS FOR TWO TASKS
  $confirm_hidden = Array(Array('name' => 'task', 'value' => 'deletegroup'),
			  Array('name' => 'group_id', 'value' => $group_id),
			  Array('name' => 's', 'value' => $s),
			  Array('name' => 'p', 'value' => $p),
			  Array('name' => 'f_title', 'value' => $f_title),
			  Array('name' => 'f_owner', 'value' => $f_owner));
  $cancel_hidden = Array(Array('name' => 'task', 'value' => 'main'),
			 Array('name' => 's', 'value' => $s),
			 Array('name' => 'p', 'value' => $p),
			 Array('name' => 'f_title', 'value' => $f_title),
			 Array('name' => 'f_owner', 'value' => $f_owner));

  // LOAD CONFIRM PAGE WITH APPROPRIATE VARIABLES
  $smarty->assign('confirm_form_action', 'admin_viewgroups.php');
  $smarty->assign('cancel_form_action', 'admin_viewgroups.php');
  $smarty->assign('confirm_hidden', $confirm_hidden);
  $smarty->assign('cancel_hidden', $cancel_hidden);
  $smarty->assign('headline', $admin_viewgroups[16]);
  $smarty->assign('instructions', $admin_viewgroups[17]);
  $smarty->assign('confirm_submit', $admin_viewgroups[16]);
  $smarty->assign('cancel_submit', $admin_viewgroups[18]);
  $smarty->display("admin_confirm.tpl");
  exit();




// DELETE ALBUM
} elseif($task == "deletegroup") {
 
  $group->group_delete($group_id);

}







// SET USER GROUP SORT-BY VARIABLES FOR HEADING LINKS
$i = "id";   // GROUP_ID
$t = "t";    // GROUP_TITLE
$o = "o";    // OWNER OF GROUP
$m = "m";    // MEMBERS IN GROUP
$d = "d";    // CREATION DATE OF GROUP

// SET SORT VARIABLE FOR DATABASE QUERY
if($s == "i") {
  $sort = "se_groups.group_id";
  $i = "id";
} elseif($s == "id") {
  $sort = "se_groups.group_id DESC";
  $i = "i";
} elseif($s == "t") {
  $sort = "se_groups.group_title";
  $t = "td";
} elseif($s == "td") {
  $sort = "se_groups.group_title DESC";
  $t = "t";
} elseif($s == "o") {
  $sort = "se_users.user_username";
  $o = "od";
} elseif($s == "od") {
  $sort = "se_users.user_username DESC";
  $o = "o";
} elseif($s == "m") {
  $sort = "num_members";
  $m = "md";
} elseif($s == "md") {
  $sort = "num_members DESC";
  $m = "m";
} elseif($s == "d") {
  $sort = "se_groups.group_datecreated";
  $d = "dd";
} elseif($s == "dd") {
  $sort = "se_groups.group_datecreated DESC";
  $d = "d";
} else {
  $sort = "se_groups.group_id DESC";
  $i = "i";
}



// ADD CRITERIA FOR FILTER
$where = "";
if($f_owner != "") { $where .= " se_users.user_username LIKE '%$f_owner%'"; }
if($f_owner != "" & $f_title != "") { $where .= " AND"; }
if($f_title != "") { $where.= " se_groups.group_title LIKE '%$f_title%'"; }
if($where != "") { $where = "($where)"; }


// DELETE NECESSARY GROUPS
$start = ($p - 1) * $groups_per_page;
if($task == "delete") { $group->group_delete_selected($start, $groups_per_page, $sort, $where); }

// GET TOTAL GROUPS
$total_groups = $group->group_total($where, 1);

// MAKE GROUP PAGES
$page_vars = make_page($total_groups, $groups_per_page, $p);
$page_array = Array();
for($x=0;$x<=$page_vars[2]-1;$x++) {
  if($x+1 == $page_vars[1]) { $link = "1"; } else { $link = "0"; }
  $page_array[$x] = Array('page' => $x+1,
			  'link' => $link);
}

// GET GROUP ARRAY
$groups = $group->group_list($page_vars[0], $groups_per_page, $sort, $where, 1);








// ASSIGN VARIABLES AND SHOW VIEW GROUPS PAGE
$smarty->assign('total_groups', $total_groups);
$smarty->assign('pages', $page_array);
$smarty->assign('groups', $groups);
$smarty->assign('f_title', $f_title);
$smarty->assign('f_owner', $f_owner);
$smarty->assign('i', $i);
$smarty->assign('t', $t);
$smarty->assign('o', $o);
$smarty->assign('m', $m);
$smarty->assign('d', $d);
$smarty->assign('p', $p);
$smarty->assign('s', $s);
$smarty->display("$page.tpl");
exit();
?>