{include file='header.tpl'}

<div class='page_header'><a href='{$url->url_base}group.php?group_id={$group->group_info.group_id}'>{$group->group_info.group_title}</a> &#187; {$group_discussion4}</div>

<br>



<table cellpadding='0' cellspacing='0' width='100%' style='margin-bottom: 10px;'>
<tr>
<td>
{if $allowed_to_discuss != 0}<a href='group_discussion_post.php?group_id={$group->group_info.group_id}'><img src='./images/icons/group_discussion_post16.gif' class='icon' border='0'>{$group_discussion5}</a>{/if}
&nbsp;&nbsp;
<a href='{$url->url_base}group.php?group_id={$group->group_info.group_id}'><img src='./images/icons/back16.gif' class='icon' border='0'>{$group_discussion6} {$group->group_info.group_title}</a>
</td>
{* DISPLAY PAGINATION MENU IF APPLICABLE *}
{if $maxpage > 1}
  <td align='right'>
    {if $p != 1}<a href='group_discussion.php?group_id={$group->group_info.group_id}&p={math equation='p-1' p=$p}'>&#171; {$group_discussion7}</a>{else}<font class='disabled'>&#171; {$group_discussion7}</font>{/if}
    {if $p_start == $p_end}
      &nbsp;|&nbsp; {$group_discussion8} {$p_start} {$group_discussion9} {$total_topics} &nbsp;|&nbsp; 
    {else}
      &nbsp;|&nbsp; {$group_discussion10} {$p_start}-{$p_end} {$group_discussion9} {$total_topics} &nbsp;|&nbsp; 
    {/if}
    {if $p != $maxpage}<a href='group_discussion.php?group_id={$group->group_info.group_id}&p={math equation='p+1' p=$p}'>{$group_discussion11} &#187;</a>{else}<font class='disabled'>{$group_discussion11} &#187;</font>{/if}
    </div>
  </td>
{/if}
</tr>
</table>

{* LOOP THROUGH GROUP TOPICS *}
<table cellpadding='0' cellspacing='0' width='100%' class='group_discussion_table'>
<tr>
<td class='group_discussion_header' width='100%' nowrap='nowrap'>{$group_discussion14}</td>
<td class='group_discussion_header' nowrap='nowrap' align='center'>{$group_discussion15}</td>
<td class='group_discussion_header' nowrap='nowrap' align='center'>{$group_discussion16}</td>
<td class='group_discussion_header' nowrap='nowrap' align='center'>{$group_discussion17}</td>
</tr>
{section name=topic_loop loop=$topics}
  <tr>
  <td class='group_discussion_topic{cycle values="1,1,1,1,2,2,2,2"}'>
    <img src='./images/icons/group_discussion16.gif' border='0' class='icon'>&nbsp;<b><a href='group_discussion_view.php?group_id={$group->group_info.group_id}&grouptopic_id={$topics[topic_loop].grouptopic_id}'>{$topics[topic_loop].grouptopic_subject}</a></b>
    {if $group->user_rank == 2 || $group->user_rank == 1}&nbsp;[ <a href='group_discussion_delete.php?group_id={$group->group_info.group_id}&grouptopic_id={$topics[topic_loop].grouptopic_id}'>{$group_discussion13}</a> ]{/if}
  </td>
  <td class='group_discussion_topic{cycle values="1,1,1,1,2,2,2,2"}' align='center' nowrap='nowrap'>
    {$datetime->time_since($topics[topic_loop].grouptopic_date)}
  </td>
  <td class='group_discussion_topic{cycle values="1,1,1,1,2,2,2,2"}' align='center' nowrap='nowrap'>
    &nbsp;{$topics[topic_loop].groupposts_total-1} {$group_discussion18}&nbsp;
  </td>
  <td class='group_discussion_topic{cycle values="1,1,1,1,2,2,2,2"}' align='center' nowrap='nowrap'>
    &nbsp;{$topics[topic_loop].grouptopic_views} {$group_discussion19}&nbsp;
  </td>
  </tr>

  </div>
{/section}
</table>


<table cellpadding='0' cellspacing='0' width='100%' style='margin-top: 5px;'>
<tr>
<td>&nbsp;</td>
{* DISPLAY PAGINATION MENU IF APPLICABLE *}
{if $maxpage > 1}
  <td align='right'>
    {if $p != 1}<a href='group_discussion.php?group_id={$group->group_info.group_id}&p={math equation='p-1' p=$p}'>&#171; {$group_discussion7}</a>{else}<font class='disabled'>&#171; {$group_discussion7}</font>{/if}
    {if $p_start == $p_end}
      &nbsp;|&nbsp; {$group_discussion8} {$p_start} {$group_discussion9} {$total_topics} &nbsp;|&nbsp; 
    {else}
      &nbsp;|&nbsp; {$group_discussion10} {$p_start}-{$p_end} {$group_discussion9} {$total_topics} &nbsp;|&nbsp; 
    {/if}
    {if $p != $maxpage}<a href='group_discussion.php?group_id={$group->group_info.group_id}&p={math equation='p+1' p=$p}'>{$group_discussion11} &#187;</a>{else}<font class='disabled'>{$group_discussion11} &#187;</font>{/if}
    </div>
  </td>
{/if}
</tr>
</table>


{include file='footer.tpl'}