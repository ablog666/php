{include file='header.tpl'}

  <div id="pageBody" class="pageBody">

  <div id="wrapH">
  <div id="wrapHI">
   <div id="header">
    <h1>Редактирование профиля</h1>
   </div>
  </div>
  </div>

  <div id="wrap2">
  <div id="wrap1">
   <div id="content">

    <div class="clearFix tBar">
     <ul class="tabs">
    {section name=tab_loop loop=$tabs}
    {if $tabs[tab_loop].tab_id == $tab_id}<li><a href='editprofile.php?tab_id={$tabs[tab_loop].tab_id}'>{$tabs[tab_loop].tab_name}</a>
    {else}<li><a href='editprofile.php?tab_id={$tabs[tab_loop].tab_id}'>{$tabs[tab_loop].tab_name}</a>{/if}
    {/section}
<li><a href="editprofile.php?page=employment" style="width:8.2em">Карьера</a></li>
<li><a href="editprofile.php?page=education" style="width:8.2em">Образование</a></li>
    <li><a href="editprofile.php?page=comments" style="width:8.2em">Комментарии</a></li>
   {if $user->level_info.level_photo_allow != 0}<li class="activeLink"><a href="editprofile.php?page=photo" style="width:6.2em">Фото</a></li>{/if}
     </ul>
    </div>

    

    <div class="editorPanel clearFix">
{if $m == 2}<div id="messageWrap"><div id="message">Спецеффект установлен.</div>&nbsp;</div>{/if}
{if $m == 3}<div id="messageWrap"><div id="message">Спецеффект успешно удален.</div>&nbsp;</div>{/if}

{* SHOW ERROR MESSAGE *}
{if $is_error != 0}
  <br>
  <div class='center'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td class='result'><div class='error'><img src='./images/error.gif' class='icon' border='0'> {$error_message}</div></td>
  </tr>
  </table>
  </div>
{/if}

<form method="post" action="" name="delPhoto" id="delPhoto">
      <input type="hidden" name="subm" id="subm" value="747">
      <input type="hidden" name="e" id="e" value="photo">
      <input type="hidden" name="task" id="task" value="remove"></form>
      <form enctype="multipart/form-data" method="post" action="" name="editPhoto" id="editPhoto">
      <input type="hidden" name="subm" id="subm" value="1">
       <table class="editor" border="0" cellspacing="0">
       <tr>
        <td class="labelHigh" style="width:210px; text-align:center">

{if $user->user_info.user_photoef > 0}
<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" width="200" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}"><param name="wmode" value="transparent">
<param name="movie" value="images/effects/eff_{$user->user_info.user_photoef}.swf">
<param name="allowScriptAccess" value="never">
<embed allowscriptaccess="never" type="application/x-shockwave-flash" src="images/effects/eff_{$user->user_info.user_photoef}.swf" wmode="transparent" width="200" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}">
</object></div>
{/if}
{if $user->user_info.user_photoef == 0}
	 <img src='{$user->user_photo("./images/nophoto.gif")}' border='0'>
{/if}

         <input type="submit" value='.' style="color:#fff;border:0;padding:0;margin:0;background:#F7F7F7;height:1x;width:2px"/>
	</td>

        <td>
	 <div class="photo">
	 <h4>Загрузка фотографии</h4>
	 <p>Вы можете загрузить сюда только собственную фотографию расширения JPG, JPEG, GIF или PNG. Загрузка постороннего изображения приведёт к удалению Вашего аккаунта.</p>
	 <input type="file" class="inputfile" size="30" id="photo" name="photo" />
	 <small><br><br>Файлы размером более 5 MB не загрузятся.<br />В случае возникновения проблем попробуйте загрузить фотографию меньшего размера.<br><br></small>
         <div style="margin-bottom:15px;">

		{literal}			
          <script type="text/javascript">
function save_photo() {
  //check_flood('profile_photo_flood', {/literal}{$user->user_info.user_id}{literal}, function() {
    document.editPhoto.submit();
  //}
  //);
}
          </script>
          {/literal}
          <ul class='nNav'>
           <li style="margin-left:0px;">
            <b class="nc"><b class="nc1"><b></b></b><b class="nc2"><b></b></b></b>
            <span class="ncc"><a href="javascript: save_photo()">Обновить фотографию</a></span>
            <b class="nc"><b class="nc2"><b></b></b><b class="nc1"><b></b></b></b>
           </li>
           
           <li style="margin-left:10px;">

            <b class="nc"><b class="nc1"><b></b></b><b class="nc2"><b></b></b></b>
            <span class="ncc"><a href="user_editprofile_effects.php">Добавить спецэффекты</a></span>
            <b class="nc"><b class="nc2"><b></b></b><b class="nc1"><b></b></b></b>
           </li>
          </ul>
         </div>
	 <br>
	 	 <br>

	 <h4>Удаление фотографии</h4>
	 <p>Вы можете удалить текущую фотографию, но не забудьте загрузить новую, иначе на её месте будет стоять большой вопросительный знак.</p>
	 <p>
         <div>
          <ul class='nNav'>
           <li style="margin-left:0px">
            <b class="nc"><b class="nc1"><b></b></b><b class="nc2"><b></b></b></b>
            <span class="ncc"><a href="javascript:document.delPhoto.submit();">Удалить фотографию</a></span>
            <b class="nc"><b class="nc2"><b></b></b><b class="nc1"><b></b></b></b>
           </li>
{if $user->user_info.user_photoef > 0}
           <li style="margin-left:10px;">

            <b class="nc"><b class="nc1"><b></b></b><b class="nc2"><b></b></b></b>
            <span class="ncc"><a href="user_editprofile_effects.php?page=effdel">Удалить спецэффекты</a></span>
            <b class="nc"><b class="nc2"><b></b></b><b class="nc1"><b></b></b></b>
           </li>{/if}
          </ul>
         </div>
	 </p>
	         </td>
       </tr>
      </table>
  <input type='hidden' name='task' value='upload'>
  <input type='hidden' name='MAX_FILE_SIZE' value='5000000'>
     </form>

    </div>
   </div>
  </div>
  </div>
  </div>
  <div id="boxHolder"></div>





{include file='footer.tpl'}