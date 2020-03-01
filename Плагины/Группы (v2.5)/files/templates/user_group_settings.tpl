{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group.php'>{$user_group_settings1}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_invites.php'>{$user_group_settings2}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_group_settings.php'>{$user_group_settings4}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_browse.php'>{$user_group_settings3}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<img src='./images/icons/group48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_group_settings5}</div>
<div>{$user_group_settings6}</div>

<br>

{* SHOW SUCCESS MESSAGE *}
{if $result != 0}
  <table cellpadding='0' cellspacing='0'><tr><td class='result'>
  <div class='success'><img src='./images/success.gif' border='0' class='icon'> {$user_group_settings7}</div>
  </td></tr></table>
{/if}

<br>

<form action='user_group_settings.php' method='POST'>

<div><b>{$user_group_settings9}</b></div>
<div class='form_desc'>{$user_group_settings10}</div>
<table cellpadding='0' cellspacing='0'>
<tr><td><input type='checkbox' value='1' id='groupinvite' name='usersetting_notify_groupinvite'{if $user->usersetting_info.usersetting_notify_groupinvite == 1} CHECKED{/if}></td><td><label for='groupinvite'>{$user_group_settings11}</label></td></tr>
</table>

{* ONLY DISPLAY IF USER CAN CREATE GROUPS *}
{if $user->level_info.level_group_allow != 0}
  <table cellpadding='0' cellspacing='0'>
  <tr><td><input type='checkbox' value='1' id='groupcomment' name='usersetting_notify_groupcomment'{if $user->usersetting_info.usersetting_notify_groupcomment == 1} CHECKED{/if}></td><td><label for='groupcomment'>{$user_group_settings12}</label></td></tr>
  </table>
  <table cellpadding='0' cellspacing='0'>
  <tr><td><input type='checkbox' value='1' id='groupmediacomment' name='usersetting_notify_groupmediacomment'{if $user->usersetting_info.usersetting_notify_groupmediacomment == 1} CHECKED{/if}></td><td><label for='groupmediacomment'>{$user_group_settings13}</label></td></tr>
  </table>
  <table cellpadding='0' cellspacing='0'>
  <tr><td><input type='checkbox' value='1' id='groupmemberrequest' name='usersetting_notify_groupmemberrequest'{if $user->usersetting_info.usersetting_notify_groupmemberrequest == 1} CHECKED{/if}></td><td><label for='groupmemberrequest'>{$user_group_settings14}</label></td></tr>
  </table>
{/if}

<br>

<input type='submit' class='button' value='{$user_group_settings8}'>
<input type='hidden' name='task' value='dosave'>
</form>


{include file='footer.tpl'}