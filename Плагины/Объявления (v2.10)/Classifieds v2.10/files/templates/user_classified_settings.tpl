{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_classified.php'>{$user_classified_settings2}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_classified_settings.php'>{$user_classified_settings3}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_classified_browse.php'>{$user_classified_settings13}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<img src='./images/icons/classified48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_classified_settings7}</div>
<div>{$user_classified_settings8}</div>

<br>

{* SHOW SUCCESS MESSAGE *}
{if $result != 0}
  <table cellpadding='0' cellspacing='0'><tr><td class='success'>
  <img src='./images/success.gif' border='0' class='icon'>{$user_classified_settings1}
  </td></tr></table>
{/if}

<br>


{if $user->level_info.level_classified_comments !== "6"}
  <form action='user_classified_settings.php' method='post'>
  <div><b>{$user_classified_settings9}</b></div>
  <div class='form_desc'>{$user_classified_settings10}</div>
  <table cellpadding='0' cellspacing='0' class='editprofile_options'>
  <tr><td><input type='checkbox' value='1' id='classifiedcomment' name='usersetting_notify_classifiedcomment'{if $user->usersetting_info.usersetting_notify_classifiedcomment == 1} CHECKED{/if}></td><td><label for='classifiedcomment'>{$user_classified_settings11}</label></td></tr>
  </table>
  <br>
  <input type='submit' class='button' value='{$user_classified_settings6}'>
  <input type='hidden' name='task' value='dosave'>
  </form>
{else}
  {$user_classified_settings12}
{/if}


{include file='footer.tpl'}