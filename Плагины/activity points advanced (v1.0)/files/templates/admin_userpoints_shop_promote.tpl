{include file='admin_header.tpl'}

{literal}
<script src="../include/js/semods.js"></script>
<script src="../include/js/semods.controls.multiselect.js"></script>

<script>
function init_multiselects() {
  new SEMods.Controls.MultiSelect( "offer_levels" );
  new SEMods.Controls.MultiSelect( "offer_subnets" );
}

SEMods.B.register_onload( init_multiselects );
</script>

  
<style>

.multiSelect {
  background:#FFFFFF url('../images/apps_dropdown.gif') no-repeat scroll right center;
  border:1px solid #BBBBBB;
  display:inline;
  padding:2px 20px 2px 4px;
  width:200px;
  
  Xoverflow: hidden;
}
.multiSelect.hover {
  background:transparent url('../images/apps_dropdown_hover.gif') no-repeat scroll right center;
}
.multiSelect.active, .multiSelect.focus {
  border:1px inset #000000;
}
.multiSelect.active {
  background:transparent url('../images/apps_dropdown_active.gif') no-repeat scroll right center;
}
.multiSelectOptions {
  background:#FFFFFF none repeat scroll 0%;
  border:1px solid #B2B2B2;
  margin-top:-1px;
  max-height:150px;
  overflow:auto;
  Xwidth:206px;
  width:198px;
}
.multiSelectOptions label {
  display:block;
  padding:2px 5px;
}
.multiSelectOptions label.checked {
  background:#E6E6E6 none repeat scroll 0%;
}
.multiSelectOptions label.selectAll {
  border-bottom:1px dotted #CCCCCC;
}
.multiSelectOptions label.hover {
  background:#CFCFCF none repeat scroll 0%;
}

iframe.layerfix {
  display:none;/*sorry for IE5*/
  display/**/:block;/*sorry for IE5*/
  position:absolute;/*must have*/
  top:0;/*must have*/
  left:0;/*must have*/
  z-index:1;/*must have*/
  filter:mask();/*must have*/
  Xwidth:3000px;/*must have for any big value*/
  Xheight:3000px/*must have for any big value*/;
}

table.tabs {
	margin-bottom: 12px;
}
td.tab {
	background: #FFFFFF;
	padding-left: 1px;
	border-bottom: 1px solid #CCCCCC;
}
td.tab0 {
	font-size: 1pt;
	padding-left: 7px;
	border-bottom: 1px solid #CCCCCC;
}
td.tab1 {
	border: 1px solid #CCCCCC;
	border-top: 3px solid #AAAAAA;
	border-bottom: none;
	font-weight: bold;
	padding: 6px 8px 6px 8px;
}
td.tab2 {
	background: #F8F8F8;
	border: 1px solid #CCCCCC;
	border-top: 3px solid #CCCCCC;
	font-weight: bold;
	padding: 6px 8px 6px 8px;
}
td.tab3 {
	background: #FFFFFF;
	border-bottom: 1px solid #CCCCCC;
	padding-right: 12px;
	width: 100%;
	text-align: right;
	vertical-align: middle;
}
.tabs A {
  text-decoration: none;
}

.tabs A:hover {
  text-decoration: underline;
}

</style>
{/literal}


<h2>{$admin_userpoints_shop_promote1}</h2>
{$admin_userpoints_shop_promote2}

<br><br>
<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab1' NOWRAP>{if $item_id !=0}<a href='admin_userpoints_shop.php?task=edit&item_id={$item_id}'>{$admin_userpoints_shop_promote40}{else}{$admin_userpoints_shop_promote40}{/if}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP>{if $item_id !=0}<a href='admin_userpoints_shopphoto.php?item_id={$item_id}'>{$admin_userpoints_shop_promote41}</a>{else}{$admin_userpoints_shop_promote41}{/if}</td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP>{if $item_id !=0}<a href='admin_userpoints_shopcomments.php?item_id={$item_id}'>{$admin_userpoints_shop_promote42}</a>{else}{$admin_userpoints_shop_promote42}{/if}</td>
<td class='tab3'>&nbsp;<a href='admin_userpoints_shop.php'>&#171; &nbsp; {$admin_userpoints_shop_promote43}</a></td>
</tr>
</table>

<br>

{if $is_error != 0}
<div class='error'><img src='../images/error.gif' border='0' class='icon'> {$error_message}</div>
{elseif $result == 1}
<div class='success'><img src='../images/success.gif' border='0' class='icon'> {$admin_userpoints_shop_promote39}</div>
{/if}

<table cellpadding='0' cellspacing='0'>
<form action='admin_userpoints_shop_promote.php' method='POST'>
<tr>
<td class='form1'>{$admin_userpoints_shop_promote3}</td>
<td class='form2'><input style="width:500px" type='text' class='text' name='offer_title' value='{$offer_title}' size='40' maxlength='50'></td>
</tr>

<tr>
<td class='form1'>{$admin_userpoints_shop_promote4}</td>
<td class='form2'><textarea style="width:500px" name='offer_desc' rows='4' cols='40' class='text'>{$offer_desc}</textarea></td>
</tr>

<tr>
<td class='form1'>{$admin_userpoints_shop_promote8}</td>
<td class='form2'><input type='text' class='text' name='offer_cost' value='{$offer_cost}' size='40' maxlength='50'></td>
</tr>

<tr>
<td class='form1'>{$admin_userpoints_shop_promote20}</td>
<td class='form2'>
  <select class='text' name='promotion_template'>
    {section name=p_loop loop=$promotion_templates}
    <option value='{$promotion_templates[p_loop].ad_id}'{if $promotion_template == $promotion_templates[p_loop].ad_id} SELECTED{/if}>{$promotion_templates[p_loop].ad_name}</option>
    {/section}
  </select>
</td>
</tr>

<script>
var promotion_types = eval({$promotion_types_js});
</script>

{literal}
<script>
function promotion_type_onchange() {
  var promotiontype_id = document.getElementById('promotion_type').value;
  for(var i=0;i<promotion_types.length;i++) {
    elem = document.getElementById('promotion_html_div_'+promotion_types[i].promotiontype_id).style.display = 'none';
  }
  if(promotiontype_id != '')
    elem = document.getElementById('promotion_html_div_'+promotiontype_id).style.display = 'block';
}

function reset_html(pid) {
  for(var i=0;i<promotion_types.length;i++) {
    if(promotion_types[i].promotiontype_id == pid)
      document.getElementById('promotion_html_'+promotion_types[i].promotiontype_id).value = promotion_types[i].promotiontype_html;
  }
}

</script>
{/literal}

<tr>
<td class='form1'>{$admin_userpoints_shop_promote21}</td>
<td class='form2'>
  <select class='text' id='promotion_type' name='promotion_type' onchange="promotion_type_onchange()">
    <option></option>
    {section name=pt_loop loop=$promotion_types}
    <option value='{$promotion_types[pt_loop].promotiontype_id}'{if $promotion_type == $promotion_types[pt_loop].promotiontype_id} SELECTED{/if}>{$promotion_types[pt_loop].promotiontype_name}</option>
    {/section}
  </select>
</td>
</tr>


<tr>
<td class='form1'>{$admin_userpoints_shop_promote22}</td>
<td class='form2'>
    {section name=pt_loop1 loop=$promotion_types}
    <div id='promotion_html_div_{$promotion_types[pt_loop1].promotiontype_id}' style="display: {if $promotion_type == $promotion_types[pt_loop1].promotiontype_id}block{else}none{/if}">  
   <textarea id='promotion_html_{$promotion_types[pt_loop1].promotiontype_id}' name='promotion_html[{$promotion_types[pt_loop1].promotiontype_id}]' rows='4' cols='90' class='text'>{if $promotion_type == $promotion_types[pt_loop1].promotiontype_id}{$promotion_html}{else}{$promotion_types[pt_loop1].promotiontype_html}{/if}</textarea>
   <br><a href="javascript:reset_html({$promotion_types[pt_loop1].promotiontype_id})"> {$admin_userpoints_shop_promote18} </a>
   </div>
    {/section}
  
</td>
</tr>

<tr>
<td class='form1'>{$admin_userpoints_shop_promote29}</td>
<td class='form2'><input type='text' class='text' name='promotion_duration' value='{$promotion_duration}' size='5' Xmaxlength='50'> {$admin_userpoints_shop_promote30}</td>
</tr>


<tr>
<td class='form1'>{$admin_userpoints_shop_promote23}</td>
<td class='form2'>

<select class='text' name='promotion_reqapproval'>
<option value='1'{if $promotion_reqapproval == 1} SELECTED{/if}>{$admin_userpoints_shop_promote24}</option>
<option value='0'{if $promotion_reqapproval == 0} SELECTED{/if}>{$admin_userpoints_shop_promote25}</option>
</select>

</td>
</tr>



<tr>
<td class='form1'>{$admin_userpoints_shop_promote26}</td>
<td class='form2'>

<select class='text' name='promotion_delaystart'>
<option value='1'{if $promotion_delaystart == 1} SELECTED{/if}>{$admin_userpoints_shop_promote28}</option>
<option value='0'{if $promotion_delaystart == 0} SELECTED{/if}>{$admin_userpoints_shop_promote27}</option>
</select>

</td>
</tr>

<tr>
<td class='form1'>&nbsp;</td>
<td class='form2'>&nbsp;</td>
</tr>



<tr>
<td class='form1'>{$admin_userpoints_shop_promote32}</td>
<td class='form2'>


<input id="offer_levels_input" type="text" readonly="readonly" class="multiSelect" value="{$admin_userpoints_shop_promote34}" style="cursor: default;" />
<input type="hidden" id="offer_levels_all" name="offer_levels_all" value="{$levels_all}">
<iframe border=0 frameBorder=0 class="layerfix" id="offer_levels_iframe"></iframe>
<div id="offer_levels_div" class="multiSelectOptions" style="position: absolute; z-index: 99999; display: none;">
<label class="selectAll"><input type="checkbox" class="selectAll" /> {$admin_userpoints_shop_promote35} </label>
{section name=level_loop loop=$levels}
<label><input type="checkbox" name="offer_levels[]" value="{$levels[level_loop].level_id}" {if $levels[level_loop].level_selected} checked="checked" {/if}/> {$levels[level_loop].level_name} {if $levels[level_loop].level_default} {$admin_userpoints_shop_promote31} {/if} </label>
{/section}
</div>

</td>
</tr>


<tr>
<td class='form1'>{$admin_userpoints_shop_promote33}</td>
<td class='form2'>


<input id="offer_subnets_input" type="text" readonly="readonly" class="multiSelect" value="{$admin_userpoints_shop_promote34}" style="cursor: default;" />
<input type="hidden" id="offer_subnets_all" name="offer_subnets_all" value="{$subnets_all}">
<iframe border=0 frameBorder=0 class="layerfix" id="offer_subnets_iframe" style="display:block"></iframe>
<div id="offer_subnets_div" class="multiSelectOptions" style="position: absolute; z-index: 99999; display: none;">
<label class="selectAll"><input type="checkbox" class="selectAll" /> {$admin_userpoints_shop_promote35} </label>
{section name=subnet_loop loop=$subnets}
<label><input type="checkbox" name="offer_subnets[]" value="{$subnets[subnet_loop].subnet_id}" {if $subnets[subnet_loop].subnet_selected} checked="checked" {/if}/> {$subnets[subnet_loop].subnet_name} </label>
{/section}
</div>

</td>
</tr>



  
<tr>
<td class='form1'>{$admin_userpoints_shop_promote11}</td>
<td class='form2'>

<select class='text' name='offer_enabled'>
<option value='1'{if $offer_enabled == 1} SELECTED{/if}>{$admin_userpoints_shop_promote12}</option>
<option value='0'{if $offer_enabled == 0} SELECTED{/if}>{$admin_userpoints_shop_promote13}</option>
</select>

</td>
</tr>

<tr>
<td class='form1'>{$admin_userpoints_shop_promote17}</td>
<td class='form2'>

<select class='text' name='offer_allow_comments'>
<option value='1'{if $offer_allow_comments == 1} SELECTED{/if}>{$admin_userpoints_shop_promote24}</option>
<option value='0'{if $offer_allow_comments == 0} SELECTED{/if}>{$admin_userpoints_shop_promote25}</option>
</select>

</td>
</tr>


<tr>
<td class='form1'>{$admin_userpoints_shop_promote16}</td>
<td class='form2'><input style="width:500px" type='text' class='text' name='offer_tags' value='{$offer_tags}' size='40' maxlength='50'></td>
</tr>

<tr>
<td class='form1'>&nbsp;</td>
<td class='form2'>&nbsp;</td>
</tr>


<tr>
<td class='form1'>&nbsp;</td>
<td class='form2'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td><input type='submit' class='button' value='{$admin_userpoints_shop_promote9}'>&nbsp;</td>
  <input type='hidden' name='task' value='addoffer'>
  <input type='hidden' name='item_id' value='{$item_id}'>
  </form>
  <form action='admin_userpoints_shop.php' method='GET'>
  <td><input type='submit' class='button' value='{$admin_userpoints_shop_promote10}'></td>
  </tr>
  </form>
  </table>
</td>
</tr>
</table>


{include file='admin_footer.tpl'}