<?
$page = "admin_gifts";
include "admin_header.php";

if(isset($_POST['s'])) { $s = $_POST['s']; } elseif(isset($_GET['s'])) { $s = $_GET['s']; } else { $s = "id"; }
if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }
if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['gifts_id'])) { $gifts_id = $_POST['gifts_id']; } elseif(isset($_GET['gifts_id'])) { $gifts_id = $_GET['gifts_id']; } else { $gifts_id = 0; }
if(isset($_POST['gifts_cat_id'])) { $gifts_cat_id = $_POST['gifts_cat_id']; } elseif(isset($_GET['gifts_cat_id'])) { $gifts_cat_id = $_GET['gifts_cat_id']; } else { $gifts_cat_id = 0; }

// VALIDATE gifts ID OR SET TASK TO MAIN
if($task == "confirm" OR $task == "deletegifts") {
if($gifts_id > 0){
  if($database->database_num_rows($database->database_query("SELECT gifts_id FROM se_gifts WHERE gifts_id='$gifts_id'")) != 1) { $task = "main"; }
}elseif($gifts_cat_id > 0){
  if($database->database_num_rows($database->database_query("SELECT gifts_cat_id FROM se_gifts_cat WHERE gifts_cat_id='$gifts_cat_id'")) != 1) { $task = "main"; }
}
}



// CREATE gifts OBJECT
$gifts_per_page = 100;
$gifts = new se_gifts();


// CONFIRM gifts DELETION
if($task == "confirm") {
if($gifts_id > 0){
  // SET HIDDEN INPUT ARRAYS FOR TWO TASKS
  $confirm_hidden = Array(Array('name' => 'task', 'value' => 'deletegifts'),
			  Array('name' => 'gifts_id', 'value' => $gifts_id),
			  Array('name' => 's', 'value' => $s),
			  Array('name' => 'p', 'value' => $p),
			  Array('name' => 'f_title', 'value' => $f_title),
			  Array('name' => 'f_owner', 'value' => $f_owner));
  $cancel_hidden = Array(Array('name' => 'task', 'value' => 'main'),
			 Array('name' => 's', 'value' => $s),
			 Array('name' => 'p', 'value' => $p),
			 Array('name' => 'f_title', 'value' => $f_title),
			 Array('name' => 'f_owner', 'value' => $f_owner));
}elseif($gifts_cat_id > 0){
  $confirm_hidden = Array(Array('name' => 'task', 'value' => 'deletegifts'),
			  Array('name' => 'gifts_cat_id', 'value' => $gifts_cat_id),
			  Array('name' => 's', 'value' => $s),
			  Array('name' => 'p', 'value' => $p),
			  Array('name' => 'f_title', 'value' => $f_title),
			  Array('name' => 'f_owner', 'value' => $f_owner));
  $cancel_hidden = Array(Array('name' => 'task', 'value' => 'main'),
			 Array('name' => 's', 'value' => $s),
			 Array('name' => 'p', 'value' => $p));
}
  // LOAD CONFIRM PAGE WITH APPROPRIATE VARIABLES
  $smarty->assign('confirm_form_action', 'admin_gifts.php');
  $smarty->assign('cancel_form_action', 'admin_gifts.php');
  $smarty->assign('confirm_hidden', $confirm_hidden);
  $smarty->assign('cancel_hidden', $cancel_hidden);
  $smarty->assign('headline', $admin_gifts[14]);
  $smarty->assign('instructions', $admin_gifts[15]);
  $smarty->assign('confirm_submit', $admin_gifts[14]);
  $smarty->assign('cancel_submit', $admin_gifts[16]);
  $smarty->display("admin_confirm.tpl");
  exit();




// DELETE gifts
} elseif($task == "deletegifts") {
if($gifts_id > 0){
  $gifts->gifts_delete($gifts_id);
}elseif($gifts_cat_id > 0){
  $gifts->gifts_cat_delete($gifts_cat_id);
}
}elseif($task == "add_gifts"){
  $result=$gifts->add_gifts("gifts_file",$_POST['gifts_id_cat'],$_POST['gifts_price']);
}elseif($task == "add_gifts_cat"){
  $result=$gifts->add_gifts_cat($_POST['gifts_cat_name']);
}elseif($task == "edit_gifts"){
  $result=$gifts->update_gifts($_POST['gifts_id'],$_POST['gifts_id_cat'],$_POST['gifts_price']);
}elseif($task == "edit_gifts_cat"){
  $result=$gifts->update_gifts_cat($_POST['gifts_cat_id'],$_POST['gifts_cat_name']);
}



// SET gifts SORT-BY VARIABLES FOR HEADING LINKS
$i = "id";   // gifts_ID
$t = "t";    // gifts_TITLE
$u = "u";    // OWNER OF gifts
$f = "f";    // FILES IN gifts
$su = "su";  // TOTAL SPACE USED

// SET SORT VARIABLE FOR DATABASE QUERY
if($s == "i") {
  $sort = "se_gifts.gifts_id";
  $i = "id";
} elseif($s == "id") {
  $sort = "se_gifts.gifts_id DESC";
  $i = "i";
} elseif($s == "su") {
  $sort = "se_gifts.gifts_price";
  $su = "sud";
} elseif($s == "sud") {
  $sort = "se_gifts.gifts_price DESC";
  $su = "su";
} else {
  $sort = "se_gifts.gifts_id DESC";
  $i = "i";
}


// ADD CRITERIA FOR FILTER
$where = "";
// DELETE NECESSARY gifts
$start = ($p - 1) * $gifts_per_page;
if($task == "delete") { $gifts->gifts_delete_selected($start, $gifts_per_page, $sort, $where); }

// GET TOTAL gifts
$total_gifts = $gifts->gifts_total($where);

// MAKE gifts PAGES
$page_vars = make_page($total_gifts, $gifts_per_page, $p);
$page_array = Array();
for($x=0;$x<=$page_vars[2]-1;$x++) {
  if($x+1 == $page_vars[1]) { $link = "1"; } else { $link = "0"; }
  $page_array[$x] = Array('page' => $x+1,
			  'link' => $link);
}

// GET gifts ARRAY
$gifts = $gifts->gifts_list($page_vars[0], $gifts_per_page, $sort,$where);

$giftsc = new se_gifts();

$giftsc = $giftsc->giftsc_list(0, 100);




// ASSIGN VARIABLES AND SHOW VIEW gifts PAGE
$smarty->assign('total_gifts', $total_gifts);
$smarty->assign('pages', $page_array);
$smarty->assign('gifts', $gifts);
$smarty->assign('giftsc', $giftsc);
$smarty->assign('result', $result);
$smarty->assign('i', $i);
$smarty->assign('t', $t);
$smarty->assign('u', $u);
$smarty->assign('f', $f);
$smarty->assign('su', $su);
$smarty->assign('p', $page_vars[1]);
$smarty->assign('s', $s);
$smarty->display("$page.tpl");
exit();
?>