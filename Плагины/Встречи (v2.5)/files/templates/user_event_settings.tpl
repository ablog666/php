{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event.php'>{$user_event_settings1}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_event_settings.php'>{$user_event_settings4}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event_browse.php'>{$user_event_settings3}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<img src='./images/icons/event48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_event_settings5}</div>
<div>{$user_event_settings6}</div>

<br>

{* SHOW SUCCESS MESSAGE *}
{if $result != 0}
  <table cellpadding='0' cellspacing='0'><tr><td class='result'>
  <div class='success'><img src='./images/success.gif' border='0' class='icon'> {$user_event_settings7}</div>
  </td></tr></table>
{/if}

<br>

<form action='user_event_settings.php' method='POST'>

<div><b>{$user_event_settings9}</b></div>
<div class='form_desc'>{$user_event_settings10}</div>
<table cellpadding='0' cellspacing='0'>
<tr><td><input type='checkbox' value='1' id='eventinvite' name='usersetting_notify_eventinvite'{if $user->usersetting_info.usersetting_notify_eventinvite == 1} CHECKED{/if}></td><td><label for='eventinvite'>{$user_event_settings11}</label></td></tr>
</table>

{* ONLY DISPLAY IF USER CAN CREATE GROUPS *}
{if $user->level_info.level_event_allow != 0}
  <table cellpadding='0' cellspacing='0'>
  <tr><td><input type='checkbox' value='1' id='eventcomment' name='usersetting_notify_eventcomment'{if $user->usersetting_info.usersetting_notify_eventcomment == 1} CHECKED{/if}></td><td><label for='eventcomment'>{$user_event_settings12}</label></td></tr>
  </table>
  <table cellpadding='0' cellspacing='0'>
  <tr><td><input type='checkbox' value='1' id='eventmediacomment' name='usersetting_notify_eventmediacomment'{if $user->usersetting_info.usersetting_notify_eventmediacomment == 1} CHECKED{/if}></td><td><label for='eventmediacomment'>{$user_event_settings13}</label></td></tr>
  </table>
  <table cellpadding='0' cellspacing='0'>
  <tr><td><input type='checkbox' value='1' id='eventmemberrequest' name='usersetting_notify_eventmemberrequest'{if $user->usersetting_info.usersetting_notify_eventmemberrequest == 1} CHECKED{/if}></td><td><label for='eventmemberrequest'>{$user_event_settings14}</label></td></tr>
  </table>
{/if}

<br>

<input type='submit' class='button' value='{$user_event_settings8}'>
<input type='hidden' name='task' value='dosave'>
</form>


{include file='footer.tpl'}