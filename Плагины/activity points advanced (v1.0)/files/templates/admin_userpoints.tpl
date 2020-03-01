{include file='admin_header.tpl'}

<h2>{$admin_userpoints1}</h2>
{$admin_userpoints2}

<br><br>

{if $result != 0}

  {if empty($error)}
  <div class='success'><img src='../images/success.gif' class='icon' border='0'> {$admin_userpoints3}</div>
  {else}
    <div class='error'><img src='../images/error.gif' class='icon' border='0'> {$error} </div>
  {/if}

{/if}


<form action='admin_userpoints.php' method='POST'>


  <table cellpadding='0' cellspacing='0' width='600px'>
  <tr><td class='header'>{$admin_userpoints4}</td></tr>
  <tr><td class='setting1'>
  {$admin_userpoints5}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='setting_userpoints_enable_activitypoints' id='setting_userpoints_enable_activitypoints_1' value='1'{if $setting_userpoints_enable_activitypoints == 1} CHECKED{/if}>&nbsp;</td><td><label for='setting_userpoints_enable_activitypoints_1'>{$admin_userpoints6}</label></td></tr>
    <tr><td><input type='radio' name='setting_userpoints_enable_activitypoints' id='setting_userpoints_enable_activitypoints_0' value='0'{if $setting_userpoints_enable_activitypoints == 0} CHECKED{/if}>&nbsp;</td><td><label for='setting_userpoints_enable_activitypoints_0'>{$admin_userpoints7}</label></td></tr>
    </table>
  </td></tr>
  
  </table>

<br>

  <table cellpadding='0' cellspacing='0' width='600px'>
  <tr><td class='header'>{$admin_userpoints8}</td></tr>
  <tr><td class='setting1'>
  {$admin_userpoints9}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='setting_userpoints_enable_topusers' id='setting_userpoints_enable_topusers_1' value='1'{if $setting_userpoints_enable_topusers == 1} CHECKED{/if}>&nbsp;</td><td><label for='setting_userpoints_enable_topusers_1'>{$admin_userpoints10}</label></td></tr>
    <tr><td><input type='radio' name='setting_userpoints_enable_topusers' id='setting_userpoints_enable_topusers_0' value='0'{if $setting_userpoints_enable_topusers == 0} CHECKED{/if}>&nbsp;</td><td><label for='setting_userpoints_enable_topusers_0'>{$admin_userpoints11}</label></td></tr>
    </table>
  </td></tr>
  
  </table>

<br>

<input type='submit' class='button' value='{$admin_userpoints13}'>
<input type='hidden' name='crontab_prev_state' value='{$setting_crontab_enabled}'>
<input type='hidden' name='task' value='dosave'>
</form>


{include file='admin_footer.tpl'}