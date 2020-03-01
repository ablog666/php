{include file='admin_header.tpl'}

<h2>{$admin_levels_userpointssettings35} {$level_name}</h2>
{$admin_levels_userpointssettings36}

<table cellspacing='0' cellpadding='0' width='100%' style='margin-top: 20px;'>
<tr>
<td class='vert_tab0'>&nbsp;</td>
<td valign='top' class='pagecell' rowspan='{math equation='x+2' x=$level_menu|@count}'>

  <h2>{$admin_levels_userpointssettings1}</h2>
  {$admin_levels_userpointssettings2}

  <br><br>

  {* SHOW SUCCESS MESSAGE *}
  {if $result != 0}
    <div class='success'><img src='../images/success.gif' class='icon' border='0'> {$admin_levels_userpointssettings15}</div>
  {/if}

  {* SHOW ERROR MESSAGE *}
  {if $is_error != 0}
    <div class='error'><img src='../images/error.gif' class='icon' border='0'> {$error_message}</div>
  {/if}

  <table cellpadding='0' cellspacing='0' width='600'>
  <form action='admin_levels_userpointssettings.php' method='POST'>
  <tr><td class='header'>{$admin_levels_userpointssettings3}</td></tr>
  <tr><td class='setting1'>
  {$admin_levels_userpointssettings4}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='level_userpoints_allow' id='userpoints_allow_1' value='1'{if $level_userpoints_allow == 1} CHECKED{/if}>&nbsp;</td><td><label for='userpoints_allow_1'>{$admin_levels_userpointssettings5}</label></td></tr>
    <tr><td><input type='radio' name='level_userpoints_allow' id='userpoints_allow_0' value='0'{if $level_userpoints_allow == 0} CHECKED{/if}>&nbsp;</td><td><label for='userpoints_allow_0'>{$admin_levels_userpointssettings6}</label></td></tr>
    </table>
  </td></tr></table>

  <br>

  <table cellpadding='0' cellspacing='0' width='600'>
  <tr><td class='header'>{$admin_levels_userpointssettings7}</td></tr>
  <tr><td class='setting1'>
  {$admin_levels_userpointssettings8}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='level_userpoints_allow_transfer' id='userpointst_allow_1' value='1'{if $level_userpoints_allow_transfer == 1} CHECKED{/if}>&nbsp;</td><td><label for='userpointst_allow_1'>{$admin_levels_userpointssettings9}</label></td></tr>
    <tr><td><input type='radio' name='level_userpoints_allow_transfer' id='userpointst_allow_0' value='0'{if $level_userpoints_allow_transfer == 0} CHECKED{/if}>&nbsp;</td><td><label for='userpointst_allow_0'>{$admin_levels_userpointssettings10}</label></td></tr>
    </table>
  </td></tr>
  <tr><td class='setting1'>
  {$admin_levels_userpointssettings11}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td>{$admin_levels_userpointssettings12}&nbsp;&nbsp;</td><td><input type='text' name='level_userpoints_max_transfer' value='{$level_userpoints_max_transfer}' maxlength='5' size='5'>&nbsp;{$admin_levels_userpointssettings13}</tr>
    </table>
  </td></tr>
  </table>

  <br>
  
  <input type='submit' class='button' value='{$admin_levels_userpointssettings14}'>
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
  <div style='height: 300px;'>&nbsp;</div>
</td>
</tr>
</table>

{include file='admin_footer.tpl'}