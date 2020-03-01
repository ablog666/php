{include file='admin_header.tpl'}

{literal}
<script src="../include/js/semods.js"></script>

<script>
function userpoints_growtable() {
  SEMods.B.toggle("userpoints_basic_table", "userpoints_full_table");
}

function confirm_transaction(tid) {
  var asyncform = document.getElementById('asyncform');
  document.getElementById('asyncform_task').value = "confirm";
  document.getElementById('asyncform_transaction_id').value = tid;
  
  asyncform.submit();
}

function cancel_transaction(tid) {
  var asyncform = document.getElementById('asyncform');
  document.getElementById('asyncform_task').value = "cancel";
  document.getElementById('asyncform_transaction_id').value = tid;
  
  asyncform.submit();
}


</script>
{/literal}


<h2>{$admin_userpoints_transactions1}</h2>
{$admin_userpoints_transactions2}

<br><br>

<table cellpadding='0' cellspacing='0' align='center'>
<tr>
<td align='center'>
<div class='box'>
<table cellpadding='0' cellspacing='0' xalign='center'>
<tr><form action='admin_userpoints_transactions.php' method='GET'>
<td>{$admin_userpoints_transactions3}<br><input type='text' class='text' name='f_user' value='{$f_user}' size='15' maxlength='50'>&nbsp;</td>
<td>{$admin_userpoints_transactions6}<br><input type='text' class='text' name='f_title' value='{$f_title}' size='50' maxlength='100'>&nbsp;</td>
<td>{$admin_userpoints_transactions4}<br><select class='text' name='f_state'><option value=-1>All</option>{section name=state_loop loop=$transaction_states}<option value='{$transaction_states[state_loop].transactionstate_id}'{if $f_state == $transaction_states[state_loop].transactionstate_id} SELECTED{/if}>{$transaction_states[state_loop].transactionstate_name}</option>{/section}</select>&nbsp;</td>
<td valign='bottom'><input type='submit' class='button' value='{$admin_userpoints_transactions14}'></td>
<input type='hidden' name='s' value='{$s}'>
</form>
</tr>
</table>
</div>
</td></tr></table>
  
<br>

{if $total_items == 0}

  <table cellpadding='0' cellspacing='0' width='400' align='center'>
  <tr>
  <td align='center'>
  <div class='box'><b>{$admin_userpoints_transactions5}</b></div>
  </td></tr></table>
  <br>

{else}

  <div class='pages'>{$total_items} {$admin_userpoints_transactions16} &nbsp;|&nbsp; {$admin_userpoints_transactions17} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_userpoints_transactions.php?s={$s}&p={$pages[page_loop].page}&f_user={$f_user}&f_title={$f_title}&f_email={$f_email}&f_state={$f_state}'>{$pages[page_loop].page}</a>{/if} {/section}</div>



{literal}
<style>
td.up_tblheader1 {
  background:#DFECF8 none repeat scroll 0%;
  font-weight:bold;
  padding:5px;
}

td.up_tblitem1 {
  background:#FFFFFF none repeat scroll 0%;
  border-top:1px solid #DDDDDD;
  padding:5px;
  vertical-align:middle;
}

</style>
{/literal}

  <table cellpadding='0' cellspacing='0' style='border: 1px solid #CCC'>
  <tr>
<!--
  <td class='up_tblheader1' width='10'><input type='checkbox' name='select_all' onClick='javascript:doCheckAll()'></td>
-->
  <td class='up_tblheader1'><a href='admin_userpoints_transactions.php?p={$p}&s={$u}&f_user={$f_user}&f_title={$f_title}&f_state={$f_state}'>{$admin_userpoints_transactions18}</a></td>
  <td class='up_tblheader1'>{$admin_userpoints_transactions23}</td>
  <td class='up_tblheader1'><a href='admin_userpoints_transactions.php?p={$p}&s={$d}&f_user={$f_user}&f_title={$f_title}&f_state={$f_state}'>{$admin_userpoints_transactions19}</a></td>
  <td class='up_tblheader1'>{$admin_userpoints_transactions20}</td>
  <td class='up_tblheader1'><a href='admin_userpoints_transactions.php?p={$p}&s={$st}&f_user={$f_user}&f_title={$f_title}&f_state={$f_state}'>{$admin_userpoints_transactions21}</a></td>
  <td class='up_tblheader1'><a href='admin_userpoints_transactions.php?p={$p}&s={$a}&f_user={$f_user}&f_title={$f_title}&f_state={$f_state}'>{$admin_userpoints_transactions22}</a></td>
  </tr>

  {* LIST ITEMS *}
  {section name=item_loop loop=$items}
    <tr>
    <td class='up_tblitem1' nowrap='nowrap'><a href='{$url->url_create('profile', $items[item_loop].transaction_username)}'> {$items[item_loop].transaction_username}</a></td>
    <td class='up_tblitem1'>{$items[item_loop].transaction_id}</td>
    <td class='up_tblitem1' nowrap='nowrap'>{$datetime->cdate("`$setting.setting_dateformat` `$setting.setting_timeformat`", $datetime->timezone($items[item_loop].transaction_date, $global_timezone))}</td>
    <td class='up_tblitem1' width='100%'>{$items[item_loop].transaction_desc}</td>
    <td class='up_tblitem1' nowrap='nowrap'>{$items[item_loop].transaction_state} {if $items[item_loop].transaction_stateid == 1} ( <a href="javascript:confirm_transaction({$items[item_loop].transaction_id})">{$admin_userpoints_transactions27}</a> | <a href="javascript:cancel_transaction({$items[item_loop].transaction_id})">{$admin_userpoints_transactions28}</a> ) {/if} </td>
    <td class='up_tblitem1' nowrap='nowrap'>{$items[item_loop].transaction_amount}</td>
    </tr>
  {/section}
  </table>

  <br>


  





  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td>
  </td>
  <td align='left' valign='top'>
    <div class='pages2'>{$total_items} {$admin_userpoints_transactions16} &nbsp;|&nbsp; {$admin_userpoints_transactions17} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_userpoints_transactions.php?s={$s}&p={$pages[page_loop].page}&f_user={$f_user}&f_title={$f_title}&f_state={$f_state}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
  </td>
  </tr>
  </table>

  <br><br>
  
  <form method=POST id="asyncform" action="admin_userpoints_transactions.php">
    <input type="hidden" id="asyncform_task" name="task">
    <input type="hidden" id="asyncform_transaction_id" name="transaction_id">
      
    <input type="hidden" name="f_user" value="{$f_user}">
    <input type="hidden" name="f_title" value="{$f_title}">
    <input type="hidden" name="f_state" value="{$f_state}">
    <input type="hidden" name="s" value="{$s}">
    <input type="hidden" name="p" value="{$p}">
  </form>
  
{/if}

{include file='admin_footer.tpl'}