{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_classified.php'>{$user_classified_edit_media1}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_classified_settings.php'>{$user_classified_edit_media2}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_classified_browse.php'>{$user_classified_edit_media5}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<img src='./images/icons/classified48.gif' border='0' class='icon_big'>
<div class='page_header'>{$user_classified_edit_media3}</div>
<div>{$user_classified_edit_media4}</div>

<br><br>

{* SHOW JUST ADDED MESSAGE *}
{if $justadded == 1}
  <div id='classified_result'>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td class='success'><img src='./images/success.gif' border='0' class='icon'>{$user_classified_edit_media6}</td>
    </tr>
    </table>
    <br>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td><input type='button' class='button' value='{$user_classified_edit_media17}' onClick="hidediv('classified_result');showdiv('classified_pagecontent');">&nbsp;</td>
    <td>
      <form action='user_classified.php' method='get'>
      <input type='submit' class='button' value='{$user_classified_edit_media18}'>
      </form>
    </td>
    </tr>
    </table>
  </div>
{/if}

<div id='classified_pagecontent' style='{if $justadded == 1}display: none;{/if}'>

{if $user->level_info.level_classified_photo != 0}
  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td class='header'>{$user_classified_edit_media7}</td>
  </tr>
  <tr>
  <td class='classified_box'>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td valign='top'><img src='{$classified->classified_photo("./images/nophoto.gif")}' border='0' class='photo'></td>
    <td style='padding-left: 10px;' valign='top'>
      <form action='user_classified_edit_media.php' method='post' enctype='multipart/form-data'>
      <div>{$user_classified_edit_media9}</div>
      <input type='file' name='photo' class='text' size='40'>
      <input type='submit' class='button' value='{$user_classified_edit_media8}'>
      <input type='hidden' name='task' value='upload'>
      <input type='hidden' name='MAX_FILE_SIZE' value='5000000'>
      <input type='hidden' name='classified_id' value='{$classified_id}'>
      </form>
    </td>
    </tr>
    </table>
  </td>
  </tr>
  </table>

  <br>
{/if}



  {literal}
  <script type='text/javascript'>
  <!--
  function doUpload(spot) {
    hidediv('uploadform'+spot);
    showdiv('uploadform_uploading'+spot);
  }

  function uploadComplete(result_code, response, spot, classifiedmedia_id) {
    if(result_code == 1) {
      alert(response);
      showdiv('uploadform'+spot);
      hidediv('uploadform_uploading'+spot);
    } else {
      hidediv('uploadform_uploading'+spot);
      showdiv('uploadform_uploaded'+spot);
      uploadform_newmedia = document.getElementById('uploadform_newmedia'+spot);
      uploadform_newmedia.src = response;
      var nextspot = parseInt(spot);
      nextspot = nextspot + 1;
      showdiv('uploadbox'+nextspot);
      var deletelink = document.getElementById('deletelink'+spot);
      deletelink.innerHTML = "[ <a href='javascript:void(0)' onClick=\"deletePhoto2('"+classifiedmedia_id+"', '"+spot+"')\">{/literal}{$user_classified_edit_media10}{literal}</a> ]";
    }
  }

  function deletePhoto(classifiedmedia_id, spot) {
    document.getElementById('photo'+spot).style.display = "none";
    document.getElementById('photo'+spot+'_deleting').style.display = "block";
    var divname = 'photo' + spot + '_deleting';
    var uploadframe = document.getElementById('uploadframe'+spot);
    uploadframe.src = 'user_classified_edit_media.php?task=deletemedia&classified_id={/literal}{$classified_id}{literal}&classifiedmedia_id='+classifiedmedia_id;
    setTimeout("hidediv('"+divname+"')", 1500);
  }

  function deletePhoto2(classifiedmedia_id, spot) {
    document.getElementById('uploadbox'+spot).style.display = "none";
    document.getElementById('photo'+spot+'_deleting').style.display = "block";
    var divname = 'photo' + spot + '_deleting';
    var uploadframe = document.getElementById('uploadframe'+spot);
    uploadframe.src = 'user_classified_edit_media.php?task=deletemedia&classified_id={/literal}{$classified_id}{literal}&classifiedmedia_id='+classifiedmedia_id;
    setTimeout("hidediv('"+divname+"')", 1500);
  }

  //-->
  </script>
  {/literal}


  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td class='header'>{$user_classified_edit_media11}</td>
  </tr>
  <tr>
  <td class='classified_box'>

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

      {* SHOW MEDIA *}
      <div id='photo{$smarty.section.file_loop.iteration}' style='margin: 30px; text-align: left;'>
        <div class='album_thumb2' style='width: 300px;'>
          <img src='{$file_src}' border='0' width='{$misc->photo_size($file_src,'300','250','w')}' class='photo'>
        </div>
        <div style='margin-top: 5px; font-weight: bold;'>[ <a href='javascript:void(0)' onClick="deletePhoto('{$files[file_loop].classifiedmedia_id}', '{$smarty.section.file_loop.iteration}')">{$user_classified_edit_media12}</a> ]</div>
      </div>
      <div id='photo{$smarty.section.file_loop.iteration}_deleting' style='margin: 30px; width: 300px; min-height: 260px; display: none; text-align: left;'>
        <div class='album_thumb2' style='border: 1px solid #DDDDDD;'>
          <div style='margin-top: 90px; font-weight: bold; text-align: center;'>
            {$user_classified_edit_media13}
            <br><img src='./images/icons/classifieds_working.gif' border='0'>
          </div>
        </div>
      </div>
      <iframe id='uploadframe{$smarty.section.file_loop.iteration}' name='uploadframe{$spot}' style='display: none;' frameborder='no' src='about:blank'></iframe>

    {/section}

    {assign var='totalspots' value=11}
    {assign var='formstoshow' value=$totalspots-$smarty.section.file_loop.iteration}
    {if $smarty.section.file_loop.iteration > 0}
      {assign var='media_shown_already' value=$smarty.section.file_loop.iteration-1}
    {else}
      {assign var='media_shown_already' value=0}
    {/if}

    {* PREPARE UPLOAD SLOTS *}
    {section name='form_loop' loop=$formstoshow}

      {assign var='spot' value=$smarty.section.form_loop.iteration+$media_shown_already}
      <div id='uploadbox{$spot}' style='margin: 30px; text-align: left; {if $smarty.section.form_loop.first != true} display: none;{/if}'>
        <div id='uploadform{$spot}' class='classified_uploadform' style='width: 300px; min-height: 260px;'>
          <form action='user_classified_edit_media.php' method='post' target='uploadframe{$spot}' enctype='multipart/form-data' onSubmit="doUpload('{$spot}')">
          <div style='margin-top: 50px;'>{$user_classified_edit_media14}</div>
          <br>
          <input type='file' name='file' name='photo' class='text'>
          <br><br>
          <input type='submit' class='button' value='{$user_classified_edit_media8}'>
          <input type='hidden' name='task' value='uploadmedia'>
          <input type='hidden' name='MAX_FILE_SIZE' value='5000000'>
          <input type='hidden' name='classified_id' value='{$classified_id}'>
          <input type='hidden' name='spot' value='{$spot}'>
          </form>
        </div>
        <div id='uploadform_uploading{$spot}' class='classified_uploadform_uploading' style='width: 300px; height: 260px; display: none;'>
          <img src='./images/icons/classifieds_working.gif' border='0' style='margin-top: 90px;'>
        </div>
        <div id='uploadform_uploaded{$spot}' style='display: none;'>
          <div><img src='./trans.gif' id='uploadform_newmedia{$spot}' border='0' class='photo' width='300'></div>
          <div style='margin-top: 5px; font-weight: bold;'><span id='deletelink{$spot}'></span>&nbsp;</div>
        </div>
      </div>
      <div id='photo{$spot}_deleting' style='display: none; margin: 30px; text-align: left;'>
        <div class='album_thumb2' style='width: 300px; min-height: 260px; border: 1px solid #DDDDDD;'>
          <div style='margin-top: 90px; font-weight: bold; text-align: center;'>
            Deleting photo...
            <br><img src='./images/icons/classifieds_working.gif' border='0'>
          </div>
        </div>
      </div>
      <iframe id='uploadframe{$spot}' name='uploadframe{$spot}' style='display: none;' frameborder='no' src='about:blank'></iframe>

    {/section}

  </td>
  </tr>
  </table>

  <br>

  <form action='user_classified.php' method='get'>
    <input type='submit' class='button' value='{$user_classified_edit_media15}'>
  </form>

</div>

{include file='footer.tpl'}