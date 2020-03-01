{include file='header.tpl'}



<div class='page_header'>Подарки <a href='{$url->url_create('profile', $owner->user_info.user_username)}'>{$owner->user_info.user_username}</a></div>

<br>

<table cellpadding='0' cellspacing='0' width='100%' style='margin-bottom: 5px;'>
<tr>
<td>
&nbsp;&nbsp;
<a href='{$url->url_create('profile', $owner->user_info.user_username)}'><img src='./images/icons/back16.gif' class='icon' border='0'>{$gifts_profile1} {$owner->user_info.user_username} </a>
</td>
{* DISPLAY PAGINATION MENU IF APPLICABLE *}
{if $maxpage > 1}
  <td align='right'>
    {if $p != 1}<a href='profile_gifts.php?user={$owner->user_info.user_username}&p={math equation='p-1' p=$p}'>&#171; {$profile_comments7}</a>{else}<font class='disabled'>&#171; {$profile_comments7}</font>{/if}
    {if $p_start == $p_end}
      &nbsp;|&nbsp; {$profile_comments8} {$p_start} {$profile_comments9} {$total_comments} &nbsp;|&nbsp; 
    {else}
      &nbsp;|&nbsp; {$profile_comments10} {$p_start}-{$p_end} {$profile_comments9} {$total_comments} &nbsp;|&nbsp; 
    {/if}
    {if $p != $maxpage}<a href='profile_gifts.php?user={$owner->user_info.user_username}&p={math equation='p+1' p=$p}'>{$profile_comments11} &#187;</a>{else}<font class='disabled'>{$profile_comments11} &#187;</font>{/if}
    </div>
  </td>
{/if}
</tr>
</table>


{* LOOP THROUGH PROFILE GIFTS *}
  {section name=gifts_loop loop=$gifts}
  {cycle name="startrow" values="<table align='center' cellpadding='0' cellspacing='0'><tr>,,,,"}
<td align='center'>
<img src='./images/gifts/{$gifts[gifts_loop].gifts_id}.png' title='{$gifts[gifts_loop].gifts_comment}'><BR>
{if $gifts[gifts_loop].gifts_type == 1}
<a href='{$url->url_create('profile',$gifts[gifts_loop].gifts_from->user_info.user_username)}'>{$gifts[gifts_loop].gifts_from->user_info.user_username}</a>
{elseif $gifts[gifts_loop].gifts_type == 2}
{if $owner->user_info.user_id == $user->user_info.user_id}
<a href='{$url->url_create('profile',$gifts[gifts_loop].gifts_from->user_info.user_username)}'>{$gifts[gifts_loop].gifts_from->user_info.user_username}</a>
{else}
Аноним
{/if}
{elseif $gifts[gifts_loop].gifts_type == 3}
Аноним
{/if}
</td>
  {if $smarty.section.gifts_loop.last == true}
    </tr></table>
  {else}
    {cycle name="endrow" values=",,,,</tr></table>"}
  {/if}
  {/section}



<table cellpadding='0' cellspacing='0' width='100%' style='margin-top: 5px;'>
<tr>
<td>&nbsp;</td>
{* DISPLAY PAGINATION MENU IF APPLICABLE *}
{if $maxpage > 1}
  <td align='right'>
    {if $p != 1}<a href='profile_gifts.php?user={$owner->user_info.user_username}&p={math equation='p-1' p=$p}'>&#171; {$profile_comments7}</a>{else}<font class='disabled'>&#171; {$profile_comments7}</font>{/if}
    {if $p_start == $p_end}
      &nbsp;|&nbsp; {$profile_comments8} {$p_start} {$profile_comments9} {$total_comments} &nbsp;|&nbsp; 
    {else}
      &nbsp;|&nbsp; {$profile_comments10} {$p_start}-{$p_end} {$profile_comments9} {$total_comments} &nbsp;|&nbsp; 
    {/if}
    {if $p != $maxpage}<a href='profile_gifts.php?user={$owner->user_info.user_username}&p={math equation='p+1' p=$p}'>{$profile_comments11} &#187;</a>{else}<font class='disabled'>{$profile_comments11} &#187;</font>{/if}
    </div>
  </td>
{/if}
</tr>
</table>


{include file='footer.tpl'}