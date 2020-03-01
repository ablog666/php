{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_music_edit.php'>{$user_music_settings4}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_music_settings.php'>{$user_music_settings5}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<img src='./images/icons/music48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_music_settings1}</div>
<div>{$user_music_settings2}</div>

<br>

{* SHOW SAVE CHANGES MESSAGE *}
{if $task == "dosave"}
  <table cellpadding='0' cellspacing='0'>
  <tr><td class='success'><img src='./images/success.gif' border='0' class='icon'>Your changes have been saved.</td></tr>
  </table>
  <br>
{/if}

<form action='user_music_settings.php' method='post'>
<div><b>{$user_music_settings9}</b></div>
<table cellpadding='0' cellspacing='0'>
<tr>
<td><input type='radio' name='profile_autoplay' id='profile_autoplay1' value='1' {if $profile_autoplay == '1'}checked{/if}></td>
<td><label for='profile_autoplay1'>{$user_music_settings10}</label></td>
</tr>
<tr>
<td><input type='radio' name='profile_autoplay' id='profile_autoplay0' value='0' {if $profile_autoplay == '0'}checked{/if}></td>
<td><label for='profile_autoplay0'>{$user_music_settings11}</label></td>
</tr>
</table>

<br>

<div><b>{$user_music_settings12}</b></div>
<table cellpadding='0' cellspacing='0'>
<tr>
<td><input type='radio' name='site_autoplay' id='site_autoplay1' value='1' {if $site_autoplay == '1'}checked{/if}></td>
<td><label for='site_autoplay1'>{$user_music_settings13}</label></td>
</tr>
<tr>
<td><input type='radio' name='site_autoplay' id='site_autoplay0' value='0' {if $site_autoplay == '0'}checked{/if}></td>
<td><label for='site_autoplay0'>{$user_music_settings14}</label></td>
</tr>
</table>

{* SHOW SKIN SELECTION IF ALLOWED *}
{if $skins}
  <br>
  <div><b>Music Player Skin</b></div>
  <select class='text' name='select_music_skin' id='select_music_skin' onChange='showPlayerSkin()' style='width: 150px;'>
  {section name=skin_loop loop=$skins}
    <option value='{$skins[skin_loop].skin_id}'{if $skins[skin_loop].skin_id == $skin_id} selected='selected'{/if}>{$skins[skin_loop].skin_title}</option>
  {/section}	
  </select>
  <input type='hidden' name='skin_id_cache' id='skin_id_cache' value='{$skin_id}'>
  <br><br>
  {section name=skin_loop2 loop=$skins}
    <div id='skin{$skins[skin_loop2].skin_id == $skin_id}'{if $skins[skin_loop2].skin_id != $skin_id} style='display: none;'{/if}>
      <img src='include/music_skins/{$skins[skin_loop2].skin_title}/screenshot.jpg'>
    </div>
  {/section}

  {literal}
  <script type='text/javascript'>
  <!--
  function showPlayerSkin() {
    old_skin = document.getElementById('skin_id_cache').value;
    new_skin = document.getElementById('select_music_skin').value;
    hidediv('skin'+old_skin);
    showdiv('skin'+new_skin);
    document.getElementById('skin_id_cache').value = new_skin; 
  }
  //-->
  </script>
  {/literal}
  
{/if}

<br>
<table cellpadding='0' cellspacing='0'>
<tr>
<td>
  <input type='submit' class='button' value='{$user_music_settings15}'>&nbsp;
  <input type='hidden' name='task' value='dosave'>
  </form>
</td>
<td>
  <form action='user_music_edit.php' method='get'>
  <input type='submit' class='button' value='Cancel'>
  </form>
</td>
</tr>
</table>

{include file='footer.tpl'}