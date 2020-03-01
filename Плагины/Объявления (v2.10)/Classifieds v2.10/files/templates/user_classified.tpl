{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_classified.php'>{$user_classified1}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_classified_settings.php'>{$user_classified2}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_classified_browse.php'>{$user_classified7}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<img src='./images/icons/classified48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_classified3}</div>
<div>{$user_classified4}</div>

<br>

<div>
  <a href='user_classified_new.php'><img src='./images/icons/classified_post16.gif' border='0' class='icon'>{$user_classified5}</a>
  &nbsp;&nbsp;&nbsp;&nbsp;
  <a href="javascript:void(0)" onClick="showhide('classified_search');"><img src='./images/icons/search16.gif' border='0' class='icon'>{$user_classified6}</a>
</div>

<br>

{* SHOW SEARCH FIELD IF ANY ENTRIES EXIST *}
{if ($search != "" AND $total_classifieds == 0) OR ($search == "" AND $total_classifieds > 0) OR ($search != "" AND $total_classifieds > 0)}
  <div class='classified_search' id='classified_search' style='text-align: center;{if $search == ""} display: none;{/if}'>
    <form action='user_classified.php' name='searchform' method='post'>
    <table cellpadding='0' cellspacing='0' align='center'>
    <tr>
    <td>{$user_classified8}&nbsp;</td>
    <td><input type='text' name='search' maxlength='100' size='30' value='{$search}'>&nbsp;</td>
    <td><input type='submit' class='button' value='{$user_classified26}'></td>
    </tr>
    </table>
    <input type='hidden' name='s' value='{$s}'>
    <input type='hidden' name='p' value='{$p}'>
    </form>
  </div>
{/if}

{* DISPLAY PAGINATION MENU IF APPLICABLE *}
{if $maxpage > 1}
  <div class='center'>
  {if $p != 1}<a href='user_classified.php?search={$search}&p={math equation='p-1' p=$p}'>&#171; {$user_classified9}</a>{else}<font class='disabled'>&#171; {$user_classified9}</font>{/if}
  {if $p_start == $p_end}
    &nbsp;|&nbsp; {$user_classified10} {$p_start} {$user_classified11} {$total_classifieds} &nbsp;|&nbsp; 
  {else}
    &nbsp;|&nbsp; {$user_classified12} {$p_start}-{$p_end} {$user_classified11} {$total_classifieds} &nbsp;|&nbsp; 
  {/if}
  {if $p != $maxpage}<a href='user_classified.php?search={$search}&p={math equation='p+1' p=$p}'>{$user_classified13} &#187;</a>{else}<font class='disabled'>{$user_classified13} &#187;</font>{/if}
  </div>
  <br>
{/if}

{* DISPLAY MESSAGE IF NO CLASSIFIED ENTRIES *}
{if $total_classifieds == 0}
  <table cellpadding='0' cellspacing='0' align='center'><tr>
  <td class='result'>
     
    {* SHOW NO CLASSIFIED ENTRIES MESSAGE *}
    {if $search != ""}
      <img src='./images/icons/bulb16.gif' border='0' class='icon'>{$user_classified14}
    {else}
      <img src='./images/icons/bulb16.gif' border='0' class='icon'>{$user_classified15} <a href='user_classified_new.php'>{$user_classified16}</a> {$user_classified17}
    {/if}

  </td></tr></table>

{* DISPLAY CLASSIFIED LISTINGS *}
{else}

  {section name=classified_loop loop=$classifieds}

    <table cellpadding='0' cellspacing='0' width='100%'>
    {* CREATE CLASSIFIED ENTRY TITLE *}
    {if $classifieds[classified_loop].classified_title != ""}
      {assign var='classified_title' value=$classifieds[classified_loop].classified_title|truncate:70:"...":false|choptext:40:"<br>"}
    {else}
      {assign var='classified_title' value=$user_classified21}
    {/if}
    <tr>
    <td valign='top' style='padding-right: 10px; text-align: center;' width='1'><a href='{$url->url_create('classified', $user->user_info.user_username, $classifieds[classified_loop].classified_id)}'><img src='{$classifieds[classified_loop].classified->classified_photo("./images/nophoto.gif")}' border='0' class='photo' width='{$misc->photo_size($classifieds[classified_loop].classified->classified_photo("./images/nophoto.gif"),'100','100','w')}'></a></td>
    <td valign='top'>
      <div style='padding: 5px; background: #EEEEEE; font-weight: bold'>
        <div style='float: left;'><a href='{$url->url_create('classified', $user->user_info.user_username, $classifieds[classified_loop].classified_id)}'>{$classified_title}</a></div>
        <div style='text-align: right;'><a href='user_classified_edit_media.php?classified_id={$classifieds[classified_loop].classified_id}'>{$user_classified28}</a> | <a href='user_classified_edit.php?classified_id={$classifieds[classified_loop].classified_id}'>{$user_classified23}</a> | <a href='user_classified_delete.php?classified_id={$classifieds[classified_loop].classified_id}'>{$user_classified24}</a></div>
      </div>
      <div style='padding: 5px; vertical-align: top;'>
        <div style='color: #888888;'>
	  {$user_classified29} {$datetime->cdate("`$setting.setting_dateformat`", $datetime->timezone($classifieds[classified_loop].classified_date, $global_timezone))}, 
          <a href='{$url->url_create('classified', $user->user_info.user_username, $classifieds[classified_loop].classified_id)}'>{$classifieds[classified_loop].total_comments} {$user_classified22}</a>,
          {$classifieds[classified_loop].classified_views} {$user_classified30}
        </div>
	<div style='padding-top: 5px;'>{$classifieds[classified_loop].classified_body|truncate:500:"...":true|choptext:40:"<br>"}</div>
      </div>
    </td>
    </tr>
    </table>

    {* ADD SPACER *}
    {if $smarty.section.classified_loop.last != true}
      <div class='classified_spacer'>&nbsp;</div>
    {/if}

  {/section}
{/if}


{* DISPLAY PAGINATION MENU IF APPLICABLE *}
{if $maxpage > 1}
  <div class='center'>
  {if $p != 1}<a href='user_classified.php?search={$search}&p={math equation='p-1' p=$p}'>&#171; {$user_classified9}</a>{else}<font class='disabled'>&#171; {$user_classified9}</font>{/if}
  {if $p_start == $p_end}
    &nbsp;|&nbsp; {$user_classified10} {$p_start} {$user_classified11} {$total_classifieds} &nbsp;|&nbsp; 
  {else}
    &nbsp;|&nbsp; {$user_classified12} {$p_start}-{$p_end} {$user_classified11} {$total_classifieds} &nbsp;|&nbsp; 
  {/if}
  {if $p != $maxpage}<a href='user_classified.php?search={$search}&p={math equation='p+1' p=$p}'>{$user_classified13} &#187;</a>{else}<font class='disabled'>{$user_classified13} &#187;</font>{/if}
  </div>
  <br>
{/if}

{include file='footer.tpl'}