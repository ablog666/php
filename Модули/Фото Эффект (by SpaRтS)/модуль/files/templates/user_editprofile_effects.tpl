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
        <li><a href='editprofile.php?tab_id=1'>Personal Information</a>        <li><a href='editprofile.php?tab_id=2'>Contact Information</a>    <li><a href="editprofile.php?page=employment" style="width:8.2em">Карьера</a></li>
<li><a href="editprofile.php?page=education" style="width:8.2em">Образование</a></li>
    <li><a href="editprofile.php?page=comments" style="width:8.2em">Комментарии</a></li>
   <li class="activeLink"><a href="editprofile.php?page=photo" style="width:6.2em">Фото</a></li>     </ul>


    

    <div class="editorPanel clearFix">


{if $m == 1}<div id="messageWrap"><div id="message">У Вас не хватает поинтов для установки спецеффекта</div>&nbsp;</div>{/if}
	

      <form enctype="multipart/form-data" action="user_editprofile_effects.php" name="effectPhoto" id="effectPhoto">			<input type='hidden' name='page' value='effected'>


      <div class="settingsPanel" style="margin-top: 0px; padding-top: 12px;">
						<h4>Спецэффекты</h4>
      			Выбранный спецэффект будет примёнен к Вашей фотографии в анкете. Установка или смена спецэфекта стоит <b>15 поинтов</b>. При изменении картинки аватара - спецэффект <b>останется</b>.
      </div>
            	<table class="editor" border="0" cellspacing="0"><tr>
        <td >

        	<table>
        		<tr>
        			<td>

<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" width="200" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}"><param name="wmode" value="transparent">
<param name="movie" value="images/effects/eff_1.swf">
<param name="allowScriptAccess" value="never">
<embed allowscriptaccess="never" type="application/x-shockwave-flash" src="images/effects/eff_1.swf" wmode="transparent" width="200" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}">
</object></div>
	 				</div>
	 					</td>
	 					</tr>
	 					<tr>

	 					<td class="labelHigh" style="width:210px; text-align:center">
	 				<input type="radio" name="effect" value="1" >Сверкающие звезды<br />
	 				</td>
	 				</tr>
	 				</table>
				</td>
      	
            	
        <td >
        	<table>

        		<tr>
        			<td>
	 				<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
	 				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"><param name="wmode" value="transparent"><param name="movie" value="./images/effects/eff_2.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="./images/effects/eff_2.swf" wmode="transparent" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"></object>
	 				</div>
	 					</td>
	 					</tr>
	 					<tr>
	 					<td class="labelHigh" style="width:210px; text-align:center">

	 				<input type="radio" name="effect" value="2" >Неземная влюблённость<br />
	 				</td>
	 				</tr>
	 				</table>
				</td>
      	</tr></table>
            	<table class="editor" border="0" cellspacing="0"><tr>
        <td >

        	<table>
        		<tr>
        			<td>
	 				<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
	 				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"><param name="wmode" value="transparent"><param name="movie" value="./images/effects/eff_5.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="./images/effects/eff_5.swf" wmode="transparent" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"></object>
	 				</div>
	 					</td>
	 					</tr>
	 					<tr>

	 					<td class="labelHigh" style="width:210px; text-align:center">
	 				<input type="radio" name="effect" value="5" >Звезда в шоке<br />
	 				</td>
	 				</tr>
	 				</table>
				</td>
      	
            	
        <td >
        	<table>

        		<tr>
        			<td>
	 				<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
	 				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"><param name="wmode" value="transparent"><param name="movie" value="./images/effects/eff_6.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="./images/effects/eff_6.swf" wmode="transparent" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"></object>
	 				</div>
	 					</td>
	 					</tr>
	 					<tr>
	 					<td class="labelHigh" style="width:210px; text-align:center">

	 				<input type="radio" name="effect" value="6" >Matrix still has you<br />
	 				</td>
	 				</tr>
	 				</table>
				</td>
      	</tr></table>
            	<table class="editor" border="0" cellspacing="0"><tr>
        <td >

        	<table>
        		<tr>
        			<td>
	 				<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
	 				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"><param name="wmode" value="transparent"><param name="movie" value="./images/effects/eff_8.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="./images/effects/eff_8.swf" wmode="transparent" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"></object>
	 				</div>
	 					</td>
	 					</tr>
	 					<tr>

	 					<td class="labelHigh" style="width:210px; text-align:center">
	 				<input type="radio" name="effect" value="8" >Воздушные поцелуи<br />
	 				</td>
	 				</tr>
	 				</table>
				</td>
      	
            	
        <td >
        	<table>

        		<tr>
        			<td>
	 				<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
	 				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"><param name="wmode" value="transparent"><param name="movie" value="./images/effects/eff_9.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="./images/effects/eff_9.swf" wmode="transparent" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"></object>
	 				</div>
	 					</td>
	 					</tr>
	 					<tr>
	 					<td class="labelHigh" style="width:210px; text-align:center">

	 				<input type="radio" name="effect" value="9" >Ніхто мене не любить<br />
	 				</td>
	 				</tr>
	 				</table>
				</td>
      	</tr></table>
            	<table class="editor" border="0" cellspacing="0"><tr>
        <td >

        	<table>
        		<tr>
        			<td>
	 				<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
	 				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"><param name="wmode" value="transparent"><param name="movie" value="./images/effects/eff_10.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="./images/effects/eff_10.swf" wmode="transparent" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"></object>
	 				</div>
	 					</td>
	 					</tr>
	 					<tr>

	 					<td class="labelHigh" style="width:210px; text-align:center">
	 				<input type="radio" name="effect" value="10" >Вечная весна<br />
	 				</td>
	 				</tr>
	 				</table>
				</td>
      	
            	
        <td >
        	<table>

        		<tr>
        			<td>
	 				<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
	 				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"><param name="wmode" value="transparent"><param name="movie" value="./images/effects/eff_12.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="./images/effects/eff_12.swf" wmode="transparent" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"></object>
	 				</div>
	 					</td>
	 					</tr>
	 					<tr>
	 					<td class="labelHigh" style="width:210px; text-align:center">

	 				<input type="radio" name="effect" value="12" >Новогодний снегопад<br />
	 				</td>
	 				</tr>
	 				</table>
				</td>
      	</tr></table>
            	<table class="editor" border="0" cellspacing="0"><tr>
        <td >

        	<table>
        		<tr>
        			<td>
	 				<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
	 				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"><param name="wmode" value="transparent"><param name="movie" value="./images/effects/eff_13.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="./images/effects/eff_13.swf" wmode="transparent" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"></object>
	 				</div>
	 					</td>
	 					</tr>
	 					<tr>

	 					<td class="labelHigh" style="width:210px; text-align:center">
	 				<input type="radio" name="effect" value="13" >Праздничные огни<br />
	 				</td>
	 				</tr>
	 				</table>
				</td>
      	
            	
        <td >
        	<table>

        		<tr>
        			<td>
	 				<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
	 				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"><param name="wmode" value="transparent"><param name="movie" value="./images/effects/eff_15.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="./images/effects/eff_15.swf" wmode="transparent" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"></object>
	 				</div>
	 					</td>
	 					</tr>
	 					<tr>
	 					<td class="labelHigh" style="width:210px; text-align:center">

	 				<input type="radio" name="effect" value="15" >Марс и Венера<br />
	 				</td>
	 				</tr>
	 				</table>
				</td>
      	</tr></table>
            	<table class="editor" border="0" cellspacing="0"><tr>
        <td >

        	<table>
        		<tr>
        			<td>
	 				<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
	 				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"><param name="wmode" value="transparent"><param name="movie" value="./images/effects/eff_16.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="./images/effects/eff_16.swf" wmode="transparent" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"></object>
	 				</div>
	 					</td>
	 					</tr>
	 					<tr>

	 					<td class="labelHigh" style="width:210px; text-align:center">
	 				<input type="radio" name="effect" value="16" >Лепестки роз<br />
	 				</td>
	 				</tr>
	 				</table>
				</td>
      	
            	
        <td >
        	<table>

        		<tr>
        			<td>
	 				<div style="background-image: url({$user->user_photo("./images/nophoto.gif")}); width: 200px; height: {$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}px;" align="center">
	 				<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://pdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="lecteur" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"><param name="wmode" value="transparent"><param name="movie" value="./images/effects/eff_17.swf"><param name="allowScriptAccess" value="never"><embed allowscriptaccess="never" type="application/x-shockwave-flash" src="./images/effects/eff_17.swf" wmode="transparent" height="{$misc->photo_size($user->user_photo("./images/nophoto.gif"),'200','999','h')}" width="200"></object>
	 				</div>
	 				</div>
	 					</td>
	 					</tr>
	 					<tr>
	 					<td class="labelHigh" style="width:210px; text-align:center">

	 				<input type="radio" name="effect" value="17" >Падающие сердца<br />
	 				</td>
	 				</tr>
	 				</table>
				</td>
      	</tr></table>


              </table>
      <table class="editor" style="margin-left: 0px;" border="0" cellspacing="0">

				<tbody><tr>
	        <td class="label" style="width: 235px;"></td>
	        <td>
	      <ul class='nNav'>
	           <li style="margin-left:0px;">
	            <b class="nc"><b class="nc1"><b></b></b><b class="nc2"><b></b></b></b>
	            <span class="ncc"><a href="javascript: document.effectPhoto.submit()">Применить спецэфект</a></span>
	            <b class="nc"><b class="nc2"><b></b></b><b class="nc1"><b></b></b></b>

	           </li>
	      </ul>
		  </td>
	       </tr>
	      </tbody>
      	</table>
     </form>
       </div>
     </div>

  </div>
  </div>
  </div>
  <div id="boxHolder"></div>



{include file='footer.tpl'}