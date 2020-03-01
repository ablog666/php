{include file='header.tpl'}

  <table cellpadding='0' cellspacing='0' width='100%' border=0>
  <tr valign='top'>
	<td width='60%'>
  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr><td class='home_header'>{$title}</td></tr>
	<tr>
  <td class='home_box'>

{* DISPLAY PAGINATION MENU IF APPLICABLE *}
{if $maxpage > 1}
  <br>
  <div class='center'>
  {if $p != 1}<a href='{$link_files}page={math equation='p-1' p=$p}'>&#171; Предыдущая страница </a>{else}<font class='disabled'>&#171; {$album9}</font>{/if}
  {if $p_start == $p_end}
    &nbsp;|&nbsp; просмотр фото {$p_start} из {$total_files} &nbsp;|&nbsp;
  {else}
    &nbsp;|&nbsp; просмотр фото {$p_start}-{$p_end} из {$total_files} &nbsp;|&nbsp;
  {/if}
  {if $p != $maxpage}<a href='{$link_files}page={math equation='p+1' p=$p}'>Следующая страница &#187;</a>{else}<font class='disabled'>{$album13} &#187;</font>{/if}
  </div>
{/if}

<table cellpadding='0' cellspacing='0' align='center'>
<tr>
<td>

{if !empty($files)}
{* SHOW FILES IN THIS ALBUM *}
{section name=files_loop loop=$files}

  {* START NEW ROW *}
  {cycle name="startrow" values="<table cellpadding='0' cellspacing='0'><tr>,,,,"}
  {* SHOW THUMBNAIL *}
  <td style='padding: 15px; text-align: center; vertical-align: middle;'>
     {$files[files_loop].media_title|truncate:20:"...":true|default:"Неназванный"}&nbsp;
    <div class='album_thumb2' style='width: 120; text-align: center; vertical-align: middle;'>
        <a href='{$url->url_create("album_file", $files[files_loop].media_username, $files[files_loop].media_album_id,$files[files_loop].media_id)}' style="display:block;">
          {if $files[files_loop].media_ext == "jpg" OR
              $files[files_loop].media_ext == "jpeg" OR
              $files[files_loop].media_ext == "gif" OR
              $files[files_loop].media_ext == "png" OR
              $files[files_loop].media_ext == "tif" OR
              $files[files_loop].media_ext == "bmp"}
              <img src='{$files[files_loop].media_path}' onMouseover="tip('Название:&nbsp;{$files[files_loop].media_title|truncate:20:"...":true|default:"нет"}<br>Автор:&nbsp;{$files[files_loop].media_username|truncate:15}<br>Описание:&nbsp;{$files[files_loop].media_desc|truncate:20:"...":true|default:"нет"}<br>Просмотров:&nbsp;{$files[files_loop].media_views}<br>Комментариев:&nbsp;{$files[files_loop].media_comment}', 150)"; onMouseout="hidetip()" class='photo' style="border:none; margin:3px;" border='0' width='{$misc->photo_size($files[files_loop].media_path,"90","90","w")}'>
          {else}
            <img src='./images/icons/file_big.gif' valign="center" class='photo' border='0' width='{$misc->photo_size("./images/icons/file_big.gif","90","90","w")}'>
          {/if}
 </a></div>
        <div align="center">
   Просмотров: {$files[files_loop].media_views} | Комм. {$files[files_loop].media_comment}
        </div>
  </td>
  {* END ROW AFTER 3 RESULTS *}
  {if $smarty.section.files_loop.last == true}
    </tr></table>
  {else}
    {cycle name="endrow" values=",,,,</tr></table>"}
  {/if}

{/section}
{else}
нет фоток.
{/if}
</td>
</tr>
</table>

{* DISPLAY PAGINATION MENU IF APPLICABLE *}
{if $maxpage > 1}
  <br>
  <div class='center'>
  {if $p != 1}<a href='{$link_files}page={math equation='p-1' p=$p}'>&#171; Предыдущая страница </a>{else}<font class='disabled'>&#171; {$album9}</font>{/if}
  {if $p_start == $p_end}
    &nbsp;|&nbsp; просмотр фото {$p_start} из {$total_files} &nbsp;|&nbsp;
  {else}
    &nbsp;|&nbsp; просмотр фото {$p_start}-{$p_end} из {$total_files} &nbsp;|&nbsp;
  {/if}
  {if $p != $maxpage}<a href='{$link_files}page={math equation='p+1' p=$p}'>Следующая страница &#187;</a>{else}<font class='disabled'>{$album13} &#187;</font>{/if}
  </div>
{/if}

	</td>
	</tr>
	</table>
{include file='footer.tpl'}
