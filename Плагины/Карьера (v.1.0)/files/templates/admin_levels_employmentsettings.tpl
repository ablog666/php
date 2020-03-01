{include file='admin_header.tpl'}

<h2>{$admin_levels_employmentsettings9} {$level_name}</h2>
{$admin_levels_employmentsettings10}

<table cellspacing='0' cellpadding='0' width='100%' style='margin-top: 20px;'>
<tr>
<td class='vert_tab0'>&nbsp;</td>
<td valign='top' class='pagecell' rowspan='{math equation='x+2' x=$level_menu|@count}'>


  <h2>{$admin_levels_employmentsettings1}</h2>
  {$admin_levels_employmentsettings2}

  <br><br>

  {if $result != 0}
    <div class='success'><img src='../images/success.gif' class='icon' border='0'> {$admin_levels_employmentsettings8}</div>
  {/if}

  {if $is_error != 0}
    <div class='error'><img src='../images/error.gif' class='icon' border='0'> {$error_message}</div>
  {/if}

  <form action='admin_levels_employmentsettings.php' method='POST'>
  <table cellpadding='0' cellspacing='0' width='600'>
  <tr><td class='header'>{$admin_levels_employmentsettings3}</td></tr>
  <tr><td class='setting1'>
  {$admin_levels_employmentsettings4}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='level_employment_allow' id='employment_allow_1' value='1'{if $employment_allow == 1} CHECKED{/if}>&nbsp;</td><td><label for='employment_allow_1'>{$admin_levels_employmentsettings5}</label></td></tr>
    <tr><td><input type='radio' name='level_employment_allow' id='employment_allow_0' value='0'{if $employment_allow == 0} CHECKED{/if}>&nbsp;</td><td><label for='employment_allow_0'>{$admin_levels_employmentsettings6}</label></td></tr>
    </table>
  </td></tr></table>

  <br>
  
  <input type='submit' class='button' value='{$admin_levels_employmentsettings7}'>
  <input type='hidden' name='task' value='dosave'>
  <input type='hidden' name='level_id' value='{$level_id}'>
  </form>


</td>
</tr>

{section name=menu_loop loop=$level_menu}
  <tr><td width='100' nowrap='nowrap' class='vert_tab' style='{if $smarty.section.menu_loop.first != TRUE} border-top: none;{/if}{if $level_menu[menu_loop].page == $page} border-right: none;{/if}'><a href='{$level_menu[menu_loop].link}?level_id={$level_id}'>{$level_menu[menu_loop].title}</td></tr>
{/section}

<tr>
<td class='vert_tab0'>
  <div style='height: 2500px;'>&nbsp;</div>
</td>
</tr>
</table>

{include file='admin_footer.tpl'}