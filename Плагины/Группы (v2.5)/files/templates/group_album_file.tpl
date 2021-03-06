{include file='header.tpl'}


{* JAVASCRIPT FOR ADDING COMMENT *}
{literal}
<script type='text/javascript'>
<!--
var comment_changed = 0;
var last_comment = {/literal}{$comments|@count}{literal};
var next_comment = last_comment+1;
var total_comments = {/literal}{$total_comments}{literal};

function removeText(commentBody) {
  if(comment_changed == 0) {
    commentBody.value='';
    commentBody.style.color='#000000';
    comment_changed = 1;
  }
}

function addText(commentBody) {
  if(commentBody.value == '') {
    commentBody.value = '{/literal}{$group_album_file18}{literal}';
    commentBody.style.color = '#888888';
    comment_changed = 0;
  }
}

function checkText() {
  if(comment_changed == 0) { 
    var commentBody = document.getElementById('comment_body');
    commentBody.value=''; 
  }
  var commentSubmit = document.getElementById('comment_submit');
  commentSubmit.value = '{/literal}{$group_album_file19}{literal}';
  commentSubmit.disabled = true;
  
}

function addComment(is_error, comment_body, comment_date) {
  if(is_error == 1) {
    var commentError = document.getElementById('comment_error');
    commentError.style.display = 'block';
    if(comment_body == '') {
      commentError.innerHTML = '{/literal}{$group_album_file20}{literal}';
    } else {
      commentError.innerHTML = '{/literal}{$group_album_file21}{literal}';
    }
    var commentSubmit = document.getElementById('comment_submit');
    commentSubmit.value = '{/literal}{$group_album_file10}{literal}';
    commentSubmit.disabled = false;
  } else {
    var commentError = document.getElementById('comment_error');
    commentError.style.display = 'none';
    commentError.innerHTML = '';

    var commentBody = document.getElementById('comment_body');
    commentBody.value = '';
    addText(commentBody);

    var commentSubmit = document.getElementById('comment_submit');
    commentSubmit.value = '{/literal}{$group_album_file10}{literal}';
    commentSubmit.disabled = false;

    if(document.getElementById('comment_secure')) {
      var commentSecure = document.getElementById('comment_secure');
      commentSecure.value=''
      var secureImage = document.getElementById('secure_image');
      secureImage.src = secureImage.src + '?' + (new Date()).getTime();
    }

    total_comments++;
    var totalComments = document.getElementById('total_comments');
    totalComments.innerHTML = total_comments;

    var newComment = document.createElement('div');
    var divIdName = 'comment_'+next_comment;
    newComment.setAttribute('id',divIdName);
    var newTable = "<table cellpadding='0' cellspacing='0' width='100%'><tr><td class='album_item1' width='80'>";
    {/literal}
      {if $user->user_info.user_id != 0}
        newTable += "<a href='{$url->url_create('profile',$user->user_info.user_username)}'><img src='{$user->user_photo('./images/nophoto.gif')}' class='photo' border='0' width='{$misc->photo_size($user->user_photo('./images/nophoto.gif'),'75','75','w')}'></a></td><td class='album_item2'><table cellpadding='0' cellspacing='0' width='100%'><tr><td class='album_comment_author'><b><a href='{$url->url_create('profile',$user->user_info.user_username)}'>{$user->user_info.user_username}</a></b> - {$datetime->cdate("`$setting.setting_timeformat` `$group_album_file22` `$setting.setting_dateformat`", $datetime->timezone($smarty.now, $global_timezone))}</td><td class='album_comment_author' align='right' nowrap='nowrap'>&nbsp;[ <a href='user_messages_new.php?to={$user->user_info.user_username}'>{$group_album_file23}</a> ]</td>";
      {else}
        newTable += "<img src='./images/nophoto.gif' class='photo' border='0' width='75'></td><td class='album_item2'><table cellpadding='0' cellspacing='0' width='100%'><tr><td class='album_comment_author'><b>{$group_album_file14}</b> - {$datetime->cdate("`$setting.setting_timeformat` `$group_album_file22` `$setting.setting_dateformat`", $datetime->timezone($smarty.now, $global_timezone))}</td><td class='album_comment_author' align='right' nowrap='nowrap'>&nbsp;</td>";
      {/if}
      newTable += "</tr><tr><td colspan='2' class='album_comment_body'>"+comment_body+"</td></tr></table></td></tr></table>";
    {literal}
    newComment.innerHTML = newTable;
    var mediaComments = document.getElementById('media_comments');
    var prevComment = document.getElementById('comment_'+last_comment);
    mediaComments.insertBefore(newComment, prevComment);
    next_comment++;
    last_comment++;
  }
}
//-->
</script>
{/literal}


<table class='tabs' cellpadding='0' cellspacing='0' width='100%'>
<tr><td class='tab0'>&nbsp;</td></tr>
</table>

<div class='page_header'><img src='./images/icons/album22.gif' border='0' class='icon'> <a href='group.php?group_id={$group->group_info.group_id}'>{$group->group_info.group_title}</a>'s <a href='group_album.php?group_id={$group->group_info.group_id}'>{$group_album_file4}</a></div>

{* SET MEDIA PATH *}
{assign var='groupmedia_dir' value=$group->group_dir($group->group_info.group_id)}
{assign var='groupmedia_path' value="`$groupmedia_dir``$groupmedia_info.groupmedia_id`.`$groupmedia_info.groupmedia_ext`"}



{* DISPLAY IMAGE *}
{if $groupmedia_info.groupmedia_ext == "jpg" OR 
    $groupmedia_info.groupmedia_ext == "jpeg" OR 
    $groupmedia_info.groupmedia_ext == "gif" OR 
    $groupmedia_info.groupmedia_ext == "png" OR 
    $groupmedia_info.groupmedia_ext == "bmp"}
  {assign var='file_src' value="<img src='`$groupmedia_path`' border='0'>"}

{* DISPLAY AUDIO *}
{elseif $groupmedia_info.groupmedia_ext == "mp3" OR 
        $groupmedia_info.groupmedia_ext == "mp4" OR 
        $groupmedia_info.groupmedia_ext == "wav"}
  {assign var='groupmedia_download' value="[ <a href='`$groupmedia_path`'>`$group_album_file5`</a> ]"}
  {assign var='file_src' value="<a href='`$groupmedia_path`'><img src='./images/icons/audio_big.gif' border='0'></a>"}

{* DISPLAY WINDOWS VIDEO *}
{elseif $groupmedia_info.groupmedia_ext == "mpeg" OR 
	$groupmedia_info.groupmedia_ext == "mpg" OR 
	$groupmedia_info.groupmedia_ext == "mpa" OR 
	$groupmedia_info.groupmedia_ext == "avi" OR 
	$groupmedia_info.groupmedia_ext == "ram" OR 
	$groupmedia_info.groupmedia_ext == "rm"}
  {assign var='groupmedia_download' value="[ <a href='`$groupmedia_path`'>`$group_album_file6`</a> ]"}
  {assign var='file_src' value="
    <object id='video'
      classid='CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6'
      type='application/x-oleobject'>
      <param name='url' value='`$groupmedia_path`'>
      <param name='sendplaystatechangeevents' value='True'>
      <param name='autostart' value='true'>
      <param name='autosize' value='true'>
      <param name='uimode' value='mini'>
      <param name='playcount' value='9999'>
    </OBJECT>
  "}

{* DISPLAY QUICKTIME FILE *}
{elseif $groupmedia_info.groupmedia_ext == "mov" OR 
	$groupmedia_info.groupmedia_ext == "moov" OR 
	$groupmedia_info.groupmedia_ext == "movie" OR 
	$groupmedia_info.groupmedia_ext == "qtm" OR 
	$groupmedia_info.groupmedia_ext == "qt"}
  {assign var='groupmedia_download' value="[ <a href='`$groupmedia_path`'>`$group_album_file6`</a> ]"}
  {assign var='file_src' value="
    <embed src='`$groupmedia_path`' controller='true' autosize='1' scale='1' width='550' height='350'>
  "}

{* EMBED FLASH FILE *}
{elseif $groupmedia_info.groupmedia_ext == "swf"}
  {assign var='file_src' value="
    <object width='350' height='250' classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0' id='mymoviename'> 
      <param name='movie' value='$groupmedia_path'>  
      <param name='quality' value='high'> 
      <param name='bgcolor' value='#ffffff'> 
      <embed src='`$groupmedia_path`' quality='high' bgcolor='#ffffff' name='Flash Movie' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer'> 
      </embed> 
    </object> 
  "}

{* DISPLAY UNKNOWN FILETYPE *}
{else}
  {assign var='groupmedia_download' value="[ <a href='`$groupmedia_path`'>`$group_album_file7`</a> ]"}
  {assign var='file_src' value="<a href='`$groupmedia_path`'><img src='./images/icons/file_big.gif' border='0'></a>"}
{/if}





<br>

{* SHOW ARROWS, HIDE IF NECESSARY *}
<table cellpadding='0' cellspacing='0' align='center'>
<tr>
<td width='30' align='right'>{if $link_first != "#"}<a href='{$link_first}'><img src='./images/icons/arrow_start.gif' class='icon' border='0'></a>{/if}</td>
<td width='30' align='right'>{if $link_back != "#"}<a href='{$link_back}'><img src='./images/icons/arrow_back.gif' class='icon' border='0'></a>{/if}</td>
<td align='center' nowrap='nowrap' style='padding-right: 8px;'><b>[ <a href='group_album.php?group_id={$group->group_info.group_id}'>{$group_album_file8} {$group->group_info.group_title}{$group_album_file9}</a> ]</b></td>
<td width='30'>{if $link_next != "#"}<a href='{$link_next}'><img src='./images/icons/arrow_next.gif' class='icon' border='0'></a>{/if}</td>
<td width='30'>{if $link_end != "#"}<a href='{$link_end}'><img src='./images/icons/arrow_end.gif' class='icon' border='0'></a>{/if}</td>
</tr>
</table>

<br>

<table cellpadding='0' cellspacing='0' align='center' width='100%'>
<tr>
<td align='center'>
  <div class='album_title'>{$groupmedia_info.groupmedia_title}</div>
  {if $groupmedia_info.groupmedia_desc != ""}{$groupmedia_info.groupmedia_desc}<br><br>{/if}
  {if $link_next != "#"}<a href='{$link_next}'>{$file_src}</a>{else}{$file_src}{/if}
  {if $groupmedia_download != ""}<br><br>{$groupmedia_download}{/if}

  <br><br>

  {* SHOW REPORT LINK *}
  <table cellpadding='0' cellspacing='0' align='center'>
  <tr>
  <td>
    <table cellpadding='0' cellspacing='0'>
    <tr><td class='button'>
      <a href='user_report.php?return_url={$url->url_current()}'><img src='./images/icons/report16.gif' border='0' class='icon'>{$group_album_file11}</a>
    </td></tr>
    </table>
  </td>
  </tr>
  </table>
</td>
</tr>
</table>


<br>

{* BEGIN COMMENTS *}
<table cellpadding='0' cellspacing='0' width='100%'>
<tr>  
<td class='header'>
  {$group_album_file12} (<span id='total_comments'>{$total_comments}</span>)
</td>
</tr>
{if $allowed_to_comment != 0}
  <tr>
  <td class='album_postcomment'>
    <form action='group_album_file.php' method='post' target='AddCommentWindow' onSubmit='checkText()'>
    <textarea name='comment_body' id='comment_body' rows='2' cols='65' onfocus='removeText(this)' onblur='addText(this)' style='color: #888888; width: 100%;'>{$group_album_file18}</textarea>

    <table cellpadding='0' cellspacing='0' width='100%'>
    <tr>
    {if $setting.setting_comment_code == 1}
      <td width='75' valign='top'><img src='./images/secure.php' id='secure_image' border='0' height='20' width='67' class='signup_code'></td>
      <td width='68' style='padding-top: 4px;'><input type='text' name='comment_secure' id='comment_secure' class='text' size='6' maxlength='10'></td>
      <td width='10'><img src='./images/icons/tip.gif' border='0' class='icon' onMouseover="tip('{$group_album_file24}')"; onMouseout="hidetip()"></td>
    {/if}
    <td align='right' style='padding-top: 5px;'>
    <input type='submit' id='comment_submit' class='button' value='{$group_album_file10}'>
    <input type='hidden' name='groupmedia_id' value='{$groupmedia_info.groupmedia_id}'>
    <input type='hidden' name='group_id' value='{$group->group_info.group_id}'>
    <input type='hidden' name='task' value='dopost'>
    </form>
    </td>
    </tr>
    </table>
    <div id='comment_error' style='color: #FF0000; display: none;'></div>
    <iframe name='AddCommentWindow' style='display: none' src=''></iframe>
  </td>
  </tr>
{/if}
<tr>
<td class='album' id='media_comments'>

  {* LOOP THROUGH GROUP MEDIA COMMENTS *}
  {section name=comment_loop loop=$comments}
    <div id='comment_{math equation='t-c' t=$comments|@count c=$smarty.section.comment_loop.index}'>
    <table cellpadding='0' cellspacing='0' width='100%'>
    <tr>
    <td class='album_item1' width='80'>
      {if $comments[comment_loop].comment_author->user_info.user_id != 0}
        <a href='{$url->url_create('profile',$comments[comment_loop].comment_author->user_info.user_username)}'><img src='{$comments[comment_loop].comment_author->user_photo('./images/nophoto.gif')}' class='photo' border='0' width='{$misc->photo_size($comments[comment_loop].comment_author->user_photo('./images/nophoto.gif'),'75','75','w')}'></a>
      {else}
        <img src='./images/nophoto.gif' class='photo' border='0' width='75'>
      {/if}
    </td>
    <td class='album_item2'>
      <table cellpadding='0' cellspacing='0' width='100%'>
      <tr>
      <td class='album_comment_author'><b>{if $comments[comment_loop].comment_author->user_info.user_id != 0}<a href='{$url->url_create('profile',$comments[comment_loop].comment_author->user_info.user_username)}'>{$comments[comment_loop].comment_author->user_info.user_username}</a>{else}{$group_album_file14}{/if}</b> - {$datetime->cdate("`$setting.setting_timeformat` `$group_album_file22` `$setting.setting_dateformat`", $datetime->timezone($comments[comment_loop].comment_date, $global_timezone))}</td>
      <td class='album_comment_author' align='right' nowrap='nowrap'>&nbsp;[ <a href='user_messages_new.php?to={$comments[comment_loop].comment_author->user_info.user_username}'>{$group_album_file23}</a> ]</td>
      </tr>
      <tr>
      <td colspan='2' class='album_comment_body'>{$comments[comment_loop].comment_body}</td>
      </tr>
      </table>
    </td>
    </tr>
    </table>
    </div>
  {/section}

</td>
</tr>
</table>
{* END COMMENTS *}


{include file='footer.tpl'}