{include file='header.tpl'}

<link rel="stylesheet" href="./templates/styles_userpoints.css" title="stylesheet" type="text/css">  

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_vault.php'>{$user_points_shop1}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_points_transactions.php'>{$user_points_shop2}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_points_offers.php'>{$user_points_shop3}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_points_shop.php'>{$user_points_shop4}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_points_faq.php'>{$user_points_shop5}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<img style="margin-left:5px;margin-right:10px;" src='./images/icons/userpoints_coins48.png' border='0' class='icon_big'>
<div class='page_header'>{$user_points_shop11}</div>
<div>{$user_points_shop12}</div>

<br>
<br>

<table cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td style='padding-right: 10px; vertical-align: top;'>

  {* SHOW SEARCH BOX *}
  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td style='padding: 10px; border: 1px solid #DDDDDD; background: #F5F5F5;'>
    <form action='user_points_shop.php' method='GET'>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td class='browse_field'>
        {$user_points_shop13}<br>
      <input type='text' class='text' size='40' name='search' value='{$search}'>
      <input type='submit' class='button' value='Search'>
    </td>
    </tr>
    </table>

    </form>

  </td>
  </tr>
  </table>

  <br>

  {* DISPLAY PAGINATION MENU IF APPLICABLE *}
  {if $maxpage > 1}
    <div class='center'>
    {if $p != 1}<a href='user_points_shop.php?search={$search}&tag={$tag}&p={math equation='p-1' p=$p}'>&#171; {$user_points_shop6}</a>{else}<font class='disabled'>&#171; {$user_points_shop6}</font>{/if}
    {if $p_start == $p_end}
      &nbsp;|&nbsp; {$user_points_shop7} {$p_start} {$user_points_shop8} {$total_items} &nbsp;|&nbsp; 
    {else}
      &nbsp;|&nbsp; {$user_points_shop9} {$p_start}-{$p_end} {$user_points_shop8} {$total_items} &nbsp;|&nbsp; 
    {/if}
    {if $p != $maxpage}<a href='user_points_shop.php?search={$search}&tag={$tag}&p={math equation='p+1' p=$p}'>{$user_points_shop10} &#187;</a>{else}<font class='disabled'>{$user_points_shop10} &#187;</font>{/if}
    </div>
    <br>
  {/if}


{* DISPLAY MESSAGE IF NO ITEMS *}
{if $total_items == 0}
  <table cellpadding='0' cellspacing='0' align='center'><tr>
  <td class='result'>
     
    {if $search != ""}
      <img src='./images/icons/bulb16.gif' border='0' class='icon'>{$user_points_shop20}
    {else}
      <img src='./images/icons/bulb16.gif' border='0' class='icon'>{$user_points_shop21}
    {/if}

  </td></tr></table>

{* DISPLAY ITEMS *}
{/if}


  {* DISPLAY ITEMS *}
  {section name=item_loop loop=$items}

    <table cellpadding='0' cellspacing='0' width='100%'>
    <tr>
    <td valign='top' style='padding-right: 10px; text-align: center;' width='100px'><a href='user_points_shop_item.php?shopitem_id={$items[item_loop].userpointspender_id}'><img src='{$items[item_loop].userpointspender_photo}' border='0' class='photo' width='{$misc->photo_size($items[item_loop].userpointspender_photo,'100','100','w')}'></a></td>
    <td valign='top'>
      <div style='padding: 5px; background: #EEEEEE; font-weight: bold'>
        <div style='float: left;'><a href='user_points_shop_item.php?shopitem_id={$items[item_loop].userpointspender_id}'>{$items[item_loop].userpointspender_title|truncate:70:"...":false|choptext:40:"<br>"}</a></div>
		<div style='text-align: right;'> <a href='#' onclick="return false"> &nbsp;<!--Buy--></a></div>
      </div>
      <div style='padding: 5px; vertical-align: top;'>
        <div style='color: #888888;'>
	  {$user_points_shop14} {$datetime->cdate("`$setting.setting_dateformat`", $datetime->timezone($items[item_loop].userpointspender_date, $global_timezone))}, 
          <a href='#' onclick="return false">{$items[item_loop].userpointspender_comments} {$user_points_shop16}</a>,
          {$items[item_loop].userpointspender_views} {$user_points_shop15}
        </div>
	<div style='padding-top: 5px;'>{$items[item_loop].userpointspender_body|truncate:500:"...":true|choptext:60:"<br>"}</div>
      </div>
    </td>
    </tr>
    </table>

    {* ADD SPACER *}
    {if $smarty.section.item_loop.last != true}
      <div class='xxspacer'>&nbsp;</div>
    {/if}

  {/section}

  <br><br>

  {* DISPLAY PAGINATION MENU IF APPLICABLE *}
  {if $maxpage > 1}
    <div class='center'>
    {if $p != 1}<a href='user_points_shop.php?search={$search}&tag={$tag}&p={math equation='p-1' p=$p}'>&#171; {$user_points_shop6}</a>{else}<font class='disabled'>&#171; {$user_points_shop6}</font>{/if}
    {if $p_start == $p_end}
      &nbsp;|&nbsp; {$user_points_shop7} {$p_start} {$user_points_shop8} {$total_items} &nbsp;|&nbsp; 
    {else}
      &nbsp;|&nbsp; {$user_points_shop9} {$p_start}-{$p_end} {$user_points_shop8} {$total_items} &nbsp;|&nbsp; 
    {/if}
    {if $p != $maxpage}<a href='user_points_shop.php?search={$search}&tag={$tag}&p={math equation='p+1' p=$p}'>{$user_points_shop10} &#187;</a>{else}<font class='disabled'>{$user_points_shop10} &#187;</font>{/if}
    </div>
    <br>
  {/if}

</td>
<td style='width: 190px; padding: 5px; background: #F5F5F5; border: 1px solid #DDDDDD;' valign='top'>

<div style="text-align:center;padding-bottom: 10px">
  {$user_points_shop17}
</div>

<div style="line-height:200%">
  {$tagcloud}
</div>

</td>
</tr>
</table>

{include file='footer.tpl'}