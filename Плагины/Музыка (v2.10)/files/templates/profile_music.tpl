{* SHOW MUSIC PLAYER *}
{if $music_allow == '1'}
  <table cellpadding='0' cellspacing='0' width='100%' style='margin-bottom: 10px;'>
  <tr>
  <td class='header'>{$owner->user_info.user_username}{$header_music5}</td>
  </tr>
  <tr>
  <td class='profile'>
    <object width='{$skin_width}' height='{$skin_height}' id='main' align='middle'>
      <param name='movie' value='images/xspf_jukebox.swf?skin_url=include/music_skins/{$skin}/&autoplay={if $autoplay == '0'}false{else}true{/if}&playlist_url=music_playlist.php?user_id={$owner->user_info.user_id}&alphabetize=false&autoload=true&autoresume=false&findImage=true&timedisplay=1&loaded=1' />
      <param name='wmode' value='transparent' />
      <embed src='images/xspf_jukebox.swf?skin_url=include/music_skins/{$skin}/&autoplay={if $autoplay == '0'}false{else}true{/if}&playlist_url=music_playlist.php?user_id={$owner->user_info.user_id}&alphabetize=false&autoload=true&autoresume=false&findImage=true&timedisplay=1&loaded=1' wmode='transparent' width='{$skin_width}' height='{$skin_height}' name='main' align='middle' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />
    </object> 
  </td>
  </tr>
  </table>
{/if}