{include file='admin_header.tpl'}

{literal}
<script src="../include/js/semods.js"></script>

<script>
function userpoints_growtable() {
  SEMods.B.toggle("userpoints_basic_table", "userpoints_full_table");
}
</script>
{/literal}

<h2>{$admin_userpoints_viewusers1}</h2>
{$admin_userpoints_viewusers2}

<br><br>

<table cellpadding='0' cellspacing='0' xalign='center'>
<tr>
<td align='center'>
<div class='box'>
<table cellpadding='0' cellspacing='0' xalign='center'>
<tr><form action='admin_userpoints_viewusers.php' method='POST'>
<td>{$admin_userpoints_viewusers3}<br><input type='text' class='text' name='f_user' value='{$f_user}' size='15' maxlength='50'>&nbsp;</td>
<td>{$admin_userpoints_viewusers5}<br><input type='text' class='text' name='f_email' value='{$f_email}' size='15' maxlength='70'>&nbsp;</td>
<td>{$admin_userpoints_viewusers24}<br><select class='text' name='f_level'><option></option>{section name=level_loop loop=$levels}<option value='{$levels[level_loop].level_id}'{if $f_level == $levels[level_loop].level_id} SELECTED{/if}>{$levels[level_loop].level_name}</option>{/section}</select>&nbsp;</td>
<td>{$admin_userpoints_viewusers25}<br><select class='text' name='f_subnet'><option></option>{section name=subnet_loop loop=$subnets}<option value='{$subnets[subnet_loop].subnet_id}'{if $f_subnet == $subnets[subnet_loop].subnet_id} SELECTED{/if}>{$subnets[subnet_loop].subnet_name}</option>{/section}</select>&nbsp;</td>
<td>{$admin_userpoints_viewusers6}<br><select class='text' name='f_enabled'><option></option><option value='1'{if $f_enabled == "1"} SELECTED{/if}>{$admin_userpoints_viewusers9}</option><option value='0'{if $f_enabled == "0"} SELECTED{/if}>{$admin_userpoints_viewusers10}</option></select>&nbsp;&nbsp;&nbsp;</td>
<td valign='bottom'><input type='submit' class='button' value='{$admin_userpoints_viewusers14}'></td>
<input type='hidden' name='s' value='{$s}'>
</form>
</tr>
</table>
</div>
</td></tr></table>
  
<br>

{if $total_users == 0}

  <table cellpadding='0' cellspacing='0' width='400' align='center'>
  <tr>
  <td align='center'>
  <div class='box'><b>{$admin_userpoints_viewusers21}</b></div>
  </td></tr></table>
  <br>

{else}

  <div class='pages'>{$total_users} {$admin_userpoints_viewusers16} &nbsp;|&nbsp; {$admin_userpoints_viewusers17} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_userpoints_viewusers.php?s={$s}&p={$pages[page_loop].page}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_enabled={$f_enabled}'>{$pages[page_loop].page}</a>{/if} {/section}</div>

  {* SHORT TABLE *}
  
  <div id="userpoints_basic_table" style="display:block">

  <table cellpadding='0' cellspacing='0' class='list' style="width:auto;" xwidth='100%' id="usertable">
  <tr>
  <td class='header' width='10' Xstyle='padding-left: 0px;'><a class='header' href='admin_userpoints_viewusers.php?s={$i}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers15}</a></td>
  <td class='header'><a class='header' href='admin_userpoints_viewusers.php?s={$u}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers3}</a></td>
  <td class='header'><a class='header' href='admin_userpoints_viewusers.php?s={$em}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers5}</a></td>

  <td class='header' width='20'><a class='header' href='admin_userpoints_viewusers.php?s={$pc}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers18}</a></td>
  <td class='header' Xwidth='50'><a class='header' href='admin_userpoints_viewusers.php?s={$tp}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers19}</a></td>

  <td class='header'>{$admin_userpoints_viewusers8}</td>

  <td> <input type=button class='button' id="userpoints_table_grower" value='-->' onclick="javascript:userpoints_growtable()"></td>
  </tr>
  
  <!-- LOOP THROUGH USERS -->
  {section name=user_loop loop=$users}
    <tr class='{cycle values="background1,background2"}'>
    <td class='item' Xstyle='padding-left: 0px;'>{$users[user_loop].user_id}</td>
    <td class='item'><a href='{$url->url_create('profile', $users[user_loop].user_username)}'>{$users[user_loop].user_username|truncate:25:"...":true}</a></td>
    <td class='item'><a href='mailto:{$users[user_loop].user_email}'>{$users[user_loop].user_email|truncate:25:"...":true}</a></td>

    <td class='item'>{$users[user_loop].userpoints_count}</td>
    <td class='item'>{$users[user_loop].userpoints_totalearned}</td>
   
    <td class='item' nowrap='nowrap'><a href='admin_userpoints_viewusers_edit.php?user_id={$users[user_loop].user_id}&s={$s}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers11}</a> </td>
    <td class='item'>&nbsp;</td>
    </tr>
  {/section}
  </table>

  </div>
  
  {* FULL TABLE *}
  
  <div id="userpoints_full_table" style="display:none;">
      
  <table cellpadding='0' cellspacing='0' class='list' style="width:auto;" Xwidth='100%' id="usertable">
    
  <tr>

  <td class='header' width='10' Xstyle='padding-left: 0px;'><a class='header' href='admin_userpoints_viewusers.php?s={$i}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers15}</a></td>
  <td class='header'><a class='header' href='admin_userpoints_viewusers.php?s={$u}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers3}</a></td>
  <td class='header'><a class='header' href='admin_userpoints_viewusers.php?s={$em}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers5}</a></td>

  <td class='header' width='20'><a class='header' href='admin_userpoints_viewusers.php?s={$pc}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers18}</a></td>
  <td class='header' Xwidth='50'><a class='header' href='admin_userpoints_viewusers.php?s={$tp}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers19}</a></td>

  <td class='header'>{$admin_userpoints_viewusers8}</td>

  <td class='header'>{$admin_userpoints_viewusers24}</td>
  <td class='header'>{$admin_userpoints_viewusers25}</td>
  <td class='header' align='center'>{$admin_userpoints_viewusers6}</td>
  <td class='header'><a class='header' href='admin_userpoints_viewusers.php?s={$sd}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_subnet={$f_subnet}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers7}</a></td>
  <td> <input type=button class='button' id="userpoints_table_grower" value='<--' onclick="javascript:userpoints_growtable()"></td>
  </tr>
  
  <!-- LOOP THROUGH USERS -->
  {section name=user_loop loop=$users}
    <tr class='{cycle name=t2 values="background1,background2"}'>

    <td class='item' Xstyle='padding-left: 0px;'>{$users[user_loop].user_id}</td>
    <td class='item'><a href='{$url->url_create('profile', $users[user_loop].user_username)}'>{$users[user_loop].user_username|truncate:25:"...":true}</a></td>
    <td class='item'><a href='mailto:{$users[user_loop].user_email}'>{$users[user_loop].user_email|truncate:25:"...":true}</a></td>

    <td class='item'>{$users[user_loop].userpoints_count}</td>
    <td class='item'>{$users[user_loop].userpoints_totalearned}</td>
   
    <td class='item' nowrap='nowrap'><a href='admin_userpoints_viewusers_edit.php?user_id={$users[user_loop].user_id}&s={$s}&p={$p}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_enabled={$f_enabled}'>{$admin_userpoints_viewusers11}</a> </td>

    <td class='item'><a href='admin_levels_edit.php?level_id={$users[user_loop].user_level_id}'>{$users[user_loop].user_level}</a></td>
    <td class='item'><a href='admin_subnetworks_edit.php?subnet_id={$users[user_loop].user_subnet_id}'>{$users[user_loop].user_subnet}</a></td>
    <td class='item' align='center'>{$users[user_loop].user_enabled}</td>
    <td class='item' nowrap='nowrap'>{$datetime->cdate($setting.setting_dateformat, $datetime->timezone($users[user_loop].user_signupdate, $setting.setting_timezone))}</td>
    <td class='item'>&nbsp;</td>
    </tr>
  {/section}
  </table>

  </div>

  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td>
  </td>
  <td align='left' valign='top'>
    <div class='pages2'>{$total_users} {$admin_userpoints_viewusers1} &nbsp;|&nbsp; {$admin_userpoints_viewusers17} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_userpoints_viewusers.php?s={$s}&p={$pages[page_loop].page}&f_user={$f_user}&f_email={$f_email}&f_level={$f_level}&f_enabled={$f_enabled}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
  </td>
  </tr>
  </table>

  <br><br>
  
{/if}

{include file='admin_footer.tpl'}