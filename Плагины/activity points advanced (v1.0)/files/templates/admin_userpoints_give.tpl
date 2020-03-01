{include file='admin_header.tpl'}

<script src="../include/js/semods.js"></script>

{literal}
<script>
function userpoints_gp_onchange(elem) {
  SEMods.B.hide("div1","div2","div3");
  SEMods.B.show("div"+elem.value);
}
</script>
{/literal}


<h2>{$admin_userpoints_give1}</h2>
{$admin_userpoints_give2}

<br><br>

{if $result != 0}
<div class='success'><img src='../images/success.gif' class='icon' border='0'> {$admin_userpoints_give3}</div>
{/if}

{if $is_error != 0}
<div class='error'><img src='../images/error.gif' class='icon' border='0'> {$error_message}</div>
{/if}

<form action="admin_userpoints_give.php" method="POST">
  
<table cellpadding='0' cellspacing='0' width='600'>
<tr>
<td class='header'>{$admin_userpoints_give4}</td>
</tr>
<td class='setting1'>

  <table cellpadding='0' cellspacing='0'>
  <tr>
    <td width="50"> {$admin_userpoints_give5} </td>
    <td><select name="sendtotype" id="sendtotype" onchange="userpoints_gp_onchange(this)"><option value="0">All users</option><option value="1">All users on level...</option><option value="2">All users in subnetwork...</option><option value="3">Specific user</option></select></td>
    <td>
      <div id="div1" style="display:none">&nbsp; Level &nbsp;{html_options name="level" options=$levels}</div>
      <div id="div2" style="display:none">&nbsp; Subnetwork {html_options name="subnet" options=$subnets}</div>
      <div id="div3" style="display:none">&nbsp; User: <input type='text' class='text' name='username'></div>
    </td>
  </tr>
  <tr>
    <td width="50" style="padding-top: 10px"> Amount: </td>
    <td style="padding-top: 10px"> <input type='text' class='text' name='points' size=5 value={$points}></td>
  </tr>
  <tr>
    <td width="50"> &nbsp;</td>
    <td style="padding-top: 2px"> <span style="color: #BBB"> {$admin_userpoints_give13} </span> </td>
  </tr>
  </table>

</td>
</tr>

<tr><td class='setting2' colspan=2>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td><input type='checkbox' name='send_message' id='send_message' value='1'{if $send_message == 1} checked='checked'{/if}></td>
  <td><label for='send_message'>{$admin_userpoints_give9}</label></td>
  </tr>
  </table>
</td>
</tr>

<tr>
<td class='setting2'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td width='80'>{$admin_userpoints_give6}</td>
  <td><input type='text' class='text' size='30' name='subject' value='{$subject}' maxlength='200'></td>
  </tr>
  <tr>
  <td valign='top'>{$admin_userpoints_give7}</td>
  <td><textarea rows='6' cols='80' class='text' name='message'>{$message}</textarea></td>
  </tr>
  </table>
</td>
</tr>
</table>

<br>

<input type='submit' class='button' value='{$admin_userpoints_give8}'>
<input type='hidden' name='task' value='dogivepoints'>
</form>


{include file='admin_footer.tpl'}