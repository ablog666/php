<?
$page = "admin_userpoints_offercomments";
include "admin_header.php";
include_once "../include/class_comment.php";

$task = semods::getpost('task', "main");
$item_id = semods::getpost('item_id', 0);
$p = semods::getpost('p', 1);


// CREATE PROFILE COMMENT OBJECT
$comments_per_page = 50;
$comment = new se_comment( 'userpointearner', 'userpointearner_id', $item_id );

// DELETE NECESSARY COMMENTS
$start = ($p - 1) * $comments_per_page;
if($task == "delete") {
  $comment->comment_delete_selected($start, $comments_per_page);
  
  // Recount total comments
  $database->database_query( "UPDATE se_semods_userpointearner SET userpointearner_comments = ( SELECT COUNT(*) FROM se_userpointearnercomments WHERE userpointearnercomment_userpointearner_id = $item_id ) WHERE userpointearner_id = $item_id" );
  
  header("Location: admin_userpoints_offercomments.php?item_id=$item_id" );
}


// GET TOTAL COMMENTS
$total_comments = $comment->comment_total();

// MAKE COMMENT PAGES
$page_vars = make_page($total_comments, $comments_per_page, $p);

// GET COMMENT ARRAY
$comments = $comment->comment_list($page_vars[0], $comments_per_page);

$misc = new se_misc();

// ASSIGN VARIABLES AND INCLUDE FOOTER
$smarty->assign('comments', $comments);
$smarty->assign('total_comments', $total_comments);
$smarty->assign('p', $page_vars[1]);
$smarty->assign('maxpage', $page_vars[2]);
$smarty->assign('p_start', $page_vars[0]+1);
$smarty->assign('p_end', $page_vars[0]+count($comments));

$smarty->assign('item_id', $item_id);
$smarty->assign('misc', $misc);

$smarty->display("$page.tpl");
exit();
?>