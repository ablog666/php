{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit.php?group_id={$group->group_info.group_id}'>{$user_group_edit_members_remove1}</a></td><td class='tab'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_group_edit_members.php?group_id={$group->group_info.group_id}'>{$user_group_edit_members_remove2}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit_invite.php?group_id={$group->group_info.group_id}'>{$user_group_edit_members_remove3}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit_files.php?group_id={$group->group_info.group_id}'>{$user_group_edit_members_remove4}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit_comments.php?group_id={$group->group_info.group_id}'>{$user_group_edit_members_remove5}</a></td><td class='tab'>&nbsp;</td>
{if $group->groupowner_level_info.level_group_style == 1}<td class='tab2' NOWRAP><a href='user_group_edit_style.php?group_id={$group->group_info.group_id}'>{$user_group_edit_members_remove6}</a></td><td class='tab'>&nbsp;</td>{/if}
{if $group->user_rank == 2}<td class='tab2' NOWRAP><a href='user_group_edit_delete.php?group_id={$group->group_info.group_id}'>{$user_group_edit_members_remove7}</a></td><td class='tab'>&nbsp;</td>{/if}
<td class='tab3'><a href='user_group.php'>&#171; {$user_group_edit_members_remove8}</a></td>
</tr>
</table>

<table cellpadding='0' cellspacing='0' width='100%'><tr><td class='page'>

<div>
  <img src='./images/icons/group_delete48.gif' border='0' class='icon_big'>
  <div class='page_header'>{$user_group_edit_members_remove9}</div>
  <div>{$user_group_edit_members_remove10}</div>
</div>

<br><br>

<table cellpadding='0' cellspacing='0'>
<tr>
<td>
  <form action='user_group_edit_members_remove.php' method='post'>
  <input type='submit' class='button' value='{$user_group_edit_members_remove11}'>&nbsp;
  <input type='hidden' name='member_id' value='{$member_id}'>
  <input type='hidden' name='group_id' value='{$group->group_info.group_id}'>
  <input type='hidden' name='task' value='doremove'>
  </form>
</td>
<td>
  <form action='user_group_edit_members.php' method='get'>
  <input type='submit' class='button' value='{$user_group_edit_members_remove12}'>
  <input type='hidden' name='group_id' value='{$group->group_info.group_id}'>
  </form>
</td>
</tr>
</table>

</td></tr></table>

{include file='footer.tpl'}