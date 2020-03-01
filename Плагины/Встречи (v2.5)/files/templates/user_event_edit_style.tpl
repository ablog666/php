{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event_edit.php?event_id={$event->event_info.event_id}'>{$user_event_edit_style2}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event_edit_members.php?event_id={$event->event_info.event_id}'>{$user_event_edit_style3}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event_edit_files.php?event_id={$event->event_info.event_id}'>{$user_event_edit_style5}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event_edit_comments.php?event_id={$event->event_info.event_id}'>{$user_event_edit_style6}</a></td><td class='tab'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_event_edit_style.php?event_id={$event->event_info.event_id}'>{$user_event_edit_style7}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event_edit_delete.php?event_id={$event->event_info.event_id}'>{$user_event_edit_style8}</a></td><td class='tab'>&nbsp;</td>
<td class='tab3'><a href='user_event.php'>&#171; {$user_event_edit_style9}</a></td>
</tr>
</table>

<div>
   <img src='./images/icons/event_edit48.gif' border='0' class='icon_big'>
   <div class='page_header'>{$user_event_edit_style10} <a href='event.php?event_id={$event->event_info.event_id}'>{$event->event_info.event_title|truncate:30:"...":true}</a></div>
   {$user_event_edit_style11}
</div>

<br>

{* SHOW SUCCESS MESSAGE *}
{if $result != 0}
  <br>
  <table cellpadding='0' cellspacing='0'><tr>
  <td class='result'><img src='./images/success.gif' border='0' class='icon'> {$user_event_edit_style1}</div></td>
  </tr></table>
{/if}

<br>

<form action='user_event_edit_style.php' method='POST'>
<textarea name='style_event' rows='17' cols='50' style='width: 100%; font-family: courier, serif;'>{$style_event}</textarea>
<br>
<br>
<input type='submit' class='button' value='{$user_event_edit_style12}'>
<input type='hidden' name='event_id' value='{$event->event_info.event_id}'>
<input type='hidden' name='task' value='dosave'>
</form>


{include file='footer.tpl'}