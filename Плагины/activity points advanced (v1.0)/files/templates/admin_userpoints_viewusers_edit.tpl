{include file='admin_header.tpl'}

{literal}
<script src="../include/js/semods.js"></script>

<style>
.points_totalearned_edit {
  text-decoration: none;
}

.points_totalearned_edit:hover {
  text-decoration: underline;
}
</style>

<script>
function edit_total() {
  SEMods.B.ge("totalpoints_readonly").style.display = "none";
  SEMods.B.ge("totalpoints_edit").style.display = "";
//  SEMods.B.toggle("totalpoints_readonly", "totalpoints_edit");
}
</script>
{/literal}


<h2>{$admin_userpoints_viewusers_edit1} {$user_username}</h2>
{$admin_userpoints_viewusers_edit2}

<br><br>

{if $error_message != ""}
  <div class='error'><img src='../images/error.gif' border='0' class='icon'> {$error_message}</div>
{/if}

{if $result != ""}
  <div class='success'><img src='../images/success.gif' border='0' class='icon'> {$result}</div>
{/if}

<form action='admin_userpoints_viewusers_edit.php' method='POST'>

<table cellpadding='0' cellspacing='0' class='stats'>
<tr>
<td class='stat0'>
<table cellpadding='0' cellspacing='0'>
<tr>
<td><b>{$admin_userpoints_viewusers_edit3}</b>
<span id="totalpoints_readonly" style="display: inline">{$points_totalearned} <span style="color: #CCC">(</span><a class='points_totalearned_edit' href="javascript:edit_total()"><span style="color: #CCC">{$admin_userpoints_viewusers_edit20}</span></a><span style="color: #CCC">)</span></span>
<span id="totalpoints_edit" style="display: none"><input type='text' class='text' name='points_totalearned' value='{$points_totalearned}'></span>
</td>
<td style='padding-left: 20px;'><b>{$admin_userpoints_viewusers_edit4}</b> {$points_totalspent}</td>
</tr>
</table>
</td>
</tr>
</table>

<br>

<table cellpadding='0' cellspacing='0'>
<tr>
<td class='form1'>{$admin_userpoints_viewusers_edit5}</td>
<td class='form2'><input type='text' class='text' name='user_points' value='{$points}'></td>
</tr>

<tr>
<td class='form1'>{$admin_userpoints_viewusers_edit11}</td>
<td class='form2'>

<select class='text' name='user_points_enabled'>
<option value='1'{if $user_points_enabled == 1} SELECTED{/if}>{$admin_userpoints_viewusers_edit18}</option>
<option value='0'{if $user_points_enabled == 0} SELECTED{/if}>{$admin_userpoints_viewusers_edit19}</option>
</select>

</td>
</tr>

<tr>
<td class='form1'>&nbsp;</td>
<td class='form2'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td><input type='submit' class='button' value='{$admin_userpoints_viewusers_edit6}'>&nbsp;</td>
  <input type='hidden' name='task' value='edituser'>
  <input type='hidden' name='user_id' value='{$user_id}'>
  <input type='hidden' name='s' value='{$s}'>
  <input type='hidden' name='p' value='{$p}'>
  <input type='hidden' name='f_user' value='{$f_user}'>
  <input type='hidden' name='f_email' value='{$f_email}'>
  <input type='hidden' name='f_level' value='{$f_level}'>
  <input type='hidden' name='f_enabled' value='{$f_enabled}'>
  </form>
  <form action='admin_userpoints_viewusers_edit.php' method='POST'>
  <td><input type='submit' class='button' value='{$admin_userpoints_viewusers_edit7}'></td>
  <input type='hidden' name='s' value='{$s}'>
  <input type='hidden' name='p' value='{$p}'>
  <input type='hidden' name='f_user' value='{$f_user}'>
  <input type='hidden' name='f_email' value='{$f_email}'>
  <input type='hidden' name='f_level' value='{$f_level}'>
  <input type='hidden' name='f_enabled' value='{$f_enabled}'>
  </tr>
  </form>
  </table>
</td>
</tr>
</form>
</table>


<br><br>

{include file='admin_footer.tpl'}