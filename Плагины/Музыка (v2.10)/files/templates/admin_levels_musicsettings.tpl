{include file='admin_header.tpl'}

<h2>{$admin_levels_musicsettings19} {$level_name}</h2>
{$admin_levels_musicsettings20}

<table cellspacing='0' cellpadding='0' width='100%' style='margin-top: 20px;'>
<tr>
<td class='vert_tab0'>&nbsp;</td>
<td valign='top' class='pagecell' rowspan='{math equation='x+2' x=$level_menu|@count}'>

  <h2>{$admin_levels_musicsettings1}</h2>
  {$admin_levels_musicsettings2}

  <br><br>

  {* SHOW SUCCESS MESSAGE *}
  {if $result != 0}
    <div class='success'><img src='../images/success.gif' class='icon' border='0'> {$admin_levels_musicsettings21}</div>
  {/if}

  {* SHOW ERROR MESSAGE *}
  {if $is_error != 0}
    <div class='error'><img src='../images/error.gif' class='icon' border='0'> {$error_message}</div>
  {/if}

  <table cellpadding='0' cellspacing='0' width='600'>
  <form action='admin_levels_musicsettings.php' method='POST'>
  <tr><td class='header'>{$admin_levels_musicsettings3}</td></tr>
  <tr><td class='setting1'>
  {$admin_levels_musicsettings4}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='level_music_allow' id='music_allow_1' value='1'{if $music_allow == 1} CHECKED{/if}>&nbsp;</td><td><label for='music_music_1'>{$admin_levels_musicsettings5}</label></td></tr>
    <tr><td><input type='radio' name='level_music_allow' id='music_allow_0' value='0'{if $music_allow == 0} CHECKED{/if}>&nbsp;</td><td><label for='music_music_0'>{$admin_levels_musicsettings6}</label></td></tr>
    </table>
  </td></tr></table>

  <br>
  
  <table cellpadding='0' cellspacing='0' width='600'>
  <tr><td class='header'>{$admin_levels_musicsettings7}</td></tr>
  <tr><td class='setting1'>
  {$admin_levels_musicsettings8}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='text' name='level_music_maxnum' value='{$music_maxnum}' maxlength='3' size='5'>&nbsp;{$admin_levels_musicsettings9}</tr>
    </table>
  </td></tr></table>

  <br>

  <table cellpadding='0' cellspacing='0' width='600'>
  <tr><td class='header'>{$admin_levels_musicsettings10}</td></tr>
  <tr><td class='setting1'>
  {$admin_levels_musicsettings11}
  </td></tr><tr><td class='setting2'>
  <textarea name='level_music_exts' rows='2' cols='40' class='text' style='width: 100%;'>{$music_exts_value}</textarea>
  </td></tr></table>

  <br>

  <table cellpadding='0' cellspacing='0' width='600'>
  <tr><td class='header'>{$admin_levels_musicsettings12}</td></tr>
  <tr><td class='setting1'>
  {$admin_levels_musicsettings13}
  </td></tr><tr><td class='setting2'>
  <textarea name='level_music_mimes' rows='2' cols='40' class='text' style='width: 100%;'>{$music_mimes_value}</textarea>
  </td></tr></table>

  <br>

  <table cellpadding='0' cellspacing='0' width='600'>
  <tr><td class='header'>{$admin_levels_musicsettings14}</td></tr>
  <tr><td class='setting1'>
  {$admin_levels_musicsettings15}
  </td></tr><tr><td class='setting2'>
  <select name='level_music_storage' class='text'>
  <option value='102400'{if $music_storage == 102400} SELECTED{/if}>100 Kb</option>
  <option value='204800'{if $music_storage == 204800} SELECTED{/if}>200 Kb</option>
  <option value='512000'{if $music_storage == 512000} SELECTED{/if}>500 Kb</option>
  <option value='1048576'{if $music_storage == 1048576} SELECTED{/if}>1 MB</option>
  <option value='2097152'{if $music_storage == 2097152} SELECTED{/if}>2 MB</option>
  <option value='3145728'{if $music_storage == 3145728} SELECTED{/if}>3 MB</option>
  <option value='4194304'{if $music_storage == 4194304} SELECTED{/if}>4 MB</option>
  <option value='5242880'{if $music_storage == 5242880} SELECTED{/if}>5 MB</option>
  <option value='6291456'{if $music_storage == 6291456} SELECTED{/if}>6 MB</option>
  <option value='7340032'{if $music_storage == 7340032} SELECTED{/if}>7 MB</option>
  <option value='8388608'{if $music_storage == 8388608} SELECTED{/if}>8 MB</option>
  <option value='9437184'{if $music_storage == 9437184} SELECTED{/if}>9 MB</option>
  <option value='10485760'{if $music_storage == 10485760} SELECTED{/if}>10 MB</option>
  <option value='15728640'{if $music_storage == 15728640} SELECTED{/if}>15 MB</option>
  <option value='20971520'{if $music_storage == 20971520} SELECTED{/if}>20 MB</option>
  <option value='26214400'{if $music_storage == 26214400} SELECTED{/if}>25 MB</option>
  <option value='52428800'{if $music_storage == 52428800} SELECTED{/if}>50 MB</option>
  <option value='78643200'{if $music_storage == 78643200} SELECTED{/if}>75 MB</option>
  <option value='104857600'{if $music_storage == 104857600} SELECTED{/if}>100 MB</option>
  <option value='209715200'{if $music_storage == 209715200} SELECTED{/if}>200 MB</option>
  <option value='314572800'{if $music_storage == 314572800} SELECTED{/if}>300 MB</option>
  <option value='419430400'{if $music_storage == 419430400} SELECTED{/if}>400 MB</option>
  <option value='524288000'{if $music_storage == 524288000} SELECTED{/if}>500 MB</option>
  <option value='629145600'{if $music_storage == 629145600} SELECTED{/if}>600 MB</option>
  <option value='734003200'{if $music_storage == 734003200} SELECTED{/if}>700 MB</option>
  <option value='838860800'{if $music_storage == 838860800} SELECTED{/if}>800 MB</option>
  <option value='943718400'{if $music_storage == 943718400} SELECTED{/if}>900 MB</option>
  <option value='1073741824'{if $music_storage == 1073741824} SELECTED{/if}>1 GB</option>
  <option value='2147483648'{if $music_storage == 2147483648} SELECTED{/if}>2 GB</option>
  <option value='5368709120'{if $music_storage == 5368709120} SELECTED{/if}>5 GB</option>
  <option value='10737418240'{if $music_storage == 10737418240} SELECTED{/if}>10 GB</option>
  <option value='0'{if $music_storage == 0} SELECTED{/if}> </option>
  </select>
  </td></tr></table>

  <br>

  <table cellpadding='0' cellspacing='0' width='600'>
  <tr><td class='header'>{$admin_levels_musicsettings16}</td></tr>
  <tr><td class='setting1'>
  {$admin_levels_musicsettings17}
  </td></tr><tr><td class='setting2'>
  <input type='text' class='text' size='5' name='level_music_maxsize' maxlength='6' value='{$music_maxsize}'> KB
  </td></tr>
  </table>
  
  <br>
  
  <table cellpadding='0' cellspacing='0' width='600'>
  <tr><td class='header'>{$admin_levels_musicsettings24}</td></tr>
  <tr><td class='setting1'>
  {$admin_levels_musicsettings25}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td><input type='radio' name='level_music_allow_skins' id='music_allow_1_skins' value='1'{if $music_allow_skins == 1} CHECKED{/if}>&nbsp;</td><td><label for='music_music_skins_1'>{$admin_levels_musicsettings26}</label></td></tr>
    <tr><td><input type='radio' name='level_music_allow_skins' id='music_allow_0_skins' value='0'{if $music_allow_skins == 0} CHECKED{/if}>&nbsp;</td><td><label for='music_music_skins_0'>{$admin_levels_musicsettings27}</label></td></tr>
    </table>  
  </td></tr>
  <tr><td class='setting1'>
  {$admin_levels_musicsettings28}
  </td></tr><tr><td class='setting2'>
    <table cellpadding='0' cellspacing='0'>
    <tr><td>
  	<select name='level_music_skin_default' class='text'>
  	{section name=skin_loop loop=$music_skins}
  	<option value='{$music_skins[skin_loop].skin_id}'{if $music_skins[skin_loop].skin_id == $music_skin_default} SELECTED{/if}>{$music_skins[skin_loop].skin_title}</option>
  	{/section}
  	</tr></td>
    </table>
  </td></tr>  
  </table>
  <br>
  
  <input type='submit' class='button' value='{$admin_levels_musicsettings18}'>
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
  <div style='height: 800px;'>&nbsp;</div>
</td>
</tr>
</table>

{include file='admin_footer.tpl'}