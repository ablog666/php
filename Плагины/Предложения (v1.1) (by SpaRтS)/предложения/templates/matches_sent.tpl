{include file='header.tpl'}
<link rel='stylesheet' href='{$filedata}css/account.css' type='text/css' />
<link rel='stylesheet' href='{$filedata}css/matches.css?4' type='text/css' />
<script src='{$filedata}js/matches.js?5'></script>



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
   <li >
    <a href="matches.php" style="width:10em">Мое предложение</a>

   </li>
   <li >
    <a href="matches.php?act=search" style="width:11em">Поиск предложений</a>
   </li>
   <li class="activeLink">
    <a href="matches.php?act=sent" style="width:13em">Принятые предложения</a>
   </li>
  </ul>

 </div>

 <div class="bar clearFix summaryBar">
  <div class="summary">

{if $total_users == 0}Нет принятых предложений.{else}
Вы откликнулись на {$total_users} предложения. {if $total_users > 20}Показаны страницы #{$p_start}-{math equation='p+20' p=$p_end}{/if}
{/if}

<IMG id="progr7" style="margin:2px 2px 0px 0px; display:none" SRC="images/upload.gif"></div>
{if $maxpage > 1}
 <ul class="pageList">
  {if $p > 2}<li><a href='matches.php?act=sent&p=1'>«</a></li>{/if}
  {if $p != 1}<li><a href='matches.php?act=sent&p={math equation='p-1' p=$p}'>{math equation='p-1' p=$p}</a></li>{/if}
  <li class='current'><a>{$p}</a></li>
  {if $p != $maxpage}<li><a href='matches.php?act=sent&p={math equation='p+1' p=$p}'>{math equation='p+1' p=$p}</a></li>{/if}
{if $p < $maxpage}<li><a href='matches.php?act=sent&p={$maxpage}'>»</a></li>{/if}
 </ul>
{/if}
 </div>
 <div style='background-color:#f7f7f7; padding:20px'>
 <div style="overflow: auto;">
      {section name=sent_loop loop=$sents}
<div class="matchSent">

<table><tbody><tr>
<td>
<div class="matchPhoto">
<a href='/profile.php?user={$sents[sent_loop].sent_user_username}'>{if $sents[sent_loop].myuser->user_info.user_photo == "./nophoto.gif"}
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


<td class="matchSentInfo" id="memInfo{$sents[sent_loop].sent_id}" style="{if $sents[sent_loop].sent_view == 1}border-right: 1px solid rgb(218, 225, 232); background-color: rgb(245, 247, 249);{/if}">
 
 <div><a style="font-weight: bold;" href="/profile.php?user={$sents[sent_loop].sent_user_username}">{$sents[sent_loop].myuser->user_info.user_username} {$sents[sent_loop].myuser->user_info.user_lastname}</a>, <span style="color: rgb(133, 135, 143);">{$sents[sent_loop].profile_5}</span></div>

 <div style="padding: 20px 0px;"><b>Хотели бы Вы</b> {$sents[sent_loop].sent_body}?</div>


</td></tr></tbody></table>

</div>


      {/section}  




</div>
<div style="clear:both"></div>
 </div>

  <div class="bar clearfix footerBar">

{if $maxpage > 1}
 <ul class="pageList">
  {if $p > 2}<li><a href='matches.php?act=sent&p=1'>«</a></li>{/if}
  {if $p != 1}<li><a href='matches.php?act=sent&p={math equation='p-1' p=$p}'>{math equation='p-1' p=$p}</a></li>{/if}
  <li class='current'><a>{$p}</a></li>
  {if $p != $maxpage}<li><a href='matches.php?act=sent&p={math equation='p+1' p=$p}'>{math equation='p+1' p=$p}</a></li>{/if}
{if $p < $maxpage}<li><a href='matches.php?act=sent&p={$maxpage}'>»</a></li>{/if}
 </ul>
{/if}
 </div>

    
   </div>
  </div>
  </div>

  </div>
  <div id="boxHolder"></div>


{include file='footer.tpl'}



