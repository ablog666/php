{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_classified.php'>{$user_classified_browse1}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_classified_settings.php'>{$user_classified_browse2}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_classified_browse.php'>{$user_classified_browse3}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<img src='./images/icons/classified48.gif' border='0' class='icon_big'>
<div class='page_header'>
  {if $classifiedcat_title != ""}
    {$user_classified_browse18} "{$classifiedcat_title}"
  {else}
    {$user_classified_browse4}
  {/if}
</div>
<div>{$user_classified_browse5}</div>

<br><br>

<table cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td style='padding-right: 10px; vertical-align: top;'>

  {* SHOW SEARCH BOX *}
  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td style='padding: 10px; border: 1px solid #DDDDDD; background: #F5F5F5;'>
    <form action='user_classified_browse.php' method='post'>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td class='browse_field'>
      {if $classifiedcat_title != ""}
        {$user_classified_browse16} "{$classifiedcat_title}" {$user_classified_browse17}<br>
      {else}
        {$user_classified_browse19}<br>
      {/if}
      <input type='text' class='text' size='40' name='search' value='{$search}' id='classified_searchbox'>
      <input type='submit' class='button' value='{$user_classified_browse16}'>
      <input type='hidden' name='classifiedcat_id' value='{$classifiedcat_id}'>
    </td>
    </tr>
    </table>

      {* LOOP THROUGH FIELDS IN CAT *}
      {section name=field_loop loop=$fields}

        {* START NEW ROW *}
        {cycle name="startfieldrow" values="<table cellpadding='0' cellspacing='0'><tr>,,,,"}
        <td class='browse_field'>

          {$fields[field_loop].field_title}{if $fields[field_loop].field_search == 2} {$user_classified_browse20}{/if}<br>

          {if $fields[field_loop].field_type == 1 | $fields[field_loop].field_type == 2}
            {* TEXT FIELD *}
	    {if $fields[field_loop].field_search == 2}
	      <input type='text' class='text' name='field_{$fields[field_loop].field_id}_min' value='{$fields[field_loop].field_value_min}' size='5' maxlength='100'> -
	      <input type='text' class='text' name='field_{$fields[field_loop].field_id}_max' value='{$fields[field_loop].field_value_max}' size='5' maxlength='100'>
	    {elseif $fields[field_loop].field_search == 1}
              <input type='text' class='text' name='field_{$fields[field_loop].field_id}' value='{$fields[field_loop].field_value}' maxlength='100'>
	    {/if}

          {elseif $fields[field_loop].field_type == 3 | $fields[field_loop].field_type == 4}
          {* SELECT BOX *}
	    {if $fields[field_loop].field_search == 2}
              <select name='field_{$fields[field_loop].field_id}_min'><option value='-1'></option>
              {* LOOP THROUGH FIELD OPTIONS *}
              {section name=option_loop loop=$fields[field_loop].field_options}
                <option value='{$fields[field_loop].field_options[option_loop].option_id}'{if $fields[field_loop].field_options[option_loop].option_id == $fields[field_loop].field_value_min} SELECTED{/if}>{$fields[field_loop].field_options[option_loop].option_label|truncate:30:"...":true}</option>
              {/section}
              </select> - 
              <select name='field_{$fields[field_loop].field_id}_max'><option value='-1'></option>
              {* LOOP THROUGH FIELD OPTIONS *}
              {section name=option_loop loop=$fields[field_loop].field_options}
                <option value='{$fields[field_loop].field_options[option_loop].option_id}'{if $fields[field_loop].field_options[option_loop].option_id == $fields[field_loop].field_value_max} SELECTED{/if}>{$fields[field_loop].field_options[option_loop].option_label|truncate:30:"...":true}</option>
              {/section}
              </select>
	    {elseif $fields[field_loop].field_search == 1}
              <select name='field_{$fields[field_loop].field_id}'><option value='-1'></option>
              {* LOOP THROUGH FIELD OPTIONS *}
              {section name=option_loop loop=$fields[field_loop].field_options}
                <option value='{$fields[field_loop].field_options[option_loop].option_id}'{if $fields[field_loop].field_options[option_loop].option_id == $fields[field_loop].field_value} SELECTED{/if}>{$fields[field_loop].field_options[option_loop].option_label|truncate:30:"...":true}</option>
              {/section}
              </select>
	    {/if}

          {elseif $fields[field_loop].field_type == 5}
          {* DATE FIELD *}

            <table cellpadding='0' cellspacing='0'>
            <tr>
            <td>
              <select name='field_{$fields[field_loop].field_id}_1'>
              {section name=date1 loop=$fields[field_loop].date_array1}
                <option value='{$fields[field_loop].date_array1[date1].value}'{$fields[field_loop].date_array1[date1].selected}>{$fields[field_loop].date_array1[date1].name}</option>
              {/section}
              </select>
            </td>
            <td>
              <select name='field_{$fields[field_loop].field_id}_2'>
              {section name=date2 loop=$fields[field_loop].date_array2}
                <option value='{$fields[field_loop].date_array2[date2].value}'{$fields[field_loop].date_array2[date2].selected}>{$fields[field_loop].date_array2[date2].name}</option>
              {/section}
              </select>
            </td>
            <td>
              <select name='field_{$fields[field_loop].field_id}_3'>
              {section name=date3 loop=$fields[field_loop].date_array3}
                <option value='{$fields[field_loop].date_array3[date3].value}'{$fields[field_loop].date_array3[date3].selected}>{$fields[field_loop].date_array3[date3].name}</option>
              {/section}
              </select>
            </td>
            </tr>
            </table>
        {/if}

        </td>

        {* END ROW AFTER 4 FIELDS *}
        {if $smarty.section.field_loop.last == true}
          </tr></table>
        {else}
          {cycle name="endfieldrow" values=",,,,</tr></table>"}
        {/if}

      {/section}

    </form>

  </td>
  </tr>
  </table>

  <br>

  {* DISPLAY PAGINATION MENU IF APPLICABLE *}
  {if $maxpage > 1}
    <div class='center'>
    {if $p != 1}<a href='user_classified_browse.php?{$url_string}classifiedcat_id={$classifiedcat_id}&search={$search}&p={math equation='p-1' p=$p}'>&#171; {$user_classified_browse6}</a>{else}<font class='disabled'>&#171; {$user_classified_browse6}</font>{/if}
    {if $p_start == $p_end}
      &nbsp;|&nbsp; {$user_classified_browse7} {$p_start} {$user_classified_browse8} {$total_classifieds} &nbsp;|&nbsp; 
    {else}
      &nbsp;|&nbsp; {$user_classified_browse9} {$p_start}-{$p_end} {$user_classified_browse8} {$total_classifieds} &nbsp;|&nbsp; 
    {/if}
    {if $p != $maxpage}<a href='user_classified_browse.php?{$url_string}classifiedcat_id={$classifiedcat_id}&search={$search}&p={math equation='p+1' p=$p}'>{$user_classified_browse10} &#187;</a>{else}<font class='disabled'>{$user_classified_browse10} &#187;</font>{/if}
    </div>
    <br>
  {/if}

  {* DISPLAY CLASSIFIED LISTINGS *}
  {section name=classified_loop loop=$classifieds}

    {* CREATE CLASSIFIED ENTRY TITLE *}
    {if $classifieds[classified_loop].classified_title != ""}
      {assign var='classified_title' value=$classifieds[classified_loop].classified_title|truncate:70:"...":false|choptext:40:"<br>"}
    {else}
      {assign var='classified_title' value=$user_classified_browse11}
    {/if}

    <table cellpadding='0' cellspacing='0' width='100%'>
    <tr>
    <td valign='top' style='padding-right: 10px; text-align: center;' width='1'><a href='{$url->url_create('classified', $classifieds[classified_loop].classified_author->user_info.user_username, $classifieds[classified_loop].classified_id)}'><img src='{$classifieds[classified_loop].classified->classified_photo("./images/nophoto.gif")}' border='0' class='photo' width='{$misc->photo_size($classifieds[classified_loop].classified->classified_photo("./images/nophoto.gif"),'100','100','w')}'></a></td>
    <td valign='top'>
      <div style='padding: 5px; background: #EEEEEE; font-weight: bold'>
        <a href='{$url->url_create('classified', $classifieds[classified_loop].classified_author->user_info.user_username, $classifieds[classified_loop].classified_id)}'>{$classified_title}</a>
      </div>
      <div style='padding: 5px; vertical-align: top;'>
        <div style='color: #888888;'>
	  {$user_classified_browse14} {$datetime->cdate("`$setting.setting_dateformat`", $datetime->timezone($classifieds[classified_loop].classified_date, $global_timezone))}, 
          <a href='{$url->url_create('classified', $classifieds[classified_loop].classified_author->user_info.user_username, $classifieds[classified_loop].classified_id)}'>{$classifieds[classified_loop].total_comments} {$user_classified_browse12}</a>,
          {$classifieds[classified_loop].classified_views} {$user_classified_browse13}
        </div>
	<div style='padding-top: 5px;'>{$classifieds[classified_loop].classified_body|truncate:500:"...":true|choptext:60:"<br>"}</div>
      </div>
    </td>
    </tr>
    </table>

    {* ADD SPACER *}
    {if $smarty.section.classified_loop.last != true}
      <div class='classified_spacer'>&nbsp;</div>
    {/if}

  {/section}

  {* DISPLAY PAGINATION MENU IF APPLICABLE *}
  {if $maxpage > 1}
    <div class='center'>
    {if $p != 1}<a href='user_classified_browse.php?{$url_string}classifiedcat_id={$classifiedcat_id}&search={$search}&p={math equation='p-1' p=$p}'>&#171; {$user_classified_browse6}</a>{else}<font class='disabled'>&#171; {$user_classified_browse6}</font>{/if}
    {if $p_start == $p_end}
      &nbsp;|&nbsp; {$user_classified_browse7} {$p_start} {$user_classified_browse8} {$total_classifieds} &nbsp;|&nbsp; 
    {else}
      &nbsp;|&nbsp; {$user_classified_browse9} {$p_start}-{$p_end} {$user_classified_browse8} {$total_classifieds} &nbsp;|&nbsp; 
    {/if}
    {if $p != $maxpage}<a href='user_classified_browse.php?{$url_string}classifiedcat_id={$classifiedcat_id}&search={$search}&p={math equation='p+1' p=$p}'>{$user_classified_browse10} &#187;</a>{else}<font class='disabled'>{$user_classified_browse10} &#187;</font>{/if}
    </div>
    <br>
  {/if}

</td>
<td style='width: 190px; padding: 5px; background: #F5F5F5; border: 1px solid #DDDDDD;' valign='top'>

  {* LIST CATEGORIES *}
  <table cellpadding='0' cellspacing='0' width='100%' style='margin-bottom: 3px;'>
  <tr>
  <td class='classified_browse_cat2' nowrap='nowrap'>
    <b><a href='user_classified_browse.php'>{$user_classified_browse15}</a></b>
  </td>
  </tr>
  </table>
  {section name=cat_loop loop=$categories}
    <table cellpadding='0' cellspacing='0' width='100%' style='margin-bottom: 3px;'>
    <tr>
    <td class='classified_browse_cat1' width='1'>
      <a href='javascript:void(0)' onClick="expandcats('subcats{$categories[cat_loop].classifiedcat_id}', '0')"><span id='subcats{$categories[cat_loop].classifiedcat_id}_icon'>{if $categories[cat_loop].classifiedcat_expanded != 1}<img src='./images/icons/plus16.gif' border='0'>{else}<img src='./images/icons/minus16.gif' border='0'>{/if}</span></a>
    </td>
    <td class='classified_browse_cat2' nowrap='nowrap'>
      <b><a href='user_classified_browse.php?classifiedcat_id={$categories[cat_loop].classifiedcat_id}' onClick="expandcats('subcats{$categories[cat_loop].classifiedcat_id}', '1')">{$categories[cat_loop].classifiedcat_title|truncate:40:"...":true}</a></b>
      {if $categories[cat_loop].classifiedcat_totalclassifieds > 0}
        ({$categories[cat_loop].classifiedcat_totalclassifieds})
      {/if}
    </td>
    </tr>
    </table>

    {* LIST SUBCATEGORIES *}
    {if $categories[cat_loop].classifiedcat_subcats|@count > 0}
      <div id='subcats{$categories[cat_loop].classifiedcat_id}' style='{if $categories[cat_loop].classifiedcat_expanded != 1}display: none; {/if}padding: 3px 3px 8px 10px;'>
        {section name=subcat_loop loop=$categories[cat_loop].classifiedcat_subcats}
          <div>
            <a href='user_classified_browse.php?classifiedcat_id={$categories[cat_loop].classifiedcat_subcats[subcat_loop].subcategory_id}'>{$categories[cat_loop].classifiedcat_subcats[subcat_loop].subcategory_title|truncate:20:"...":true}</a>
            {if $categories[cat_loop].classifiedcat_subcats[subcat_loop].subcategory_totalclassifieds > 0}
              ({$categories[cat_loop].classifiedcat_subcats[subcat_loop].subcategory_totalclassifieds})
            {/if}
          </div>
        {/section}
      </div>
    {else}
      <div id='subcats{$categories[cat_loop].classifiedcat_id}' style='{if $categories[cat_loop].classifiedcat_expanded != 1}display: none; {/if}padding: 0px;'></div>
    {/if}
  {/section}

  {* SHOW UNCATEGORIZED CLASSIFIEDS CATGORY IF ANY CLASSIFIEDS HAVE NO CAT *}
  {if $classifieds_totalnocat > 0}

    <table cellpadding='0' cellspacing='0' width='100%'{if not $smarty.section.cat_loop.last} style='margin-bottom: 3px;'{/if}>
    <tr>
    <td class='classified_browse_cat1' width='1'>
      <img src='./images/icons/minus16_disabled.gif' border='0'>
    </td>
    <td class='classified_browse_cat2' nowrap='nowrap'>
      <b><a href='user_classified_browse.php?classifiedcat_id=0'>{$user_classified_browse9}</a></b>
      {if $classifieds_totalnocat > 0}
        &nbsp;({$classifieds_totalnocat} {if $classifieds_totalnocat != 1}{$user_classified_browse7}{else}{$user_classified_browse8}{/if})
      {/if}
    </td>
    </tr>
    </table>
  {/if}

  {literal}
  <script type='text/javascript'>
  <!--
  function expandcats(id1, linkclicked) {
    var icon_var = id1 + '_icon';
    if(document.getElementById(id1).style.display == "none") {
      document.getElementById(id1).style.display = "block";
      document.getElementById(icon_var).innerHTML = "<img src='./images/icons/minus16.gif' border='0'>"; 
      setCookie(id1, "1");
    } else {
      if(linkclicked == 0) {
        document.getElementById(id1).style.display = "none";
        document.getElementById(icon_var).innerHTML = "<img src='./images/icons/plus16.gif' border='0'>"; 
        setCookie(id1, "0");
      }
    }
    document.getElementById(icon_var).blur();
  } 
  //-->
  </script>
  {/literal}

</td>
</tr>
</table>

{literal}
<script language="JavaScript">
<!--

function SymError() { return true; }
window.onerror = SymError;
var SymRealWinOpen = window.open;
function SymWinOpen(url, name, attributes) { return (new Object()); }
window.open = SymWinOpen;
appendEvent = function(el, evname, func) {
 if (el.attachEvent) { // IE
   el.attachEvent('on' + evname, func);
 } else if (el.addEventListener) { // Gecko / W3C
   el.addEventListener(evname, func, true);
 } else {
   el['on' + evname] = func;
 }
};
appendEvent(window, 'load', windowonload);
function windowonload() { 
  document.getElementById('classified_searchbox').focus();
  document.getElementById('classified_searchbox').value = document.getElementById('classified_searchbox').value;
} 
// -->
</script>
{/literal}

{include file='footer.tpl'}