{include file='header.tpl'}

<div class='page_header'><a href='{$url->url_base}group.php?group_id={$group->group_info.group_id}'>{$group->group_info.group_title}</a> &#187; <a href='group_discussion.php?group_id={$group->group_info.group_id}'>{$group_discussion_view4}</a> &#187; {$topic_info.grouptopic_subject}</div>

<br>

<table cellpadding='0' cellspacing='0' width='100%' style='margin-bottom: 10px;'>
<tr>
<td>
{if $allowed_to_discuss != 0}<a href='group_discussion_post.php?group_id={$group->group_info.group_id}&grouptopic_id={$topic_info.grouptopic_id}'><img src='./images/icons/group_discussion_post16.gif' class='icon' border='0'>{$group_discussion_view5}</a>{/if}
&nbsp;&nbsp;
<a href='{$url->url_base}group_discussion.php?group_id={$group->group_info.group_id}'><img src='./images/icons/back16.gif' class='icon' border='0'>{$group_discussion_view6}</a>
</td>
{* DISPLAY PAGINATION MENU IF APPLICABLE *}
{if $maxpage > 1}
  <td align='right'>
    {if $p != 1}<a href='group_discussion_view.php?group_id={$group->group_info.group_id}&grouptopic_id={$topic_info.grouptopic_id}&p={math equation='p-1' p=$p}'>&#171; {$group_discussion_view7}</a>{else}<font class='disabled'>&#171; {$group_discussion_view7}</font>{/if}
    {if $p_start == $p_end}
      &nbsp;|&nbsp; {$group_discussion_view8} {$p_start} {$group_discussion_view9} {$total_posts} &nbsp;|&nbsp; 
    {else}
      &nbsp;|&nbsp; {$group_discussion_view10} {$p_start}-{$p_end} {$group_discussion_view9} {$total_posts} &nbsp;|&nbsp; 
    {/if}
    {if $p != $maxpage}<a href='group_discussion_view.php?group_id={$group->group_info.group_id}&grouptopic_id={$topic_info.grouptopic_id}&p={math equation='p+1' p=$p}'>{$group_discussion_view11} &#187;</a>{else}<font class='disabled'>{$group_discussion_view11} &#187;</font>{/if}
    </div>
  </td>
{/if}
</tr>
</table>

{* LOOP THROUGH GROUP POSTS *}
<table cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td class='group_discussion_header2'>{$topic_info.grouptopic_subject}</td>
</tr>
<tr>
<td class='group_discussion_thread'>
  {section name=post_loop loop=$posts}
    <table cellpadding='0' cellspacing='0' width='100%'>
    <tr>
    <td class='group_discussion_item1' width='80'>
      {if $posts[post_loop].grouppost_author->user_info.user_id != 0}
        <a href='{$url->url_create('profile',$posts[post_loop].grouppost_author->user_info.user_username)}'><img src='{$posts[post_loop].grouppost_author->user_photo('./images/nophoto.gif')}' class='photo' border='0' width='{$misc->photo_size($posts[post_loop].grouppost_author->user_photo('./images/nophoto.gif'),'75','75','w')}'></a>
      {else}
        <img src='./images/nophoto.gif' class='photo' border='0' width='75'>
      {/if}
    </td>
    <td class='group_discussion_item2'>
      <table cellpadding='0' cellspacing='0' width='100%'>
      <tr>
      <td class='group_discussion_author'><b>{if $posts[post_loop].grouppost_author->user_info.user_id != 0}<a href='{$url->url_create('profile',$posts[post_loop].grouppost_author->user_info.user_username)}'>{$posts[post_loop].grouppost_author->user_info.user_username}</a>{else}{$group_discussion_view12}{/if}</b> - {$datetime->cdate("`$setting.setting_timeformat` `$group_discussion_view13` `$setting.setting_dateformat`", $datetime->timezone($posts[post_loop].grouppost_date, $global_timezone))}</td>
      <td class='group_discussion_author' align='right' nowrap='nowrap'>
        <a href='user_messages_new.php?to={$posts[post_loop].grouppost_author->user_info.user_username}'>{$group_discussion_view14}</a>
        {if ($posts[post_loop].grouppost_author->user_info.user_id != 0 && $user->user_info.user_id == $posts[post_loop].grouppost_author->user_info.user_id) || $group->user_rank == 2 || $group->user_rank == 1}|&nbsp;<a href='group_discussion_delete.php?group_id={$group->group_info.group_id}&grouptopic_id={$topic_info.grouptopic_id}&grouppost_id={$posts[post_loop].grouppost_id}'>{$group_discussion_view15}</a>{/if}
      </td>
      </tr>
      <tr>
      <td colspan='2' class='group_discussion_body'>{$posts[post_loop].grouppost_body}</td>
      </tr>
      </table>
    </td>
    </tr>
    </table>
  {/section}
</td>
</tr>
</table>

<table cellpadding='0' cellspacing='0' width='100%' style='margin-top: 5px;'>
<tr>
<td>&nbsp;</td>
{* DISPLAY PAGINATION MENU IF APPLICABLE *}
{if $maxpage > 1}
  <td align='right'>
    {if $p != 1}<a href='group_discussion_view.php?group_id={$group->group_info.group_id}&grouptopic_id={$topic_info.grouptopic_id}&p={math equation='p-1' p=$p}'>&#171; {$group_discussion_view7}</a>{else}<font class='disabled'>&#171; {$group_discussion_view7}</font>{/if}
    {if $p_start == $p_end}
      &nbsp;|&nbsp; {$group_discussion_view8} {$p_start} {$group_discussion_view9} {$total_posts} &nbsp;|&nbsp; 
    {else}
      &nbsp;|&nbsp; {$group_discussion_view10} {$p_start}-{$p_end} {$group_discussion_view9} {$total_posts} &nbsp;|&nbsp; 
    {/if}
    {if $p != $maxpage}<a href='group_discussion_view.php?group_id={$group->group_info.group_id}&grouptopic_id={$topic_info.grouptopic_id}&p={math equation='p+1' p=$p}'>{$group_discussion_view11} &#187;</a>{else}<font class='disabled'>{$group_discussion_view11} &#187;</font>{/if}
    </div>
  </td>
{/if}
</tr>
</table>

{include file='footer.tpl'}