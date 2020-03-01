{include file='header.tpl'}
 <table cellpadding='0' cellspacing='0' class='portal_table' width='100%'>
  <tr><td>
{* Выводим новости *}
  {if $news_total > 0}
    <table cellpadding='0' cellspacing='0' class='portal_table' width='100%'>
    <tr><td class='bloki_top'>Новости</td></tr>
    <tr>
    <td class='portal_box'>
      {section name=news_loop loop=$news}
        <table cellpadding='0' cellspacing='0'>
        <tr>
        <td valign='top'><img src='./images/icons/news16.gif' border='0' class='icon'></td>
        <td valign='top'><b>{$news[news_loop].item_subject}</b><br>{$news[news_loop].item_date}<br>{$news[news_loop].item_body}</td>
        </tr>
        <tr>        
        <td valign='top' colspan="2"><b>Разместил: {$news[news_loop].item_avtor}</b></td>
        </tr>
        </table>
        {if $smarty.section.news_loop.last == false}<br>{/if}
      {/section}
    </td>
    </tr>
    </table>
  {else} Новостей нет!
  {/if}
</td> </tr>
    </table>
{include file='footer.tpl'}