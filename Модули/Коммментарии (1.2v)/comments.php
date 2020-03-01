<?php
//////////////////////////////
// Comments v1.2            //
// Author: Passtor          //
// CopyRight 2008           //
// wwww.Passtor.ru          //
// Icq: 279347551           //
// Email: r_galeev@inbox.ru //
//////////////////////////////

$page = 'comment_page';
include 'header.php';
include('include/class_comments.php');
$t_page = (isset($_GET['p'])) ? $_GET['p'] : 1;
$comments = new se_comments();
$page_comments = $comments -> ShowPage($t_page);
$smarty->assign('p', $comments -> mPage);
$smarty->assign('maxpage', $comments -> mTotalPages);
$smarty->assign('p_start', $comments -> mStart);
$smarty->assign('p_end', $comments -> mFinish);
$smarty->assign('total_comments', $comments -> mTotalComments);
$smarty->assign('comments', $page_comments);
include "footer.php";
?>