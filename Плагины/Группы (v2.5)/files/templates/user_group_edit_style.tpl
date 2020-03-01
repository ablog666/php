{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit.php?group_id={$group->group_info.group_id}'>{$user_group_edit_style2}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit_members.php?group_id={$group->group_info.group_id}'>{$user_group_edit_style3}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit_invite.php?group_id={$group->group_info.group_id}'>{$user_group_edit_style4}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit_files.php?group_id={$group->group_info.group_id}'>{$user_group_edit_style5}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit_comments.php?group_id={$group->group_info.group_id}'>{$user_group_edit_style6}</a></td><td class='tab'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_group_edit_style.php?group_id={$group->group_info.group_id}'>{$user_group_edit_style7}</a></td><td class='tab'>&nbsp;</td>
{if $group->user_rank == 2}<td class='tab2' NOWRAP><a href='user_group_edit_delete.php?group_id={$group->group_info.group_id}'>{$user_group_edit_style8}</a></td><td class='tab'>&nbsp;</td>{/if}
<td class='tab3'><a href='user_group.php'>&#171; {$user_group_edit_style9}</a></td>
</tr>
</table>

<div>
   <img src='./images/icons/group_edit48.gif' border='0' class='icon_big'>
   <div class='page_header'>{$user_group_edit_style10} <a href='group.php?group_id={$group->group_info.group_id}'>{$group->group_info.group_title|truncate:30:"...":true}</a></div>
   {$user_group_edit_style11}
</div>

<br>

{* SHOW SUCCESS MESSAGE *}
{if $result != 0}
  <br>
  <table cellpadding='0' cellspacing='0'><tr>
  <td class='result'><img src='./images/success.gif' border='0' class='icon'> {$user_group_edit_style1}</div></td>
  </tr></table>
{/if}

<br>

<form action='user_group_edit_style.php' method='POST'>
<textarea name='style_group' rows='17' cols='50' style='width: 100%; font-family: courier, serif;'>{$style_group}</textarea>
<br>
<br>
<input type='submit' class='button' value='{$user_group_edit_style12}'>
<input type='hidden' name='group_id' value='{$group->group_info.group_id}'>
<input type='hidden' name='task' value='dosave'>
</form>


{include file='footer.tpl'}