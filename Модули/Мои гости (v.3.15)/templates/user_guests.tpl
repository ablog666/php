{include file='header.tpl'}
  {* SHOW RECENT GUESTS *}
  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr><td class='home_header'>Всего гостей: {$myguests|@count}&nbsp;&nbsp;&nbsp;[ <a href='user_home.php?task=resetguests'>Сброс</a> ] </td></tr>
	<tr>
  <td class='home_box'>

    {section name=guests_loop loop=$myguests}
      {* START NEW ROW *}
      {cycle name="startrow2" values="<table cellpadding='0' cellspacing='10' align='center' width='100%' border=0>"}
      <tr valign='middle'>
<td><a href='{$url->url_create('profile',$myguests[guests_loop].guest->user_info.user_username)}'><b>{$myguests[guests_loop].guest->user_info.user_username|truncate:15}</b><br>
<img src='{$myguests[guests_loop].guest->user_photo('./images/nophoto.gif')}' class='photo' width='{$misc->photo_size($myguests[guests_loop].guest->user_photo('./images/nophoto.gif'),'90','90','w')}' border='0'></a>
</td>
<td width='100%'>
Последний визит: <b>{$myguests[guests_loop].date}</b><br>
{if $myguests[guests_loop].p_views > 0}Просмотров профиля: <b>{$myguests[guests_loop].p_views}</b> раз(а).<br>{/if}
{if $myguests[guests_loop].f_views > 0}Просмотров фото: <b>{$myguests[guests_loop].f_views}</b> раз(а).<br>{/if}
{if $myguests[guests_loop].b_views > 0}Просмотров блога: <b>{$myguests[guests_loop].b_views}</b> раз(а).{/if}
</td>
			</tr>
      {* END ROW AFTER 5 RESULTS *}
      {if $smarty.section.guests_loop.last == true}
        </table>
      {else}
        {cycle name="endrow2" values="</table>"}
      {/if}
    {/section}
  </td>
  </tr>
  </table>
{include file='footer.tpl'}