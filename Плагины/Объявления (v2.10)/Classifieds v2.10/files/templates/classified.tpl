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
    commentBody.value = '{/literal}{$classified14}{literal}';
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
  commentSubmit.value = '{/literal}{$classified15}{literal}';
  commentSubmit.disabled = true;
  
}

function addComment(is_error, comment_body, comment_date) {
  if(is_error == 1) {
    var commentError = document.getElementById('comment_error');
    commentError.style.display = 'block';
    if(comment_body == '') {
      commentError.innerHTML = '{/literal}{$classified16}{literal}';
    } else {
      commentError.innerHTML = '{/literal}{$classified17}{literal}';
    }
    var commentSubmit = document.getElementById('comment_submit');
    commentSubmit.value = '{/literal}{$classified18}{literal}';
    commentSubmit.disabled = false;
  } else {
    var commentError = document.getElementById('comment_error');
    commentError.style.display = 'none';
    commentError.innerHTML = '';

    var commentBody = document.getElementById('comment_body');
    commentBody.value = '';
    addText(commentBody);

    var commentSubmit = document.getElementById('comment_submit');
    commentSubmit.value = '{/literal}{$classified18}{literal}';
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
    var newTable = "<table cellpadding='0' cellspacing='0' width='100%'><tr><td class='classified_item1' width='80'>";
    {/literal}
      {if $user->user_info.user_id != 0}
        newTable += "<a href='{$url->url_create('profile',$user->user_info.user_username)}'><img src='{$user->user_photo('./images/nophoto.gif')}' class='photo' border='0' width='{$misc->photo_size($user->user_photo('./images/nophoto.gif'),'150','150','w')}'></a></td><td class='classified_item2'><table cellpadding='0' cellspacing='0' width='100%'><tr><td class='classified_comment_author'><b><a href='{$url->url_create('profile',$user->user_info.user_username)}'>{$user->user_info.user_username}</a></b> - {$datetime->cdate("`$setting.setting_timeformat` `$classified30` `$setting.setting_dateformat`", $datetime->timezone($smarty.now, $global_timezone))}</td><td class='classified_comment_author' align='right' nowrap='nowrap'>&nbsp;[ <a href='user_messages_new.php?to={$user->user_info.user_username}'>{$classified20}</a> ]</td>";
      {else}
        newTable += "<img src='./images/nophoto.gif' class='photo' border='0' width='75'></td><td class='classified_item2'><table cellpadding='0' cellspacing='0' width='100%'><tr><td class='classified_comment_author'><b>{$classified11}</b> - {$datetime->cdate("`$setting.setting_timeformat` `$classified30` `$setting.setting_dateformat`", $datetime->timezone($smarty.now, $global_timezone))}</td><td class='classified_comment_author' align='right' nowrap='nowrap'>&nbsp;</td>";
      {/if}
      newTable += "</tr><tr><td colspan='2' class='classified_comment_body'>"+comment_body+"</td></tr></table></td></tr></table>";
    {literal}
    newComment.innerHTML = newTable;
    var classifiedComments = document.getElementById('classified_comments');
    var prevComment = document.getElementById('comment_'+last_comment);
    classifiedComments.insertBefore(newComment, prevComment);
    next_comment++;
    last_comment++;
  }
}

//-->
</script>
{/literal}


<div class='page_header'><a href='{$url->url_create('profile', $owner->user_info.user_username)}'>{$owner->user_info.user_username}</a>{$classified3} <a href='{$url->url_create('classifieds', $owner->user_info.user_username)}'>{$classified4}</a></div>
<br>

{if isset($page_is_preview)}
<table cellspacing='0' cellpadding='0' id='classifiedpreview' style='width:100%'>
<tr><td>&nbsp;</td><td class='content' style='width:100%'>
{/if}

{* SHOW THIS ENTRY *}
<div class='classified1'>
  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td valign='top' width='1' class='classified_photo'><img src='{$classified->classified_photo("./images/nophoto.gif")}' border='0' class='photo'></td>
  <td valign='top'>
    <div class='classified_title'>{$classified->classified_info.classified_title|truncate:75:"...":true}</div>
    <div class='classified_date'>
      {assign var='classified_date' value=$classified->classified_info.classified_date}
      {$classified27} {$datetime->cdate("`$setting.setting_dateformat`", $datetime->timezone($classified_date, $global_timezone))} {$classified28} {$datetime->cdate("`$setting.setting_timeformat`", $datetime->timezone($classified_date, $global_timezone))}, {$classified->classified_info.classified_views} {$classified29}
    </div>
    {* SHOW ENTRY CATEGORY *}
    {if $cat_info.classifiedcat_title != ""}
      <div class='classified_category'>{$classified7} <a href='user_classified_browse.php?classifiedcat_id={$classified->classified_info.classified_classifiedcat_id}'>{$cat_info.classifiedcat_title}</a></div>
    {/if}
    <div class='classified_fields'>
      {section name=field_loop loop=$fields}
      <div>{$fields[field_loop].field_title}: {$fields[field_loop].field_value_formatted}</div>
      {/section}
    </div>
    <div class='classified_body'>{$classified->classified_info.classified_body|choptext:75:"<br>"}</div>

    {if $total_files > 0}
      <br>
    {/if}

    {* SHOW FILES IN THIS ALBUM *}
    {section name=file_loop loop=$files}

      {* IF IMAGE, GET THUMBNAIL *}
      {if $files[file_loop].classifiedmedia_ext == "jpeg" OR $files[file_loop].classifiedmedia_ext == "jpg" OR $files[file_loop].classifiedmedia_ext == "gif" OR $files[file_loop].classifiedmedia_ext == "png" OR $files[file_loop].classifiedmedia_ext == "bmp"}
        {assign var='file_dir' value=$classified->classified_dir($classified->classified_info.classified_id)}
        {assign var='file_src' value="`$file_dir``$files[file_loop].classifiedmedia_id`.jpg"}
      {* SET THUMB PATH FOR AUDIO *}
      {elseif $files[file_loop].classifiedmedia_ext == "mp3" OR $files[file_loop].classifiedmedia_ext == "mp4" OR $files[file_loop].classifiedmedia_ext == "wav"}
        {assign var='file_src' value='./images/icons/audio_big.gif'}
      {* SET THUMB PATH FOR VIDEO *}
      {elseif $files[file_loop].classifiedmedia_ext == "mpeg" OR $files[file_loop].classifiedmedia_ext == "mpg" OR $files[file_loop].classifiedmedia_ext == "mpa" OR $files[file_loop].classifiedmedia_ext == "avi" OR $files[file_loop].classifiedmedia_ext == "swf" OR $files[file_loop].classifiedmedia_ext == "mov" OR $files[file_loop].classifiedmedia_ext == "ram" OR $files[file_loop].classifiedmedia_ext == "rm"}
        {assign var='file_src' value='./images/icons/video_big.gif'}
      {* SET THUMB PATH FOR UNKNOWN *}
      {else}
        {assign var='file_src' value='./images/icons/file_big.gif'}
      {/if}

      {* START NEW ROW *}
      {cycle name="startrow" values="<table cellpadding='0' cellspacing='0'><tr>,"}
      {* SHOW THUMBNAIL *}
      <td style='padding: 5px 10px 5px 0px; text-align: center; vertical-align: middle;'>
        {$files[file_loop].classifiedmedia_title|truncate:20:"...":true}
        <div class='album_thumb2' style='text-align: center; vertical-align: middle;'>
          <img src='{$file_src}' border='0'  width='{$misc->photo_size($file_src,'300','240','w')}' class='photo'>
        </div>
      </td>
      {* END ROW AFTER 3 RESULTS *}
      {if $smarty.section.file_loop.last == true}
        </tr></table>
      {else}
        {cycle name="endrow" values=",</tr></table>"}
      {/if}

    {/section}

  </td>
  </tr>
  </table>
</div>

<br>

<div>
  <a href='{$url->url_create('classifieds', $owner->user_info.user_username)}'><img src='./images/icons/back16.gif' border='0' class='icon'>{$classified24}{$owner->user_info.user_username}{$classified25}</a>
  &nbsp;&nbsp;&nbsp;
  <a href='user_messages_new.php?to={$owner->user_info.user_username}'><img src='./images/icons/sendmessage16.gif' border='0' class='icon'>{$classified21}</a>
  &nbsp;&nbsp;&nbsp;
  <a href='user_report.php?return_url={$url->url_current()}'><img src='./images/icons/report16.gif' border='0' class='icon'>{$classified26}</a>
</div>

<br>

{* BEGIN COMMENTS *}
<table cellpadding='0' cellspacing='0' width='100%'>
<tr>  
<td class='header'>
  {$classified8} (<span id='total_comments'>{$total_comments}</span>)
</td>
</tr>
{if $allowed_to_comment != 0}
  <tr id='classified_postcomment'>
  <td class='classified_postcomment'>
    <form action='classified.php' method='post' target='AddCommentWindow' onSubmit='checkText()'>
    <textarea name='comment_body' id='comment_body' rows='2' cols='65' onfocus='removeText(this)' onblur='addText(this)' style='color: #888888; width: 100%;'>{$classified14}</textarea>

    <table cellpadding='0' cellspacing='0' width='100%'>
    <tr>
    {if $setting.setting_comment_code == 1}
      <td width='75' valign='top'><img src='./images/secure.php' id='secure_image' border='0' height='20' width='67' class='signup_code'></td>
      <td width='68' style='padding-top: 4px;'><input type='text' name='comment_secure' id='comment_secure' class='text' size='6' maxlength='10'></td>
      <td width='10'><img src='./images/icons/tip.gif' border='0' class='icon' onMouseover="tip('{$classified19}')"; onMouseout="hidetip()"></td>
    {/if}
    <td align='right' style='padding-top: 5px;'>
    <input type='submit' id='comment_submit' class='button' value='{$classified18}'>
    <input type='hidden' name='user' value='{$owner->user_info.user_username}'>
    <input type='hidden' name='classified_id' value='{$classified->classified_info.classified_id}'>
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
<td class='classified' id='classified_comments'>

  {* LOOP THROUGH classified COMMENTS *}
  {section name=comment_loop loop=$comments}
    <div id='comment_{math equation='t-c' t=$comments|@count c=$smarty.section.comment_loop.index}'>
    <table cellpadding='0' cellspacing='0' width='100%'>
    <tr>
    <td class='classified_item1' width='80'>
      {if $comments[comment_loop].comment_author->user_info.user_id != 0}
        <a href='{$url->url_create('profile',$comments[comment_loop].comment_author->user_info.user_username)}'><img src='{$comments[comment_loop].comment_author->user_photo('./images/nophoto.gif')}' class='photo' border='0' width='{$misc->photo_size($comments[comment_loop].comment_author->user_photo('./images/nophoto.gif'),'75','75','w')}'></a>
      {else}
        <img src='./images/nophoto.gif' class='photo' border='0' width='75'>
      {/if}
    </td>
    <td class='classified_item2'>
      <table cellpadding='0' cellspacing='0' width='100%'>
      <tr>
      <td class='classified_comment_author'><b>{if $comments[comment_loop].comment_author->user_info.user_id != 0}<a href='{$url->url_create('profile',$comments[comment_loop].comment_author->user_info.user_username)}'>{$comments[comment_loop].comment_author->user_info.user_username}</a>{else}{$classified11}{/if}</b> - {$datetime->cdate("`$setting.setting_timeformat` `$classified30` `$setting.setting_dateformat`", $datetime->timezone($comments[comment_loop].comment_date, $global_timezone))}</td>
      <td class='classified_comment_author' align='right' nowrap='nowrap'>&nbsp;[ <a href='user_messages_new.php?to={$comments[comment_loop].comment_author->user_info.user_username}'>{$classified20}</a> ]</td>
      </tr>
      <tr>
      <td colspan='2' class='classified_comment_body'>{$comments[comment_loop].comment_body}</td>
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