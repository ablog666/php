{* BEGIN CLASSIFIED LISTINGS *}
{if $owner->level_info.level_classified_allow != 0 AND $total_listings > 0}

  <table cellpadding='0' cellspacing='0' width='100%' style='margin-bottom: 10px;'>
  <tr><td class='header'>
    {$header_classified2} ({$total_listings})
    {* IF MORE THAN 5 LISTINGS, SHOW VIEW MORE LINKS *}
    {if $total_listings > 5}&nbsp;[ <a href='{$url->url_create('classifieds', $owner->user_info.user_username)}'>{$header_classified3}</a> ]{/if}
  </td></tr>
  <tr>
  <td class='profile'>
    {* LOOP THROUGH FIRST 5 CLASSIFIED LISTINGS *}
    {section name=listing_loop loop=$listings}
      <table cellpadding='0' cellspacing='0' width='100%'>
      <tr>
      <td valign='top' width='1'><img src='./images/icons/classified16.gif' border='0' class='icon'></td>
      <td valign='top'>
        <div><a href='{$url->url_create('classified', $owner->user_info.user_username, $listings[listing_loop].classified_id)}'>{if $listings[listing_loop].classified_title == ""}{$header_classified4}{else}{$listings[listing_loop].classified_title|truncate:30:"...":true|choptext:20:"<br>"}{/if}</a></div>
	<div>{$header_classified5} {$datetime->time_since($listings[listing_loop].classified_date)}</div>
      </td>
      </tr>
      </table>
      {if $smarty.section.listing_loop.last != true}<div style='font-size: 1pt; margin-top: 2px; margin-bottom: 2px;'>&nbsp;</div>{/if}
    {/section}
  </td>
  </tr>
  </table>

{/if}