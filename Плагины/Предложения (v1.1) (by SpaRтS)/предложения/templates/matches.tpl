{include file='header.tpl'}
<link rel='stylesheet' href='{$filedata}css/account.css' type='text/css' />
<link rel='stylesheet' href='{$filedata}css/matches.css?4' type='text/css' />
<script src='{$filedata}js/matches.js?5'></script>



{literal}
<script type="text/javascript">
function delMem(id) {
 var ajax = new Ajax(); 
 ajax.onDone = function(ajaxObj,responseText) {
  ge('progr7').style.display = 'none';
  ge('memInfo7).innerHTML = "<div id='msg'>Пользователь удален из списка.</div>";
 };
 ge('progr7').style.display = '';
 ajax.post('/matches.php?act=a_delmem&id=7');
}
</script>
{/literal}



  <div id="pageBody" class="pageBody">

  <div id="wrapH">
  <div id="wrapHI">
   <div id="header">
    <h1>Предложения</h1>
   </div>
  </div>
  </div>

  <div id="wrap2">
  <div id="wrap1">
   <div id="content">

 <div class="clearFix tBar">
  <ul class="tabs">
   <li class="activeLink">
    <a href="matches.php" style="width:10em">Мое предложение</a>

   </li>
   <li >
    <a href="matches.php?act=search" style="width:11em">Поиск предложений</a>
   </li>
   <li >
    <a href="matches.php?act=sent" style="width:13em">Принятые предложения</a>
   </li>
  </ul>

 </div>

 <div class="matchWrapEdit">

	 <div class="privacy_panel" style="margin: 0px auto 0px auto; width:480px">
	  <div class="privacy_panel_editor" style="width:478px">
   <div class="privacy_panel_border">
<span class="pollEdit">

<a href="javascript: quickReply('edit', 0.55, 0.40, 1); ge('reply_field').value = ''; shide('br');" class=style3>редактировать</a>


<span style='color:#adbbca;padding:0px 4px'>|</span><span id='qAction'>{if $matches_act == 0}<a href='javascript: qClose();'>закрыть</a>{/if}{if $matches_act == 1}<a href='javascript: qOpen();'>открыть</a>{/if}</span></span>

<IMG id="progr2" style="float:right; display:none; margin:12px 2px 0px 0px" SRC="images/upload.gif">

    <h2 style="">Предложение<span id=qClosed>{if $matches_act == 1}закрыто{/if}</span></h2>

      <div class="privacy_panel_settings" style="text-align:center; padding:0px">
       <b style="color:#45688E; font-weight: bold">Хотели бы Вы</b> <span><a href="javascript: quickReply('edit', 0.55, 0.40, 1); ge('reply_field').value = ''; shide('br');" class=style3>{if $matches_body == ""}...{else}{$matches_body}{/if}</a></span>?
      </div>


    <div id="edit">
     <div id="r" class="r" style="display:none">
      <div style="padding: 5px 12px">
<form action="matches.php" name="postMessage" id="postMessage">
<input name="act" value="a_save" type="hidden">
<input name="id" value="{$owner->user_info.user_id}" type="hidden">
<div style="padding:10px 10px 0px 0px; height:115px;">
<center><b style="color:#45688E; font-weight: bold">Хотели бы Вы</b> <input type='text' class='text' name='text' value='{if $matches_body == ""}...{else}{$matches_body}{/if}' maxlength='100' size='30'><center>

    <table style="margin-bottom:10px"><tr><td style="text-align:right; width:30px; vertical-align:top; padding:7px 0px 10px 70px; font-weight: bold; color: #888">
     Примеры:
    </td><td style="padding:5px 0px 5px 0px">
     <ul class="listing" style="margin:0px 0px 8px 0px;">
      <li><span><a id="qAdd1" href="javascript:qAdd(1);">посетить кинотеатр на выходных</a></span></li>
      <li><span><a id="qAdd3" href="javascript:qAdd(3);">съездить на гору Фудзияма в мае</a></span></li>
      <li><span><a id="qAdd2" href="javascript:qAdd(2);">сыграть в теннис</a></span></li>
     </ul>

    </td></tr><tr><td></td><td>
 <ul class='nNav' style="margin-left:25px">
  <li style="margin-left:0px">
   <b class="nc"><b class="nc1"><b></b></b><b class="nc2"><b></b></b></b>
   <span class="ncc"><a style="width: 7.5em;" href="javascript:document.postMessage.submit()">Сохранить вопрос</a></span>
   <b class="nc"><b class="nc2"><b></b></b><b class="nc1"><b></b></b></b>
  </li>
  <li>

   <b class="nc"><b class="nc1"><b></b></b><b class="nc2"><b></b></b></b>
   <span class="ncc"><a href="javascript: editQuestion();">Отмена</a></span>
   <b class="nc"><b class="nc2"><b></b></b><b class="nc1"><b></b></b></b>
  </li>
 </ul>
</form>
</td></tr></table>

</div>
     </div>

	  </div>    
	 </div>
     </div>

	  </div>    
	 </div>
</div>
 <div class="bar clearFix summaryBar">
  <div class="summary">

{if $total_users == 0}Нет ответов.{else}Откликнулись {$total_users} человек. {if $total_users > 50}Показаны страницы #{$p_start}-{math equation='p+20' p=$p_end}{/if}{/if}

<IMG id="progr7" style="margin:2px 2px 0px 0px; display:none" SRC="images/upload.gif"></div>

{if $total_users == 0}
 <div style='background-color:#f7f7f7; padding:20px'>

 <div id="noMatches">Здесь будут показаны люди, положительно ответившие на Ваше предложение.</div>
 </div>
{/if}

{if $maxpage > 1}
 <ul class="pageList">
  {if $p > 2}<li><a href='matches.php?p=1'>«</a></li>{/if}
  {if $p != 1}<li><a href='matches.php?p={math equation='p-1' p=$p}'>{math equation='p-1' p=$p}</a></li>{/if}
  <li class='current'><a>{$p}</a></li>
  {if $p != $maxpage}<li><a href='matches.php?p={math equation='p+1' p=$p}'>{math equation='p+1' p=$p}</a></li>{/if}
{if $p < $maxpage}<li><a href='matches.php?p={$maxpage}'>»</a></li>{/if}
 </ul>
{/if}
 </div>
 <div style='background-color:#f7f7f7; padding:20px'>
 <div style="overflow: auto;">
      {section name=sent_loop loop=$sents}
<div class="match">
<table><tr>
<td>
<div class="matchPhoto">
<a href='/id{$sents[sent_loop].myuser->user_info.user_id}'>{if $sents[sent_loop].myuser->user_info.user_photo == "./nophoto.gif"}
<img src="./images/nophoto.gif" width="100" border="0">
{else}
{if $sents[sent_loop].myuser->user_info.user_photo == ""}
<img src="./images/nophoto.gif" width="100" border="0">
{/if}
{if $sents[sent_loop].myuser->user_info.user_photo != ""}
<IMG SRC='./uploads_user/{math equation="x+y-((x-1)%z);" x=$sents[sent_loop].myuser->user_info.user_id y=999 z=1000}/{$sents[sent_loop].myuser->user_info.user_id}/{$sents[sent_loop].myuser->user_info.user_photo}' width="100" border="0">
{/if}
{/if}</a>
</div>
</td>

<td class="matchInfo" id="memInfo{$sents[sent_loop].sent_id}" style="{if $sents[sent_loop].sent_view == 1}border-right: 1px solid rgb(218, 225, 232); background-color: rgb(245, 247, 249);-color: rgb(245, 247, 249);{/if}">

{if $sents[sent_loop].sent_online == 1}<span class="qOnline">Онлайн</span>{/if}
 <div style="font-weight:bold;"><a href='/profile.php?user={$sents[sent_loop].myuser->user_info.user_username}'>{$sents[sent_loop].myuser->user_info.user_username}</a></div>
 <div style="padding: 10px 0px;">{$datetime->age($sents[sent_loop].profile_9)} лет<br>{$sents[sent_loop].profile_5}</a></div>
 <div style="color:#808080; font-size:9px;">{$datetime->cdate("`$setting.setting_dateformat` в `$setting.setting_timeformat`", $datetime->timezone($sents[sent_loop].sent_date, $global_timezone))}</div>
 <div><small><a href="matches.php?act=a_delmem&md={$sents[sent_loop].sent_id}">удалить</a></small></div>
</td></tr></table>
</div>
      {/section}  

</div>
<div style="clear:both"></div>
 </div>

  <div class="bar clearfix footerBar">
{if $maxpage > 1}
 <ul class="pageList">
  {if $p > 2}<li><a href='matches.php?p=1'>«</a></li>{/if}
  {if $p != 1}<li><a href='matches.php?p={math equation='p-1' p=$p}'>{math equation='p-1' p=$p}</a></li>{/if}
  <li class='current'><a>{$p}</a></li>
  {if $p != $maxpage}<li><a href='matches.php?p={math equation='p+1' p=$p}'>{math equation='p+1' p=$p}</a></li>{/if}
{if $p < $maxpage}<li><a href='matches.php?p={$maxpage}'>»</a></li>{/if}
 </ul>
{/if} 
 </div>

    
   </div>
  </div>
  </div>

  </div>
  <div id="boxHolder"></div>


{include file='footer.tpl'}



