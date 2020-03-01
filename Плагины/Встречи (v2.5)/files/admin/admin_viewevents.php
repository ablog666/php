<?
$page = "admin_viewevents";
include "admin_header.php";

if(isset($_POST['s'])) { $s = $_POST['s']; } elseif(isset($_GET['s'])) { $s = $_GET['s']; } else { $s = "id"; }
if(isset($_POST['p'])) { $p = $_POST['p']; } elseif(isset($_GET['p'])) { $p = $_GET['p']; } else { $p = 1; }
if(isset($_POST['f_title'])) { $f_title = $_POST['f_title']; } elseif(isset($_GET['f_title'])) { $f_title = $_GET['f_title']; } else { $f_title = ""; }
if(isset($_POST['f_owner'])) { $f_owner = $_POST['f_owner']; } elseif(isset($_GET['f_owner'])) { $f_owner = $_GET['f_owner']; } else { $f_owner = ""; }
if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
if(isset($_POST['event_id'])) { $event_id = $_POST['event_id']; } elseif(isset($_GET['event_id'])) { $event_id = $_GET['event_id']; } else { $event_id = 0; }

// VALIDATE EVENT ID OR SET TASK TO MAIN
if($task == "confirm" OR $task == "deleteevent") {
  if($database->database_num_rows($database->database_query("SELECT event_id FROM se_events WHERE event_id='$event_id'")) != 1) { $task = "main"; }
}


// CREATE EVENT OBJECT
$events_per_page = 100;
$event = new se_event();


// CONFIRM EVENT DELETION
if($task == "confirm") {

  // SET HIDDEN INPUT ARRAYS FOR TWO TASKS
  $confirm_hidden = Array(Array('name' => 'task', 'value' => 'deleteevent'),
			  Array('name' => 'event_id', 'value' => $event_id),
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
  $smarty->assign('confirm_form_action', 'admin_viewevents.php');
  $smarty->assign('cancel_form_action', 'admin_viewevents.php');
  $smarty->assign('confirm_hidden', $confirm_hidden);
  $smarty->assign('cancel_hidden', $cancel_hidden);
  $smarty->assign('headline', $admin_viewevents[16]);
  $smarty->assign('instructions', $admin_viewevents[17]);
  $smarty->assign('confirm_submit', $admin_viewevents[16]);
  $smarty->assign('cancel_submit', $admin_viewevents[18]);
  $smarty->display("admin_confirm.tpl");
  exit();




// DELETE ALBUM
} elseif($task == "deleteevent") {
 
  $event->event_delete($event_id);

}







// SET EVENT SORT-BY VARIABLES FOR HEADING LINKS
$i = "id";   // EVENT_ID
$t = "t";    // EVENT_TITLE
$o = "o";    // CREATOR OF EVENT
$m = "m";    // TOTAL GUESTLIST FOR EVENT
$d = "d";    // START DATE OF EVENT

// SET SORT VARIABLE FOR DATABASE QUERY
if($s == "i") {
  $sort = "se_events.event_id";
  $i = "id";
} elseif($s == "id") {
  $sort = "se_events.event_id DESC";
  $i = "i";
} elseif($s == "t") {
  $sort = "se_events.event_title";
  $t = "td";
} elseif($s == "td") {
  $sort = "se_events.event_title DESC";
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
  $sort = "se_events.event_date_start";
  $d = "dd";
} elseif($s == "dd") {
  $sort = "se_events.event_date_start DESC";
  $d = "d";
} else {
  $sort = "se_events.event_id DESC";
  $i = "i";
}



// ADD CRITERIA FOR FILTER
$where = "";
if($f_owner != "") { $where .= "se_users.user_username LIKE '%$f_owner%'"; }
if($f_owner != "" & $f_title != "") { $where .= " AND "; }
if($f_title != "") { $where.= "se_events.event_title LIKE '%$f_title%'"; }
if($where != "") { $where = "($where)"; }


// DELETE NECESSARY EVENTS
$start = ($p - 1) * $events_per_page;
if($task == "delete") { $event->event_delete_selected($start, $events_per_page, $sort, $where); }

// GET TOTAL EVENTS
$total_events = $event->event_total($where, 1);

// MAKE EVENT PAGES
$page_vars = make_page($total_events, $events_per_page, $p);
$page_array = Array();
for($x=0;$x<=$page_vars[2]-1;$x++) {
  if($x+1 == $page_vars[1]) { $link = "1"; } else { $link = "0"; }
  $page_array[$x] = Array('page' => $x+1,
			  'link' => $link);
}

// GET EVENT ARRAY
$events = $event->event_list($page_vars[0], $events_per_page, $sort, $where, 1);








// ASSIGN VARIABLES AND SHOW VIEW EVENTS PAGE
$smarty->assign('total_events', $total_events);
$smarty->assign('pages', $page_array);
$smarty->assign('events', $events);
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