{include file='header.tpl'}

<link rel="stylesheet" href="{$filedata}css/rate.css" type="text/css" />
  <div id="pageBody" class="pageBody">

  <div id="wrapH">
  <div id="wrapHI">
   <div id="header">

    <h1><a href='{$url->url_create('profile', $owner->user_info.user_id)}'>{$owner->user_info.user_name} {$owner->user_info.user_username} {$owner->user_info.user_lastname}</a>   &#187; Рейтинг</h1>
   </div>
  </div>
  </div>

  <div id="wrap2">
  <div id="wrap1">
   <div id="content">

    
<div id="rateBar" class="clearFix">
<div id="mainPanel" class="column mainPanel">




<div class="rateHelp">

<br>

	{if $total_rate > 100}
	{if $total_rate < 900}
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px;">
<tr>
<td style="border-top:1px solid #edcf0c;  background-color: #f5ebbb;" height="30px" valign="middle" align="left"><div  style="position:absolute; float:right; overflow:visible; color: #A9A26C; width:400px; text-align:center; font-family: arial, serif; line-height:30px"><font size=3>{$total_rate}</font></div><table width="{$owner->user_info.user_rate|truncate:2:true}%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="background-color: #f0e39a;  font-weight:bold;" height="30px" valign="middle" align="right"></td>
</tr>
</table>
  </td>
 </tr>
<tr><td height=7px></td></tr>
</table>
	{else}
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px;">
<tr>
<td style="border-top:1px solid #edcf0c;  background-color: #F3EACB;" height="30px" valign="middle" align="left"><div style="position:absolute; float:right; overflow:visible; color: #A9A26C; width:400px; text-align:center; font-family: arial, serif; line-height:30px"><font size=3>{$total_rate}</font></div><table width="99%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="background-color: #E1D7A2;  font-weight:bold;" height="30px" valign="middle" align="right"></td>
</tr>
</table>
  </td>
 </tr>
<tr><td height=7px></td></tr>
</table>
	{/if}

	{else}
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom:0px;">
<tr>
<td style="border-top:1px solid #c0ccd9; background-color: #eeeeee;" height="30px" valign="middle" align="left"><div href="http://www.vceti.net/id1"  style="position:absolute; float:right; overflow:visible; color: #8ba1bc; width:400px; text-align:center; line-height:30px"><font size=3>{$total_rate}%</font></div><table width="{$total_rate}%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td style="background-color: #dae2e8; color: #8ba1bc; font-weight:bold;" height="30px" valign="middle" align="right"></td>
</tr>
</table>
  </td>
 </tr>
<tr><td height=7px></td></tr>
</table>
	{/if}








<div style="padding:4px">





<div style="margin-bottom:3px"><b>Что означает рейтинг страницы?</b></div>
Рейтинг страницы определяет ее порядок при выводе в результатах поиска. Он зависит от количества голосов, которые другие пользователи отдали в пользу автора страницы в знак уважения или симпатии. 

</div>

</div>
<div class="rateHelp">
<p>
<a href="javascript: quickReply('golos', 0.55, 0.40, 1); ge('reply_field').value = ''; shide('br');" style="white-space:nowrap"><b>&darr; Проголосовать за пользователя.</b></a>
    <div id="golos">
     <div id="r" class="r" style="display:none">
      <div style="padding: 5px 12px">
<b>Внимание!</b> Цена одного голоса за пользователя составляет <b>2 поинта</b>, на вашем счету <b>{$user->user_info.user_points} поинт(ов)</b>. Для продолжения нажмите на кнопу "Голосовать".
<form action='payments.php?act=procent&user={$owner->user_info.user_username}' method='post'>
 <table cellpadding='0' cellspacing='0' width='300' align='center'>
  <tr>
  <td valign='top' width='300'>
  <b><br><center>
  <INPUT TYPE='submit' VALUE="Голосовать" class='button' name='my_lider'>
    <input type='hidden' name='task' value='procent'>
    <input type='hidden' name='cup' value='{$cup}'>
    </td>
   </tr>
  </table>
</form>
</div></div></div>
</p>
<p>
</div>

{if $user->user_info.user_id == $owner->user_info.user_id}
<div class="rateHelp">
<p>
<a href="javascript: quickReply('balans', 0.55, 0.40, 1); ge('reply_field').value = ''; shide('br');" style="white-space:nowrap"><b>&darr; Мой баланс.</b></a>
    <div id="balans">
     <div id="r" class="r" style="display:none">
      <div style="padding: 5px 12px">

Ваш баланс составляет <b>{$user->user_info.user_points} поинт(ов)</b>. 
<br>
<a>Пополнить баланc.</a>
</div></div></div>
</p>
</div>

{if $user->user_info.user_rate > 0}
<div class="rateHelp">
<p>
<a href="javascript: quickReply('obmen', 0.55, 0.40, 1); ge('reply_field').value = ''; shide('br');" style="white-space:nowrap"><b>&darr; Обменять голоса на поинты.</b></a>
    <div id="obmen">
     <div id="r" class="r" style="display:none">
      <div style="padding: 5px 12px">

Вы можите обменять голоса на поинты. 1 голос равен 1 поинту. 
На данный момент у вас {$user->user_info.user_points} поинт(ов). 
Для продолжение операции нажмите на кнупку "Обменять". 
<form action='payments.php?act=obmen&user_id={$owner->user_info.user_id}' method='post'>
 <table cellpadding='0' cellspacing='0' width='300' align='center'>
  <tr>
  <td valign='top' width='300'>
  <b><br><center>
  <INPUT TYPE='submit' VALUE="Обменять" class='button' name='my_lider'>
    <input type='hidden' name='task' value='obmen'>
    <input type='hidden' name='cup' value='{$cup}'>
    </td>
   </tr>
  </table>
</form>
</div></div></div>
</p>
</div>
{/if}
{/if}





</div>





<div id="sidePanel" class="column sidePanel">
<div class="rateSideTitle"><b>{if $user->user_info.user_id == $owner->user_info.user_id}Ваша страница{else}Страница пользователя{/if}</b></div>




<div class="rateProfile">
{if $p_percent != 0}<div> + {$p_percent}% профиль</div>{/if}
{if $owner->user_info.user_rate != 0}<div> + {$owner->user_info.user_rate}% голосов</div>{/if}
<p class="rateProfileLine">

= {math equation="x+y;" x=$owner->user_info.user_rate y=$p_percent}%
</p>
</div>


</div>
</div>
   </div>
  </div>

  </div>
{include file='footer.tpl'}