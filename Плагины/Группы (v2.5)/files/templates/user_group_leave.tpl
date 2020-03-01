{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_group.php'>{$user_group_leave1}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_invites.php'>{$user_group_leave2}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_settings.php'>{$user_group_leave11}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_browse.php'>{$user_group_leave3}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<table cellpadding='0' cellspacing='0' width='100%'><tr><td class='page'>

<img src='./images/icons/group48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_group_leave4} <a href='group.php?group_id={$group->group_info.group_id}'>{$group->group_info.group_title}</a></div>
<div>{$user_group_leave5}</div>

<br>

{* SHOW WARNING THAT GROUP WILL BE DELETED IF USER IS THE OWNER *}
{if $group->user_rank == 2}
  <br>
  <table cellpadding='0' cellspacing='0'>
  <tr><td class='result' style='text-align: left;'>
    {$user_group_leave6}
    <a href='user_group_edit_members.php?group_id={$group->group_info.group_id}'>{$user_group_leave7}</a>
    {$user_group_leave8}
  </td></tr></table>
{/if}

<br>

<table cellpadding='0' cellspacing='0'>
<tr>
<td>
  <form action='user_group_leave.php' method='post'>
  <input type='submit' class='button' value='{$user_group_leave9}'>&nbsp;
  <input type='hidden' name='group_id' value='{$group->group_info.group_id}'>
  <input type='hidden' name='task' value='doleave'>
  </form>
</td>
<td>
  <form action='user_group.php' method='post'>
  <input type='submit' class='button' value='{$user_group_leave10}'>
  </form>
</td>
</tr>
</table>

</td></tr></table>

{include file='footer.tpl'}