{include file='header.tpl'}

<div class='page_header'><a href='{$url->url_create('profile', $owner->user_info.user_username)}'>{$owner->user_info.user_username}</a>{$classifieds2}</div>
<br>

{* SHOW NO ENTRIES MESSAGE IF NECESSARY *}
{if $total_classifieds == 0}
  <table cellpadding='0' cellspacing='0'>
  <tr><td class='result'>
    <img src='./images/icons/bulb22.gif' border='0' class='icon'> <b><a href='{$url->url_create('profile', $owner->user_info.user_username)}'>{$owner->user_info.user_username}</a></b> {$classifieds3}
  </td></tr>
  </table>
{/if}

{* SHOW classified ENTRIES *}
{section name=entries_loop loop=$entries}
  {* MAKE SURE TITLE IS NOT BLANK *}
  {if $entries[entries_loop].classified_title != ""}
    {assign var='classified_title' value=$entries[entries_loop].classified_title}
  {else}
    {assign var='classified_title' value=$classified4}
  {/if}
  <div class='classified1'>
    <table cellpadding='0' cellspacing='0' width='100%'>
    <tr>
    <td valign='top' width='1' class='classified_photo'><a href='{$url->url_create('classified', $owner->user_info.user_username, $entries[entries_loop].classified_id)}'><img src='{$entries[entries_loop].classified->classified_photo("./images/nophoto.gif")}' class='photo' width='{$misc->photo_size($entries[entries_loop].classified->classified_photo("./images/nophoto.gif"),'100','100','w')}' border='0'></a></td>
    <td valign='top'>
      <div class='classified_title'><a href='{$url->url_create('classified', $owner->user_info.user_username, $entries[entries_loop].classified_id)}'>{$classified_title}</a></div>
      <div class='classified_date'>
        {$classifieds15} {$datetime->cdate("`$setting.setting_dateformat`", $datetime->timezone($entries[entries_loop].classified_date, $global_timezone))} {$classifieds16} {$datetime->cdate("`$setting.setting_timeformat`", $datetime->timezone($entries[entries_loop].classified_date, $global_timezone))}, 
	{$entries[entries_loop].classified_views} {$classifieds18}, 
        <a href='{$url->url_create('classified', $owner->user_info.user_username, $entries[entries_loop].classified_id)}'>{$entries[entries_loop].total_comments} {$classifieds5}</a>
        {if $entries[entries_loop].allowed_to_comment != 0} - [ <a href='{$url->url_create('classified', $owner->user_info.user_username, $entries[entries_loop].classified_id)}'>{$classifieds6}</a> ]{/if}
      </div>
      {* SHOW ENTRY CATEGORY *}
      {if $entries[entries_loop].classified_classifiedcat_title != ""}
        <div class='classified_category'>{$classifieds17} <a href='user_classified_browse.php?classifiedcat_id={$entries[entries_loop].classified_classifiedcat_id}'>{$entries[entries_loop].classified_classifiedcat_title}</a></div>
      {/if}
      <div class='classified_body'>{$entries[entries_loop].classified_body|choptext:75:"<br>"}</div>
    </td>
    </tr>
    </table>
  </div>
  {if $smarty.section.entries_loop.last != true}
    <div class='classified_spacer'>&nbsp;</div>
  {/if}
{/section}

{* DISPLAY PAGINATION MENU IF APPLICABLE *}
{if $maxpage > 1}
  <br>
  <div class='center'>
  {if $p != 1}<a href='{$url->url_create('classifieds', $owner->user_info.user_username)}&p={math equation='p-1' p=$p}'>&#171; {$classifieds7}</a>{else}<font class='disabled'>&#171; {$classifieds7}</font>{/if}
  {if $p_start == $p_end}
    &nbsp;|&nbsp; {$classifieds8} {$p_start} {$classifieds9} {$total_classifieds} &nbsp;|&nbsp; 
  {else}
    &nbsp;|&nbsp; {$classifieds10} {$p_start}-{$p_end} {$classifieds9} {$total_classifieds} &nbsp;|&nbsp; 
  {/if}
  {if $p != $maxpage}<a href='{$url->url_create('classifieds', $owner->user_info.user_username)}&p={math equation='p+1' p=$p}'>{$classifieds11} &#187;</a>{else}<font class='disabled'>{$classifieds11} &#187;</font>{/if}
  </div>
{/if}

{include file='footer.tpl'}