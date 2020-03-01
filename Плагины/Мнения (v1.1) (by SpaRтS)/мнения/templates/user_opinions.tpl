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
   <li class="activeLink">
    <a href="user_opinions.php" style="width:10.4em">Мнения о Вас</a>
   </li>
   <li >
    <a href="user_opinions_outbox.php" style="width:9.7em">Ваши мнения</a>
   </li>

  </ul>
 </div><div id="replyField" style="display:none">
</div>
 <div class="bar clearFix summaryBar">
  <div class="summary">{if $total_checkbox == 0}Нет мнений.{else}О Вас оставлено {$total_checkbox} мнений.{/if}</div>
 </div>

<div style='background-color:#f7f7f7; padding:20px'>

{if $m != 0}<div id='msg' style='margin:0px 0px 10px 0px'>{if $m == 1}Мнение не удалено.{/if}{if $m == 2}Мнение удалено.{/if}{if $m == 3}Пользователь больше не сможет оставить мнение о Вас.{/if}{if $m == 4}Пользователь убран из черного списка.{/if}{if $m == 5}Личное сообщение не отправленно{/if}{if $m == 6}Личное сообщение успешно отправленно{/if}</div>{/if}
 
{if $total_checkbox == 0}
 <div id="noOpinions">Здесь будут показываться анонимные мнения, которые оставили о Вас Ваши друзья.</div>
{else}
      {section name=checkbox loop=$checkboxs max=99}
<div class="opinion">
<div class="opinionInner">
<div class="opinionDel">
<a href="javascript: quickReply('opReply{$checkboxs[checkbox].checkbox_id}', 0.55, 0.40, 1); ge('reply_field').value = ''; shide('br');" class=style3>ответить</a> | <a href='user_opinions_delete.php?id={$user->user_info.user_id}&cid={$checkboxs[checkbox].checkbox_id}'>удалить</a></div>
{$datetime->cdate("`$setting.setting_dateformat` в `$setting.setting_timeformat`", $datetime->timezone($checkboxs[checkbox].checkbox_date, $global_timezone))}</div>
<div style="padding:7px 10px 10px 10px; line-height:150%; {if $checkboxs[checkbox].checkbox_view == 1}background-color: #F5F7F9;{/if}">
{$checkboxs[checkbox].checkbox_body|choptext:25:"<br>"}</div>
    <div id="opReply{$checkboxs[checkbox].checkbox_id}">
     <div id="r" class="r" style="display:none">
      <div style="padding: 5px 12px">
        <form action="user_opinions_msg.php" name="postMessage{$checkboxs[checkbox].checkbox_id}" id="postMessage{$checkboxs[checkbox].checkbox_id}">
         <input type="hidden" name="cid" value="{$checkboxs[checkbox].checkbox_id}"/>
         <textarea onkeyup="utils.checkTextLength(4096, this.value, ge('textWarn'))" name="body" style="width:99%; height:60px" id="message_text"></textarea>
        <div style="padding-top:5px; height:25px;">
         <ul class='nNav'>
     <li style="margin-left:0px">
      <b class="nc"><b class="nc1"><b></b></b><b class="nc2"><b></b></b></b>
      <span class="ncc"><a style="width:7.5em" href="javascript:document.postMessage{$checkboxs[checkbox].checkbox_id}.submit()">Отправить личное сообщение</a></span>
      <b class="nc"><b class="nc2"><b></b></b><b class="nc1"><b></b></b></b>
     </li>
      </ul>
     </div>
   </form>
</div></div></div>
</div>
      {/section}
{/if}
   </div>
  </div> 	
 </div>    


{include file='footer.tpl'}



