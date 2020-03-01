<?
$page = "news";
include "header.php";
// Блок новостей
$news = $database->database_query("SELECT * FROM se_announcements, se_admins ORDER BY announcement_order DESC LIMIT 20");
$news_array = Array();
$news_count = 0;
while ($item = $database->database_fetch_assoc($news))
{
                                $item[announcement_body] = htmlspecialchars_decode($item[announcement_body], ENT_QUOTES);
                                $news_array[$news_count] = Array('item_id' => $item[announcement_id], 'item_date' => $item[announcement_date], 'item_subject' => $item[announcement_subject], 'item_body' => $item[announcement_body], 'item_avtor' => $item[admin_name]);
                                $news_count++;
}
update_refurls();

// Обработка смарти
$smarty->assign('news', $news_array);
$smarty->assign('news_total', $news_count);
include "footer.php";
?>