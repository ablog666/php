{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event_edit.php?event_id={$event->event_info.event_id}'>{$user_event_edit_delete1}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event_edit_members.php?event_id={$event->event_info.event_id}'>{$user_event_edit_delete2}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event_edit_files.php?event_id={$event->event_info.event_id}'>{$user_event_edit_delete4}</a></td><td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event_edit_comments.php?event_id={$event->event_info.event_id}'>{$user_event_edit_delete5}</a></td><td class='tab'>&nbsp;</td>
{if $event->eventowner_level_info.level_event_style == 1}<td class='tab2' NOWRAP><a href='user_event_edit_style.php?event_id={$event->event_info.event_id}'>{$user_event_edit_delete6}</a></td><td class='tab'>&nbsp;</td>{/if}
<td class='tab1' NOWRAP><a href='user_event_edit_delete.php?event_id={$event->event_info.event_id}'>{$user_event_edit_delete7}</a></td><td class='tab'>&nbsp;</td>
<td class='tab3'><a href='user_event.php'>&#171; {$user_event_edit_delete8}</a></td>
</tr>
</table>

<table cellpadding='0' cellspacing='0' width='100%'><tr><td class='page'>

<div>
   <img src='./images/icons/event_delete48.gif' border='0' class='icon_big'>
   <div class='page_header'>{$user_event_edit_delete9} <a href='event.php?event_id={$event->event_info.event_id}'>{$event->event_info.event_title|truncate:30:"...":true}</a></div>
   {$user_event_edit_delete10}
</div>

<br>

<table cellpadding='0' cellspacing='0'>
<tr>
<td>
  <form action='user_event_edit_delete.php' method='post'>
  <input type='submit' class='button' value='{$user_event_edit_delete11}'>&nbsp;
  <input type='hidden' name='task' value='dodelete'>
  <input type='hidden' name='event_id' value='{$event->event_info.event_id}'>
  </form>
</td>
<td>
  <form action='user_event_edit.php' method='get'>
  <input type='submit' class='button' value='{$user_event_edit_delete12}'>
  <input type='hidden' name='event_id' value='{$event->event_info.event_id}'>
  </form>
</td>
</tr>
</table>

</td></tr></table>

{include file='footer.tpl'}