{include file='header.tpl'}
<link rel='stylesheet' href='{$filedata}css/account.css' type='text/css' />
<link rel='stylesheet' href='{$filedata}css/matches.css?4' type='text/css' />
<script src='{$filedata}js/matches.js?5'></script>
  <div id="pageBody" class="pageBody">

  <div id="wrapH">
  <div id="wrapHI">
   <div id="header">
    <h1> Предложения</h1>
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
   <li class="activeLink">
    <a href="matches.php?act=search" style="width:11em">Поиск предложений</a>
   </li>
   <li >
    <a href="matches.php?act=sent" style="width:13em">Принятые предложения</a>
   </li>
  </ul>

 </div>

 <div style='background-color:#f7f7f7; padding:20px'>
 <div id="resultMessage"></div>
 
<div style="overflow: auto;">

      {section name=search_loop loop=$searchs}

<div id="oneMatch">


<table><tr><td style="width:200px">
<a href='/profile.php?user={$searchs[search_loop].myuser->user_info.user_username}'>
{if $searchs[search_loop].myuser->user_info.user_photo == "./images/nophoto.gif"}
<img src="./images/nophoto.gif" border="0">
{else}
{if $searchs[search_loop].myuser->user_info.user_photo == ""}
<img src="./images/nophoto.gif" border="0">
{/if}
{if $searchs[search_loop].myuser->user_info.user_photo != ""}
<IMG SRC='./uploads_user/{math equation="x+y-((x-1)%z);" x=$searchs[search_loop].myuser->user_info.user_id y=999 z=1000}/{$searchs[search_loop].myuser->user_info.user_id}/{$searchs[search_loop].myuser->user_info.user_photo}' border="0">
{/if}
{/if}
</a>

<input type="hidden" id="current" name="current" value="0">

</td>
<td class="oneMatch">
<div><a style="font-weight:bold;" href='/profile.php?user={$searchs[search_loop].myuser->user_info.user_username}'>{$searchs[search_loop].myuser->user_info.user_username}</a>, {$datetime->age($searchs[search_loop].profile_9)} лет</div>
<div style="padding:3px 0px 3px 0px;">{$searchs[search_loop].profile_5}</div>
<div class="oneQuestion"><b>Хотели бы Вы</b> {$searchs[search_loop].matches_body}?</div>

<div style="height:30px; margin-bottom:10px">
<ul class='nNav'>
 <li style="margin-left:0px">

  <b class="nc"><b class="nc1"><b></b></b><b class="nc2"><b></b></b></b>
  <span class="ncc"><a href="matches.php?act=m_search&id={$searchs[search_loop].myuser->user_info.user_id}&c={$c}&s={$s}" style="padding:10px">Да, конечно</a></span>
  <b class="nc"><b class="nc2"><b></b></b><b class="nc1"><b></b></b></b>
 </li>
 <li>
  <b class="nc"><b class="nc1"><b></b></b><b class="nc2"><b></b></b></b>
  <span class="ncc"><a href="matches.php?act=n_search&id={$searchs[search_loop].myuser->user_info.user_id}&c={$c}&s={$s}" style="padding:10px">Нет</a></span>
  <b class="nc"><b class="nc2"><b></b></b><b class="nc1"><b></b></b></b>

 </li>
</ul>
</div>

<div style="color:#808080; font-size:9px;">{$datetime->cdate("`$setting.setting_dateformat` в `$setting.setting_timeformat`", $datetime->timezone($searchs[search_loop].matches_date, $global_timezone))}</div>

</td></tr></table>


</div>

<div style="padding:0px 0px 0px 0px; width:125px; float:right;">
<IMG id="progr2" style="display:none; float:right; margin:10px 3px 0px 0px" SRC="images/upload.gif">
<div style='border-bottom: 1px solid #ddd; padding-bottom:5px'>
<div class='matchLabel'>Город:</div>

<form action="matches.php" id="goSearch">
<input type="hidden" id="s" name="act" value="search" />

<select class="matchCitySelect" style="margin: 10px 0px;" id="city" name="c" onchange="ge('goSearch').submit();">


<option value="0" {if $c == "" OR $c == 0}selected{/if}>Любой</option>
<option value="1" {if $c == 1}selected{/if}>Москва</option>
<option value="2" {if $c == 2}selected{/if}>Санкт-Петербург</option>
<option value="3" {if $c == 3}selected{/if}>Киев</option>

</select>
</div>

<div style='border-top: 1px solid #fff; border-bottom: 1px solid #ddd'>
<div class='matchLabel'>Пол:</div>



<select class="matchCitySelect" style="margin: 10px 0px;" id="city" name="s" onchange="ge('goSearch').submit();">
<option value="0" {if $s == "" OR $s == 0}selected{/if}>Любой</option>
<option value="1" {if $s == 1}selected{/if}>Женский</option>
<option value="2" {if $s == 2}selected{/if}>Мужской</option>
</select>
</div>
</form>
<div style='border-top: 1px solid #fff'>

{if $m == 1}<div id="msg">Согласие принято.</div>{/if}
{if $m == 2}<div id="dld">Отказ принят.</div>{/if}
<div id="matchMessage"></div>

</div>
</div>
<div style="clear:both"></div>

 </div>
{/section}
    
   </div>
  </div>
  </div>

{include file='footer.tpl'}