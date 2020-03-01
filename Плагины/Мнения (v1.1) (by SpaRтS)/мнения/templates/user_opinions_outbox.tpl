{include file='header.tpl'}

<link rel='stylesheet' href='css/opinions.css' type='text/css' />
  <div id="pageBody" class="pageBody">
  <div id="wrapH">
  <div id="wrapHI">
   <div id="header">
<h1>Мнения</h1>
   </div>
  </div>
  </div>
  <div id="wrap2">
  <div id="wrap1">
   <div id="content">

  <div class="clearFix tBar">
  <ul class="tabs">
   <li>
    <a href="user_opinions.php" style="width:10.4em">Мнения о Вас</a>
   </li>
   <li class="activeLink">
    <a href="user_opinions_outbox.php" style="width:9.7em">Ваши мнения</a>
   </li>
  </ul>
 </div><div id="replyField" style="display:none">
</div>

 <div class="bar clearFix summaryBar">
  <div class="summary">{if $total_checkbox == 0}Нет мнений.{else}Вы оставили {$total_checkbox} мнений{/if}</div>
 </div>
<div style='background-color:#f7f7f7; padding:20px'>
<div style="padding:7px 10px 10px 10px; line-height:150%; {if $checkboxs[checkbox].checkbox_view == 1}background-color: #F5F7F9;{/if}">
 {if $total_checkbox == 0}
 <div id="noOpinions">Вы еще не оставили ни одного мнения.</div>
{else}

      {section name=checkbox loop=$checkboxs max=99}
<div class="opinion">
<table cellpadding=0 cellspacing=0><tr><td style="width:560px; vertical-align:top">
<div class="opinionInner">
{$datetime->cdate("`$setting.setting_dateformat` в `$setting.setting_timeformat`", $datetime->timezone($checkboxs[checkbox].checkbox_date, $global_timezone))}
</div>
<div style="padding:7px 10px 10px 10px; line-height:150%; {if $checkboxs[checkbox].checkbox_view == 1}background-color: #F5F7F9;{/if}">
{$checkboxs[checkbox].checkbox_body|choptext:25:"<br>"}
</div>
</td>

{if $checkboxs[checkbox].checkbox_private == 0}
<td style="width:90px; padding:7px 0px 0px 10px; text-align:center; vertical-align:top">
<a href="./profile.php?user={$checkboxs[checkbox].myuser->user_info.user_username}">

{if $checkboxs[checkbox].myuser->user_info.user_photo == ""}
<img src="./images/nophoto.gif" width=50>
{else}
<IMG SRC='./uploads_user/{math equation="x+y-((x-1)%z);" x=$checkboxs[checkbox].myuser->user_info.user_id y=999 z=1000}/{$checkboxs[checkbox].myuser->user_info.user_id}/{$checkboxs[checkbox].myuser->user_info.user_photo}' WIDTH=50 ALT ='' />
{/if}
<div style="font-size:9px">{$checkboxs[checkbox].myuser->user_info.user_username}</div>
</a>
</td>
{/if}
</tr></table>
</div>
      {/section}

{/if}
   </div>
  </div> 	
 </div>    
 </div>

{include file='footer.tpl'}



