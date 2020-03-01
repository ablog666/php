{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_music_edit.php'>{$user_music_delete5}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_music_settings.php'>{$user_music_delete6}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<table cellpadding='0' cellspacing='0' width='100%'><tr><td class='page'>

<img src='./images/icons/music48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_music_delete1}</div>
<div>{$user_music_delete2}</div>

<br>

<table cellpadding='0' cellspacing='0'>
<tr>
<td>
  <form action='user_music_delete.php' method='post'>
  <input type='submit' class='button' value='{$user_music_delete3}'>&nbsp;
  <input type='hidden' name='task' value='dodelete'>
  <input type='hidden' name='music_id' value='{$music_id}'>
  </form>
</td>
<form action='user_music_edit.php' method='POST'>
<td><input type='submit' class='button' value='{$user_music_delete4}'></td>
</tr>
</table>
</form>

</td></tr></table>

{include file='footer.tpl'}