{include file='header.tpl'}

{* SHOW COMMENTS *}
<table cellpadding='0' cellspacing='0' class='portal_table' align='center' width='100%'>
<tr><td class='header'>Все комментарии </td></tr>
<tr>
<td class='portal_box'>
{section name=comment_loop loop=$comments}
<div id='comment_{math equation='t-c' t=$comments|@count c=$smarty.section.comment_loop.index}'>
<table cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td class='profile_item1' width='80'>
{if $comments[comment_loop].comment_author->user_info.user_id != 0}
<a href='{$url->url_create('profile',$comments[comment_loop].comment_author->user_info.user_username)}'><img src='{$comments[comment_loop].comment_author->user_photo('./images/nophoto.gif')}' class='photo' border='0' width='{$misc->photo_size($comments[comment_loop].comment_author->user_photo('./images/nophoto.gif'),'75','75','w')}'></a>
{else}
<img src='./images/nophoto.gif' class='photo' border='0' width='75'>
{/if}
</td>
<td class='profile_item2'>
<table cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td class='profile_comment_author'><b>{if $comments[comment_loop].comment_author->user_info.user_id != 0}<a href='{$url->url_create('profile',$comments[comment_loop].comment_author->user_info.user_username)}'>{$comments[comment_loop].comment_author->user_info.user_username}</a>{else}{$profile33}{/if}</b> - {$datetime->cdate("`$setting.setting_timeformat` `$profile20` `$setting.setting_dateformat`", $datetime->timezone($comments[comment_loop].comment_date, $global_timezone))}</td>
<td class='profile_comment_author' align='right' nowrap='nowrap'>&nbsp;{$comments[comment_loop].comment_desc}</td>
</tr>
<tr>
<td colspan='2' class='profile_comment_body'>{$comments[comment_loop].comment_body|choptext:50:"<br>"}</td>
</tr>
</table>
</td>
</tr>
</table>
</div>
{/section}
</td>
</tr>
</table>
<table cellpadding='0' cellspacing='0' width='100%' style='margin-top: 5px;'>
<tr>
<td>&nbsp;</td>
{if $maxpage > 1}
<td align='right'>
{if $p != 1}<a href='comments.php?p={math equation='p-1' p=$p}'>&#171; Первая страница</a>{else}<font class='disabled'>&#171; Первая страница</font>{/if}
{if $p_start == $p_end}
&nbsp;|&nbsp; просмотр комментария {$p_start} из {$total_comments} &nbsp;|&nbsp;
{else}
&nbsp;|&nbsp; Просмотр комментариев {$p_start}-{$p_end} из {$total_comments} &nbsp;|&nbsp;
{/if}
{if $p != $maxpage}<a href='comments.php?p={math equation='p+1' p=$p}'>Следующая страница &#187;</a>{else}<font class='disabled'>Следующая страница &#187;</font>{/if}
</div>
</td>
{/if}
</tr>
</table>
{include file='footer.tpl'}