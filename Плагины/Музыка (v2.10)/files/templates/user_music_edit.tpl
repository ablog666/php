{include file='header.tpl'}
{include file='header_music.tpl'}
{assign var='media_dir' value=$url->url_userdir($user->user_info.user_id)}
<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_music_edit.php'>{$user_music_edit4}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_music_settings.php'>{$user_music_edit5}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<img src='./images/icons/music48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_music_edit1}</div>

{* EDIT THE TITLE OF A SONG *}
{if $task == 'edit'}
  <form action='user_music_edit.php' name='editform' method='post' enctype='multipart/form-data'>
  <div>{$user_music_edit3}</div>
  <br>
  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr><td class='form1'>{$user_music_edit7}: </td>
  <td class='form2'><input type='text' name='music_title' value='{$track_info.music_title}' class='text' maxlength='100' size='50'></td><td>&nbsp;</td></tr>
  <tr><td class='form2'><input type='hidden' name='task' value='doedit'><input type='hidden' name='music_id' value='{$track_info.music_id}'></td>
  <td class='form2'><input type='submit' class='button' name='submit' value='Update Song'></td></tr>
  </table>
  </form>

{* SHOW PLAYLIST *}
{else}
  <div>{$user_music_edit2}</div>
  <br>

  {* SHOW BUTTONS *}
  <table cellpadding='0' cellspacing='0'><tr>
  <td class='button' nowrap='nowrap'><a href='user_music_upload.php'><img src='./images/icons/music_upload16.gif' border='0' class='icon'>{$user_music_edit13}</a></td>
  </tr></table>
  <br>

  {* SHOW SONGS IF ANY EXIST *}
  {if $musiclist}

    <form action='user_music_edit.php' method='post'>
    <table cellpadding='0' cellspacing='0' class='music_edit_table'>
    <tr>
    <td class='music_header'></td>
    <td class='music_header' id='music_title'>{$user_music_edit7}</td>
    <td class='music_header' id='music_filesize'>{$user_music_edit8}</td>
    <td class='music_header' id='music_options'>{$user_music_edit9}</td>
    </tr>

    {section name=music_loop loop=$musiclist}
      {assign var='media_path' value="`$media_dir``$musiclist[music_loop].music_id`.`$musiclist[music_loop].music_ext`"}
      <tr>
      <td class='music_list'><input type='checkbox' name='delete_music_{$musiclist[music_loop].music_id}' value='1'></td>
      <td class='music_list' width='100%'>
        <div class='music_button'>
          <object width="17" height="17" data="images/button.swf?song_url={$media_path}&" type="application/x-shockwave-flash">
            <param value="images/button.swf?song_url={$media_path}&" name="movie"/>
            <img width="17" height="17" alt="" src="noflash.gif"/>
          </object>
        </div>
        <div class='music_title'>
          {$musiclist[music_loop].music_title}
        </div>
      </td>
      <td class='music_list'>
        {$musiclist[music_loop].music_filesize}&nbsp;MB
      </td>
      <td class='music_list' nowrap='nowrap'>
        {if $musiclist[music_loop].music_track_num != 1}
          <a href='user_music_edit.php?task=moveup&music_id={$musiclist[music_loop].music_id}'>{$user_music_edit10}</a>
        {else}
          <font class='disabled'>{$user_music_edit10}</font>
        {/if}
        |&nbsp;<a href='user_music_edit.php?task=edit&music_id={$musiclist[music_loop].music_id}'>{$user_music_edit11}</a>
        |&nbsp;<a href='user_music_delete.php?music_id={$musiclist[music_loop].music_id}'>{$user_music_edit12}</a> &nbsp;
      </td>
      </tr>
    {/section} 
  </table>

  <br>

  <input type='submit' class='button' value='Delete Selected Songs'>
  <input type='hidden' name='task' value='dodelete'>
  </form>

  {* SHOW NO SONGS MESSAGE *}
  {else}
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td class='result'><img src='./images/icons/bulb16.gif' border='0' class='icon'>{$user_music_edit14}</td>
    </tr>
    </table>
  {/if}


{/if}

{include file='footer.tpl'}