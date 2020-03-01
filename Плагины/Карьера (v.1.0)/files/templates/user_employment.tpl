{include file='header.tpl'}


<img src='./images/icons/employment48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_employment1}</div>
<div>{$user_employment2}</div>

<br><br>

{* SHOW RESULT MESSAGE *}
{if $result != ""}
<table cellpadding='0' cellspacing='0'><tr><td class='result'>
<div class='success'><img src='./images/success.gif' border='0' class='icon'> {$result}</div>
</td></tr></table>
<br>
{/if}

{* SHOW ERROR MESSAGE *}
{if $is_error != 0}
<table cellpadding='0' cellspacing='0'><tr><td class='result'>
<div class='error'><img src='./images/error.gif' border='0' class='icon'> {$error_message}</div>
</td></tr></table>
<br>
{/if}

{literal}
<script type="text/javascript">
function removeemp(eid) {
  if (confirm("{/literal}{$user_employment3}{literal}")) {
  	var myTextField = document.getElementById('edu'+eid);
  	myTextField.value = "";
  	document.getElementById('emp'+eid).style.display = 'none';
  }
  return false;
}

function toggle_is_current(ck,eid) {
  var pc = document.getElementById('is_current'+eid);
  var sc = document.getElementById('not_current'+eid);

  if (ck.checked) {
    pc.style.display = '';
    sc.style.display = 'none';
  }
  else {
    pc.style.display = 'none';
    sc.style.display = '';
  }
}
</script>
{/literal}

<form action='user_employment.php' method='POST' name='profile'>

{foreach from=$employments item=employment key=eid}
<table cellpadding='0' cellspacing='0' class='form' id="emp{$eid}">
{if $eid == 'new'}
  <tr>
    <td class='form1'>&nbsp;</td>
    <td class='form2'>{$user_employment4}</td>
  </tr> 
{/if}
  <tr>
    <td class='form1'>{$user_employment6}</td>
    <td class='form2'><input type="text" class="text" id="edu{$eid}" name="employments[{$eid}][employment_employer]" value="{$employment.employment_employer}" size="45" />
      {if $eid != 'new'}<a href="#"  onclick="removeemp({$eid}); return false;">{$user_employment5}</a>{/if}
    </td>
  </tr> 
  <tr>
    <td class='form1'>{$user_employment7}</td>
    <td class='form2'><input type="text" class="text" name="employments[{$eid}][employment_position]" value="{$employment.employment_position}" size="45" /></td>
  </tr>
  <tr>
    <td class='form1'>{$user_employment8}</td>
    <td class='form2'><textarea name="employments[{$eid}][employment_description]" rows="4" cols="45" />{$employment.employment_description}</textarea></td>
  </tr>
  <tr>
    <td class='form1'>{$user_employment9}</td>
    <td class='form2'><input type="text" class="text" name="employments[{$eid}][employment_location]" value="{$employment.employment_location}" size="45" /></td>
  </tr> 
  <tr>
    <td class='form1'>{$user_employment10}</td>
    <td class='form2'><label><input type="checkbox" onclick="toggle_is_current(this,'{$eid}');" name="employments[{$eid}][employment_is_current]" value="1" {if $employment.employment_is_current == '1'}checked="checked"{/if} />{$user_employment11}</label>
    <br>
      <select name="employments[{$eid}][employment_from_month]" size="1">
        <option value="">{$user_employment15}</option>
        {html_options options=$monthoptions selected=$employment.employment_from_month}
      </select>
      <select name="employments[{$eid}][employment_from_year]" size="1">
        <option value="">{$user_employment16}</option>
        {html_options options=$yearoptions selected=$employment.employment_from_year}
      </select>
      
      {$user_employment12}
      
      <span id="is_current{$eid}" style="display: {if $employment.employment_is_current == '1'}  {else} none {/if}">{$user_employment17}</span>
      <span id="not_current{$eid}" style="display: {if $employment.employment_is_current != '1'}  {else} none {/if}">
      <select name="employments[{$eid}][employment_to_month]" size="1">
        <option value="">{$user_employment15}</option>
        {html_options options=$monthoptions selected=$employment.employment_to_month}
      </select>
      <select name="employments[{$eid}][employment_to_year]" size="1">
        <option value="">{$user_employment16}</option>
        {html_options options=$yearoptions selected=$employment.employment_to_year}
      </select>
      </span>

    </td>
  </tr> 
  <tr><td colspan="2"><hr noshade size="0" /></td></tr> 
</table>            
{/foreach}
<table cellpadding='0' cellspacing='0' class='form'>
  <tr>
  <td class='form1'>&nbsp;</td>
  <td class='form2'><input type='submit' class='button' value='{$user_employment13}'></td>
  </tr>
</table>

<input type='hidden' name='task' value='dosave'>
</form>


{include file='footer.tpl'}
