{include file='admin_header.tpl'}

<h2>{$admin_viewmusic1}</h2>
{$admin_viewmusic2}

<br><br>

<table cellpadding='0' cellspacing='0' width='400' align='center'>
<tr>
<td align='center'>
<div class='box'>
<table cellpadding='0' cellspacing='0' align='center'>
<tr><form action='admin_viewmusic.php' method='POST'>
<td>{$admin_viewmusic4}<br><input type='text' class='text' name='f_title' value='{$f_title}' size='15' maxlength='100'>&nbsp;</td>
<td>{$admin_viewmusic5}<br><input type='text' class='text' name='f_owner' value='{$f_owner}' size='15' maxlength='50'&nbsp;</td>
<td>&nbsp;<input type='submit' class='button' value='{$admin_viewmusic13}'></td>
<input type='hidden' name='s' value='{$s}'>
</form>
</tr>
</table>
</div>
</td></tr></table>

<br>
{if $task == 'delete'}
<table cellpadding='0' cellspacing='0' width='100%'><tr><td class='page'>

<img src='../images/icons/music48.gif' border='0' class='icon_big'>
<div class='page_header'>{$admin_viewmusic15}</div>
<div>{$admin_viewmusic16}</div>

<br>
<table cellpadding='0' cellspacing='0'>
<tr>
<td>
  <form action='admin_viewmusic.php' method='post'>
  <input type='submit' class='button' value='{$admin_viewmusic15}'>&nbsp;
  <input type='hidden' name='task' value='dodelete'>
  <input type='hidden' name='music_id' value='{$music_id}'>
  <input type='hidden' name='owner' value='{$owner}'>
  </form>
</td>
<form action='admin_viewmusic.php' method='POST'>
<td><input type='submit' class='button' value='{$admin_viewmusic17}'></td>
</tr>
</table>
</form>
</td></tr></table>
{else}
{* IF THERE ARE NO MUSIC ENTRIES *}
{if $total_music == 0}

  <table cellpadding='0' cellspacing='0' width='400' align='center'>
  <tr>
  <td align='center'>
    <div class='box' style='width: 300px;'><b>{$admin_viewmusic12}</b></div>
  </td>
  </tr>
  </table>
  <br>

{* IF THERE ARE MUSIC ENTRIES *}
{else}

  {* JAVASCRIPT FOR CHECK ALL *}
  {literal}
  <script language='JavaScript'> 
  <!---
  var checkboxcount = 1;
  function doCheckAll() {
    if(checkboxcount == 0) {
      with (document.items) {
      for (var i=0; i < elements.length; i++) {
      if (elements[i].type == 'checkbox') {
      elements[i].checked = false;
      }}
      checkboxcount = checkboxcount + 1;
      }
    } else
      with (document.items) {
      for (var i=0; i < elements.length; i++) {
      if (elements[i].type == 'checkbox') {
      elements[i].checked = true;
      }}
      checkboxcount = checkboxcount - 1;
      }
  }
  // -->
  </script>
  {/literal}

  <div class='pages'>{$total_music} {$admin_viewmusic10} &nbsp;|&nbsp; {$admin_viewmusic11} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_viewmusic.php?s={$s}&p={$pages[page_loop].page}&f_title={$f_title}&f_owner={$f_owner}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
  
  <form action='admin_viewmusic.php' method='post' name='items'>
  <table cellpadding='0' cellspacing='0' class='list'>
  <tr>
  <td class='header' width='10'><input type='checkbox' name='select_all' onClick='javascript:doCheckAll()'></td>
  <td class='header' width='10' style='padding-left: 0px;'><a class='header' href='admin_viewmusic.php?s={$i}&p={$p}&f_title={$f_title}&f_owner={$f_owner}'>{$admin_viewmusic3}</a></td>
  <td class='header'><a class='header' href='admin_viewmusic.php?s={$t}&p={$p}&f_title={$f_title}&f_owner={$f_owner}'>{$admin_viewmusic4}</a></td>
  <td class='header'><a class='header' href='admin_viewmusic.php?s={$o}&p={$p}&f_title={$f_title}&f_owner={$f_owner}'>{$admin_viewmusic5}</a></td>
  <td class='header' width='100'><a class='header' href='admin_viewmusic.php?s={$d}&p={$p}&f_title={$f_title}&f_owner={$f_owner}'>{$admin_viewmusic6}</a></td>
  <td class='header' width='100'>{$admin_viewmusic7}</td>
  </tr>
   {section name=music_loop loop=$entries}
   {assign var='media_dir' value=$url->url_userdir($entries[music_loop].music_user_id)}
   {assign var='media_path' value=".`$media_dir``$entries[music_loop].music_id`.`$entries[music_loop].music_ext`"}
    <tr class='{cycle values="background1,background2"}'>
    <td class='item' style='padding-right: 0px;'><input type='checkbox' name='delete_entry_{$entries[music_loop].music_id}' value='1'></td>
    <td class='item' style='padding-left: 0px;'>{$entries[music_loop].music_id}</td>
    <td class='item'>
    <object width="17" height="17" data="../images/button.swf?song_url={$media_path}&autoload=false&" type="application/x-shockwave-flash">
	<param value="../images/button.swf?song_url={$media_path}&autoload=false&" name="movie"/>
	<img width="17" height="17" alt="" src="noflash.gif"/>
	</object>
    {$entries[music_loop].music_title}</td>
    <td class='item'><a href='#' target='_blank'>{$entries[music_loop].music_username}</a></td>
    <td class='item'>{$datetime->cdate($setting.setting_dateformat, $datetime->timezone($entries[music_loop].music_date, $setting.setting_timezone))}</td>
    <td class='item'>[ <a href='admin_viewmusic.php?task=delete&music_id={$entries[music_loop].music_id}&owner={$entries[music_loop].music_user_id}'>{$admin_viewmusic8}</a> ]</td>
    </tr>
  {/section}
  </table>

  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td>
    <br>
    <input type='submit' class='button' value='{$admin_viewmusic14}'>
    <input type='hidden' name='task' value='delete'>
    <input type='hidden' name='p' value='{$p}'>
    <input type='hidden' name='s' value='{$s}'>
    <input type='hidden' name='f_title' value='{$f_title}'>
    <input type='hidden' name='f_owner' value='{$f_owner}'>
    </form>
  </td>
  <td align='right' valign='top'>
    <div class='pages2'>{$total_music} {$admin_viewmusic10} &nbsp;|&nbsp; {$admin_viewmusic11} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_viewmusic.php?s={$s}&p={$pages[page_loop].page}&f_title={$f_title}&f_owner={$f_owner}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
  </td>
  </tr>
  </table>

{/if}
{/if}

{include file='admin_footer.tpl'}