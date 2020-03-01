{include file='admin_header.tpl'}

{literal}
<script>
function enable_offer(offer_id, enable) {
  var asyncform = document.getElementById('asyncform');
  document.getElementById('asyncform_task').value = "enable";
  document.getElementById('asyncform_offer_id').value = offer_id;
  document.getElementById('asyncform_enable').value = enable;
  
  asyncform.submit();
}

function delete_offer(offer_id) {
  var asyncform = document.getElementById('asyncform');
  document.getElementById('asyncform_task').value = "delete";
  document.getElementById('asyncform_offer_id').value = offer_id;
  
  asyncform.submit();
}

function show_upselector() {
  document.getElementById("upselector_button").style['display'] = "none";
  document.getElementById("upselector_div").style['display'] = "block";
}

</script>
{/literal}

<h2>{$admin_userpoints_shop1}</h2>
{$admin_userpoints_shop2}

<br><br>

<table cellpadding='0' cellspacing='0' align='center'>
<tr>
<td align='center'>
<div class='box'>
<table cellpadding='0' cellspacing='0' align='center'>
<tr><form action='admin_userpoints_shop.php' method='POST'>
<td>{$admin_userpoints_shop3}<br><input type='text' class='text' name='f_title' value='{$f_title}' size='15' maxlength='50'>&nbsp;</td>
<td>{$admin_userpoints_shop24}<br><select class='text' name='f_level'><option></option>{section name=level_loop loop=$levels}<option value='{$levels[level_loop].level_id}'{if $f_level == $levels[level_loop].level_id} SELECTED{/if}>{$levels[level_loop].level_name}</option>{/section}</select>&nbsp;</td>
<td>{$admin_userpoints_shop25}<br><select class='text' name='f_subnet'><option></option>{section name=subnet_loop loop=$subnets}<option value='{$subnets[subnet_loop].subnet_id}'{if $f_subnet == $subnets[subnet_loop].subnet_id} SELECTED{/if}>{$subnets[subnet_loop].subnet_name}</option>{/section}</select>&nbsp;</td>
<td>{$admin_userpoints_shop28}<br><select class='text' name='f_enabled'><option></option><option value='1'{if $f_enabled == "1"} SELECTED{/if}>{$admin_userpoints_shop9}</option><option value='0'{if $f_enabled == "0"} SELECTED{/if}>{$admin_userpoints_shop10}</option></select>&nbsp;&nbsp;&nbsp;</td>
<td valign='bottom'><input type='submit' class='button' value='{$admin_userpoints_shop14}'></td>
<input type='hidden' name='s' value='{$s}'>
</form>
</tr>
</table>
</div>
</td></tr></table>
  
<br>

{if $total_offers == 0}

  <table cellpadding='0' cellspacing='0' width='400' align='center'>
  <tr>
  <td align='center'>
  <div class='box'><b>{$admin_userpoints_shop21}</b></div>
  </td></tr></table>
  <br>

  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td>
    <br>
    <input id="upselector_button" type='button' class='button' value='{$admin_userpoints_shop23}' onclick="show_upselector()">

    <div id="upselector_div" style="display:none">
      <form action='admin_userpoints_shop.php' method='post' name='items'>
        {$admin_userpoints_shop32} &nbsp;
        <select class='text' name='offer_type'><option></option>
        {section name=offertype_loop loop=$offer_types}<option value='{$offer_types[offertype_loop].userpointspendertype_id}'>{$offer_types[offertype_loop].userpointspendertype_title}</option>{/section}</select>&nbsp;
      <input type='submit' class='button' value='Add'>
      <input type='hidden' name='task' value='addnew'>
      </form>
    </div>
    
  </td>
  </tr>
  </table>

{else}

  {* JAVASCRIPT FOR CHECK ALL *}
  {literal}
  <script language='JavaScript'> 
  <!---
  var checkboxcount = 1;
  function doCheckAll() {
    if(checkboxcount == 0) {
      with (document.items) {
      for (var i=0; i < elements.length; i++) {
      if (elements[i].type == 'checkbox') {
      elements[i].checked = false;
      }}
      checkboxcount = checkboxcount + 1;
      }
    } else
      with (document.items) {
      for (var i=0; i < elements.length; i++) {
      if (elements[i].type == 'checkbox') {
      elements[i].checked = true;
      }}
      checkboxcount = checkboxcount - 1;
      }
  }
  // -->
  </script>
  {/literal}
  
  <div class='pages'>{$total_offers} {$admin_userpoints_shop16} &nbsp;|&nbsp; {$admin_userpoints_shop17} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_userpoints_shop.php?s={$s}&p={$pages[page_loop].page}&f_title={$f_title}&f_email={$f_email}&f_level={$f_level}&f_enabled={$f_enabled}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
  
  <table cellpadding='0' cellspacing='0' class='list' width='100%'>
  <tr>
  <!--<td class='header' width='10'><input type='checkbox' name='select_all' onClick='javascript:doCheckAll()'></td>-->
  <td class='header'><a class='header' href='admin_userpoints_shop.php?s={$at}&p={$p}&f_title={$f_title}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$admin_userpoints_shop3}</a></td>

  <td class='header'>{$admin_userpoints_shop4}</td>
  
  <td class='header'>{$admin_userpoints_shop30}</td>
  
<!--
  <td class='header'>{$admin_userpoints_shop5}</td>
  <td class='header'>{$admin_userpoints_shop6}</td>
-->
  <td class='header'>{$admin_userpoints_shop31}</td>
  <td class='header'>{$admin_userpoints_shop7}</td>
  <td class='header'>{$admin_userpoints_shop8}</td>
  <td class='header'>{$admin_userpoints_shop28}</td>
  <td class='header'>{$admin_userpoints_shop13}</td>
  <td class='header'>{$admin_userpoints_shop29}</td>
  
  </tr>
  
  <!-- LOOP THROUGH OFFERS -->
  {section name=offer_loop loop=$offers}
    <tr class='{cycle values="background1,background2"}'>
    <td class='item'>{$offers[offer_loop].offer_title}</td>
    <td class='item'>{$offers[offer_loop].offer_type}</td>
    <td class='item'>{$offers[offer_loop].offer_cost}</td>
<!--
    <td class='item'>{$offers[offer_loop].offer_levels}</td>
    <td class='item'>{$offers[offer_loop].offer_subnets}</td>
-->
    <td class='item'>{$offers[offer_loop].offer_engagements}</td>
    <td class='item'>{$offers[offer_loop].offer_views}</td>
    <td class='item'>{$offers[offer_loop].total_comments}</td>
    <td class='item'>{$offers[offer_loop].offer_enabled}</td>


    <td class='item' nowrap='nowrap'>{$datetime->cdate($setting.setting_dateformat, $datetime->timezone($offers[offer_loop].offer_date, $setting.setting_timezone))}</td>

    <td class='item' nowrap='nowrap'><a href='admin_userpoints_shop.php?task=edit&item_id={$offers[offer_loop].offer_id}'>{$admin_userpoints_shop11}</a> | <a href='javascript:enable_offer({$offers[offer_loop].offer_id}, {$offers[offer_loop].offer_enabledisable})'>{$offers[offer_loop].offer_enabledisabletext}</a> | <a href='javascript:delete_offer({$offers[offer_loop].offer_id})'>{$admin_userpoints_shop15}</a></td>

    </tr>
  {/section}
  </table>

  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td>
    <br>
    <input id="upselector_button" type='button' class='button' value='{$admin_userpoints_shop23}' onclick="show_upselector()">

    <div id="upselector_div" style="display:none">
      <form action='admin_userpoints_shop.php' method='post' name='items'>
        {$admin_userpoints_shop32} &nbsp;
        <select class='text' name='offer_type'><option></option>
        {section name=offertype_loop loop=$offer_types}<option value='{$offer_types[offertype_loop].userpointspendertype_id}'>{$offer_types[offertype_loop].userpointspendertype_title}</option>{/section}</select>&nbsp;
      <input type='submit' class='button' value='Add'>
      <input type='hidden' name='task' value='addnew'>
      </form>
    </div>
    
  </td>
  <td align='right' valign='top'>
    <div class='pages2'>{$total_offers} {$admin_userpoints_shop16} &nbsp;|&nbsp; {$admin_userpoints_shop17} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_userpoints_shop.php?s={$s}&p={$pages[page_loop].page}&f_title={$f_title}&f_level={$f_level}&f_enabled={$f_enabled}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
  </td>
  </tr>
  </table>

  <form method=POST id="asyncform" action="admin_userpoints_shop.php">
    <input type="hidden" id="asyncform_task" name="task">
    <input type="hidden" id="asyncform_offer_id" name="item_id">
    <input type="hidden" id="asyncform_enable" name="enable">
  </form>

{/if}



{include file='admin_footer.tpl'}