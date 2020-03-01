{include file='header.tpl'}

<div class='page_header'><a href='{$url->url_base}group.php?group_id={$group->group_info.group_id}'>{$group->group_info.group_title}</a> &#187; <a href='group_discussion.php?group_id={$group->group_info.group_id}'>{$group_discussion_post4}</a> &#187; {if $topic_id == 0}{$group_discussion_post5}{else}{$group_discussion_post12}{/if}</div>

<br>

{* SHOW ERROR MESSAGE *}
{if $is_error != 0}
  <table cellpadding='0' cellspacing='0'>
  <tr><td class='result'>
    <div class='error'><img src='./images/error.gif' border='0' class='icon'> {$error_message}</div>
  </td></tr></table>
<br>
{/if}

<form action='group_discussion_post.php' method='post'>

{if $topic_id == 0}
  {$group_discussion_post7}
  <br><input type='text' class='text' name='topic_subject' value='{$topic_subject}' maxlength='50' size='40'>
  <br><br>
{/if}

{$group_discussion_post8}<br>
<textarea name='topic_body' rows='5' cols='65'>{$topic_body}</textarea>

<br><br>

{if $setting.setting_group_discussion_code == 1}
  <table cellspacing='0' cellpadding='0'>
  <tr>
    <td valign='top'><img src='./images/secure.php' id='secure_image' border='0' height='20' width='67' class='signup_code'>&nbsp;</td>
    <td style='padding-top: 4px;'><input type='text' name='comment_secure' id='comment_secure' class='text' size='6' maxlength='10'>&nbsp;</td>
    <td><img src='./images/icons/tip.gif' border='0' class='icon' onMouseover="tip('{$group_discussion_post13}')"; onMouseout="hidetip()"></td>
  </tr>
  </table>
  <br><br>
{/if}

<table cellpadding='0' cellspacing='0'>
<tr>
<td>
  <input type='submit' class='button' value='{if $topic_id == 0}{$group_discussion_post6}{else}{$group_discussion_post12}{/if}'>&nbsp;
  <input type='hidden' name='task' value='dopost'>
  <input type='hidden' name='group_id' value='{$group->group_info.group_id}'>
  <input type='hidden' name='grouptopic_id' value='{$topic_id}'>
  </form>
</td>
<td>
  <form action='group_discussion_post.php' method='get'>
  <input type='submit' class='button' value='{$group_discussion_post11}'>
  <input type='hidden' name='task' value='cancel'>
  <input type='hidden' name='group_id' value='{$group->group_info.group_id}'>
  <input type='hidden' name='grouptopic_id' value='{$topic_id}'>
  </form>
</td>
</tr>
</table>

{include file='footer.tpl'}