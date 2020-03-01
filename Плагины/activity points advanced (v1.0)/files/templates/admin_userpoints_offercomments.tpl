{include file='admin_header.tpl'}

{literal}
<style>
table.tabs {
	margin-bottom: 12px;
}
td.tab {
	background: #FFFFFF;
	padding-left: 1px;
	border-bottom: 1px solid #CCCCCC;
}
td.tab0 {
	font-size: 1pt;
	padding-left: 7px;
	border-bottom: 1px solid #CCCCCC;
}
td.tab1 {
	border: 1px solid #CCCCCC;
	border-top: 3px solid #AAAAAA;
	border-bottom: none;
	font-weight: bold;
	padding: 6px 8px 6px 8px;
}
td.tab2 {
	background: #F8F8F8;
	border: 1px solid #CCCCCC;
	border-top: 3px solid #CCCCCC;
	font-weight: bold;
	padding: 6px 8px 6px 8px;
}
td.tab3 {
	background: #FFFFFF;
	border-bottom: 1px solid #CCCCCC;
	padding-right: 12px;
	width: 100%;
	text-align: right;
	vertical-align: middle;
}

.tabs A {
  text-decoration: none;
}

.tabs A:hover {
  text-decoration: underline;
}

td.result {
	font-weight: bold;
	text-align: center;
	border: 1px dashed #CCCCCC;
	background: #FFFFFF;
	padding: 7px 8px 7px 7px;
}
td.error {
	font-weight: bold;
	color: #FF0000;
	text-align: center;
	padding: 7px 8px 7px 7px;
	background: #FFF3F3;
}
td.success {
	font-weight: bold;
	padding: 7px 8px 7px 7px;
	background: #f3fff3;
}

div.comment_bar {
border-bottom:1px solid #DDDDDD;
margin-bottom:10px;
margin-top:10px;
padding:0px;
}

</style>
{/literal}

<h2>{$admin_userpoints_offercomments1}</h2>
{$admin_userpoints_offercomments2}

<br><br>

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='admin_userpoints_offers.php?task=edit&item_id={$item_id}'>{$admin_userpoints_offercomments40}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='admin_userpoints_offerphoto.php?item_id={$item_id}'>{$admin_userpoints_offercomments41}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='admin_userpoints_offercomments.php?item_id={$item_id}'>{$admin_userpoints_offercomments42}</a></td>
<td class='tab3'>&nbsp;<a href='admin_userpoints_offers.php'>&#171; &nbsp; {$admin_userpoints_offercomments43}</a></td>
</tr>
</table>

<br>


{* JAVASCRIPT FOR CHECK ALL MESSAGES FEATURE *}
{literal}
  <script language='JavaScript'> 
  <!---
  var checkboxcount = 1;
  function doCheckAll() {
    if(checkboxcount == 0) {
      with (document.comments) {
      for (var i=0; i < elements.length; i++) {
      if (elements[i].type == 'checkbox') {
      elements[i].checked = false;
      }}
      checkboxcount = checkboxcount + 1;
      }
      select_all.checked=false;
    } else
      with (document.comments) {
      for (var i=0; i < elements.length; i++) {
      if (elements[i].type == 'checkbox') {
      elements[i].checked = true;
      }}
      checkboxcount = checkboxcount - 1;
      select_all.checked=true;
      }
  }
  // -->
  </script>
{/literal}

<table cellpadding='0' cellspacing='0' width='100%'>
<tr>
<td width='150'>
  <table cellpadding='0' cellspacing='0'>
  <tr>
  <td><input type='checkbox' name='select_all' id='select_all' onClick='doCheckAll()'></td>
  <td>&nbsp;[ <a href='javascript:doCheckAll()'>{$admin_userpoints_offercomments8}</a> ]</td>
  </tr>
  </table>
</td>

{* DISPLAY PAGINATION MENU IF APPLICABLE *}
{if $maxpage > 1}
  <td align='right'>
    {if $p != 1}<a href='admin_userpoints_offercomments.php?item_id={$item_id}&p={math equation='p-1' p=$p}'>&#171; {$admin_userpoints_offercomments9}</a>{else}<font class='disabled'>&#171; {$admin_userpoints_offercomments9}</font>{/if}
    {if $p_start == $p_end}
      &nbsp;|&nbsp; {$admin_userpoints_offercomments10} {$p_start} {$admin_userpoints_offercomments11} {$total_comments} &nbsp;|&nbsp; 
    {else}
      &nbsp;|&nbsp; {$admin_userpoints_offercomments12} {$p_start}-{$p_end} {$admin_userpoints_offercomments11} {$total_comments} &nbsp;|&nbsp; 
    {/if}
    {if $p != $maxpage}<a href='admin_userpoints_offercomments.php?item_id={$item_id}&p={math equation='p+1' p=$p}'>{$admin_userpoints_offercomments13} &#187;</a>{else}<font class='disabled'>{$admin_userpoints_offercomments13} &#187;</font>{/if}
  </td>
{/if}

</tr>
</table>


{if $total_comments == 0}
  {* DISPLAY MESSAGE IF THERE ARE NO COMMENTS *}
  <table cellpadding='0' cellspacing='0'>
  <tr><td class='result'><img src='../images/icons/bulb22.gif' class='icon' border='0'> {$admin_userpoints_offercomments14}</td></tr>
  </table>


{else}
  {* LIST COMMENTS *}
  <form action='admin_userpoints_offercomments.php' method='post' name='comments'>
  {section name=comment_loop loop=$comments}
    <div class='comment_bar'></div>
    <table cellpadding='0' cellspacing='0'>
    <tr>
    <td valign='top' style="Xpadding-top:9px;"><input type='checkbox' name='comment_{$comments[comment_loop].comment_id}' value='1' style='margin-top: 2px;'></td>
    <td style="padding: 5px; vertical-align: top">
    <div><b>{if $comments[comment_loop].comment_author->user_info.user_id != 0}<a href='{$url->url_create('profile',$comments[comment_loop].comment_author->user_info.user_username)}'>{$comments[comment_loop].comment_author->user_info.user_username}</a>{else}{$admin_userpoints_offercomments15}{/if}</b>
     - {$datetime->cdate("`$setting.setting_timeformat` `$admin_userpoints_offercomments3` `$setting.setting_dateformat`", $datetime->timezone($comments[comment_loop].comment_date, $global_timezone))}
    </div>
    {$comments[comment_loop].comment_body}
    </td>
    </tr>
    </table>
  {/section}

  <br>

  <input type='submit' class='button' value='{$admin_userpoints_offercomments16}'>
  <input type='hidden' name='item_id' value='{$item_id}'>
  <input type='hidden' name='task' value='delete'>
  <input type='hidden' name='p' value='{$p}'>
  </form>
{/if}

{include file='admin_footer.tpl'}