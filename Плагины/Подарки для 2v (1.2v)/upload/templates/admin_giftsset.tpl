{include file='admin_header.tpl'}

<h2>{$admin_giftsset1}</h2>
{$admin_giftsset2}

<br><br>

{if $result != 0}
  <div class='success'><img src='../images/success.gif' class='icon' border='0'> {$admin_giftsset3}</div>
{/if}

<form action='admin_giftsset.php' method='POST'>


<table cellpadding='0' cellspacing='0' width='600'>
<tr>
<td class='header'>{$admin_giftsset4}</td>
</tr>
<td class='setting1'>
  {$admin_giftsset5}
</td>
</tr>
<tr>
<td class='setting2'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td width='80'>{$admin_giftsset6}</td>
  <td><input type='text' class='text' size='30' name='setting_email_gifts_subject' value='{$setting_email_gifts_subject}' maxlength='200'></td>
  </tr><tr>
  <td valign='top'>{$admin_giftsset7}</td>
  <td><textarea rows='6' cols='80' class='text' name='setting_email_gifts_message'>{$setting_email_gifts_message}</textarea><br>{$admin_giftsset8}</td>
  </tr>
  </table>
</td>
</tr>
</table>

<br>

<input type='submit' class='button' value='{$admin_giftsset9}'>
<input type='hidden' name='task' value='dosave'>
</form>


{include file='admin_footer.tpl'}