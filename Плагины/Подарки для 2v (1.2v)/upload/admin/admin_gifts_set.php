<?
$page = "admin_gifts_set";
include "admin_header.php";

if(isset($_POST['task'])) { $task = $_POST['task']; } elseif(isset($_GET['task'])) { $task = $_GET['task']; } else { $task = "main"; }
$smarty->display("$page.tpl");
exit();
?>