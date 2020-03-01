{include file='header.tpl'}

<table class='tabs' cellpadding='0' cellspacing='0'>
<tr>
<td class='tab0'>&nbsp;</td>
<td class='tab1' NOWRAP><a href='user_event.php'>{$user_event_remove1}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event_settings.php'>{$user_event_remove11}</a></td>
<td class='tab'>&nbsp;</td>
<td class='tab2' NOWRAP><a href='user_event_browse.php'>{$user_event_remove3}</a></td>
<td class='tab3'>&nbsp;</td>
</tr>
</table>

<table cellpadding='0' cellspacing='0' width='100%'><tr><td class='page'>

<img src='./images/icons/event48.gif' border='0' class='icon_big'>

{if $event->eventmember_info.eventmember_status == -1}
  <div class='page_header'>{$user_event_remove7} <a href='event.php?event_id={$event->event_info.event_id}'>{$event->event_info.event_title}</a></div>
  <div>{$user_event_remove8}</div>
{else}
  <div class='page_header'>{$user_event_remove4} <a href='event.php?event_id={$event->event_info.event_id}'>{$event->event_info.event_title}</a></div>
  <div>{$user_event_remove5}</div>
{/if}

<br>

{* SHOW WARNING THAT EVENT WILL BE DELETED IF USER IS THE CREATOR *}
{if $event->event_info.event_user_id == $user->user_info.user_id}
  <br>
  <table cellpadding='0' cellspacing='0'>
  <tr><td class='result' style='text-align: left;'>
    {$user_event_remove6}
  </td></tr></table>
{/if}

<br>

<table cellpadding='0' cellspacing='0'>
<tr>
<td>
  <form action='user_event_remove.php' method='post'>
  <input type='submit' class='button' value='{if $event->eventmember_info.eventmember_status == -1}{$user_event_remove2}{else}{$user_event_remove9}{/if}'>&nbsp;
  <input type='hidden' name='event_id' value='{$event->event_info.event_id}'>
  <input type='hidden' name='task' value='doleave'>
  <input type='hidden' name='return_url' value='{$return_url}'>
  </form>
</td>
<td>
  <form action='user_event_remove.php' method='post'>
  <input type='submit' class='button' value='{if $event->eventmember_info.eventmember_status == -1}{$user_event_remove12}{else}{$user_event_remove10}{/if}'>
  <input type='hidden' name='task' value='cancel'>
  <input type='hidden' name='return_url' value='{$return_url}'>
  <input type='hidden' name='event_id' value='{$event->event_info.event_id}'>
  </form>
</td>
</tr>
</table>

</td></tr></table>

{include file='footer.tpl'}