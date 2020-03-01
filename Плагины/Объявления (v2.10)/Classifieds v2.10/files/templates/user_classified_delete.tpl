{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_classified.php'>{$user_classified_delete1}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_classified_style.php'>{$user_classified_delete2}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_classified_browse.php'>{$user_classified_delete7}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<table cellpadding='0' cellspacing='0' width='100%'><tr><td class='page'>

<img src='./images/icons/classified48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_classified_delete3}</div>
<div>{$user_classified_delete4}</div>

<br>

<table cellpadding='0' cellspacing='0'>
<tr>
<td>
  <form action='user_classified_delete.php' method='post'>
  <input type='submit' class='button' value='{$user_classified_delete5}'>&nbsp;
  <input type='hidden' name='task' value='dodelete'>
  <input type='hidden' name='classified_id' value='{$classified_id}'>
  </form>
</td>
<form action='user_classified.php' method='post'>
<td><input type='submit' class='button' value='{$user_classified_delete6}'></td>
</tr>
</table>
</form>

</td></tr></table>

{include file='footer.tpl'}