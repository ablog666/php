{include file='admin_header.tpl'}

<h2>{$admin_viewclassifieds1}</h2>
{$admin_viewclassifieds2}

<br><br>

<table cellpadding='0' cellspacing='0' width='400' align='center'>
<tr>
<td align='center'>
<div class='box'>
<table cellpadding='0' cellspacing='0' align='center'>
<tr><form action='admin_viewclassifieds.php' method='POST'>
<td>{$admin_viewclassifieds3}<br><input type='text' class='text' name='f_title' value='{$f_title}' size='15' maxlength='100'>&nbsp;</td>
<td>{$admin_viewclassifieds4}<br><input type='text' class='text' name='f_owner' value='{$f_owner}' size='15' maxlength='50'&nbsp;</td>
<td>&nbsp;<input type='submit' class='button' value='{$admin_viewclassifieds5}'></td>
<input type='hidden' name='s' value='{$s}'>
</form>
</tr>
</table>
</div>
</td></tr></table>

<br>

{* IF THERE ARE NO classified ENTRIES *}
{if $total_classifieds == 0}

  <table cellpadding='0' cellspacing='0' width='400' align='center'>
  <tr>
  <td align='center'>
    <div class='box' style='width: 300px;'><b>{$admin_viewclassifieds17}</b></div>
  </td>
  </tr>
  </table>
  <br>

{* IF THERE ARE classified ENTRIES *}
{else}

  {* JAVASCRIPT FOR CHECK ALL *}
  {literal}
  <script language='JavaScript'> 
  <!---
  var checkboxcount = 1;
  function doCheckAll() {
    if(checkboxcount == 0) {
      with (document.items) {
      for (var i=0; i < elements.length; i++) {
      if (elements[i].type == 'checkbox') {
      elements[i].checked = false;
      }}
      checkboxcount = checkboxcount + 1;
      }
    } else
      with (document.items) {
      for (var i=0; i < elements.length; i++) {
      if (elements[i].type == 'checkbox') {
      elements[i].checked = true;
      }}
      checkboxcount = checkboxcount - 1;
      }
  }
  // -->
  </script>
  {/literal}

  <div class='pages'>{$total_classifieds} {$admin_viewclassifieds12} &nbsp;|&nbsp; {$admin_viewclassifieds13} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_viewclassifieds.php?s={$s}&p={$pages[page_loop].page}&f_title={$f_title}&f_owner={$f_owner}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
  
  <form action='admin_viewclassifieds.php' method='post' name='items'>
  <table cellpadding='0' cellspacing='0' class='list'>
  <tr>
  <td class='header' width='10'><input type='checkbox' name='select_all' onClick='javascript:doCheckAll()'></td>
  <td class='header' width='10' style='padding-left: 0px;'><a class='header' href='admin_viewclassifieds.php?s={$i}&p={$p}&f_title={$f_title}&f_owner={$f_owner}'>{$admin_viewclassifieds6}</a></td>
  <td class='header'><a class='header' href='admin_viewclassifieds.php?s={$t}&p={$p}&f_title={$f_title}&f_owner={$f_owner}'>{$admin_viewclassifieds3}</a></td>
  <td class='header'><a class='header' href='admin_viewclassifieds.php?s={$o}&p={$p}&f_title={$f_title}&f_owner={$f_owner}'>{$admin_viewclassifieds4}</a></td>
  <td class='header' align='center'><a class='header' href='admin_viewclassifieds.php?s={$v}&p={$p}&f_title={$f_title}&f_owner={$f_owner}'>{$admin_viewclassifieds7}</a></td>
  <td class='header' width='100'><a class='header' href='admin_viewclassifieds.php?s={$d}&p={$p}&f_title={$f_title}&f_owner={$f_owner}'>{$admin_viewclassifieds8}</a></td>
  <td class='header' width='100'>{$admin_viewclassifieds9}</td>
  </tr>
  {section name=classified_loop loop=$entries}
    {assign var='classified_url' value=$url->url_create('classified', $entries[classified_loop].classified_author->user_info.user_username, $entries[classified_loop].classified_id)}

    {* CHECK IF NO TITLE *}
    {if $entries[classified_loop].classified_title == ""}
      {assign var='classified_title' value=$admin_viewclassifieds18}
    {else}
      {assign var='classified_title' value=$entries[classified_loop].classified_title}
    {/if}

    <tr class='{cycle values="background1,background2"}'>
    <td class='item' style='padding-right: 0px;'><input type='checkbox' name='delete_classified_{$entries[classified_loop].classified_id}' value='1'></td>
    <td class='item' style='padding-left: 0px;'>{$entries[classified_loop].classified_id}</td>
    <td class='item'>{$classified_title}</td>
    <td class='item'><a href='{$url->url_create('profile', $entries[classified_loop].classified_author->user_info.user_username)}' target='_blank'>{$entries[classified_loop].classified_author->user_info.user_username}</a></td>
    <td class='item' align='center'>{$entries[classified_loop].classified_views}</td>
    <td class='item'>{$datetime->cdate($setting.setting_dateformat, $datetime->timezone($entries[classified_loop].classified_date, $setting.setting_timezone))}</td>
    <td class='item'>[ <a href='admin_loginasuser.php?user_id={$entries[classified_loop].classified_author->user_info.user_id}&return_url={$url->url_encode($classified_url)}' target='_blank'>{$admin_viewclassifieds10}</a> ] [ <a href='admin_viewclassifieds.php?task=confirm&classified_id={$entries[classified_loop].classified_id}&s={$s}&p={$p}&f_title={$f_title}&f_owner={$f_owner}'>{$admin_viewclassifieds11}</a> ]</td>
    </tr>
  {/section}
  </table>

  <table cellpadding='0' cellspacing='0' width='100%'>
  <tr>
  <td>
    <br>
    <input type='submit' class='button' value='{$admin_viewclassifieds19}'>
    <input type='hidden' name='task' value='delete'>
    <input type='hidden' name='p' value='{$p}'>
    <input type='hidden' name='s' value='{$s}'>
    <input type='hidden' name='f_title' value='{$f_title}'>
    <input type='hidden' name='f_owner' value='{$f_owner}'>
    </form>
  </td>
  <td align='right' valign='top'>
    <div class='pages2'>{$total_classifieds} {$admin_viewclassifieds12} &nbsp;|&nbsp; {$admin_viewclassifieds13} {section name=page_loop loop=$pages}{if $pages[page_loop].link == '1'}{$pages[page_loop].page}{else}<a href='admin_viewclassifieds.php?s={$s}&p={$pages[page_loop].page}&f_title={$f_title}&f_owner={$f_owner}'>{$pages[page_loop].page}</a>{/if} {/section}</div>
  </td>
  </tr>
  </table>

{/if}

{include file='admin_footer.tpl'}