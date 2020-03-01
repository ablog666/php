{include file='header.tpl'}


<img src='./images/icons/education48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_education1}</div>
<div>{$user_education2}</div>

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
function removeschool(eid) {
  if (confirm("{/literal}{$user_education3}{literal}")) {
  	var myTextField = document.getElementById('edu'+eid);
  	myTextField.value = "";
  	document.getElementById('school'+eid).style.display = 'none';
  }
  return false;
}
</script>
{/literal}

<form action='user_education.php' method='POST' name='profile'>

{foreach from=$educations item=education key=eid}
<table cellpadding='0' cellspacing='0' class='form' id="school{$eid}">
{if $eid == 'new'}
  <tr>
    <td class='form1'>&nbsp;</td>
    <td class='form2'>{$user_education4}</td>
  </tr> 
{/if}
  <tr>
    <td class='form1'>{$user_education6}</td>
    <td class='form2'><input type="text" class="text" id="edu{$eid}" name="educations[{$eid}][education_name]" value="{$education.education_name}" size="30" />
      {if $eid != 'new'}<a href="#"  onclick="removeschool({$eid}); return false;">{$user_education5}</a>{/if}
    </td>
  </tr> 
  <tr>
    <td class='form1'>{$user_education7}</td>
    <td class='form2'>
      <select name="educations[{$eid}][education_for]" size="1">
        <option value=""></option>
        {html_options options=$foroptions selected=$education.education_for}
      </select>
      <select name="educations[{$eid}][education_year]" size="1">
        <option value="">{$user_education8}</option>
        {html_options options=$yearoptions selected=$education.education_year}
      </select>
    </td>
  </tr>
  <tr>
    <td class='form1'>{$user_education9}</td>
    <td class='form2'><input type="text" class="text" name="educations[{$eid}][education_degree]" value="{$education.education_degree}" size="30" /></td>
  </tr> 
  <tr>
    <td class='form1'>{$user_education10}</td>
    <td class='form2'><input type="text" class="text" name="educations[{$eid}][education_concentration1]" value="{$education.education_concentration1}" size="30" /></td>
  </tr> 
  <tr>
    <td class='form1'>{$user_education11}</td>
    <td class='form2'><input type="text" class="text" name="educations[{$eid}][education_concentration2]" value="{$education.education_concentration2}" size="30" /></td>
  </tr> 
  <tr>
    <td class='form1'>{$user_education12}</td>
    <td class='form2'><input type="text" class="text" name="educations[{$eid}][education_concentration3]" value="{$education.education_concentration3}" size="30" /></td>
  </tr> 
  <tr><td colspan="2"><hr noshade size="0" /></td></tr> 
</table>            
{/foreach}
<table cellpadding='0' cellspacing='0' class='form'>
  <tr>
  <td class='form1'>&nbsp;</td>
  <td class='form2'><input type='submit' class='button' value='{$user_education13}'></td>
  </tr>
</table>

<input type='hidden' name='task' value='dosave'>
</form>


{include file='footer.tpl'}
