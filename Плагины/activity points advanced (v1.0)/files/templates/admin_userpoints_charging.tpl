{include file='admin_header.tpl'}

<script src="../include/js/semods.js"></script>



<h2>{$admin_userpoints_charging1}</h2>
{$admin_userpoints_charging2}

<br><br>

{if $result != 0}
<div class='success'><img src='../images/success.gif' class='icon' border='0'> {$admin_userpoints_charging3}</div>
{/if}

{if $is_error != 0}
<div class='error'><img src='../images/error.gif' class='icon' border='0'> {$error_message}</div>
{/if}

<form action="admin_userpoints_charging.php" method="POST">

  <table cellpadding='0' cellspacing='0' width='600px'>
  <tr><td class='header'>{$admin_userpoints_charging4}</td></tr>
  <tr><td class='setting1'>
  {$admin_userpoints_charging5}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='charge_classified' id='charge_classified_1' value='1'{if $charge_classified == 1} CHECKED{/if}>&nbsp;</td><td><label for='charge_classified_1'>{$admin_userpoints_charging6}</label></td></tr>
    <tr><td><input type='radio' name='charge_classified' id='charge_classified_0' value='0'{if $charge_classified == 0} CHECKED{/if}>&nbsp;</td><td><label for='charge_classified_0'>{$admin_userpoints_charging7}</label></td></tr>
    </table>
  </td></tr>
  
  <tr><td class='setting1'>
  {$admin_userpoints_charging8}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='text' name='charge_classified_amount' size='5' value='{$charge_classified_amount}'>&nbsp;</td><td>{$admin_userpoints_charging9}</td></tr>
    </table>
  </td></tr>
  
  </table>

<br>

  <table cellpadding='0' cellspacing='0' width='600px'>
  <tr><td class='header'>{$admin_userpoints_charging20}</td></tr>
  <tr><td class='setting1'>
  {$admin_userpoints_charging21}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='charge_event' id='charge_event_1' value='1'{if $charge_event == 1} CHECKED{/if}>&nbsp;</td><td><label for='charge_event_1'>{$admin_userpoints_charging22}</label></td></tr>
    <tr><td><input type='radio' name='charge_event' id='charge_event_0' value='0'{if $charge_event == 0} CHECKED{/if}>&nbsp;</td><td><label for='charge_event_0'>{$admin_userpoints_charging23}</label></td></tr>
    </table>
  </td></tr>
  
  <tr><td class='setting1'>
  {$admin_userpoints_charging24}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='text' name='charge_event_amount' size='5' value='{$charge_event_amount}'>&nbsp;</td><td>{$admin_userpoints_charging9}</td></tr>
    </table>
  </td></tr>
  
  </table>

<br>

  <table cellpadding='0' cellspacing='0' width='600px'>
  <tr><td class='header'>{$admin_userpoints_charging10}</td></tr>
  <tr><td class='setting1'>
  {$admin_userpoints_charging11}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='charge_group' id='charge_group_1' value='1'{if $charge_group == 1} CHECKED{/if}>&nbsp;</td><td><label for='charge_group_1'>{$admin_userpoints_charging12}</label></td></tr>
    <tr><td><input type='radio' name='charge_group' id='charge_group_0' value='0'{if $charge_group == 0} CHECKED{/if}>&nbsp;</td><td><label for='charge_group_0'>{$admin_userpoints_charging13}</label></td></tr>
    </table>
  </td></tr>
  
  <tr><td class='setting1'>
  {$admin_userpoints_charging14}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='text' name='charge_group_amount' size='5' value='{$charge_group_amount}'>&nbsp;</td><td>{$admin_userpoints_charging9}</td></tr>
    </table>
  </td></tr>
  
  </table>

<br>

  <table cellpadding='0' cellspacing='0' width='600px'>
  <tr><td class='header'>{$admin_userpoints_charging15}</td></tr>
  <tr><td class='setting1'>
  {$admin_userpoints_charging16}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='charge_poll' id='charge_poll_1' value='1'{if $charge_poll == 1} CHECKED{/if}>&nbsp;</td><td><label for='charge_poll_1'>{$admin_userpoints_charging17}</label></td></tr>
    <tr><td><input type='radio' name='charge_poll' id='charge_poll_0' value='0'{if $charge_poll == 0} CHECKED{/if}>&nbsp;</td><td><label for='charge_poll_0'>{$admin_userpoints_charging18}</label></td></tr>
    </table>
  </td></tr>
  
  <tr><td class='setting1'>
  {$admin_userpoints_charging19}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='text' name='charge_poll_amount' size='5' value='{$charge_poll_amount}'>&nbsp;</td><td>{$admin_userpoints_charging9}</td></tr>
    </table>
  </td></tr>
  
  </table>

<br>



<input type='submit' class='button' value='{$admin_userpoints_charging25}'>
<input type='hidden' name='task' value='dosave'>
</form>


{include file='admin_footer.tpl'}