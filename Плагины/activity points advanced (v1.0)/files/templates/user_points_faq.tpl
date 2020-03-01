{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_vault.php'>{$user_points_faq1}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_points_transactions.php'>{$user_points_faq2}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_points_offers.php'>{$user_points_faq3}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_points_shop.php'>{$user_points_faq4}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_points_faq.php'>{$user_points_faq5}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>


<img src='./images/icons/help48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_points_faq8}</div>
<div>{$user_points_faq9}</div>

<br><br>

{literal}
<script language="javascript">
<!--
function showhide(id1) {
	if(document.getElementById(id1).style.display=='none') {
		document.getElementById(id1).style.display='block';
	} else {
		document.getElementById(id1).style.display='none';
	}
}
// -->
</script>
{/literal}

<div class='header'>{$user_points_faq10}</div>
<div class='faq_questions'>
  <a href="javascript:void(0);" onClick="showhide('1');">{$user_points_faq11}</a><br>
  <div class='faq' style='display: none;' id='1'>{$user_points_faq12}</div>
  <a href="javascript:void(0);" onClick="showhide('2');">{$user_points_faq13}</a><br>
  <div class='faq' style='display: none;' id='2'>
	
	{$user_points_faq14} <br><br>
	
	<table cellpadding='0' cellspacing='0' class='list' style="width:500px;" Xwidth='100%'>
	<tr>
	<td class='list_header' Xwidth='200' Xstyle='padding-left: 0px;'>{$user_points_faq15}</td>
	<td class='list_header'>{$user_points_faq16}</td>
	<td class='list_header'>{$user_points_faq17}</td>
	<td class='list_header'>{$user_points_faq18}</td>
	</tr>

	{* LOOP THROUGH ACTIONS *}
	{section name=action_loop loop=$actions}
	
		{section name=action_gloop loop=$actions[action_loop]}
	  
		  <tr class='{cycle values="list_item1,list_item2"}'>
		  <td style="padding:5px" class='item' Xstyle='padding-left: 0px;' Xwidth="100%">{$actions[action_loop][action_gloop].action_name} {if $unavailable}<br><font color="red"> {$admin_userpoints_assign7} {$actions[action_loop][action_gloop].action_requiredplugin}</font> {/if}</td>
		  <td style="padding:5px" class='item' width="20px">{$actions[action_loop][action_gloop].action_points}</td>
		  <td style="padding:5px" class='item' width="20px">{if $actions[action_loop][action_gloop].action_pointsmax == 0}{$user_points_faq20}{else}{$actions[action_loop][action_gloop].action_pointsmax}{/if}</td>
		  <td style="padding:5px" class='item' width="100px">{if $actions[action_loop][action_gloop].action_rolloverperiod == 0}{$user_points_faq21}{else} {$actions[action_loop][action_gloop].action_rolloverperiod} {$user_points_faq19} {/if}</td>
		  </tr>
		
		{/section}
		  
		<tr><td colspan=4 style="border-bottom: 1px dashed #CCC">&nbsp;</td></tr>	
  
	{/section}

	</table>
  
	<br><br>
	
  </div>
</div>

<br>

<div class='header'>{$user_points_faq50}</div>
<div class='faq_questions'>
  <a href="javascript:void(0);" onClick="showhide('6');">{$user_points_faq51}</a><br>
  <div class='faq' style='display: none;' id='6'>{$user_points_faq52}</div>
</div>

<br>

{include file='footer.tpl'}