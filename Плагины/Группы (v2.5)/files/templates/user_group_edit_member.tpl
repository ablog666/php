{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit.php?group_id={$group->group_info.group_id}'>{$user_group_edit_member1}</a></td><td class='tab'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_group_edit_members.php?group_id={$group->group_info.group_id}'>{$user_group_edit_member2}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit_invite.php?group_id={$group->group_info.group_id}'>{$user_group_edit_member3}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit_files.php?group_id={$group->group_info.group_id}'>{$user_group_edit_member4}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_group_edit_comments.php?group_id={$group->group_info.group_id}'>{$user_group_edit_member5}</a></td><td class='tab'>&nbsp;</td>
{if $group->groupowner_level_info.level_group_style == 1}<td class='tab2' NOWRAP><a href='user_group_edit_style.php?group_id={$group->group_info.group_id}'>{$user_group_edit_member6}</a></td><td class='tab'>&nbsp;</td>{/if}
{if $group->user_rank == 2}<td class='tab2' NOWRAP><a href='user_group_edit_delete.php?group_id={$group->group_info.group_id}'>{$user_group_edit_member7}</a></td><td class='tab'>&nbsp;</td>{/if}
<td class='tab3'><a href='user_group.php'>&#171; {$user_group_edit_member8}</a></td>
</tr>
</table>

<table cellpadding='0' cellspacing='0' width='100%'><tr><td class='page'>

<div>
   <img src='./images/icons/group48.gif' border='0' class='icon_big'>
   <div class='page_header'>{$user_group_edit_member9}</div>
   {$user_group_edit_member10}
</div>

<br>

<form action='user_group_edit_member.php' name='memberinfo' method='post'>
<table cellpadding='0' cellspacing='0'>
<tr>
<td class='form1' width='150'>{$user_group_edit_member11}</td>
<td class='form2'><a href='{$url->url_create('profile', $member_info.user_username)}'>{$member_info.user_username}</a></td>
</tr>

{* SHOW MEMBER TITLE FIELD IF ALLOWED BY ADMIN *}
{if $group->groupowner_level_info.level_group_titles == 1}
  <tr>
  <td class='form1'>{$user_group_edit_member12}</td>
  <td class='form2'>
    <input type='text' name='member_title' class='text' size='40' maxlength='50' value='{$member_info.groupmember_title}'>
  </td>
  </tr>
{/if}

{* SHOW MEMBER RANK FIELD *}
{if $group->user_rank == 2}
  <tr>
  <td class='form1'>{$user_group_edit_member13}</td>
  <td class='form2'>
    <select name='member_rank' id='member_rank' onChange="showwarning();">
    {if $member_info.groupmember_rank == 2}
      <option value='2'{if $member_info.groupmember_rank == 2} SELECTED{/if}>{$user_group_edit_member14}</option>
    {else}
      <option value='0'{if $member_info.groupmember_rank == 0} SELECTED{/if}>{$user_group_edit_member15}</option>
      {* ONLY SHOW OFFICER OPTION IF ALLOWED BY ADMIN *}
      {if $group->groupowner_level_info.level_group_officers == 1}<option value='1'{if $member_info.groupmember_rank == 1} SELECTED{/if}>{$user_group_edit_member16}</option>{/if}
      <option value='2'{if $member_info.groupmember_rank == 2} SELECTED{/if}>{$user_group_edit_member14}</option>
    {/if}
    </select>
  </td>
  </tr>
{/if}

{* SHOW INSTRUCTIONS IF EDITING OWNER *}
{if $member_info.groupmember_rank == 2}
  <tr>
  <td class='form1'>&nbsp;</td>
  <td class='form2'>
    <div class='form_desc'>{$user_group_edit_member18} <a href='user_group_edit_members.php?group_id={$group->group_info.group_id}'>{$user_group_edit_member21}</a> {$user_group_edit_member22}</div>
  </td>
  </tr>
{else}

  {* SHOW WARNING MESSAGE IF USER IS ABOUT TO TRANSFER OWNERSHIP *}
  <tr>
  <td class='form1' width='150'>&nbsp;</td>
  <td class='form2'><div id='warning' class='form_desc' style='display: none;'>{$user_group_edit_member17}</div></td>
  </tr>

{/if}

<tr>
<td class='form1'>&nbsp;</td>
<td class='form2'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td>
    <input type='submit' class='button' value='{$user_group_edit_member19}'>&nbsp;
    <input type='hidden' name='group_id' value='{$group->group_info.group_id}'>
    <input type='hidden' name='member_id' value='{$member_info.groupmember_id}'>
    <input type='hidden' name='task' value='dosave'>
    </form>
  </td>
  <td>
    <form action='user_group_edit_members.php?group_id={$group->group_info.group_id}' method='post'>
    <input type='submit' class='button' value='{$user_group_edit_member20}'>
    </form>
  </td>
  </tr>
  </table>
</td>
</tr>
</table>

{* JAVASCRIPT FOR SHOWING OWNERSHIP TRANSFER WARNING MESSAGE *}
{literal}
<script language='JavaScript'>
<!--
function showwarning() {
  if(document.memberinfo.member_rank.value == '2') {
    document.all.warning.style.display = 'block';
  } else {
    document.all.warning.style.display = 'none';
  }
}
//-->
</script>
{/literal}

<br>




</td></tr></table>

{include file='footer.tpl'}